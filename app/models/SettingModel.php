<?php

class SettingModel {
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getSettings()
    {
        $this->db->query('SELECT * FROM settings WHERE id = 1');
        return $this->db->single();
    }

    public function updateSettings($data)
    {
        $query = "UPDATE settings SET bank_accounts = :bank_accounts, qris_image = :qris_image WHERE id = 1";
        $this->db->query($query);
        $this->db->bind(':bank_accounts', $data['bank_accounts']);
        $this->db->bind(':qris_image', $data['qris_image']);
        $this->db->execute();
        return $this->db->rowCount();
    }
}
