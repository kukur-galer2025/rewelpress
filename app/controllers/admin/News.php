<?php

class News extends Controller {
    public function __construct()
    {
        // Require login and admin role
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
            header('Location: ' . BASEURL . '/auth/login');
            exit;
        }
    }

    public function index()
    {
        $data['judul'] = 'Kelola Berita / Agenda';
        $data['news'] = $this->model('NewsModel')->getAllNews();
        
        $this->view('templates/admin_header', $data);
        $this->view('admin/news/index', $data);
        $this->view('templates/admin_footer');
    }

    public function create()
    {
        $data['judul'] = 'Tambah Berita Baru';
        
        $this->view('templates/admin_header', $data);
        $this->view('admin/news/create', $data);
        $this->view('templates/admin_footer');
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $_POST['title'])));
            
            $data = [
                'title' => trim($_POST['title']),
                'slug' => $slug,
                'content' => $_POST['content'],
                'image' => $_POST['image_url'] ?? '' // Using URL for simplicity, or handle file upload here
            ];
            
            if ($this->model('NewsModel')->addNews($data) > 0) {
                Flasher::setFlash('berhasil', 'ditambahkan', 'success');
                header('Location: ' . BASEURL . '/admin/news');
                exit;
            } else {
                Flasher::setFlash('gagal', 'ditambahkan', 'danger');
                header('Location: ' . BASEURL . '/admin/news');
                exit;
            }
        }
    }

    public function edit($id)
    {
        $data['judul'] = 'Edit Berita';
        $data['news'] = $this->model('NewsModel')->getNewsById($id);
        
        $this->view('templates/admin_header', $data);
        $this->view('admin/news/edit', $data);
        $this->view('templates/admin_footer');
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $_POST['title'])));
            
            $data = [
                'id' => $_POST['id'],
                'title' => trim($_POST['title']),
                'slug' => $slug,
                'content' => $_POST['content'],
                'image' => $_POST['image_url'] ?? ''
            ];
            
            if ($this->model('NewsModel')->updateNews($data) >= 0) {
                Flasher::setFlash('berhasil', 'diubah', 'success');
                header('Location: ' . BASEURL . '/admin/news');
                exit;
            } else {
                Flasher::setFlash('gagal', 'diubah', 'danger');
                header('Location: ' . BASEURL . '/admin/news');
                exit;
            }
        }
    }

    public function delete($id)
    {
        if ($this->model('NewsModel')->deleteNews($id) > 0) {
            Flasher::setFlash('berhasil', 'dihapus', 'success');
            header('Location: ' . BASEURL . '/admin/news');
            exit;
        } else {
            Flasher::setFlash('gagal', 'dihapus', 'danger');
            header('Location: ' . BASEURL . '/admin/news');
            exit;
        }
    }
}
