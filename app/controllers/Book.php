<?php

class Book extends Controller {
    public function index()
    {
        $keyword = isset($_GET['q']) ? trim($_GET['q']) : '';
        $author = isset($_GET['author']) ? trim($_GET['author']) : '';
        $per_page = isset($_GET['per_page']) ? (int)$_GET['per_page'] : 10;
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        if (!in_array($per_page, [5, 10, 15, 20])) $per_page = 10;
        $offset = ($page - 1) * $per_page;

        $data['judul'] = 'Katalog Buku - Unsoed Press';
        $data['buku'] = $this->model('BookModel')->getFilteredBooks($keyword, $author, null, $per_page, $offset);
        $data['total_books'] = $this->model('BookModel')->getFilteredBooksCount($keyword, $author, null);
        $data['categories'] = $this->model('CategoryModel')->getHierarchicalCategories();
        $data['authors'] = $this->model('BookModel')->getBookAuthors();
        $data['active_category'] = null;
        $data['keyword'] = $keyword;
        $data['active_author'] = $author;
        $data['per_page'] = $per_page;
        $data['current_page'] = $page;
        $data['total_pages'] = ceil($data['total_books'] / $per_page);
        
        $this->view('templates/header', $data);
        $this->view('book/index', $data);
        $this->view('templates/footer');
    }

    public function category($id_or_slug = null)
    {
        if(is_null($id_or_slug)) {
            header('Location: ' . BASEURL . '/book');
            exit;
        }

        $category = $this->model('CategoryModel')->getCategoryByIdOrSlug($id_or_slug);
        if(!$category) {
            header('Location: ' . BASEURL . '/book');
            exit;
        }
        $id = $category['id'];

        $keyword = isset($_GET['q']) ? trim($_GET['q']) : '';
        $author = isset($_GET['author']) ? trim($_GET['author']) : '';
        $per_page = isset($_GET['per_page']) ? (int)$_GET['per_page'] : 10;
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        if (!in_array($per_page, [5, 10, 15, 20])) $per_page = 10;
        $offset = ($page - 1) * $per_page;

        $data['buku'] = $this->model('BookModel')->getFilteredBooks($keyword, $author, $id, $per_page, $offset);
        $data['total_books'] = $this->model('BookModel')->getFilteredBooksCount($keyword, $author, $id);
        $data['categories'] = $this->model('CategoryModel')->getHierarchicalCategories();
        $data['authors'] = $this->model('BookModel')->getBookAuthors();
        $data['active_category'] = $id;
        $data['active_category_slug'] = $category['slug'];
        $data['keyword'] = $keyword;
        $data['active_author'] = $author;
        $data['per_page'] = $per_page;
        $data['current_page'] = $page;
        $data['total_pages'] = ceil($data['total_books'] / $per_page);
        
        $cat_name = $category['name'];
        $data['judul'] = 'Kategori: ' . $cat_name . ' - Unsoed Press';

        $this->view('templates/header', $data);
        $this->view('book/index', $data);
        $this->view('templates/footer');
    }

    public function promo()
    {
        $keyword = isset($_GET['q']) ? trim($_GET['q']) : '';
        $author = isset($_GET['author']) ? trim($_GET['author']) : '';
        
        $data['judul'] = 'Super Sale & Flash Sale - Unsoed Press';
        $buku_promo = $this->model('BookModel')->getPromoBooks($keyword, $author);
        
        // Manual pagination for promo books (since it's a special query)
        $per_page = isset($_GET['per_page']) ? (int)$_GET['per_page'] : 10;
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        if (!in_array($per_page, [5, 10, 15, 20])) $per_page = 10;
        $offset = ($page - 1) * $per_page;
        
        $data['total_books'] = count($buku_promo);
        $data['buku'] = array_slice($buku_promo, $offset, $per_page);
        
        $data['categories'] = $this->model('CategoryModel')->getHierarchicalCategories();
        $data['authors'] = $this->model('BookModel')->getBookAuthors();
        $data['active_category'] = 'promo';
        $data['is_promo_page'] = true;
        
        $data['keyword'] = $keyword;
        $data['active_author'] = $author;
        $data['per_page'] = $per_page;
        $data['current_page'] = $page;
        $data['total_pages'] = ceil($data['total_books'] / $per_page);

        $this->view('templates/header', $data);
        $this->view('book/index', $data);
        $this->view('templates/footer');
    }

    public function detail($id_or_slug = null)
    {
        if(is_null($id_or_slug)) {
            header('Location: ' . BASEURL);
            exit;
        }

        $data['buku'] = $this->model('BookModel')->getBookByIdOrSlug($id_or_slug);
        
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
