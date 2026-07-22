<?php

class Notification extends Controller {
    public function read($id)
    {
        $this->model('NotificationModel')->markAsRead($id);
        
        $redirect = $_GET['link'] ?? $_SERVER['HTTP_REFERER'] ?? BASEURL;
        if (empty($redirect) || $redirect == '#') {
            $redirect = BASEURL;
        }
        header('Location: ' . $redirect);
        exit;
    }

    public function read_all()
    {
        // Cek apakah admin atau user biasa
        if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') {
            $this->model('NotificationModel')->markAllAsReadForAdmin();
        } elseif (isset($_SESSION['user_id'])) {
            $this->model('NotificationModel')->markAllAsReadForUser($_SESSION['user_id']);
        }
        
        $redirect = $_SERVER['HTTP_REFERER'] ?? BASEURL;
        header('Location: ' . $redirect);
        exit;
    }
}
