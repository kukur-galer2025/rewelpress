<?php

class Order extends Controller {
    
    public function __construct()
    {
        // Middleware: Check if user is logged in
        if(!isset($_SESSION['user_id'])) {
            header('Location: ' . BASEURL . '/auth/login');
            exit;
        }
    }

    public function index()
    {
        $data['judul'] = 'Riwayat Pesanan - Unsoed Press';
        
        $orderModel = $this->model('OrderModel');
        $orders = $orderModel->getOrdersByUserId($_SESSION['user_id']);
        // Populate items for each order
        foreach ($orders as &$order) {
            $fullOrder = $orderModel->getOrderById($order['id']);
            $order['items'] = $fullOrder['items'] ?? [];
        }
        $data['orders'] = $orders;
        
        $data['ebook_orders'] = $this->model('EbookOrderModel')->getEbookOrdersByUserId($_SESSION['user_id']);
        
        $this->view('templates/header', $data);
        $this->view('order/history', $data);
        $this->view('templates/footer');
    }

    public function checkout()
    {
        if(!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
            header('Location: ' . BASEURL . '/cart');
            exit;
        }

        $delivery_method = isset($_POST['delivery_method']) ? $_POST['delivery_method'] : 'pickup';
        $shipping_address = (isset($_POST['shipping_address']) && trim($_POST['shipping_address']) !== '') ? trim($_POST['shipping_address']) : null;

        $total_amount = 0;
        $cart_items = [];
        $bookModel = $this->model('BookModel');

        foreach($_SESSION['cart'] as $book_id => $qty) {
            $book = $bookModel->getBookById($book_id);
            if($book) {
                if ($book['stock'] < $qty) {
                    die('Maaf, stok untuk buku "' . htmlspecialchars($book['title']) . '" tidak mencukupi. Sisa stok: ' . $book['stock']);
                }
                $book['qty'] = $qty;
                $book['subtotal'] = $book['price'] * $qty;
                $total_amount += $book['subtotal'];
                $cart_items[] = $book;
            }
        }

        $subtotal = $total_amount;
        $voucher_code = null;
        $discount_amount = 0.00;

        if (isset($_SESSION['applied_voucher'])) {
            $res = $this->model('VoucherModel')->validateAndCalculate($_SESSION['applied_voucher']['code'], $subtotal, 'book');
            if ($res['valid']) {
                $voucher_code = $res['voucher']['code'];
                $discount_amount = $res['discount_amount'];
                $total_amount = max(0, $subtotal - $discount_amount);
                $this->model('VoucherModel')->applyVoucherUsage($voucher_code);
            }
        }

        $order_id = $this->model('OrderModel')->createOrder($_SESSION['user_id'], $total_amount, $cart_items, $voucher_code, $discount_amount, $delivery_method, $shipping_address);

        if($order_id) {
            // Decrease stock
            foreach($cart_items as $item) {
                $bookModel->decreaseStock($item['id'], $item['qty']);
            }

            // Clear cart & voucher
            unset($_SESSION['cart']);
            unset($_SESSION['applied_voucher']);

            // Simulate sending invoice email
            $user_email = $this->model('UserModel')->getUserById($_SESSION['user_id'])['email'];
            $subject = "Invoice Pesanan #" . $order_id . " - Unsoed Press";
            $message = "Terima kasih telah berbelanja di Unsoed Press.\n\nTotal Tagihan: Rp " . number_format($total_amount, 0, ',', '.') . "\n";
            if ($delivery_method == 'shipping') {
                $message .= "Metode Pengiriman: Kirim via Kurir (Ongkir Bayar di Tujuan)\nAlamat: " . $shipping_address . "\n\n";
            } else {
                $message .= "Metode Pengiriman: Ambil di Tempat (Kantor Unsoed Press)\n\n";
            }
            $message .= "Silakan selesaikan pembayaran Anda dengan masuk ke menu Riwayat Pesanan di website kami.";
            $headers = "From: noreply@unsoedpress.test";
            
            $this->model('EmailModel')->sendEmail($user_email, $subject, $message);

            header('Location: ' . BASEURL . '/order/pay/' . $order_id);
        } else {
            die('Gagal membuat pesanan. Silakan coba lagi.');
        }
        exit;
    }

    public function pay($id)
    {
        $data['judul'] = 'Pembayaran - Unsoed Press';
        $data['order'] = $this->model('OrderModel')->getOrderById($id);
        $data['settings'] = $this->model('SettingModel')->getSettings();

        // Check ownership
        if(!$data['order'] || $data['order']['user_id'] != $_SESSION['user_id']) {
            header('Location: ' . BASEURL . '/order');
            exit;
        }

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            if(isset($_FILES['receipt']) && $_FILES['receipt']['error'] == 0) {
                $allowed_types = ['jpg', 'jpeg', 'png'];
                $file_extension = strtolower(pathinfo($_FILES["receipt"]["name"], PATHINFO_EXTENSION));
                
                if (!in_array($file_extension, $allowed_types)) {
                    $data['error'] = "Tipe file tidak diizinkan. Hanya JPG, JPEG, dan PNG.";
                } elseif ($_FILES['receipt']['size'] > 5 * 1024 * 1024) {
                    $data['error'] = "Ukuran file terlalu besar. Maksimal 5MB.";
                } else {
                    $target_dir = "../public/assets/uploads/";
                    if(!file_exists($target_dir)) {
                        mkdir($target_dir, 0777, true);
                    }
                    
                    $new_filename = 'receipt_' . $id . '_' . uniqid() . '.' . $file_extension;
                    $target_file = $target_dir . $new_filename;
                    
                    if(move_uploaded_file($_FILES["receipt"]["tmp_name"], $target_file)) {
                        $receipt_path = BASEURL . '/assets/uploads/' . $new_filename;
                        $this->model('OrderModel')->uploadReceipt($id, $receipt_path);
                        header('Location: ' . BASEURL . '/order?msg=success_upload');
                        exit;
                    } else {
                        $data['error'] = "Gagal mengunggah file. Silakan coba lagi.";
                    }
                }
            } else {
                $data['error'] = "Silakan pilih file bukti bayar terlebih dahulu.";
            }
        }

        $this->view('templates/header', $data);
        $this->view('order/pay', $data);
        $this->view('templates/footer');
    }
}
