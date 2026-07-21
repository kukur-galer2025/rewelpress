<?php

class Admin extends Controller {
    
    public function __construct()
    {
        // Middleware: Check if user is logged in and is admin
        if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
            header('Location: ' . BASEURL . '/auth/login');
            exit;
        }
    }

    public function index()
    {
        $data['judul'] = 'Dashboard Admin - Unsoed Press';
        
        $this->view('templates/admin_header', $data);
        $this->view('admin/dashboard', $data);
        $this->view('templates/admin_footer');
    }

    // --- CRUD BUKU ---

    public function books()
    {
        $data['judul'] = 'Kelola Buku - Unsoed Press';
        $data['books'] = $this->model('BookModel')->getAllBooks();
        
        $this->view('templates/admin_header', $data);
        $this->view('admin/books/index', $data);
        $this->view('templates/admin_footer');
    }

    public function create_book()
    {
        $data['judul'] = 'Tambah Buku Baru - Unsoed Press';
        $data['categories'] = $this->model('CategoryModel')->getHierarchicalCategories();

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Handle Image Upload
            $image_path = null;
            if(isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $target_dir = "../public/assets/uploads/";
                if(!file_exists($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }
                
                $file_extension = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
                $new_filename = uniqid() . '.' . $file_extension;
                $target_file = $target_dir . $new_filename;
                
                if(move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    $image_path = BASEURL . '/assets/uploads/' . $new_filename;
                }
            }
            
            $_POST['image'] = $image_path;
            
            if($this->model('BookModel')->addBook($_POST) > 0) {
                header('Location: ' . BASEURL . '/admin/books?msg=success_add');
                exit;
            }
        }

        $this->view('templates/admin_header', $data);
        $this->view('admin/books/create', $data);
        $this->view('templates/admin_footer');
    }

    public function edit_book($id)
    {
        $data['judul'] = 'Edit Buku - Unsoed Press';
        $data['buku'] = $this->model('BookModel')->getBookById($id);
        $data['categories'] = $this->model('CategoryModel')->getHierarchicalCategories();

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Handle Image Upload
            $image_path = $_POST['old_image']; // keep old image by default
            
            if(isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $target_dir = "../public/assets/uploads/";
                if(!file_exists($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }
                
                $file_extension = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
                $new_filename = uniqid() . '.' . $file_extension;
                $target_file = $target_dir . $new_filename;
                
                if(move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    $image_path = BASEURL . '/assets/uploads/' . $new_filename;
                }
            }
            
            $_POST['image'] = $image_path;
            $_POST['id'] = $id;
            
            if($this->model('BookModel')->updateBook($_POST) >= 0) { // >= 0 because if no changes made, rowCount is 0
                header('Location: ' . BASEURL . '/admin/books?msg=success_edit');
                exit;
            }
        }

        $this->view('templates/admin_header', $data);
        $this->view('admin/books/edit', $data);
        $this->view('templates/admin_footer');
    }

    public function delete_book($id)
    {
        if($this->model('BookModel')->deleteBook($id) > 0) {
            header('Location: ' . BASEURL . '/admin/books?msg=success_delete');
        } else {
            header('Location: ' . BASEURL . '/admin/books?msg=error');
        }
        exit;
    }

    // --- CRUD KATEGORI ---

    public function categories()
    {
        $data['judul'] = 'Kelola Kategori - Unsoed Press';
        $data['categories'] = $this->model('CategoryModel')->getHierarchicalCategories();
        
        $this->view('templates/admin_header', $data);
        $this->view('admin/categories/index', $data);
        $this->view('templates/admin_footer');
    }

    public function create_category()
    {
        $data['judul'] = 'Tambah Kategori - Unsoed Press';
        $data['parent_categories'] = $this->model('CategoryModel')->getAllCategories();

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            if($this->model('CategoryModel')->addCategory($_POST) > 0) {
                header('Location: ' . BASEURL . '/admin/categories?msg=success_add');
                exit;
            }
        }

        $this->view('templates/admin_header', $data);
        $this->view('admin/categories/create', $data);
        $this->view('templates/admin_footer');
    }

    public function edit_category($id)
    {
        $data['judul'] = 'Edit Kategori - Unsoed Press';
        $data['category'] = $this->model('CategoryModel')->getCategoryById($id);
        $data['parent_categories'] = $this->model('CategoryModel')->getAllCategories();

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST['id'] = $id;
            if($this->model('CategoryModel')->updateCategory($_POST) >= 0) {
                header('Location: ' . BASEURL . '/admin/categories?msg=success_edit');
                exit;
            }
        }

        $this->view('templates/admin_header', $data);
        $this->view('admin/categories/edit', $data);
        $this->view('templates/admin_footer');
    }

    public function delete_category($id)
    {
        $result = $this->model('CategoryModel')->deleteCategory($id);
        if($result > 0) {
            header('Location: ' . BASEURL . '/admin/categories?msg=success_delete');
        } else if($result === -1) {
            header('Location: ' . BASEURL . '/admin/categories?msg=error_has_books');
        } else {
            header('Location: ' . BASEURL . '/admin/categories?msg=error');
        }
        exit;
    }

    // --- PENGATURAN PEMBAYARAN ---

    public function settings()
    {
        $data['judul'] = 'Pengaturan Pembayaran - Unsoed Press';
        $data['settings'] = $this->model('SettingModel')->getSettings();
        
        $this->view('templates/admin_header', $data);
        $this->view('admin/settings', $data);
        $this->view('templates/admin_footer');
    }

    public function update_settings()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'bank_accounts' => $_POST['bank_accounts'],
                'qris_image' => $_POST['old_qris']
            ];

            if(isset($_FILES['qris_image']) && $_FILES['qris_image']['error'] == 0) {
                $target_dir = "../public/assets/uploads/";
                if(!file_exists($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }
                
                $file_extension = pathinfo($_FILES["qris_image"]["name"], PATHINFO_EXTENSION);
                $new_filename = 'qris_' . uniqid() . '.' . $file_extension;
                $target_file = $target_dir . $new_filename;
                
                if(move_uploaded_file($_FILES["qris_image"]["tmp_name"], $target_file)) {
                    $data['qris_image'] = BASEURL . '/assets/uploads/' . $new_filename;
                }
            }

            $this->model('SettingModel')->updateSettings($data);
            header('Location: ' . BASEURL . '/admin/settings?msg=success');
            exit;
        }
    }

    // --- MANAJEMEN PESANAN ---

    public function orders()
    {
        $data['judul'] = 'Pesanan Masuk - Unsoed Press';
        $data['orders'] = $this->model('OrderModel')->getAllOrders();
        
        $this->view('templates/admin_header', $data);
        $this->view('admin/orders/index', $data);
        $this->view('templates/admin_footer');
    }

    public function order_detail($id)
    {
        $data['judul'] = 'Detail Pesanan - Unsoed Press';
        $data['order'] = $this->model('OrderModel')->getOrderById($id);
        
        $this->view('templates/admin_header', $data);
        $this->view('admin/orders/detail', $data);
        $this->view('templates/admin_footer');
    }

    public function update_order($id, $status)
    {
        // allowed status: confirmed, rejected
        if(in_array($status, ['confirmed', 'rejected'])) {
            $this->model('OrderModel')->updateOrderStatus($id, $status);
        }
        header('Location: ' . BASEURL . '/admin/orders');
        exit;
    }

    // --- MANAJEMEN BERITA ---

    public function news()
    {
        $data['judul'] = 'Kelola Berita / Agenda';
        $data['news'] = $this->model('NewsModel')->getAllNews();
        
        $this->view('templates/admin_header', $data);
        $this->view('admin/news/index', $data);
        $this->view('templates/admin_footer');
    }

    public function create_news()
    {
        $data['judul'] = 'Tambah Berita Baru';
        
        $this->view('templates/admin_header', $data);
        $this->view('admin/news/create', $data);
        $this->view('templates/admin_footer');
    }

    public function store_news()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $_POST['title'])));
            
            // Handle multiple image uploads
            $uploaded_images = [];
            if(isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
                $target_dir = "../public/assets/uploads/news/";
                if(!file_exists($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }
                
                $count = count($_FILES['images']['name']);
                for($i = 0; $i < $count; $i++) {
                    if($_FILES['images']['error'][$i] == 0) {
                        $file_extension = pathinfo($_FILES["images"]["name"][$i], PATHINFO_EXTENSION);
                        $new_filename = uniqid('news_') . '_' . $i . '.' . $file_extension;
                        $target_file = $target_dir . $new_filename;
                        
                        if(move_uploaded_file($_FILES["images"]["tmp_name"][$i], $target_file)) {
                            $uploaded_images[] = BASEURL . '/assets/uploads/news/' . $new_filename;
                        }
                    }
                }
            }
            
            $image_json = empty($uploaded_images) ? '' : json_encode($uploaded_images);

            $data = [
                'title' => trim($_POST['title']),
                'slug' => $slug,
                'content' => $_POST['content'],
                'image' => $image_json
            ];
            
            if ($this->model('NewsModel')->addNews($data) > 0) {
                header('Location: ' . BASEURL . '/admin/news?msg=success_add');
                exit;
            } else {
                header('Location: ' . BASEURL . '/admin/news?msg=error');
                exit;
            }
        }
    }

    public function edit_news($id)
    {
        $data['judul'] = 'Edit Berita';
        $data['news'] = $this->model('NewsModel')->getNewsById($id);
        
        $this->view('templates/admin_header', $data);
        $this->view('admin/news/edit', $data);
        $this->view('templates/admin_footer');
    }

    public function update_news()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $_POST['title'])));
            
            $image_json = $_POST['old_images'] ?? '';

            // Handle new multiple image uploads
            $uploaded_images = [];
            if(isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
                $target_dir = "../public/assets/uploads/news/";
                if(!file_exists($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }
                
                $count = count($_FILES['images']['name']);
                for($i = 0; $i < $count; $i++) {
                    if($_FILES['images']['error'][$i] == 0) {
                        $file_extension = pathinfo($_FILES["images"]["name"][$i], PATHINFO_EXTENSION);
                        $new_filename = uniqid('news_') . '_' . $i . '.' . $file_extension;
                        $target_file = $target_dir . $new_filename;
                        
                        if(move_uploaded_file($_FILES["images"]["tmp_name"][$i], $target_file)) {
                            $uploaded_images[] = BASEURL . '/assets/uploads/news/' . $new_filename;
                        }
                    }
                }
                if(!empty($uploaded_images)) {
                    $image_json = json_encode($uploaded_images);
                }
            }
            
            $data = [
                'id' => $_POST['id'],
                'title' => trim($_POST['title']),
                'slug' => $slug,
                'content' => $_POST['content'],
                'image' => $image_json
            ];
            
            if ($this->model('NewsModel')->updateNews($data) >= 0) {
                header('Location: ' . BASEURL . '/admin/news?msg=success_edit');
                exit;
            } else {
                header('Location: ' . BASEURL . '/admin/news?msg=error');
                exit;
            }
        }
    }

    public function delete_news($id)
    {
        if ($this->model('NewsModel')->deleteNews($id) > 0) {
            header('Location: ' . BASEURL . '/admin/news?msg=success_delete');
            exit;
        } else {
            header('Location: ' . BASEURL . '/admin/news?msg=error');
            exit;
        }
    }
}

