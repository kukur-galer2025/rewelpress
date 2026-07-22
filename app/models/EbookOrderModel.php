<?php

class EbookOrderModel {
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    /**
     * Buat order e-book baru (status: pending)
     */
    public function createEbookOrder($user_id, $ebook_id, $amount, $voucher_code = null, $discount_amount = 0.00)
    {
        // Cek apakah sudah ada order pending/paid/confirmed untuk ebook ini dari user yang sama
        $existing = $this->getActiveOrderByUserAndEbook($user_id, $ebook_id);
        if ($existing) {
            return $existing['id']; // kembalikan ID order yang sudah ada
        }

        $this->db->query('INSERT INTO ebook_orders (user_id, ebook_id, amount, voucher_code, discount_amount, status) VALUES (:user_id, :ebook_id, :amount, :voucher_code, :discount_amount, "pending")');
        $this->db->bind(':user_id', (int)$user_id);
        $this->db->bind(':ebook_id', (int)$ebook_id);
        $this->db->bind(':amount', floatval($amount));
        $this->db->bind(':voucher_code', !empty($voucher_code) ? $voucher_code : null);
        $this->db->bind(':discount_amount', floatval($discount_amount));
        $this->db->execute();

        $order_id = $this->db->lastInsertId();

        // Notifikasi admin
        if ($order_id) {
            require_once __DIR__ . '/NotificationModel.php';
            $notif = new NotificationModel();
            $notif->addNotification(
                0,
                "Pesanan E-Book Baru #EBO-{$order_id}",
                "Ada pesanan e-book baru senilai Rp " . number_format($amount, 0, ',', '.') . " menunggu pembayaran.",
                BASEURL . "/admin/ebook_orders"
            );
        }

        return $order_id;
    }

    /**
     * Terapkan voucher ke pesanan e-book yang masih pending
     */
    public function updateOrderVoucher($order_id, $voucher_code, $discount_amount, $new_amount)
    {
        $this->db->query('UPDATE ebook_orders SET voucher_code = :voucher_code, discount_amount = :discount_amount, amount = :new_amount WHERE id = :id AND status = "pending"');
        $this->db->bind(':voucher_code', trim(strtoupper($voucher_code)));
        $this->db->bind(':discount_amount', floatval($discount_amount));
        $this->db->bind(':new_amount', floatval($new_amount));
        $this->db->bind(':id', (int)$order_id);
        return $this->db->execute();
    }

    /**
     * Hapus voucher dari pesanan e-book yang masih pending dan kembalikan ke harga asli
     */
    public function removeOrderVoucher($order_id, $original_price)
    {
        $this->db->query('UPDATE ebook_orders SET voucher_code = NULL, discount_amount = 0.00, amount = :original_price WHERE id = :id AND status = "pending"');
        $this->db->bind(':original_price', floatval($original_price));
        $this->db->bind(':id', (int)$order_id);
        return $this->db->execute();
    }

    /**
     * Ambil order e-book berdasarkan ID
     */
    public function getEbookOrderById($id)
    {
        $this->db->query('
            SELECT ebook_orders.*,
                   ebooks.title as ebook_title,
                   ebooks.file_pdf, ebooks.file_size, ebooks.page_count, ebooks.is_free,
                   ebooks.ebook_price, ebooks.book_id,
                   books.image as cover_image,
                   users.name as user_name, users.email as user_email
            FROM ebook_orders
            JOIN ebooks ON ebook_orders.ebook_id = ebooks.id
            LEFT JOIN books ON ebooks.book_id = books.id
            JOIN users ON ebook_orders.user_id = users.id
            WHERE ebook_orders.id = :id
        ');
        $this->db->bind(':id', (int)$id);
        return $this->db->single();
    }

    /**
     * Ambil semua order e-book milik user tertentu
     */
    public function getEbookOrdersByUserId($user_id)
    {
        $this->db->query('
            SELECT ebook_orders.*,
                   ebooks.title as ebook_title,
                   ebooks.file_size, ebooks.page_count,
                   books.image as cover_image
            FROM ebook_orders
            JOIN ebooks ON ebook_orders.ebook_id = ebooks.id
            LEFT JOIN books ON ebooks.book_id = books.id
            WHERE ebook_orders.user_id = :user_id
            ORDER BY ebook_orders.created_at DESC
        ');
        $this->db->bind(':user_id', (int)$user_id);
        return $this->db->resultSet();
    }

    /**
     * Cek apakah user punya order aktif (pending/paid/confirmed) untuk ebook tertentu
     */
    public function getActiveOrderByUserAndEbook($user_id, $ebook_id)
    {
        $this->db->query("
            SELECT * FROM ebook_orders
            WHERE user_id = :user_id AND ebook_id = :ebook_id
              AND status IN ('pending','paid','confirmed')
            ORDER BY created_at DESC
            LIMIT 1
        ");
        $this->db->bind(':user_id', (int)$user_id);
        $this->db->bind(':ebook_id', (int)$ebook_id);
        return $this->db->single();
    }

    /**
     * Cek apakah user punya akses unduh (status = confirmed)
     */
    public function hasConfirmedAccess($user_id, $ebook_id)
    {
        $this->db->query("
            SELECT COUNT(*) as cnt FROM ebook_orders
            WHERE user_id = :user_id AND ebook_id = :ebook_id AND status = 'confirmed'
        ");
        $this->db->bind(':user_id', (int)$user_id);
        $this->db->bind(':ebook_id', (int)$ebook_id);
        $result = $this->db->single();
        return $result && $result['cnt'] > 0;
    }

    /**
     * Upload bukti bayar, ubah status jadi 'paid'
     */
    public function uploadReceipt($order_id, $receipt_path, $user_id)
    {
        // Pastikan order milik user
        $this->db->query("UPDATE ebook_orders SET payment_receipt = :receipt, status = 'paid' WHERE id = :id AND user_id = :user_id");
        $this->db->bind(':receipt', $receipt_path);
        $this->db->bind(':id', (int)$order_id);
        $this->db->bind(':user_id', (int)$user_id);
        $this->db->execute();
        $rowCount = $this->db->rowCount();

        if ($rowCount > 0) {
            require_once __DIR__ . '/NotificationModel.php';
            $notif = new NotificationModel();
            $notif->addNotification(
                0,
                "Bukti Bayar E-Book #EBO-{$order_id}",
                "Pelanggan telah mengunggah bukti pembayaran untuk order e-book #EBO-{$order_id}. Silakan verifikasi.",
                BASEURL . "/admin/ebook_orders"
            );
        }

        return $rowCount;
    }

    // ===================== ADMIN METHODS =====================

    /**
     * Ambil semua order e-book (untuk admin)
     */
    public function getAllEbookOrders()
    {
        $this->db->query('
            SELECT ebook_orders.*,
                   ebooks.title as ebook_title, ebooks.ebook_price,
                   users.name as user_name, users.email as user_email
            FROM ebook_orders
            JOIN ebooks ON ebook_orders.ebook_id = ebooks.id
            JOIN users ON ebook_orders.user_id = users.id
            ORDER BY ebook_orders.created_at DESC
        ');
        return $this->db->resultSet();
    }

    /**
     * Update status order (confirmed/rejected) oleh admin
     */
    public function updateStatus($order_id, $status, $note = '')
    {
        $order = $this->getEbookOrderById($order_id);

        $this->db->query("UPDATE ebook_orders SET status = :status, note = :note WHERE id = :id");
        $this->db->bind(':status', $status);
        $this->db->bind(':note', $note);
        $this->db->bind(':id', (int)$order_id);
        $this->db->execute();
        $rowCount = $this->db->rowCount();

        // Kirim notifikasi ke user
        if ($rowCount > 0 && $order) {
            require_once __DIR__ . '/NotificationModel.php';
            $notif = new NotificationModel();

            if ($status === 'confirmed') {
                $notif->addNotification(
                    $order['user_id'],
                    "✅ Pembayaran E-Book Diverifikasi!",
                    "Pembayaran untuk e-book \"{$order['ebook_title']}\" telah dikonfirmasi. Silakan unduh e-book Anda sekarang!",
                    BASEURL . "/ebook/detail/" . $order['ebook_id']
                );
            } elseif ($status === 'rejected') {
                $notif->addNotification(
                    $order['user_id'],
                    "❌ Pembayaran E-Book Ditolak",
                    "Maaf, pembayaran untuk e-book \"{$order['ebook_title']}\" tidak dapat diverifikasi. Silakan hubungi admin untuk informasi lebih lanjut.",
                    BASEURL . "/ebook/detail/" . $order['ebook_id']
                );
            }
        }

        return $rowCount;
    }

    public function countByStatus($status)
    {
        $this->db->query("SELECT COUNT(*) as cnt FROM ebook_orders WHERE status = :status");
        $this->db->bind(':status', $status);
        $result = $this->db->single();
        return $result ? $result['cnt'] : 0;
    }
}
