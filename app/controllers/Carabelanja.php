<?php

class Carabelanja extends Controller {
    public function index()
    {
        $data['judul'] = 'Panduan & Cara Belanja Buku - Unsoed Press';

        $this->view('templates/header', $data);
        $this->view('carabelanja/index', $data);
        $this->view('templates/footer');
    }
}
