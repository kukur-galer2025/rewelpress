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
        $data['total_books'] = count($this->model('BookModel')->getAllBooks());
        $data['total_orders'] = count($this->model('OrderModel')->getAllOrders());
        $data['total_users'] = count($this->model('UserModel')->getAllUsers());
        $data['total_ebooks'] = count($this->model('EbookModel')->getAllEbooks());
        $data['total_revenue'] = $this->model('OrderModel')->getTotalRevenue();
        $data['pending_orders'] = $this->model('OrderModel')->getPendingOrdersCount();
        $data['latest_orders'] = $this->model('OrderModel')->getLatestOrders(5);
        $data['monthly_sales'] = $this->model('OrderModel')->getMonthlySales();
        
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
        $data['authors'] = $this->model('AuthorModel')->getAllAuthors();

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['author'])) {
                if (is_array($_POST['author'])) {
                    foreach($_POST['author'] as $a) {
                        $this->model('AuthorModel')->addAuthorIfNotExists($a);
                    }
                    $_POST['author'] = implode('; ', $_POST['author']);
                } else {
                    $this->model('AuthorModel')->addAuthorIfNotExists($_POST['author']);
                }
            }
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
            } else {
                header('Location: ' . BASEURL . '/admin/books?msg=error');
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
        $data['authors'] = $this->model('AuthorModel')->getAllAuthors();

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['author'])) {
                if (is_array($_POST['author'])) {
                    foreach($_POST['author'] as $a) {
                        $this->model('AuthorModel')->addAuthorIfNotExists($a);
                    }
                    $_POST['author'] = implode('; ', $_POST['author']);
                } else {
                    $this->model('AuthorModel')->addAuthorIfNotExists($_POST['author']);
                }
            }
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
            } else {
                header('Location: ' . BASEURL . '/admin/books?msg=error');
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
            } else {
                header('Location: ' . BASEURL . '/admin/categories?msg=error');
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
            } else {
                header('Location: ' . BASEURL . '/admin/categories?msg=error');
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

    public function export_pdf()
    {
        // Pastikan vendor/autoload.php dimuat
        require_once '../vendor/autoload.php';
        
        $orders = $this->model('OrderModel')->getAllOrders();
        
        // Buat HTML untuk PDF
        $html = '<!DOCTYPE html><html><head><title>Laporan Pesanan</title>';
        $html .= '<style>
            body { font-family: sans-serif; font-size: 12px; }
            table { w-full; border-collapse: collapse; margin-top: 20px; width: 100%; }
            th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
            th { background-color: #f4f4f4; }
            h2 { text-align: center; color: #0f3460; }
        </style></head><body>';
        $html .= '<h2>Laporan Pesanan - Unsoed Press</h2>';
        $html .= '<p>Tanggal Cetak: ' . date('d M Y H:i') . '</p>';
        $html .= '<table>';
        $html .= '<tr><th>ID Pesanan</th><th>Pelanggan</th><th>Tanggal</th><th>Total</th><th>Status</th></tr>';
        
        $totalRev = 0;
        foreach($orders as $o) {
            if ($o['status'] == 'confirmed') $totalRev += $o['total_amount'];
            
            $html .= '<tr>';
            $html .= '<td>#INV-' . $o['id'] . '</td>';
            $html .= '<td>' . htmlspecialchars($o['email']) . '</td>';
            $html .= '<td>' . date('d M Y H:i', strtotime($o['created_at'])) . '</td>';
            $html .= '<td>Rp ' . number_format($o['total_amount'], 0, ',', '.') . '</td>';
            $html .= '<td>' . strtoupper($o['status']) . '</td>';
            $html .= '</tr>';
        }
        
        $html .= '</table>';
        $html .= '<p style="margin-top: 20px; font-weight: bold; text-align: right;">Total Pendapatan (Confirmed): Rp ' . number_format($totalRev, 0, ',', '.') . '</p>';
        $html .= '</body></html>';

        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        
        // Attachment 0 untuk preview di browser, 1 untuk langsung download
        $dompdf->stream("Laporan_Pesanan_" . date('Ymd') . ".pdf", array("Attachment" => 0));
        exit;
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

    public function resend_invoice($id)
    {
        $order = $this->model('OrderModel')->getOrderById($id);
        if ($order) {
            require_once '../app/models/EmailModel.php';
            $emailModel = new EmailModel();
            
            $subject = "Invoice Pesanan #" . $order['id'] . " - Unsoed Press";
            $message = "Terima kasih telah berbelanja di Unsoed Press.\n\nTotal Tagihan: Rp " . number_format($order['total_amount'], 0, ',', '.') . "\n";
            if (isset($order['delivery_method']) && $order['delivery_method'] == 'shipping') {
                $message .= "Metode Pengiriman: Kirim via Kurir (Ongkir Bayar di Tujuan)\nAlamat: " . $order['shipping_address'] . "\n\n";
            } else {
                $message .= "Metode Pengiriman: Ambil di Tempat (Kantor Unsoed Press)\n\n";
            }
            if ($order['status'] == 'pending') {
                $message .= "Status Pesanan: BELUM BAYAR\nSilakan selesaikan pembayaran Anda dengan masuk ke menu Riwayat Pesanan di website kami.";
            } elseif ($order['status'] == 'paid') {
                $message .= "Status Pesanan: MENUNGGU KONFIRMASI\nPembayaran Anda sedang dalam pengecekan oleh Admin.";
            } elseif ($order['status'] == 'confirmed') {
                $message .= "Status Pesanan: LUNAS TERKONFIRMASI\nPembayaran telah diterima! Pesanan Anda sedang disiapkan. Jika ambil di tempat, silakan kunjungi kantor kami.";
            } else {
                $message .= "Status Pesanan: DITOLAK\nPesanan ini tidak valid atau telah dibatalkan.";
            }
            
            $emailModel->sendEmail($order['email'], $subject, $message);
        }
        header('Location: ' . BASEURL . '/admin/order_detail/' . $id);
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

    // --- CRUD TOKOH PENULIS ---

    public function authors()
    {
        $data['judul'] = 'Kelola Tokoh Penulis - Unsoed Press';
        $data['authors'] = $this->model('AuthorModel')->getAllAuthors();
        
        $this->view('templates/admin_header', $data);
        $this->view('admin/authors/index', $data);
        $this->view('templates/admin_footer');
    }

    public function create_author()
    {
        $data['judul'] = 'Tambah Tokoh Penulis - Unsoed Press';

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $photo_path = !empty($_POST['photo_url']) ? trim($_POST['photo_url']) : null;
            
            // Handle Image Upload if file provided
            if(isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
                $target_dir = "../public/assets/uploads/";
                if(!file_exists($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }
                
                $file_extension = pathinfo($_FILES["photo"]["name"], PATHINFO_EXTENSION);
                $new_filename = 'author_' . uniqid() . '.' . $file_extension;
                $target_file = $target_dir . $new_filename;
                
                if(move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
                    $photo_path = BASEURL . '/assets/uploads/' . $new_filename;
                }
            }
            
            $_POST['photo'] = $photo_path;
            
            if($this->model('AuthorModel')->addAuthor($_POST) > 0) {
                header('Location: ' . BASEURL . '/admin/authors?msg=success_add');
            } else {
                header('Location: ' . BASEURL . '/admin/authors?msg=error');
            }
            exit;
        }

        $this->view('templates/admin_header', $data);
        $this->view('admin/authors/create', $data);
        $this->view('templates/admin_footer');
    }

    public function edit_author($id)
    {
        $data['judul'] = 'Edit Tokoh Penulis - Unsoed Press';
        $data['author'] = $this->model('AuthorModel')->getAuthorById($id);

        if(!$data['author']) {
            header('Location: ' . BASEURL . '/admin/authors');
            exit;
        }

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $photo_path = !empty($_POST['photo_url']) ? trim($_POST['photo_url']) : $_POST['old_photo'];
            
            if(isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
                $target_dir = "../public/assets/uploads/";
                if(!file_exists($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }
                
                $file_extension = pathinfo($_FILES["photo"]["name"], PATHINFO_EXTENSION);
                $new_filename = 'author_' . uniqid() . '.' . $file_extension;
                $target_file = $target_dir . $new_filename;
                
                if(move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
                    $photo_path = BASEURL . '/assets/uploads/' . $new_filename;
                }
            }
            
            $_POST['photo'] = $photo_path;
            $_POST['id'] = $id;
            
            if($this->model('AuthorModel')->updateAuthor($_POST) >= 0) {
                header('Location: ' . BASEURL . '/admin/authors?msg=success_edit');
            } else {
                header('Location: ' . BASEURL . '/admin/authors?msg=error');
            }
            exit;
        }

        $this->view('templates/admin_header', $data);
        $this->view('admin/authors/edit', $data);
        $this->view('templates/admin_footer');
    }

    public function delete_author($id)
    {
        if($this->model('AuthorModel')->deleteAuthor($id) > 0) {
            header('Location: ' . BASEURL . '/admin/authors?msg=success_delete');
        } else {
            header('Location: ' . BASEURL . '/admin/authors?msg=error');
        }
        exit;
    }

    // --- CRUD GALLERY (ALBUM, PHOTO, VIDEO) ---

    public function gallery($album_id = null)
    {
        $data['judul'] = 'Kelola Gallery Foto & Album - Unsoed Press';
        $data['albums'] = $this->model('GalleryModel')->getAllAlbumsWithCount();
        $data['current_album_id'] = $album_id;
        
        if ($album_id && is_numeric($album_id)) {
            $data['photos'] = $this->model('GalleryModel')->getPhotosByAlbum($album_id);
        } else {
            $data['photos'] = $this->model('GalleryModel')->getAllPhotos();
        }

        $this->view('templates/admin_header', $data);
        $this->view('admin/gallery/index', $data);
        $this->view('templates/admin_footer');
    }

    public function create_album()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->model('GalleryModel')->addAlbum($_POST) > 0) {
                header('Location: ' . BASEURL . '/admin/gallery?msg=success_add_album');
            } else {
                header('Location: ' . BASEURL . '/admin/gallery?msg=error');
            }
            exit;
        }
    }

    public function delete_album($id)
    {
        if ($this->model('GalleryModel')->deleteAlbum($id) > 0) {
            header('Location: ' . BASEURL . '/admin/gallery?msg=success_delete_album');
        } else {
            header('Location: ' . BASEURL . '/admin/gallery?msg=error');
        }
        exit;
    }

    public function create_photo()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $image_url = !empty($_POST['image_url']) ? trim($_POST['image_url']) : null;

            if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
                $target_dir = "../public/assets/uploads/";
                if (!file_exists($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }

                $file_extension = pathinfo($_FILES["photo"]["name"], PATHINFO_EXTENSION);
                $new_filename = 'gallery_' . uniqid() . '.' . $file_extension;
                $target_file = $target_dir . $new_filename;

                if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
                    $image_url = BASEURL . '/assets/uploads/' . $new_filename;
                }
            }

            $_POST['image_url'] = $image_url;

            if ($this->model('GalleryModel')->addPhoto($_POST) > 0) {
                header('Location: ' . BASEURL . '/admin/gallery/' . $_POST['album_id'] . '?msg=success_add_photo');
            } else {
                header('Location: ' . BASEURL . '/admin/gallery?msg=error');
            }
            exit;
        }
    }

    public function delete_photo($id)
    {
        if ($this->model('GalleryModel')->deletePhoto($id) > 0) {
            header('Location: ' . BASEURL . '/admin/gallery?msg=success_delete_photo');
        } else {
            header('Location: ' . BASEURL . '/admin/gallery?msg=error');
        }
        exit;
    }

    public function gallery_videos()
    {
        $data['judul'] = 'Kelola Gallery Video - Unsoed Press';
        $data['videos'] = $this->model('GalleryModel')->getAllVideos();

        $this->view('templates/admin_header', $data);
        $this->view('admin/gallery/videos', $data);
        $this->view('templates/admin_footer');
    }

    public function create_video()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->model('GalleryModel')->addVideo($_POST) > 0) {
                header('Location: ' . BASEURL . '/admin/gallery_videos?msg=success_add_video');
            } else {
                header('Location: ' . BASEURL . '/admin/gallery_videos?msg=error');
            }
            exit;
        }
    }

    public function delete_video($id)
    {
        if ($this->model('GalleryModel')->deleteVideo($id) > 0) {
            header('Location: ' . BASEURL . '/admin/gallery_videos?msg=success_delete_video');
        } else {
            header('Location: ' . BASEURL . '/admin/gallery_videos?msg=error');
        }
        exit;
    }

    // --- CRUD CONTACT MESSAGES ---

    public function messages()
    {
        $data['judul'] = 'Pesan Kontak Masuk - Unsoed Press';
        $data['messages'] = $this->model('ContactModel')->getAllMessages();

        $this->view('templates/admin_header', $data);
        $this->view('admin/messages/index', $data);
        $this->view('templates/admin_footer');
    }

    public function read_message($id)
    {
        $this->model('ContactModel')->markAsRead($id);
        header('Location: ' . BASEURL . '/admin/messages');
        exit;
    }

    public function delete_message($id)
    {
        if ($this->model('ContactModel')->deleteMessage($id) > 0) {
            header('Location: ' . BASEURL . '/admin/messages?msg=success_delete');
        } else {
            header('Location: ' . BASEURL . '/admin/messages?msg=error');
        }
        exit;
    }

    // --- MANAJEMEN PENGGUNA (CRUD USERS) ---

    public function users()
    {
        $data['judul'] = 'Kelola Pengguna - Unsoed Press';
        $data['users'] = $this->model('UserModel')->getAllUsers();

        $this->view('templates/admin_header', $data);
        $this->view('admin/users/index', $data);
        $this->view('templates/admin_footer');
    }

    public function create_user()
    {
        $data['judul'] = 'Tambah Pengguna Baru';

        $this->view('templates/admin_header', $data);
        $this->view('admin/users/create', $data);
        $this->view('templates/admin_footer');
    }

    public function store_user()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->model('UserModel')->addUser($_POST) > 0) {
                header('Location: ' . BASEURL . '/admin/users?msg=success_add');
            } else {
                header('Location: ' . BASEURL . '/admin/create_user?msg=email_exists');
            }
            exit;
        }
    }

    public function edit_user($id)
    {
        $data['judul'] = 'Edit Pengguna';
        $data['user'] = $this->model('UserModel')->getUserById($id);

        if (!$data['user']) {
            header('Location: ' . BASEURL . '/admin/users');
            exit;
        }

        $this->view('templates/admin_header', $data);
        $this->view('admin/users/edit', $data);
        $this->view('templates/admin_footer');
    }

    public function update_user()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->model('UserModel')->updateUser($_POST) > 0) {
                header('Location: ' . BASEURL . '/admin/users?msg=success_update');
            } else {
                header('Location: ' . BASEURL . '/admin/users?msg=no_change');
            }
            exit;
        }
    }

    public function delete_user($id)
    {
        if ($this->model('UserModel')->deleteUser($id) > 0) {
            header('Location: ' . BASEURL . '/admin/users?msg=success_delete');
        } else {
            header('Location: ' . BASEURL . '/admin/users?msg=error_delete');
        }
        exit;
    }

    // --- MANAJEMEN E-BOOK / PUBLIKASI DIGITAL ---

    public function ebooks()
    {
        $data['judul'] = 'Kelola E-Book & Publikasi Digital - Unsoed Press';
        $data['ebooks'] = $this->model('EbookModel')->getAllEbooks();

        $this->view('templates/admin_header', $data);
        $this->view('admin/ebooks/index', $data);
        $this->view('templates/admin_footer');
    }

    public function create_ebook()
    {
        $data['judul'] = 'Tambah E-Book Baru - Unsoed Press';
        $data['books'] = $this->model('BookModel')->getAllBooks();
        $data['categories'] = $this->model('CategoryModel')->getHierarchicalCategories();

        $this->view('templates/admin_header', $data);
        $this->view('admin/ebooks/create', $data);
        $this->view('templates/admin_footer');
    }

    public function store_ebook()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $postData = $_POST;

            // Handle Upload File PDF Utama E-Book
            if (isset($_FILES['file_pdf_upload']) && $_FILES['file_pdf_upload']['error'] == 0) {
                $target_dir = "../public/assets/uploads/ebooks/";
                if (!file_exists($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }
                $file_ext = pathinfo($_FILES["file_pdf_upload"]["name"], PATHINFO_EXTENSION);
                $new_filename = uniqid('ebook_') . '.' . $file_ext;
                if (move_uploaded_file($_FILES["file_pdf_upload"]["tmp_name"], $target_dir . $new_filename)) {
                    $postData['file_pdf'] = $new_filename;
                }
            }

            // Handle Upload File PDF Preview Bab 1
            if (isset($_FILES['preview_pdf_upload']) && $_FILES['preview_pdf_upload']['error'] == 0) {
                $target_dir = "../public/assets/uploads/ebooks/";
                if (!file_exists($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }
                $file_ext = pathinfo($_FILES["preview_pdf_upload"]["name"], PATHINFO_EXTENSION);
                $new_filename = uniqid('preview_') . '.' . $file_ext;
                if (move_uploaded_file($_FILES["preview_pdf_upload"]["tmp_name"], $target_dir . $new_filename)) {
                    $postData['preview_pdf'] = $new_filename;
                }
            }

            if ($this->model('EbookModel')->addEbook($postData) > 0) {
                header('Location: ' . BASEURL . '/admin/ebooks?msg=success_add');
            } else {
                header('Location: ' . BASEURL . '/admin/create_ebook?msg=error');
            }
            exit;
        }
    }

    public function edit_ebook($id)
    {
        $data['judul'] = 'Edit Data E-Book - Unsoed Press';
        $data['ebook'] = $this->model('EbookModel')->getEbookById($id);
        $data['books'] = $this->model('BookModel')->getAllBooks();
        $data['categories'] = $this->model('CategoryModel')->getHierarchicalCategories();

        if (!$data['ebook']) {
            header('Location: ' . BASEURL . '/admin/ebooks');
            exit;
        }

        $this->view('templates/admin_header', $data);
        $this->view('admin/ebooks/edit', $data);
        $this->view('templates/admin_footer');
    }

    public function update_ebook()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $postData = $_POST;

            // Handle Upload File PDF Utama E-Book
            if (isset($_FILES['file_pdf_upload']) && $_FILES['file_pdf_upload']['error'] == 0) {
                $target_dir = "../public/assets/uploads/ebooks/";
                if (!file_exists($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }
                $file_ext = pathinfo($_FILES["file_pdf_upload"]["name"], PATHINFO_EXTENSION);
                $new_filename = uniqid('ebook_') . '.' . $file_ext;
                if (move_uploaded_file($_FILES["file_pdf_upload"]["tmp_name"], $target_dir . $new_filename)) {
                    $postData['file_pdf'] = $new_filename;
                }
            }

            // Handle Upload File PDF Preview Bab 1
            if (isset($_FILES['preview_pdf_upload']) && $_FILES['preview_pdf_upload']['error'] == 0) {
                $target_dir = "../public/assets/uploads/ebooks/";
                if (!file_exists($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }
                $file_ext = pathinfo($_FILES["preview_pdf_upload"]["name"], PATHINFO_EXTENSION);
                $new_filename = uniqid('preview_') . '.' . $file_ext;
                if (move_uploaded_file($_FILES["preview_pdf_upload"]["tmp_name"], $target_dir . $new_filename)) {
                    $postData['preview_pdf'] = $new_filename;
                }
            }

            if ($this->model('EbookModel')->updateEbook($postData) > 0) {
                header('Location: ' . BASEURL . '/admin/ebooks?msg=success_update');
            } else {
                header('Location: ' . BASEURL . '/admin/ebooks?msg=no_change');
            }
            exit;
        }
    }

    public function delete_ebook($id)
    {
        if ($this->model('EbookModel')->deleteEbook($id) > 0) {
            header('Location: ' . BASEURL . '/admin/ebooks?msg=success_delete');
        } else {
            header('Location: ' . BASEURL . '/admin/ebooks?msg=error_delete');
        }
        exit;
    }

    // --- MANAJEMEN PESANAN E-BOOK ---

    public function ebook_orders()
    {
        $data['judul'] = 'Pesanan E-Book - Unsoed Press';
        $data['orders'] = $this->model('EbookOrderModel')->getAllEbookOrders();

        $this->view('templates/admin_header', $data);
        $this->view('admin/ebook_orders/index', $data);
        $this->view('templates/admin_footer');
    }

    public function ebook_order_detail($id)
    {
        $data['judul'] = 'Detail Pesanan E-Book - Unsoed Press';
        $data['order'] = $this->model('EbookOrderModel')->getEbookOrderById($id);

        if (!$data['order']) {
            header('Location: ' . BASEURL . '/admin/ebook_orders');
            exit;
        }

        $this->view('templates/admin_header', $data);
        $this->view('admin/ebook_orders/detail', $data);
        $this->view('templates/admin_footer');
    }

    public function confirm_ebook_order($id)
    {
        $note = isset($_GET['note']) ? trim($_GET['note']) : '';
        $this->model('EbookOrderModel')->updateStatus($id, 'confirmed', $note);
        header('Location: ' . BASEURL . '/admin/ebook_orders?msg=confirmed');
        exit;
    }

    public function reject_ebook_order($id)
    {
        $note = isset($_POST['note']) ? trim($_POST['note']) : 'Bukti pembayaran tidak valid.';
        $this->model('EbookOrderModel')->updateStatus($id, 'rejected', $note);
        header('Location: ' . BASEURL . '/admin/ebook_orders?msg=rejected');
        exit;
    }

    /* ========================================================
     * KELOLA VOUCHER & PROMO
     * ======================================================== */
    public function vouchers()
    {
        $data['judul'] = 'Kelola Voucher & Promo - Admin Unsoed Press';
        $data['vouchers'] = $this->model('VoucherModel')->getAllVouchers();

        $this->view('templates/admin_header', $data);
        $this->view('admin/vouchers/index', $data);
        $this->view('templates/admin_footer');
    }

    public function create_voucher()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->model('VoucherModel')->addVoucher($_POST) > 0) {
                header('Location: ' . BASEURL . '/admin/vouchers?msg=success_create');
                exit;
            } else {
                header('Location: ' . BASEURL . '/admin/create_voucher?msg=error');
                exit;
            }
        }

        $data['judul'] = 'Buat Voucher Baru - Admin Unsoed Press';
        $this->view('templates/admin_header', $data);
        $this->view('admin/vouchers/create', $data);
        $this->view('templates/admin_footer');
    }

    public function edit_voucher($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->model('VoucherModel')->updateVoucher($id, $_POST) >= 0) {
                header('Location: ' . BASEURL . '/admin/vouchers?msg=success_update');
                exit;
            } else {
                header('Location: ' . BASEURL . '/admin/edit_voucher/' . $id . '?msg=error');
                exit;
            }
        }

        $data['judul'] = 'Edit Voucher - Admin Unsoed Press';
        $data['voucher'] = $this->model('VoucherModel')->getVoucherById($id);

        if (!$data['voucher']) {
            header('Location: ' . BASEURL . '/admin/vouchers');
            exit;
        }

        $this->view('templates/admin_header', $data);
        $this->view('admin/vouchers/edit', $data);
        $this->view('templates/admin_footer');
    }

    public function delete_voucher($id)
    {
        if ($this->model('VoucherModel')->deleteVoucher($id) > 0) {
            header('Location: ' . BASEURL . '/admin/vouchers?msg=success_delete');
        } else {
            header('Location: ' . BASEURL . '/admin/vouchers?msg=error_delete');
        }
        exit;
    }
}

