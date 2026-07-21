<?php

class News extends Controller {
    public function index()
    {
        $data['judul'] = 'Berita & Agenda - Unsoed Press';
        $data['news'] = $this->model('NewsModel')->getAllNews();
        
        $this->view('templates/header', $data);
        // Will create this view if needed, but for now just redirect or show basic
        $this->view('news/index', $data);
        $this->view('templates/footer');
    }

    public function read($slug)
    {
        $data['news'] = $this->model('NewsModel')->getNewsBySlug($slug);
        
        if (empty($data['news'])) {
            // Not found
            header('Location: ' . BASEURL);
            exit;
        }

        // Fetch other news for sidebar/related section
        $data['related_news'] = $this->model('NewsModel')->getLatestNews(4);
        
        $data['judul'] = $data['news']['title'] . ' - Unsoed Press';
        
        $this->view('templates/header', $data);
        $this->view('news/read', $data);
        $this->view('templates/footer');
    }
}
