<?php

class Auth extends Controller {
    
    public function index()
    {
        header('Location: ' . BASEURL . '/auth/login');
        exit;
    }

    public function login()
    {
        if(isset($_SESSION['user_id'])) {
            header('Location: ' . BASEURL);
            exit;
        }

        $data['judul'] = 'Login - Unsoed Press';

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];
            
            $user = $this->model('UserModel')->getUserByEmail($email);
            
            if($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_role'] = $user['role'];
                
                if($user['role'] == 'admin') {
                    header('Location: ' . BASEURL . '/admin');
                } else {
                    header('Location: ' . BASEURL);
                }
                exit;
            } else {
                $data['error'] = 'Email atau password salah!';
            }
        }

        $this->view('templates/auth_header', $data);
        $this->view('auth/login', $data);
        $this->view('templates/auth_footer');
    }

    public function register()
    {
        if(isset($_SESSION['user_id'])) {
            header('Location: ' . BASEURL);
            exit;
        }

        $data['judul'] = 'Register - Unsoed Press';

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            $user = $this->model('UserModel')->getUserByEmail($email);
            
            if($user) {
                $data['error'] = 'Email sudah terdaftar!';
            } else {
                if($this->model('UserModel')->registerUser($_POST) > 0) {
                    $data['success'] = 'Registrasi berhasil! Silakan login.';
                } else {
                    $data['error'] = 'Gagal melakukan registrasi.';
                }
            }
        }

        $this->view('templates/auth_header', $data);
        $this->view('auth/register', $data);
        $this->view('templates/auth_footer');
    }

    public function logout()
    {
        session_destroy();
        header('Location: ' . BASEURL . '/auth/login');
        exit;
    }

    public function forgot_password()
    {
        $data['judul'] = 'Lupa Password - Unsoed Press';

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            $user = $this->model('UserModel')->getUserByEmail($email);
            
            if($user) {
                $token = $this->model('UserModel')->createPasswordResetToken($email);
                
                // Construct reset link
                $reset_link = BASEURL . '/auth/reset_password/' . $token;
                
                // In a real app, use mail() or PHPMailer.
                // For this environment, we'll try using mail() which Laragon intercepts to its mail catcher,
                // BUT we also show it on the UI for easy local testing.
                $subject = "Reset Password Unsoed Press";
                $message = "Klik link berikut untuk mereset password Anda:\n\n" . $reset_link;
                $headers = "From: noreply@unsoedpress.test";
                
                @mail($email, $subject, $message, $headers);
                
                $data['success'] = 'Link reset password telah dikirim ke email Anda! (Karena ini mode simulasi lokal, linknya adalah: <a href="'.$reset_link.'" class="underline font-bold text-unsoed-blue">Klik Di Sini</a>)';
            } else {
                $data['error'] = 'Email tidak ditemukan di sistem kami.';
            }
        }

        $this->view('templates/auth_header', $data);
        $this->view('auth/forgot_password', $data);
        $this->view('templates/auth_footer');
    }

    public function reset_password($token = null)
    {
        if(is_null($token)) {
            header('Location: ' . BASEURL . '/auth/login');
            exit;
        }

        $reset_data = $this->model('UserModel')->getResetToken($token);
        
        if(!$reset_data) {
            die('Token tidak valid atau sudah kadaluarsa.');
        }

        $data['judul'] = 'Reset Password - Unsoed Press';
        $data['token'] = $token;

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $password = $_POST['password'];
            $password_confirm = $_POST['password_confirm'];
            
            if($password === $password_confirm) {
                $this->model('UserModel')->resetPassword($reset_data['email'], $password);
                header('Location: ' . BASEURL . '/auth/login?reset=success');
                exit;
            } else {
                $data['error'] = 'Konfirmasi password tidak cocok!';
            }
        }

        $this->view('templates/auth_header', $data);
        $this->view('auth/reset_password', $data);
        $this->view('templates/auth_footer');
    }
}
