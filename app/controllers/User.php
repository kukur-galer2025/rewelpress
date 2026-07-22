<?php

class User extends Controller {

    public function __construct()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASEURL . '/auth/login');
            exit;
        }
    }

    public function profile()
    {
        $data['judul'] = 'Profil Saya - Unsoed Press';
        $data['user'] = $this->model('UserModel')->getUserById($_SESSION['user_id']);

        $this->view('templates/header', $data);
        $this->view('user/profile', $data);
        $this->view('templates/footer');
    }

    public function update_profile()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASEURL . '/user/profile');
            exit;
        }

        $user = $this->model('UserModel')->getUserById($_SESSION['user_id']);

        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $current_password = $_POST['current_password'] ?? '';
        $new_password = $_POST['new_password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';

        if (empty($name) || empty($email)) {
            $_SESSION['flash_error'] = 'Nama dan email wajib diisi.';
            header('Location: ' . BASEURL . '/user/profile');
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['flash_error'] = 'Format email tidak valid.';
            header('Location: ' . BASEURL . '/user/profile');
            exit;
        }

        // Check if email changed and already taken
        if ($email !== $user['email']) {
            $existingUser = $this->model('UserModel')->getUserByEmail($email);
            if ($existingUser) {
                $_SESSION['flash_error'] = 'Email sudah digunakan oleh akun lain.';
                header('Location: ' . BASEURL . '/user/profile');
                exit;
            }
        }

        // Handle password change
        $passwordToUpdate = null;
        if (!empty($new_password)) {
            if (empty($current_password) || !password_verify($current_password, $user['password'])) {
                $_SESSION['flash_error'] = 'Password lama salah.';
                header('Location: ' . BASEURL . '/user/profile');
                exit;
            }
            if ($new_password !== $confirm_password) {
                $_SESSION['flash_error'] = 'Konfirmasi password baru tidak cocok.';
                header('Location: ' . BASEURL . '/user/profile');
                exit;
            }
            if (!preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $new_password)) {
                $_SESSION['flash_error'] = 'Sandi minimal 8 karakter, mengandung huruf besar, angka, dan simbol!';
                header('Location: ' . BASEURL . '/user/profile');
                exit;
            }
            $passwordToUpdate = $new_password;
        }

        $result = $this->model('UserModel')->updateProfile($_SESSION['user_id'], [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'password' => $passwordToUpdate
        ]);

        if ($result) {
            $_SESSION['user_name'] = $name;
            $_SESSION['flash_success'] = 'Profil berhasil diperbarui!';
        } else {
            $_SESSION['flash_error'] = 'Gagal memperbarui profil.';
        }

        header('Location: ' . BASEURL . '/user/profile');
        exit;
    }
}
