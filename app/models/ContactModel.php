<?php

class ContactModel {
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getAllMessages()
    {
        $this->db->query('SELECT * FROM contact_messages ORDER BY created_at DESC');
        return $this->db->resultSet();
    }

    public function getUnreadCount()
    {
        $this->db->query('SELECT COUNT(*) as count FROM contact_messages WHERE is_read = 0');
        $result = $this->db->single();
        return $result ? $result['count'] : 0;
    }

    public function getMessageById($id)
    {
        $this->db->query('SELECT * FROM contact_messages WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function addMessage($data)
    {
        $this->db->query('INSERT INTO contact_messages (full_name, email, subject, message, is_read, created_at) VALUES (:full_name, :email, :subject, :message, 0, NOW())');
        $this->db->bind(':full_name', trim($data['full_name']));
        $this->db->bind(':email', trim($data['email']));
        $this->db->bind(':subject', trim($data['subject']));
        $this->db->bind(':message', trim($data['message']));
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function markAsRead($id)
    {
        $this->db->query('UPDATE contact_messages SET is_read = 1 WHERE id = :id');
        $this->db->bind(':id', $id);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function deleteMessage($id)
    {
        $this->db->query('DELETE FROM contact_messages WHERE id = :id');
        $this->db->bind(':id', $id);
        $this->db->execute();
        return $this->db->rowCount();
    }
}
