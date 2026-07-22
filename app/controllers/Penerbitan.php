<?php

class Penerbitan extends Controller {
    public function index()
    {
        $data['judul'] = 'Layanan & Prosedur Penerbitan - Unsoed Press';

        $this->view('templates/header', $data);
        $this->view('penerbitan/index', $data);
        $this->view('templates/footer');
    }
}
