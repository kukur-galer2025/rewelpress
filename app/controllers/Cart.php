<?php

class Cart extends Controller {
    
    public function index()
    {
        $data['judul'] = 'Keranjang Belanja - Unsoed Press';
        $data['cart_items'] = [];
        $data['total_price'] = 0;

        if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            $bookModel = $this->model('BookModel');
            foreach($_SESSION['cart'] as $book_id => $qty) {
                $book = $bookModel->getBookById($book_id);
                if($book) {
                    $book['qty'] = $qty;
                    $book['subtotal'] = $book['price'] * $qty;
                    $data['total_price'] += $book['subtotal'];
                    $data['cart_items'][] = $book;
                }
            }
        }

        // Ambil voucher aktif untuk ditampilkan di widget keranjang
        $data['active_vouchers'] = $this->model('VoucherModel')->getActiveVouchers('book');
        $data['applied_voucher'] = null;

        if (isset($_SESSION['applied_voucher'])) {
            // Validasi ulang voucher dengan total belanja saat ini
            $res = $this->model('VoucherModel')->validateAndCalculate($_SESSION['applied_voucher']['code'], $data['total_price'], 'book');
            if ($res['valid']) {
                $data['applied_voucher'] = [
                    'code' => $res['voucher']['code'],
                    'title' => $res['voucher']['title'],
                    'discount_amount' => $res['discount_amount']
                ];
                $_SESSION['applied_voucher'] = $data['applied_voucher'];
            } else {
                unset($_SESSION['applied_voucher']);
                $data['voucher_error'] = $res['message'];
            }
        }

        $this->view('templates/header', $data);
        $this->view('cart/index', $data);
        $this->view('templates/footer');
    }

    public function apply_voucher()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $code = trim($_POST['voucher_code'] ?? '');
            
            // Hitung subtotal keranjang saat ini
            $subtotal = 0;
            if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                $bookModel = $this->model('BookModel');
                foreach($_SESSION['cart'] as $book_id => $qty) {
                    $book = $bookModel->getBookById($book_id);
                    if($book) {
                        $subtotal += ($book['price'] * $qty);
                    }
                }
            }

            $res = $this->model('VoucherModel')->validateAndCalculate($code, $subtotal, 'book');
            if ($res['valid']) {
                $_SESSION['applied_voucher'] = [
                    'code' => $res['voucher']['code'],
                    'title' => $res['voucher']['title'],
                    'discount_amount' => $res['discount_amount']
                ];
                header('Location: ' . BASEURL . '/cart?voucher=applied');
            } else {
                unset($_SESSION['applied_voucher']);
                header('Location: ' . BASEURL . '/cart?voucher_err=' . urlencode($res['message']));
            }
            exit;
        }
        header('Location: ' . BASEURL . '/cart');
        exit;
    }

    public function remove_voucher()
    {
        unset($_SESSION['applied_voucher']);
        header('Location: ' . BASEURL . '/cart?voucher=removed');
        exit;
    }

    public function add($id)
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $qty = isset($_POST['qty']) ? (int)$_POST['qty'] : 1;
            
            if(!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }

            if(isset($_SESSION['cart'][$id])) {
                $_SESSION['cart'][$id] += $qty;
            } else {
                $_SESSION['cart'][$id] = $qty;
            }
        }
        
        header('Location: ' . BASEURL . '/cart');
        exit;
    }

    public function remove($id)
    {
        if(isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
        }
        
        header('Location: ' . BASEURL . '/cart');
        exit;
    }
    
    public function update()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['qty'])) {
            foreach($_POST['qty'] as $id => $qty) {
                if((int)$qty > 0) {
                    $_SESSION['cart'][$id] = (int)$qty;
                } else {
                    unset($_SESSION['cart'][$id]);
                }
            }
        }
        
        header('Location: ' . BASEURL . '/cart');
        exit;
    }
    
    public function clear()
    {
        unset($_SESSION['cart']);
        unset($_SESSION['applied_voucher']);
        header('Location: ' . BASEURL . '/cart');
        exit;
    }
}
