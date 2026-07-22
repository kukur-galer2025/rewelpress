<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['judul']; ?></title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <!-- Tailwind CSS (Compiled) -->
    <link rel="stylesheet" href="<?= BASEURL; ?>/assets/css/style.css">
    
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        /* Tailwind custom styles for Select2 */
        .select2-container .select2-selection--multiple {
            border-color: #d1d5db;
            border-radius: 0.5rem;
            min-height: 42px;
            padding: 2px 8px;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #f3f4f6;
            border: 1px solid #e5e7eb;
            border-radius: 4px;
            padding: 2px 8px;
            margin-top: 6px;
        }
        .select2-container--default.select2-container--focus .select2-selection--multiple {
            border-color: #3b82f6;
            outline: 0;
        }
    </style>
</head>
<body class="bg-gray-100 font-sans antialiased text-gray-800">

    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar -->
        <aside class="w-64 bg-unsoed-darkblue shadow-xl flex-shrink-0 flex flex-col h-full hidden md:flex transition-all duration-300 z-20">
            <!-- Logo -->
            <div class="h-20 flex items-center px-6 bg-black/10 border-b border-white/10">
                <a href="<?= BASEURL; ?>/admin" class="flex items-center gap-3">
                    <i class="fas fa-book-reader text-2xl text-unsoed-yellow"></i>
                    <div class="font-serif text-xl font-bold tracking-tight text-white">
                        UNSOED<span class="text-unsoed-yellow">ADMIN</span>
                    </div>
                </a>
            </div>

            <!-- Navigation -->
            <div class="flex-1 overflow-y-auto py-5 flex flex-col gap-1.5 px-3">
                <p class="text-[11px] font-extrabold text-gray-400 uppercase tracking-wider mb-1.5 px-3">Menu Utama</p>
                <?php
                $uri = $_SERVER['REQUEST_URI'];
                $is_dashboard = (strpos($uri, '/admin') !== false && !preg_match('/\/admin\/(books|create_book|edit_book|ebooks|create_ebook|edit_ebook|ebook_orders|ebook_order_detail|confirm_ebook_order|reject_ebook_order|vouchers|create_voucher|edit_voucher|authors|create_author|edit_author|orders|order_detail|news|create_news|edit_news|gallery|create_album|edit_album|create_photo|gallery_videos|create_video|edit_video|settings|categories|create_category|edit_category|users|create_user|edit_user)/', $uri));
                ?>
                <a href="<?= BASEURL; ?>/admin" class="flex items-center justify-between px-3.5 h-11 rounded-xl text-sm font-medium text-white/80 hover:text-white hover:bg-white/10 transition-all <?= $is_dashboard ? 'bg-unsoed-blue font-bold text-white shadow-md' : '' ?>">
                    <div class="flex items-center gap-3 min-w-0">
                        <i class="fas fa-tachometer-alt w-5 text-center flex-shrink-0"></i>
                        <span class="truncate whitespace-nowrap">Dashboard</span>
                    </div>
                </a>

                <a href="<?= BASEURL; ?>/admin/books" class="flex items-center justify-between px-3.5 h-11 rounded-xl text-sm font-medium text-white/80 hover:text-white hover:bg-white/10 transition-all <?= (strpos($uri, '/admin/books') !== false || strpos($uri, '/admin/create_book') !== false || strpos($uri, '/admin/edit_book') !== false) ? 'bg-unsoed-blue font-bold text-white shadow-md' : '' ?>">
                    <div class="flex items-center gap-3 min-w-0">
                        <i class="fas fa-book w-5 text-center flex-shrink-0"></i>
                        <span class="truncate whitespace-nowrap">Kelola Buku</span>
                    </div>
                </a>

                <a href="<?= BASEURL; ?>/admin/ebooks" class="flex items-center justify-between px-3.5 h-11 rounded-xl text-sm font-medium text-white/80 hover:text-white hover:bg-white/10 transition-all <?= (strpos($uri, '/admin/ebooks') !== false || strpos($uri, '/admin/create_ebook') !== false || strpos($uri, '/admin/edit_ebook') !== false) ? 'bg-unsoed-blue font-bold text-white shadow-md' : '' ?>">
                    <div class="flex items-center gap-3 min-w-0">
                        <i class="fas fa-tablet-alt w-5 text-center text-red-400 flex-shrink-0"></i>
                        <span class="truncate whitespace-nowrap">Kelola E-Book</span>
                    </div>
                    <span class="bg-red-500 text-white text-[10px] font-extrabold px-2 py-0.5 rounded-full flex-shrink-0 ml-1">PDF</span>
                </a>

                <a href="<?= BASEURL; ?>/admin/authors" class="flex items-center justify-between px-3.5 h-11 rounded-xl text-sm font-medium text-white/80 hover:text-white hover:bg-white/10 transition-all <?= (strpos($uri, '/admin/authors') !== false || strpos($uri, '/admin/create_author') !== false || strpos($uri, '/admin/edit_author') !== false) ? 'bg-unsoed-blue font-bold text-white shadow-md' : '' ?>">
                    <div class="flex items-center gap-3 min-w-0">
                        <i class="fas fa-user-tie w-5 text-center flex-shrink-0"></i>
                        <span class="truncate whitespace-nowrap">Tokoh Penulis</span>
                    </div>
                </a>

                <a href="<?= BASEURL; ?>/admin/orders" class="flex items-center justify-between px-3.5 h-11 rounded-xl text-sm font-medium text-white/80 hover:text-white hover:bg-white/10 transition-all <?= (strpos($uri, '/admin/orders') !== false || strpos($uri, '/admin/order_detail') !== false) ? 'bg-unsoed-blue font-bold text-white shadow-md' : '' ?>">
                    <div class="flex items-center gap-3 min-w-0">
                        <i class="fas fa-shopping-cart w-5 text-center flex-shrink-0"></i>
                        <span class="truncate whitespace-nowrap">Pesanan Buku</span>
                    </div>
                </a>

                <?php
                    $ebookOrderCount = 0;
                    try {
                        require_once dirname(dirname(dirname(__FILE__))) . '/models/EbookOrderModel.php';
                        $ebookOrderCount = (new EbookOrderModel())->countByStatus('paid');
                    } catch(Exception $e) {}
                ?>
                <a href="<?= BASEURL; ?>/admin/ebook_orders" class="flex items-center justify-between px-3.5 h-11 rounded-xl text-sm font-medium text-white/80 hover:text-white hover:bg-white/10 transition-all <?= strpos($uri, '/admin/ebook_orders') !== false || strpos($uri, '/admin/confirm_ebook_order') !== false || strpos($uri, '/admin/reject_ebook_order') !== false ? 'bg-unsoed-blue font-bold text-white shadow-md' : '' ?>">
                    <div class="flex items-center gap-3 min-w-0">
                        <i class="fas fa-file-invoice-dollar w-5 text-center text-yellow-400 flex-shrink-0"></i>
                        <span class="truncate whitespace-nowrap">Pesanan E-Book</span>
                    </div>
                    <?php if($ebookOrderCount > 0): ?>
                        <span class="bg-yellow-500 text-white text-[10px] font-extrabold px-2 py-0.5 rounded-full flex-shrink-0 ml-1 animate-pulse"><?= esc($ebookOrderCount) ?></span>
                    <?php endif; ?>
                </a>

                <a href="<?= BASEURL; ?>/admin/vouchers" class="flex items-center justify-between px-3.5 h-11 rounded-xl text-sm font-medium text-white/80 hover:text-white hover:bg-white/10 transition-all <?= (strpos($uri, '/admin/vouchers') !== false || strpos($uri, '/admin/create_voucher') !== false || strpos($uri, '/admin/edit_voucher') !== false) ? 'bg-unsoed-blue font-bold text-white shadow-md' : '' ?>">
                    <div class="flex items-center gap-3 min-w-0">
                        <i class="fas fa-ticket-alt w-5 text-center text-amber-400 flex-shrink-0"></i>
                        <span class="truncate whitespace-nowrap">Kelola Voucher</span>
                    </div>
                </a>

                <a href="<?= BASEURL; ?>/admin/news" class="flex items-center justify-between px-3.5 h-11 rounded-xl text-sm font-medium text-white/80 hover:text-white hover:bg-white/10 transition-all <?= (strpos($uri, '/admin/news') !== false || strpos($uri, '/admin/create_news') !== false || strpos($uri, '/admin/edit_news') !== false) ? 'bg-unsoed-blue font-bold text-white shadow-md' : '' ?>">
                    <div class="flex items-center gap-3 min-w-0">
                        <i class="fas fa-newspaper w-5 text-center flex-shrink-0"></i>
                        <span class="truncate whitespace-nowrap">Berita / Agenda</span>
                    </div>
                </a>

                <a href="<?= BASEURL; ?>/admin/gallery" class="flex items-center justify-between px-3.5 h-11 rounded-xl text-sm font-medium text-white/80 hover:text-white hover:bg-white/10 transition-all <?= (strpos($uri, '/admin/gallery') !== false || strpos($uri, '/admin/create_album') !== false || strpos($uri, '/admin/create_photo') !== false || strpos($uri, '/admin/create_video') !== false) ? 'bg-unsoed-blue font-bold text-white shadow-md' : '' ?>">
                    <div class="flex items-center gap-3 min-w-0">
                        <i class="fas fa-images w-5 text-center flex-shrink-0"></i>
                        <span class="truncate whitespace-nowrap">Kelola Gallery</span>
                    </div>
                </a>

                <?php
                    require_once dirname(dirname(dirname(__FILE__))) . '/models/ContactModel.php';
                    require_once dirname(dirname(dirname(__FILE__))) . '/models/NotificationModel.php';
                    $contactModelInstance = new ContactModel();
                    $unreadMessagesCount = $contactModelInstance->getUnreadCount();
                    
                    $adminNotifModel = new NotificationModel();
                    $adminUnreadNotif = $adminNotifModel->getAdminUnreadCount();
                    $adminNotifs = $adminNotifModel->getAdminNotifications(7);
                ?>
                <a href="<?= BASEURL; ?>/admin/messages" class="flex items-center justify-between px-3.5 h-11 rounded-xl text-sm font-medium text-white/80 hover:text-white hover:bg-white/10 transition-all <?= (strpos($uri, '/admin/messages') !== false) ? 'bg-unsoed-blue font-bold text-white shadow-md' : '' ?>">
                    <div class="flex items-center gap-3 min-w-0">
                        <i class="fas fa-envelope-open-text w-5 text-center flex-shrink-0"></i>
                        <span class="truncate whitespace-nowrap">Pesan Kontak</span>
                    </div>
                    <?php if($unreadMessagesCount > 0): ?>
                        <span class="bg-red-500 text-white font-extrabold text-[10px] px-2 py-0.5 rounded-full flex-shrink-0 ml-1 animate-pulse shadow-sm"><?= esc($unreadMessagesCount) ?> Baru</span>
                    <?php endif; ?>
                </a>
                
                <p class="text-[11px] font-extrabold text-gray-400 uppercase tracking-wider mb-1.5 px-3 mt-5">Sistem & Pengguna</p>
                
                <a href="<?= BASEURL; ?>/admin/users" class="flex items-center justify-between px-3.5 h-11 rounded-xl text-sm font-medium text-white/80 hover:text-white hover:bg-white/10 transition-all <?= (strpos($uri, '/admin/users') !== false || strpos($uri, '/admin/create_user') !== false || strpos($uri, '/admin/edit_user') !== false) ? 'bg-unsoed-blue font-bold text-white shadow-md' : '' ?>">
                    <div class="flex items-center gap-3 min-w-0">
                        <i class="fas fa-users w-5 text-center flex-shrink-0"></i>
                        <span class="truncate whitespace-nowrap">Kelola Pengguna</span>
                    </div>
                </a>

                <a href="<?= BASEURL; ?>/admin/settings" class="flex items-center justify-between px-3.5 h-11 rounded-xl text-sm font-medium text-white/80 hover:text-white hover:bg-white/10 transition-all <?= (strpos($uri, '/admin/settings') !== false) ? 'bg-unsoed-blue font-bold text-white shadow-md' : '' ?>">
                    <div class="flex items-center gap-3 min-w-0">
                        <i class="fas fa-cog w-5 text-center flex-shrink-0"></i>
                        <span class="truncate whitespace-nowrap">Pengaturan</span>
                    </div>
                </a>

                <a href="<?= BASEURL; ?>/admin/categories" class="flex items-center justify-between px-3.5 h-11 rounded-xl text-sm font-medium text-white/80 hover:text-white hover:bg-white/10 transition-all <?= (strpos($uri, '/admin/categories') !== false || strpos($uri, '/admin/create_category') !== false || strpos($uri, '/admin/edit_category') !== false) ? 'bg-unsoed-blue font-bold text-white shadow-md' : '' ?>">
                    <div class="flex items-center gap-3 min-w-0">
                        <i class="fas fa-tags w-5 text-center flex-shrink-0"></i>
                        <span class="truncate whitespace-nowrap">Kategori</span>
                    </div>
                </a>

                <a href="<?= BASEURL; ?>" target="_blank" class="flex items-center justify-between px-3.5 h-11 rounded-xl text-sm font-medium text-white/80 hover:text-unsoed-yellow hover:bg-white/10 transition-all mt-3">
                    <div class="flex items-center gap-3 min-w-0">
                        <i class="fas fa-external-link-alt w-5 text-center flex-shrink-0"></i>
                        <span class="truncate whitespace-nowrap">Lihat Website</span>
                    </div>
                </a>
            </div>
            
            <!-- User Profile -->
            <div class="h-20 bg-black/20 flex items-center px-6 gap-3">
                <div class="w-10 h-10 rounded-full bg-unsoed-yellow text-white flex items-center justify-center font-bold text-lg">
                    <?= substr($_SESSION['user_name'] ?? 'A', 0, 1) ?>
                </div>
                <div class="flex-1 overflow-hidden">
                    <p class="text-sm font-bold text-white truncate"><?= $_SESSION['user_name'] ?? 'Admin' ?></p>
                    <p class="text-xs text-gray-400 capitalize"><?= $_SESSION['user_role'] ?? 'admin' ?></p>
                </div>
                <a href="<?= BASEURL; ?>/auth/logout" class="text-gray-400 hover:text-red-400 transition" title="Logout">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col h-full relative overflow-y-auto bg-gray-50">
            <!-- Header Topbar Admin -->
            <header class="h-20 bg-white shadow-sm flex items-center justify-between px-6 md:justify-end z-30 sticky top-0">
                <button class="md:hidden text-gray-600 hover:text-unsoed-blue">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <div class="flex items-center gap-5">
                    <!-- Notification Bell Dropdown Admin -->
                    <div class="relative group inline-block">
                        <a href="javascript:void(0)" class="relative p-2.5 text-gray-600 hover:text-unsoed-blue transition flex items-center justify-center rounded-xl hover:bg-gray-100">
                            <i class="fas fa-bell text-xl"></i>
                            <?php if($adminUnreadNotif > 0): ?>
                            <span class="absolute top-1 right-1 w-5 h-5 bg-red-500 text-white text-[10px] font-extrabold flex items-center justify-center rounded-full border-2 border-white animate-pulse"><?= esc($adminUnreadNotif) ?></span>
                            <?php endif; ?>
                        </a>
                        <div class="absolute right-0 top-full mt-2 w-80 bg-white rounded-2xl shadow-2xl border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform origin-top-right scale-95 group-hover:scale-100 z-50">
                            <div class="p-3.5 bg-unsoed-darkblue text-white rounded-t-2xl flex items-center justify-between">
                                <span class="font-bold text-sm flex items-center gap-2">
                                    <i class="fas fa-bell text-unsoed-yellow"></i> Notifikasi Admin
                                </span>
                                <?php if($adminUnreadNotif > 0): ?>
                                <a href="<?= BASEURL ?>/notification/read_all" class="text-[11px] text-unsoed-lightyellow hover:underline font-semibold">Tandai Dibaca</a>
                                <?php endif; ?>
                            </div>
                            <div class="max-h-80 overflow-y-auto divide-y divide-gray-100">
                                <?php if(empty($adminNotifs)): ?>
                                    <div class="p-6 text-center text-gray-400 text-xs">Belum ada notifikasi baru.</div>
                                <?php else: foreach($adminNotifs as $n): ?>
                                    <a href="<?= BASEURL ?>/notification/read/<?= esc($n['id']) ?>?link=<?= urlencode($n['link'] ?? '#') ?>" class="block p-3 hover:bg-gray-50 transition <?= $n['is_read'] ? 'opacity-60 bg-white' : 'bg-blue-50/40 font-semibold' ?>">
                                        <div class="flex items-start gap-2.5">
                                            <div class="w-2 h-2 rounded-full mt-1.5 flex-shrink-0 <?= $n['is_read'] ? 'bg-gray-300' : 'bg-red-500' ?>"></div>
                                            <div class="flex-1">
                                                <h5 class="text-xs text-gray-800 leading-tight mb-1"><?= htmlspecialchars($n['title']) ?></h5>
                                                <p class="text-[11px] text-gray-600 font-normal line-clamp-2 leading-relaxed"><?= htmlspecialchars($n['message']) ?></p>
                                                <span class="text-[10px] text-gray-400 block mt-1 font-normal"><?= date('d M Y, H:i', strtotime($n['created_at'])) ?></span>
                                            </div>
                                        </div>
                                    </a>
                                <?php endforeach; endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Content -->
            <div class="p-6 md:p-10 flex-1">
