<?php

class Home extends Controller {
    public function index()
    {
        $data['judul'] = 'Beranda - Unsoed Press';
        
        // Attempt to get books from DB, fallback to empty array if DB not setup
        try {
            $data['buku_terbaru'] = $this->model('BookModel')->getLatestBooks(5);
            $data['buku_terpopuler'] = $this->model('BookModel')->getPopularBooks(5);
            $data['buku_terlaris'] = $this->model('BookModel')->getBestSellerBooks(5);
            $data['tokoh_penulis'] = $this->model('BookModel')->getDistinctAuthors(6);
            $data['agenda_terkini'] = $this->model('NewsModel')->getLatestNews(3);
        } catch (Exception $e) {
            $data['buku_terbaru'] = [];
            $data['buku_terpopuler'] = [];
            $data['buku_terlaris'] = [];
            $data['tokoh_penulis'] = [];
            $data['agenda_terkini'] = [];
            $data['db_error'] = true;
        }

        $this->view('templates/header', $data);
        $this->view('home/index', $data);
        $this->view('templates/footer');
    }
}
