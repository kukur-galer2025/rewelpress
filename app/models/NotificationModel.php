<?php

class NotificationModel {
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    // --- Untuk Admin (user_id IS NULL atau 0) ---
    public function getAdminNotifications($limit = 15)
    {
        $this->db->query('SELECT * FROM notifications WHERE (user_id IS NULL OR user_id = 0) ORDER BY created_at DESC LIMIT :limit');
        $this->db->bind(':limit', (int)$limit);
        return $this->db->resultSet();
    }

    public function getAdminUnreadCount()
    {
        $this->db->query('SELECT COUNT(*) as count FROM notifications WHERE (user_id IS NULL OR user_id = 0) AND is_read = 0');
        $row = $this->db->single();
        return $row ? (int)$row['count'] : 0;
    }

    // --- Untuk Pengguna / Customer (user_id > 0) ---
    public function getUserNotifications($user_id, $limit = 15)
    {
        $this->db->query('SELECT * FROM notifications WHERE user_id = :user_id ORDER BY created_at DESC LIMIT :limit');
        $this->db->bind(':user_id', (int)$user_id);
        $this->db->bind(':limit', (int)$limit);
        return $this->db->resultSet();
    }

    public function getUserUnreadCount($user_id)
    {
        $this->db->query('SELECT COUNT(*) as count FROM notifications WHERE user_id = :user_id AND is_read = 0');
        $this->db->bind(':user_id', (int)$user_id);
        $row = $this->db->single();
        return $row ? (int)$row['count'] : 0;
    }

    // --- Tambah Notifikasi ---
    public function addNotification($user_id, $title, $message, $link = null)
    {
        $this->db->query('INSERT INTO notifications (user_id, title, message, link, is_read, created_at) VALUES (:user_id, :title, :message, :link, 0, NOW())');
        $this->db->bind(':user_id', ($user_id !== null && $user_id !== '') ? (int)$user_id : 0);
        $this->db->bind(':title', trim($title));
        $this->db->bind(':message', trim($message));
        $this->db->bind(':link', $link);
        $this->db->execute();
        return $this->db->rowCount();
    }

    // --- Tandai Dibaca ---
    public function markAsRead($id)
    {
        $this->db->query('UPDATE notifications SET is_read = 1 WHERE id = :id');
        $this->db->bind(':id', (int)$id);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function markAllAsReadForUser($user_id)
    {
        $this->db->query('UPDATE notifications SET is_read = 1 WHERE user_id = :user_id');
        $this->db->bind(':user_id', (int)$user_id);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function markAllAsReadForAdmin()
    {
        $this->db->query('UPDATE notifications SET is_read = 1 WHERE (user_id IS NULL OR user_id = 0)');
        $this->db->execute();
        return $this->db->rowCount();
    }
}
