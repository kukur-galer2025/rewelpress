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
        $data['orders'] = $this->model('OrderModel')->getOrdersByUserId($_SESSION['user_id']);
        
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

        $total_amount = 0;
        $cart_items = [];
        $bookModel = $this->model('BookModel');

        foreach($_SESSION['cart'] as $book_id => $qty) {
            $book = $bookModel->getBookById($book_id);
            if($book) {
                $book['qty'] = $qty;
                $book['subtotal'] = $book['price'] * $qty;
                $total_amount += $book['subtotal'];
                $cart_items[] = $book;
            }
        }

        $order_id = $this->model('OrderModel')->createOrder($_SESSION['user_id'], $total_amount, $cart_items);

        if($order_id) {
            // Clear cart
            unset($_SESSION['cart']);

            // Simulate sending invoice email
            $user_email = $this->model('UserModel')->getUserById($_SESSION['user_id'])['email'];
            $subject = "Invoice Pesanan #" . $order_id . " - Unsoed Press";
            $message = "Terima kasih telah berbelanja di Unsoed Press.\n\nTotal Tagihan: Rp " . number_format($total_amount, 0, ',', '.') . "\nSilakan selesaikan pembayaran Anda dengan masuk ke menu Riwayat Pesanan di website kami.";
            $headers = "From: noreply@unsoedpress.test";
            @mail($user_email, $subject, $message, $headers);

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
                $target_dir = "../public/assets/uploads/";
                if(!file_exists($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }
                
                $file_extension = pathinfo($_FILES["receipt"]["name"], PATHINFO_EXTENSION);
                $new_filename = 'receipt_' . $id . '_' . uniqid() . '.' . $file_extension;
                $target_file = $target_dir . $new_filename;
                
                if(move_uploaded_file($_FILES["receipt"]["tmp_name"], $target_file)) {
                    $receipt_path = BASEURL . '/assets/uploads/' . $new_filename;
                    $this->model('OrderModel')->uploadReceipt($id, $receipt_path);
                    header('Location: ' . BASEURL . '/order?msg=success_upload');
                    exit;
                }
            }
        }

        $this->view('templates/header', $data);
        $this->view('order/pay', $data);
        $this->view('templates/footer');
    }
}
