<?php

class Cart extends Controller {
    
    public function index()
    {
        $data['judul'] = 'Keranjang Belanja - Unsoed Press';
        $data['cart_items'] = [];
        $data['total_price'] = 0;
        
        // Ensure session format is correct
        if(isset($_SESSION['cart']) && !is_array(reset($_SESSION['cart']))) {
            unset($_SESSION['cart']);
        }

        if(isset($_SESSION['cart']['book']) && !empty($_SESSION['cart']['book'])) {
            $bookModel = $this->model('BookModel');
            foreach($_SESSION['cart']['book'] as $book_id => $qty) {
                $book = $bookModel->getBookById($book_id);
                if($book) {
                    $book['cart_type'] = 'book';
                    $book['qty'] = $qty;
                    $book['subtotal'] = $book['price'] * $qty;
                    $data['total_price'] += $book['subtotal'];
                    $data['cart_items'][] = $book;
                }
            }
        }
        
        if(isset($_SESSION['cart']['ebook']) && !empty($_SESSION['cart']['ebook'])) {
            $ebookModel = $this->model('EbookModel');
            foreach($_SESSION['cart']['ebook'] as $ebook_id => $qty) {
                $ebook = $ebookModel->getEbookById($ebook_id);
                if($ebook) {
                    // Normalize the array to match physical book structure for the view
                    $ebook['cart_type'] = 'ebook';
                    $ebook['price'] = $ebook['ebook_price'];
                    $ebook['stock'] = 1; // E-books always have 1 max stock
                    $ebook['qty'] = 1;
                    $ebook['subtotal'] = $ebook['price'] * 1;
                    
                    // If no cover is specifically available, it uses the related physical book cover if joined (done in EbookModel)
                    if (empty($ebook['image']) && !empty($ebook['cover_image'])) {
                        $ebook['image'] = $ebook['cover_image'];
                    }
                    
                    $data['total_price'] += $ebook['subtotal'];
                    $data['cart_items'][] = $ebook;
                }
            }
        }

        // Ambil voucher aktif untuk ditampilkan di widget keranjang (mendukung all, book, ebook)
        // Kita ambil semua voucher yang aktif saja
        $data['active_vouchers'] = $this->model('VoucherModel')->getAllVouchers();
        $data['applied_voucher'] = null;

        if (isset($_SESSION['applied_voucher'])) {
            // Validasi ulang voucher dengan total belanja saat ini. 
            // Catatan: Model voucher mungkin perlu update untuk support tipe cart yang baru
            $res = $this->model('VoucherModel')->validateAndCalculate($_SESSION['applied_voucher']['code'], $data['total_price'], 'all'); // simplify to 'all' for now
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
            if(isset($_SESSION['cart']['book'])) {
                $bookModel = $this->model('BookModel');
                foreach($_SESSION['cart']['book'] as $id => $qty) {
                    $item = $bookModel->getBookById($id);
                    if($item) $subtotal += ($item['price'] * $qty);
                }
            }
            if(isset($_SESSION['cart']['ebook'])) {
                $ebookModel = $this->model('EbookModel');
                foreach($_SESSION['cart']['ebook'] as $id => $qty) {
                    $item = $ebookModel->getEbookById($id);
                    if($item) $subtotal += $item['ebook_price'];
                }
            }

            $res = $this->model('VoucherModel')->validateAndCalculate($code, $subtotal, 'all');
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

    public function add($type = 'book', $id = 0)
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $qty = isset($_POST['qty']) ? (int)$_POST['qty'] : 1;
            
            if(!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = ['book' => [], 'ebook' => []];
            }
            // Compatibility for old format
            if(!isset($_SESSION['cart']['book'])) {
                $_SESSION['cart'] = ['book' => [], 'ebook' => []];
            }

            if ($type === 'book') {
                $book = $this->model('BookModel')->getBookById($id);
                if(!$book) {
                    header('Location: ' . BASEURL . '/cart');
                    exit;
                }

                $current_qty = isset($_SESSION['cart']['book'][$id]) ? $_SESSION['cart']['book'][$id] : 0;
                $new_qty = $current_qty + $qty;

                if($new_qty > $book['stock']) {
                    header('Location: ' . BASEURL . '/book/detail/' . $book['slug'] . '?error=stock');
                    exit;
                }

                $_SESSION['cart']['book'][$id] = $new_qty;
            } 
            elseif ($type === 'ebook') {
                $ebook = $this->model('EbookModel')->getEbookById($id);
                if(!$ebook) {
                    header('Location: ' . BASEURL . '/cart');
                    exit;
                }
                
                // Cek apakah user sudah punya ebook ini
                if(isset($_SESSION['user_id'])) {
                    $hasAccess = $this->model('EbookModel')->hasConfirmedAccess($_SESSION['user_id'], $id);
                    if ($hasAccess) {
                        header('Location: ' . BASEURL . '/ebook/detail/' . $ebook['slug'] . '?error=already_owned');
                        exit;
                    }
                }

                $_SESSION['cart']['ebook'][$id] = 1; // Ebook selalu 1 qty
            }
        }
        
        header('Location: ' . BASEURL . '/cart');
        exit;
    }

    public function remove($type, $id)
    {
        if(isset($_SESSION['cart'][$type][$id])) {
            unset($_SESSION['cart'][$type][$id]);
        }
        
        header('Location: ' . BASEURL . '/cart');
        exit;
    }
    
    public function update()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['qty'])) {
            $bookModel = $this->model('BookModel');
            $stock_error = false;
            
            // Only update physical books (ebooks are fixed to 1)
            foreach($_POST['qty'] as $key => $qty) {
                // Key format is expected to be "book_ID" or "ebook_ID"
                $parts = explode('_', $key);
                if (count($parts) == 2) {
                    $type = $parts[0];
                    $id = $parts[1];
                    
                    if ($type === 'book') {
                        if((int)$qty > 0) {
                            $book = $bookModel->getBookById($id);
                            if ($book && (int)$qty > $book['stock']) {
                                $_SESSION['cart']['book'][$id] = $book['stock'];
                                $stock_error = true;
                            } else {
                                $_SESSION['cart']['book'][$id] = (int)$qty;
                            }
                        } else {
                            unset($_SESSION['cart']['book'][$id]);
                        }
                    }
                }
            }
            
            if ($stock_error) {
                header('Location: ' . BASEURL . '/cart?error=stock');
                exit;
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
