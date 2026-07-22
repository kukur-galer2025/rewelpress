<?php

class UserModel {
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getUserByEmail($email)
    {
        $this->db->query('SELECT * FROM users WHERE email = :email');
        $this->db->bind(':email', $email);
        return $this->db->single();
    }
    
    public function getUserById($id)
    {
        $this->db->query('SELECT * FROM users WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function registerUser($data)
    {
        $this->db->query('INSERT INTO users (name, email, password, role) VALUES (:name, :email, :password, :role)');
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        
        $hashed_password = password_hash($data['password'], PASSWORD_BCRYPT);
        $this->db->bind(':password', $hashed_password);
        $this->db->bind(':role', 'customer');
        
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function createPasswordResetToken($email)
    {
        // Delete any existing token for this email
        $this->db->query('DELETE FROM password_resets WHERE email = :email');
        $this->db->bind(':email', $email);
        $this->db->execute();
        
        // Generate random token
        $token = bin2hex(random_bytes(32));
        
        // Insert new token
        $this->db->query('INSERT INTO password_resets (email, token) VALUES (:email, :token)');
        $this->db->bind(':email', $email);
        $this->db->bind(':token', $token);
        $this->db->execute();
        
        return $token;
    }

    public function getResetToken($token)
    {
        $this->db->query('SELECT * FROM password_resets WHERE token = :token');
        $this->db->bind(':token', $token);
        return $this->db->single();
    }

    public function resetPassword($email, $new_password)
    {
        $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
        
        $this->db->query('UPDATE users SET password = :password WHERE email = :email');
        $this->db->bind(':password', $hashed_password);
        $this->db->bind(':email', $email);
        $this->db->execute();
        
        // Delete token after use
        $this->db->query('DELETE FROM password_resets WHERE email = :email');
        $this->db->bind(':email', $email);
        $this->db->execute();
        
        return true;
    }

    // ==========================================
    // METODE CRUD UNTUK PANEL ADMIN
    // ==========================================

    public function getAllUsers()
    {
        $this->db->query('SELECT * FROM users ORDER BY created_at DESC');
        return $this->db->resultSet();
    }

    public function addUser($data)
    {
        // Cek apakah email sudah ada
        if ($this->getUserByEmail($data['email'])) {
            return false;
        }

        $this->db->query('INSERT INTO users (name, email, password, role, phone, address, created_at) VALUES (:name, :email, :password, :role, :phone, :address, NOW())');
        $this->db->bind(':name', trim($data['name']));
        $this->db->bind(':email', trim($data['email']));
        
        $password = !empty($data['password']) ? $data['password'] : 'unsoed123';
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $this->db->bind(':password', $hashed_password);
        
        $this->db->bind(':role', $data['role'] ?? 'customer');
        $this->db->bind(':phone', trim($data['phone'] ?? ''));
        $this->db->bind(':address', trim($data['address'] ?? ''));
        
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function updateUser($data)
    {
        // Cek apakah ada perubahan password
        if (!empty($data['password'])) {
            $query = 'UPDATE users SET name = :name, email = :email, password = :password, role = :role, phone = :phone, address = :address WHERE id = :id';
            $this->db->query($query);
            $hashed_password = password_hash($data['password'], PASSWORD_BCRYPT);
            $this->db->bind(':password', $hashed_password);
        } else {
            $query = 'UPDATE users SET name = :name, email = :email, role = :role, phone = :phone, address = :address WHERE id = :id';
            $this->db->query($query);
        }

        $this->db->bind(':name', trim($data['name']));
        $this->db->bind(':email', trim($data['email']));
        $this->db->bind(':role', $data['role'] ?? 'customer');
        $this->db->bind(':phone', trim($data['phone'] ?? ''));
        $this->db->bind(':address', trim($data['address'] ?? ''));
        $this->db->bind(':id', (int)$data['id']);

        $this->db->execute();
        return $this->db->rowCount();
    }

    public function deleteUser($id)
    {
        // Jangan izinkan hapus akun diri sendiri yang sedang login (keamanan dasar)
        if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $id) {
            return false;
        }

        $this->db->query('DELETE FROM users WHERE id = :id');
        $this->db->bind(':id', (int)$id);
        $this->db->execute();
        return $this->db->rowCount();
    }
}
