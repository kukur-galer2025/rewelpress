<?php

class Promo extends Controller {
    
    public function index()
    {
        $data['judul'] = 'Katalog Promo & Voucher Diskon - Unsoed Press';
        $data['vouchers'] = $this->model('VoucherModel')->getActiveVouchers('all');
        
        $this->view('templates/header', $data);
        $this->view('promo/index', $data);
        $this->view('templates/footer');
    }

    /**
     * Endpoint AJAX untuk memvalidasi voucher dan menghitung diskon saat checkout
     */
    public function validate_ajax()
    {
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $code = $_POST['code'] ?? '';
            $subtotal = floatval($_POST['subtotal'] ?? 0);
            $type = $_POST['type'] ?? 'all'; // 'book' atau 'ebook'

            $result = $this->model('VoucherModel')->validateAndCalculate($code, $subtotal, $type);
            echo json_encode($result);
            exit;
        }
        echo json_encode(['valid' => false, 'message' => 'Invalid request']);
        exit;
    }
}
