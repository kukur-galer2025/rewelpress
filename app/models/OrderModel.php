<?php

class OrderModel {
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    // -- For Customer --

    public function createOrder($user_id, $total_amount, $cart_items, $voucher_code = null, $discount_amount = 0.00, $delivery_method = 'pickup', $shipping_address = null)
    {
        // Begin Transaction natively using PDO
        $this->db->query("START TRANSACTION");
        $this->db->execute();

        try {
            // 1. Insert Order
            $this->db->query('INSERT INTO orders (user_id, total_amount, voucher_code, discount_amount, delivery_method, shipping_address, status) VALUES (:user_id, :total_amount, :voucher_code, :discount_amount, :delivery_method, :shipping_address, :status)');
            $this->db->bind(':user_id', $user_id);
            $this->db->bind(':total_amount', $total_amount);
            $this->db->bind(':voucher_code', !empty($voucher_code) ? $voucher_code : null);
            $this->db->bind(':discount_amount', floatval($discount_amount));
            $this->db->bind(':delivery_method', $delivery_method);
            $this->db->bind(':shipping_address', $shipping_address);
            $this->db->bind(':status', 'pending');
            $this->db->execute();
            
            $order_id = $this->db->lastInsertId();

            // 2. Insert Order Items
            foreach($cart_items as $item) {
                $this->db->query('INSERT INTO order_items (order_id, book_id, quantity, price) VALUES (:order_id, :book_id, :qty, :price)');
                $this->db->bind(':order_id', $order_id);
                $this->db->bind(':book_id', $item['id']);
                $this->db->bind(':qty', $item['qty']);
                $this->db->bind(':price', $item['price']);
                $this->db->execute();
            }

            // Commit
            $this->db->query("COMMIT");
            $this->db->execute();

            // Trigger Notifikasi untuk Admin (user_id = 0)
            require_once __DIR__ . '/NotificationModel.php';
            $notif = new NotificationModel();
            $notif->addNotification(0, "Pesanan Baru #INV-" . $order_id, "Pesanan baru seharga Rp " . number_format($total_amount, 0, ',', '.') . " menunggu pembayaran.", BASEURL . "/admin/orders");

            return $order_id;
        } catch (Exception $e) {
            $this->db->query("ROLLBACK");
            $this->db->execute();
            return false;
        }
    }

    public function getOrdersByUserId($user_id)
    {
        $this->db->query('SELECT * FROM orders WHERE user_id = :user_id ORDER BY created_at DESC');
        $this->db->bind(':user_id', $user_id);
        return $this->db->resultSet();
    }

    public function getOrderById($id)
    {
        // Get order + user email
        $this->db->query('SELECT orders.*, users.name as user_name, users.email FROM orders JOIN users ON orders.user_id = users.id WHERE orders.id = :id');
        $this->db->bind(':id', $id);
        $order = $this->db->single();

        if($order) {
            $this->db->query('SELECT order_items.*, books.title, books.image FROM order_items JOIN books ON order_items.book_id = books.id WHERE order_id = :order_id');
            $this->db->bind(':order_id', $id);
            $order['items'] = $this->db->resultSet();
        }

        return $order;
    }

    public function uploadReceipt($order_id, $receipt_path)
    {
        $this->db->query('UPDATE orders SET payment_receipt = :receipt, status = :status WHERE id = :id');
        $this->db->bind(':receipt', $receipt_path);
        $this->db->bind(':status', 'paid');
        $this->db->bind(':id', $order_id);
        $this->db->execute();
        $rowCount = $this->db->rowCount();

        if ($rowCount > 0) {
            require_once __DIR__ . '/NotificationModel.php';
            $notif = new NotificationModel();
            $notif->addNotification(0, "Bukti Pembayaran Diunggah #INV-" . $order_id, "Pelanggan telah mengunggah bukti transfer untuk pesanan #INV-" . $order_id, BASEURL . "/admin/orders");
        }

        return $rowCount;
    }

    // -- For Admin --
    
    public function getAllOrders()
    {
        $this->db->query('SELECT orders.*, users.name as user_name FROM orders JOIN users ON orders.user_id = users.id ORDER BY orders.created_at DESC');
        return $this->db->resultSet();
    }

    public function updateOrderStatus($id, $status)
    {
        $order = $this->getOrderById($id);

        $this->db->query('UPDATE orders SET status = :status WHERE id = :id');
        $this->db->bind(':status', $status);
        $this->db->bind(':id', $id);
        $this->db->execute();
        $rowCount = $this->db->rowCount();

        if ($rowCount > 0 && $order && !empty($order['user_id'])) {
            require_once __DIR__ . '/NotificationModel.php';
            require_once __DIR__ . '/EmailModel.php';
            $notif = new NotificationModel();
            $emailModel = new EmailModel();
            
            $title = "Status Pesanan Diperbarui";
            $message = "Pesanan #INV-" . $id . " berstatus: " . strtoupper($status);
            
            if ($status === 'confirmed') {
                $title = "Pembayaran Diverifikasi!";
                $message = "Pembayaran untuk pesanan #INV-" . $id . " telah diverifikasi oleh Admin Unsoed Press. Buku segera disiapkan.";
            } elseif ($status === 'rejected') {
                $title = "Pesanan Ditolak";
                $message = "Mohon maaf, pesanan #INV-" . $id . " tidak dapat diproses/ditolak. Silakan hubungi redaksi.";
            }

            $notif->addNotification($order['user_id'], $title, $message, BASEURL . "/order");
            $emailModel->sendEmail($order['email'], $title, $message . "\n\nCek riwayat pesanan Anda di website kami.");
        }

        return $rowCount;
    }
}
