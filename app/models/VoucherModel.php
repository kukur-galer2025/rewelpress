<?php

class VoucherModel {
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    /**
     * Ambil semua voucher (untuk Admin)
     */
    public function getAllVouchers()
    {
        $this->db->query('SELECT * FROM vouchers ORDER BY id DESC');
        return $this->db->resultSet();
    }

    /**
     * Ambil voucher aktif (untuk display promo umum dan checkout)
     */
    public function getActiveVouchers($applicable_to = 'all')
    {
        $sql = 'SELECT * FROM vouchers 
                WHERE is_active = 1 
                AND (start_date IS NULL OR start_date <= NOW())
                AND (end_date IS NULL OR end_date >= NOW())
                AND (quota = 0 OR used_count < quota)';
        
        if ($applicable_to !== 'all') {
            $sql .= ' AND (applicable_to = :applicable_to OR applicable_to = "all")';
        }
        
        $sql .= ' ORDER BY id DESC';

        $this->db->query($sql);
        if ($applicable_to !== 'all') {
            $this->db->bind(':applicable_to', $applicable_to);
        }
        return $this->db->resultSet();
    }

    /**
     * Ambil detail voucher berdasarkan ID
     */
    public function getVoucherById($id)
    {
        $this->db->query('SELECT * FROM vouchers WHERE id = :id');
        $this->db->bind(':id', (int)$id);
        return $this->db->single();
    }

    /**
     * Ambil detail voucher berdasarkan kode
     */
    public function getVoucherByCode($code)
    {
        $this->db->query('SELECT * FROM vouchers WHERE code = :code');
        $this->db->bind(':code', trim(strtoupper($code)));
        return $this->db->single();
    }

    /**
     * Validasi dan hitung diskon voucher
     */
    public function validateAndCalculate($code, $subtotal, $applicable_to = 'all')
    {
        $code = trim(strtoupper($code));
        if (empty($code)) {
            return ['valid' => false, 'message' => 'Kode voucher tidak boleh kosong.'];
        }

        $v = $this->getVoucherByCode($code);
        if (!$v) {
            return ['valid' => false, 'message' => 'Kode voucher tidak ditemukan atau salah.'];
        }

        if ($v['is_active'] == 0) {
            return ['valid' => false, 'message' => 'Voucher ini sedang tidak aktif.'];
        }

        $now = date('Y-m-d H:i:s');
        if (!empty($v['start_date']) && $now < $v['start_date']) {
            return ['valid' => false, 'message' => 'Voucher belum berlaku.'];
        }
        if (!empty($v['end_date']) && $now > $v['end_date']) {
            return ['valid' => false, 'message' => 'Masa berlaku voucher telah berakhir.'];
        }

        if ($v['quota'] > 0 && $v['used_count'] >= $v['quota']) {
            return ['valid' => false, 'message' => 'Kuota pemakaian voucher ini sudah habis.'];
        }

        if ($v['applicable_to'] !== 'all' && $applicable_to !== 'all' && $v['applicable_to'] !== $applicable_to) {
            $typeText = ($v['applicable_to'] === 'ebook') ? 'E-Book Digital' : 'Buku Fisik';
            return ['valid' => false, 'message' => 'Voucher ini hanya berlaku untuk pembelian ' . $typeText . '.'];
        }

        if ($subtotal < $v['min_purchase']) {
            return ['valid' => false, 'message' => 'Minimum pembelian untuk voucher ini adalah Rp ' . number_format($v['min_purchase'], 0, ',', '.') . '.'];
        }

        // Hitung diskon
        $discount = 0;
        if ($v['discount_type'] === 'percent') {
            $discount = $subtotal * (floatval($v['discount_value']) / 100);
            if (!empty($v['max_discount']) && floatval($v['max_discount']) > 0 && $discount > floatval($v['max_discount'])) {
                $discount = floatval($v['max_discount']);
            }
        } else {
            $discount = floatval($v['discount_value']);
        }

        if ($discount > $subtotal) {
            $discount = $subtotal;
        }

        return [
            'valid' => true,
            'discount_amount' => $discount,
            'voucher' => $v,
            'message' => 'Voucher berhasil diterapkan! Hemat Rp ' . number_format($discount, 0, ',', '.')
        ];
    }

    /**
     * Tambahkan jumlah pemakaian voucher (+1)
     */
    public function applyVoucherUsage($code)
    {
        $this->db->query('UPDATE vouchers SET used_count = used_count + 1 WHERE code = :code');
        $this->db->bind(':code', trim(strtoupper($code)));
        return $this->db->execute();
    }

    /**
     * CRUD: Tambah voucher baru
     */
    public function addVoucher($data)
    {
        $this->db->query('
            INSERT INTO vouchers (code, title, description, discount_type, discount_value, min_purchase, max_discount, applicable_to, quota, start_date, end_date, is_active)
            VALUES (:code, :title, :description, :discount_type, :discount_value, :min_purchase, :max_discount, :applicable_to, :quota, :start_date, :end_date, :is_active)
        ');
        $this->db->bind(':code', trim(strtoupper($data['code'])));
        $this->db->bind(':title', trim($data['title']));
        $this->db->bind(':description', trim($data['description'] ?? ''));
        $this->db->bind(':discount_type', $data['discount_type']);
        $this->db->bind(':discount_value', floatval($data['discount_value']));
        $this->db->bind(':min_purchase', floatval($data['min_purchase'] ?? 0));
        $this->db->bind(':max_discount', !empty($data['max_discount']) ? floatval($data['max_discount']) : null);
        $this->db->bind(':applicable_to', $data['applicable_to']);
        $this->db->bind(':quota', intval($data['quota'] ?? 0));
        $this->db->bind(':start_date', !empty($data['start_date']) ? $data['start_date'] : null);
        $this->db->bind(':end_date', !empty($data['end_date']) ? $data['end_date'] : null);
        $this->db->bind(':is_active', isset($data['is_active']) ? 1 : 0);

        return $this->db->execute();
    }

    /**
     * CRUD: Update voucher
     */
    public function updateVoucher($id, $data)
    {
        $this->db->query('
            UPDATE vouchers 
            SET code = :code, title = :title, description = :description, discount_type = :discount_type, 
                discount_value = :discount_value, min_purchase = :min_purchase, max_discount = :max_discount, 
                applicable_to = :applicable_to, quota = :quota, start_date = :start_date, end_date = :end_date, 
                is_active = :is_active
            WHERE id = :id
        ');
        $this->db->bind(':id', (int)$id);
        $this->db->bind(':code', trim(strtoupper($data['code'])));
        $this->db->bind(':title', trim($data['title']));
        $this->db->bind(':description', trim($data['description'] ?? ''));
        $this->db->bind(':discount_type', $data['discount_type']);
        $this->db->bind(':discount_value', floatval($data['discount_value']));
        $this->db->bind(':min_purchase', floatval($data['min_purchase'] ?? 0));
        $this->db->bind(':max_discount', !empty($data['max_discount']) ? floatval($data['max_discount']) : null);
        $this->db->bind(':applicable_to', $data['applicable_to']);
        $this->db->bind(':quota', intval($data['quota'] ?? 0));
        $this->db->bind(':start_date', !empty($data['start_date']) ? $data['start_date'] : null);
        $this->db->bind(':end_date', !empty($data['end_date']) ? $data['end_date'] : null);
        $this->db->bind(':is_active', isset($data['is_active']) ? 1 : 0);

        return $this->db->execute();
    }

    /**
     * CRUD: Hapus voucher
     */
    public function deleteVoucher($id)
    {
        $this->db->query('DELETE FROM vouchers WHERE id = :id');
        $this->db->bind(':id', (int)$id);
        return $this->db->execute();
    }
}
