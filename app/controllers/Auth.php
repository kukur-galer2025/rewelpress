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
            $password = $_POST['password'];
            
            // Validasi email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $data['error'] = 'Format email tidak valid!';
            } 
            // Validasi password: minimal 8 karakter, huruf besar, angka, dan simbol
            else if (!preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $password)) {
                $data['error'] = 'Sandi minimal 8 karakter, mengandung huruf besar, angka, dan simbol!';
            } 
            else {
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
                
                // Load PHPMailer
                require_once '../vendor/autoload.php';
                $mail = new \PHPMailer\PHPMailer\PHPMailer(true);

                try {
                    $mail->isSMTP();
                    $mail->Host       = SMTP_HOST;
                    $mail->SMTPAuth   = true;
                    $mail->Username   = SMTP_USER;
                    $mail->Password   = SMTP_PASS;
                    $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port       = SMTP_PORT;

                    $mail->setFrom(SMTP_USER, 'Unsoed Press');
                    $mail->addAddress($email);

                    $mail->isHTML(true);
                    $mail->Subject = 'Reset Kata Sandi Akun Unsoed Press Anda';
                    $mail->Body    = "
                        <h3>Halo, {$user['name']}</h3>
                        <p>Kami menerima permintaan untuk mereset kata sandi akun Unsoed Press Anda.</p>
                        <p>Silakan klik tautan di bawah ini untuk membuat kata sandi baru:</p>
                        <br>
                        <a href='{$reset_link}' style='background-color:#1c3d5a; color:white; padding:10px 20px; text-decoration:none; border-radius:5px; font-weight:bold;'>Reset Kata Sandi</a>
                        <br><br>
                        <p>Jika Anda tidak meminta reset kata sandi, abaikan email ini.</p>
                        <p>Terima kasih,<br>Tim Unsoed Press</p>
                    ";

                    $mail->send();
                    $data['success'] = 'Tautan reset sandi telah dikirim ke email Anda! Silakan cek kotak masuk atau folder spam.';
                } catch (Exception $e) {
                    $data['error'] = "Gagal mengirim email. Silakan coba lagi nanti. Pesan Error: {$mail->ErrorInfo}";
                }
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

    public function google_login()
    {
        require_once '../vendor/autoload.php';
        $client = new Google_Client();
        $client->setClientId(GOOGLE_CLIENT_ID);
        $client->setClientSecret(GOOGLE_CLIENT_SECRET);
        $client->setRedirectUri(GOOGLE_REDIRECT_URI);
        $client->addScope("email");
        $client->addScope("profile");

        $auth_url = $client->createAuthUrl();
        header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
        exit;
    }

    public function google_callback()
    {
        require_once '../vendor/autoload.php';
        $client = new Google_Client();
        $client->setClientId(GOOGLE_CLIENT_ID);
        $client->setClientSecret(GOOGLE_CLIENT_SECRET);
        $client->setRedirectUri(GOOGLE_REDIRECT_URI);

        // Fix cURL error 60 on localhost Windows
        $guzzleClient = new \GuzzleHttp\Client(['verify' => false]);
        $client->setHttpClient($guzzleClient);

        if (isset($_GET['code'])) {
            $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
            if(!isset($token['error'])) {
                $client->setAccessToken($token['access_token']);
                $google_oauth = new Google_Service_Oauth2($client);
                $google_account_info = $google_oauth->userinfo->get();
                
                $email =  $google_account_info->email;
                $name =  $google_account_info->name;
                
                // Get or create user
                $user_model = $this->model('UserModel');
                
                // If user doesn't exist, it registers and returns ID, if exists, returns existing ID
                $user_id = $user_model->registerGoogleUser($name, $email);
                
                // Get full user data to set session properly
                $user = $user_model->getUserById($user_id);
                
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_role'] = $user['role'];
                
                header('Location: ' . BASEURL);
                exit;
            } else {
                // Dump the error for debugging
                $error_msg = is_array($token) ? json_encode($token) : "Unknown error";
                die("Google API Error: " . $error_msg . " | Check your Client ID, Secret, and Redirect URI match perfectly.");
            }
        }
        
        header('Location: ' . BASEURL . '/auth/login');
        exit;
    }
}
