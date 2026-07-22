<?php

class Book extends Controller {
    public function index()
    {
        $data['judul'] = 'Katalog Buku - Unsoed Press';
        $data['buku'] = $this->model('BookModel')->getAllBooks();
        $data['categories'] = $this->model('CategoryModel')->getHierarchicalCategories();
        $data['active_category'] = null;
        
        $this->view('templates/header', $data);
        $this->view('book/index', $data);
        $this->view('templates/footer');
    }

    public function category($id = null)
    {
        if(is_null($id)) {
            header('Location: ' . BASEURL . '/book');
            exit;
        }

        $data['buku'] = $this->model('BookModel')->getBooksByCategory($id);
        $data['categories'] = $this->model('CategoryModel')->getHierarchicalCategories();
        $data['active_category'] = $id;
        
        $cat_name = 'Katalog';
        foreach($data['categories'] as $cat) {
            if($cat['id'] == $id) {
                $cat_name = $cat['name'];
                break;
            }
        }
        $data['judul'] = 'Kategori: ' . $cat_name . ' - Unsoed Press';

        $this->view('templates/header', $data);
        $this->view('book/index', $data);
        $this->view('templates/footer');
    }

    public function promo()
    {
        $data['judul'] = 'Super Sale & Flash Sale - Unsoed Press';
        $data['buku'] = $this->model('BookModel')->getPromoBooks();
        $data['categories'] = $this->model('CategoryModel')->getHierarchicalCategories();
        $data['active_category'] = 'promo';
        $data['is_promo_page'] = true;

        $this->view('templates/header', $data);
        $this->view('book/index', $data);
        $this->view('templates/footer');
    }

    public function detail($id = null)
    {
        if(is_null($id)) {
            header('Location: ' . BASEURL);
            exit;
        }

        $data['buku'] = $this->model('BookModel')->getBookById($id);
        
        if(!$data['buku']) {
            header('Location: ' . BASEURL);
            exit;
        }

        $data['judul'] = $data['buku']['title'] . ' - Unsoed Press';

        $this->view('templates/header', $data);
        $this->view('book/detail', $data);
        $this->view('templates/footer');
    }

    public function search()
    {
        $keyword = isset($_GET['q']) ? trim($_GET['q']) : '';
        
        $data['judul'] = 'Pencarian: ' . htmlspecialchars($keyword) . ' - Unsoed Press';
        $data['keyword'] = htmlspecialchars($keyword);
        
        if($keyword !== '') {
            $data['buku'] = $this->model('BookModel')->searchBooks($keyword);
        } else {
            $data['buku'] = [];
        }

        $this->view('templates/header', $data);
        $this->view('book/search', $data);
        $this->view('templates/footer');
    }

    public function live_search()
    {
        header('Content-Type: application/json');
        
        $keyword = isset($_GET['q']) ? trim($_GET['q']) : '';
        
        if($keyword !== '') {
            $buku = $this->model('BookModel')->searchBooks($keyword);
        } else {
            // If empty, return all books
            $buku = $this->model('BookModel')->getAllBooks();
        }

        echo json_encode($buku);
        exit;
    }
}
