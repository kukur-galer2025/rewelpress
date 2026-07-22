<?php

class Profile extends Controller {
    public function index()
    {
        $data['judul'] = 'Profile & Tentang Kami - Unsoed Press';

        $this->view('templates/header', $data);
        $this->view('profile/index', $data);
        $this->view('templates/footer');
    }
}
