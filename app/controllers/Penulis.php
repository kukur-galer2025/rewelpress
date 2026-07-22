<?php

class Penulis extends Controller {
    public function index()
    {
        $data['judul'] = 'Daftar Tokoh Penulis - Unsoed Press';
        $data['authors'] = $this->model('AuthorModel')->getAllAuthors();
        
        $this->view('templates/header', $data);
        $this->view('penulis/index', $data);
        $this->view('templates/footer');
    }

    public function detail($id = null)
    {
        if(is_null($id)) {
            header('Location: ' . BASEURL . '/penulis');
            exit;
        }

        if(is_numeric($id)) {
            $author = $this->model('AuthorModel')->getAuthorById($id);
        } else {
            $author = $this->model('AuthorModel')->getAuthorByName(urldecode($id));
        }

        // Jika penulis tidak ditemukan di tabel authors, coba buat objek sementara jika ada di tabel books
        if(!$author) {
            $author_name = urldecode($id);
            $books = $this->model('BookModel')->getBooksByAuthorName($author_name);
            if(!empty($books)) {
                $author = [
                    'id' => 0,
                    'name' => $author_name,
                    'photo' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=400&h=400&q=80',
                    'affiliation' => 'Penulis Unsoed Press',
                    'bio' => 'Penulis dan akademisi yang telah berkarya serta menerbitkan literatur bersama Unsoed Press.'
                ];
            } else {
                header('Location: ' . BASEURL . '/book');
                exit;
            }
        }

        $data['judul'] = $author['name'] . ' - Penulis Unsoed Press';
        $data['author'] = $author;
        $data['books'] = $this->model('BookModel')->getBooksByAuthorName($author['name']);

        $this->view('templates/header', $data);
        $this->view('penulis/detail', $data);
        $this->view('templates/footer');
    }
}
