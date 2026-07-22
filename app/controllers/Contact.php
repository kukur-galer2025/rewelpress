<?php

class Contact extends Controller {
    public function index()
    {
        $data['judul'] = 'Contact Us - Unsoed Press';

        $this->view('templates/header', $data);
        $this->view('contact/index', $data);
        $this->view('templates/footer');
    }

    public function send()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->model('ContactModel')->addMessage($_POST) > 0) {
                header('Location: ' . BASEURL . '/contact?msg=success');
            } else {
                header('Location: ' . BASEURL . '/contact?msg=error');
            }
            exit;
        }
    }
}
