<?php

class Ebook extends Controller {

    public function index()
    {
        $data['judul'] = 'Katalog E-Book & Publikasi Digital - Unsoed Press';
        $data['ebooks'] = $this->model('EbookModel')->getActiveEbooks();

        $this->view('templates/header', $data);
        $this->view('ebook/index', $data);
        $this->view('templates/footer');
    }

    /**
     * Halaman detail e-book: info spesifikasi, tombol beli/unduh berdasarkan status user
     */
    public function detail($id = null)
    {
        if (!$id) {
            header('Location: ' . BASEURL . '/ebook');
            exit;
        }

        $ebook = $this->model('EbookModel')->getEbookById($id);
        if (!$ebook || $ebook['status'] !== 'active') {
            header('Location: ' . BASEURL . '/ebook');
            exit;
        }

        $data['judul'] = $ebook['title'] . ' - E-Book Unsoed Press';
        $data['ebook'] = $ebook;
        $data['has_access'] = false;
        $data['user_logged_in'] = isset($_SESSION['user_id']);
        $data['existing_order'] = null;

        if ($data['user_logged_in']) {
            $data['has_access'] = $this->model('EbookModel')->hasUserAccessToEbook($_SESSION['user_id'], $id);

            // Cek apakah sudah ada order aktif (pending/paid)
            if (!$data['has_access']) {
                $data['existing_order'] = $this->model('EbookOrderModel')->getActiveOrderByUserAndEbook($_SESSION['user_id'], $id);
            }
        }

        $this->view('templates/header', $data);
        $this->view('ebook/detail', $data);
        $this->view('templates/footer');
    }

    /**
     * Buat order e-book dan redirect ke halaman pembayaran
     */
    /**
     * Halaman konfirmasi pembelian E-Book (dengan opsi input voucher)
     */
    public function checkout($id = null)
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASEURL . '/auth/login');
            exit;
        }

        $ebook = $this->model('EbookModel')->getEbookById($id);
        if (!$ebook || $ebook['status'] !== 'active') {
            header('Location: ' . BASEURL . '/ebook');
            exit;
        }

        if ($ebook['is_free'] == 1 || floatval($ebook['ebook_price']) == 0) {
            header('Location: ' . BASEURL . '/ebook/download/' . $id);
            exit;
        }

        $data['judul'] = 'Konfirmasi Pembelian E-Book - Unsoed Press';
        $data['ebook'] = $ebook;
        $data['active_vouchers'] = $this->model('VoucherModel')->getActiveVouchers('ebook');
        
        $data['applied_voucher'] = null;
        if (isset($_SESSION['ebook_voucher'])) {
            $res = $this->model('VoucherModel')->validateAndCalculate($_SESSION['ebook_voucher']['code'], floatval($ebook['ebook_price']), 'ebook');
            if ($res['valid']) {
                $data['applied_voucher'] = [
                    'code' => $res['voucher']['code'],
                    'title' => $res['voucher']['title'],
                    'discount_amount' => $res['discount_amount']
                ];
                $_SESSION['ebook_voucher'] = $data['applied_voucher'];
            } else {
                unset($_SESSION['ebook_voucher']);
                $data['voucher_error'] = $res['message'];
            }
        }

        $this->view('templates/header', $data);
        $this->view('ebook/checkout', $data);
        $this->view('templates/footer');
    }

    public function apply_voucher_checkout($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $code = trim($_POST['voucher_code'] ?? '');
            $ebook = $this->model('EbookModel')->getEbookById($id);
            if ($ebook) {
                $res = $this->model('VoucherModel')->validateAndCalculate($code, floatval($ebook['ebook_price']), 'ebook');
                if ($res['valid']) {
                    $_SESSION['ebook_voucher'] = [
                        'code' => $res['voucher']['code'],
                        'title' => $res['voucher']['title'],
                        'discount_amount' => $res['discount_amount']
                    ];
                    header('Location: ' . BASEURL . '/ebook/checkout/' . $id . '?voucher=applied');
                    exit;
                } else {
                    unset($_SESSION['ebook_voucher']);
                    header('Location: ' . BASEURL . '/ebook/checkout/' . $id . '?voucher_err=' . urlencode($res['message']));
                    exit;
                }
            }
        }
        header('Location: ' . BASEURL . '/ebook/checkout/' . $id);
        exit;
    }

    public function remove_voucher_checkout($id)
    {
        unset($_SESSION['ebook_voucher']);
        header('Location: ' . BASEURL . '/ebook/checkout/' . $id . '?voucher=removed');
        exit;
    }

    public function order_ebook($id = null)
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASEURL . '/auth/login');
            exit;
        }

        $ebook = $this->model('EbookModel')->getEbookById($id);
        if (!$ebook || $ebook['status'] !== 'active') {
            header('Location: ' . BASEURL . '/ebook');
            exit;
        }

        $isFree = ($ebook['is_free'] == 1 || floatval($ebook['ebook_price']) == 0);
        if ($isFree) {
            header('Location: ' . BASEURL . '/ebook/download/' . $id);
            exit;
        }

        $subtotal = floatval($ebook['ebook_price']);
        $voucher_code = null;
        $discount_amount = 0.00;

        if (isset($_SESSION['ebook_voucher'])) {
            $res = $this->model('VoucherModel')->validateAndCalculate($_SESSION['ebook_voucher']['code'], $subtotal, 'ebook');
            if ($res['valid']) {
                $voucher_code = $res['voucher']['code'];
                $discount_amount = $res['discount_amount'];
                $this->model('VoucherModel')->applyVoucherUsage($voucher_code);
            }
            unset($_SESSION['ebook_voucher']);
        }

        $final_amount = max(0, $subtotal - $discount_amount);

        // Buat order jika belum ada atau gunakan yang aktif
        $order_id = $this->model('EbookOrderModel')->createEbookOrder(
            $_SESSION['user_id'],
            $id,
            $final_amount,
            $voucher_code,
            $discount_amount
        );

        if ($order_id) {
            header('Location: ' . BASEURL . '/ebook/pay/' . $order_id);
        } else {
            header('Location: ' . BASEURL . '/ebook/detail/' . $id . '?msg=order_error');
        }
        exit;
    }

    public function apply_voucher_pay($order_id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])) {
            $code = trim($_POST['voucher_code'] ?? '');
            $order = $this->model('EbookOrderModel')->getEbookOrderById($order_id);
            if ($order && $order['user_id'] == $_SESSION['user_id'] && $order['status'] === 'pending') {
                $subtotal = floatval($order['ebook_price']);
                $res = $this->model('VoucherModel')->validateAndCalculate($code, $subtotal, 'ebook');
                if ($res['valid']) {
                    $voucher_code = $res['voucher']['code'];
                    $discount_amount = $res['discount_amount'];
                    $new_amount = max(0, $subtotal - $discount_amount);
                    $this->model('EbookOrderModel')->updateOrderVoucher($order_id, $voucher_code, $discount_amount, $new_amount);
                    $this->model('VoucherModel')->applyVoucherUsage($voucher_code);
                    header('Location: ' . BASEURL . '/ebook/pay/' . $order_id . '?voucher=applied');
                    exit;
                } else {
                    header('Location: ' . BASEURL . '/ebook/pay/' . $order_id . '?voucher_err=' . urlencode($res['message']));
                    exit;
                }
            }
        }
        header('Location: ' . BASEURL . '/ebook/pay/' . $order_id);
        exit;
    }

    public function remove_voucher_pay($order_id)
    {
        if (isset($_SESSION['user_id'])) {
            $order = $this->model('EbookOrderModel')->getEbookOrderById($order_id);
            if ($order && $order['user_id'] == $_SESSION['user_id'] && $order['status'] === 'pending' && !empty($order['voucher_code'])) {
                $original_price = floatval($order['ebook_price']);
                $this->model('EbookOrderModel')->removeOrderVoucher($order_id, $original_price);
                header('Location: ' . BASEURL . '/ebook/pay/' . $order_id . '?voucher=removed');
                exit;
            }
        }
        header('Location: ' . BASEURL . '/ebook/pay/' . $order_id);
        exit;
    }

    /**
     * Halaman pembayaran e-book (upload bukti transfer)
     */
    public function pay($order_id = null)
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASEURL . '/auth/login');
            exit;
        }

        $order = $this->model('EbookOrderModel')->getEbookOrderById($order_id);

        // Validasi: order ada dan milik user ini
        if (!$order || $order['user_id'] != $_SESSION['user_id']) {
            header('Location: ' . BASEURL . '/ebook');
            exit;
        }

        // Jika sudah confirmed, tidak perlu bayar lagi
        if ($order['status'] === 'confirmed') {
            header('Location: ' . BASEURL . '/ebook/detail/' . $order['ebook_id'] . '?msg=already_confirmed');
            exit;
        }

        // Handle POST: upload bukti bayar
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_FILES['receipt']) && $_FILES['receipt']['error'] == 0) {
                $target_dir = dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR;
                if (!file_exists($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }

                $file_ext = strtolower(pathinfo($_FILES['receipt']['name'], PATHINFO_EXTENSION));
                $allowed = ['jpg', 'jpeg', 'png', 'pdf'];
                if (!in_array($file_ext, $allowed)) {
                    header('Location: ' . BASEURL . '/ebook/pay/' . $order_id . '?msg=invalid_file');
                    exit;
                }

                $new_filename = 'ebook_receipt_' . $order_id . '_' . uniqid() . '.' . $file_ext;
                $target_file = $target_dir . $new_filename;

                if (move_uploaded_file($_FILES['receipt']['tmp_name'], $target_file)) {
                    $receipt_path = BASEURL . '/assets/uploads/' . $new_filename;
                    $this->model('EbookOrderModel')->uploadReceipt($order_id, $receipt_path, $_SESSION['user_id']);
                    header('Location: ' . BASEURL . '/ebook/pay/' . $order_id . '?msg=receipt_uploaded');
                    exit;
                }
            }
            header('Location: ' . BASEURL . '/ebook/pay/' . $order_id . '?msg=upload_error');
            exit;
        }

        $data['judul'] = 'Pembayaran E-Book - Unsoed Press';
        $data['order'] = $order;
        $data['active_vouchers'] = $this->model('VoucherModel')->getActiveVouchers('ebook');
        $data['settings'] = $this->model('SettingModel')->getSettings();

        $this->view('templates/header', $data);
        $this->view('ebook/pay', $data);
        $this->view('templates/footer');
    }

    /**
     * Download ebook: gratis langsung, berbayar cek confirmed access
     */
    public function download($id = null)
    {
        if (!$id) {
            header('Location: ' . BASEURL . '/ebook');
            exit;
        }

        $ebook = $this->model('EbookModel')->getEbookById($id);
        if (!$ebook) {
            header('Location: ' . BASEURL . '/ebook');
            exit;
        }

        $isFree = ($ebook['is_free'] == 1 || floatval($ebook['ebook_price']) == 0);

        if (!$isFree) {
            if (!isset($_SESSION['user_id'])) {
                header('Location: ' . BASEURL . '/auth/login');
                exit;
            }
            $hasAccess = $this->model('EbookModel')->hasUserAccessToEbook($_SESSION['user_id'], $id);
            if (!$hasAccess) {
                header('Location: ' . BASEURL . '/ebook/detail/' . $id . '?msg=need_purchase');
                exit;
            }
        }

        // Path absolut ke file PDF
        $rootPath = dirname(dirname(dirname(__FILE__)));
        $filePath = $rootPath . DIRECTORY_SEPARATOR . 'public'
                  . DIRECTORY_SEPARATOR . 'assets'
                  . DIRECTORY_SEPARATOR . 'uploads'
                  . DIRECTORY_SEPARATOR . 'ebooks'
                  . DIRECTORY_SEPARATOR . $ebook['file_pdf'];

        if (!empty($ebook['file_pdf']) && file_exists($filePath)) {
            $this->model('EbookModel')->incrementDownload($id);

            $filename = 'Unsoed_Press_' . preg_replace('/[^a-zA-Z0-9_.-]/', '_', $ebook['title']) . '.pdf';
            header('Content-Description: File Transfer');
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filePath));
            ob_clean();
            flush();
            readfile($filePath);
            exit;
        } else {
            header('Location: ' . BASEURL . '/ebook/detail/' . $id . '?msg=file_not_ready');
            exit;
        }
    }
}
