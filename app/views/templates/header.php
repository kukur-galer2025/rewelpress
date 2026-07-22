<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['judul']; ?></title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Lora:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    
    <!-- Tailwind CSS (Compiled) -->
    <link rel="stylesheet" href="<?= BASEURL; ?>/assets/css/style.css">
</head>
<body class="bg-gray-50 text-gray-800 antialiased font-sans">

    <!-- Top Bar -->
    <div class="bg-unsoed-darkblue text-white/90 text-xs py-2.5 hidden md:block relative z-[60]">
        <div class="container mx-auto px-4 flex justify-between items-center">
            <div class="flex items-center space-x-5 font-medium tracking-wide">
                <a href="<?= BASEURL; ?>" class="hover:text-unsoed-yellow transition">Home</a>
                <a href="<?= BASEURL; ?>/profile" class="hover:text-unsoed-yellow transition">Profile</a>
                <a href="<?= BASEURL; ?>/penerbitan" class="hover:text-unsoed-yellow transition">Penerbitan</a>
                <a href="<?= BASEURL; ?>/news" class="hover:text-unsoed-yellow transition">Berita Unsoed Press</a>
                <a href="<?= BASEURL; ?>/carabelanja" class="hover:text-unsoed-yellow transition">Cara Belanja</a>
                <div class="relative group inline-block">
                    <a href="<?= BASEURL; ?>/gallery" class="hover:text-unsoed-yellow transition flex items-center gap-1 cursor-pointer">
                        <span>Gallery</span>
                    </a>
                    <div class="absolute left-0 top-full mt-1 w-36 bg-white rounded-lg shadow-2xl border border-gray-200 py-2 hidden group-hover:block z-[70] text-gray-800 font-medium">
                        <a href="<?= BASEURL; ?>/gallery/video" class="block px-4 py-2 text-sm hover:bg-unsoed-blue hover:text-white transition">Video</a>
                        <a href="<?= BASEURL; ?>/gallery/photo" class="block px-4 py-2 text-sm hover:bg-unsoed-blue hover:text-white transition">Photo</a>
                    </div>
                </div>
                <a href="<?= BASEURL; ?>/ebook" class="hover:text-unsoed-yellow transition">E-Book</a>
                <a href="<?= BASEURL; ?>/book" class="hover:text-unsoed-yellow transition">Katalog Buku</a>
                <a href="<?= BASEURL; ?>/contact" class="hover:text-unsoed-yellow transition">Contact</a>
            </div>
            <div class="flex space-x-4 font-medium tracking-wide items-center">
                <span class="text-white">Indonesia</span>
                <span class="text-gray-400 border-l border-gray-600 pl-4">English</span>
                <span class="border-l border-gray-600 pl-4 flex items-center space-x-4">
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <span class="text-unsoed-yellow font-bold">Halo, <?= $_SESSION['user_name'] ?></span>
                        <?php if($_SESSION['user_role'] == 'admin'): ?>
                            <a href="<?= BASEURL; ?>/admin" class="hover:text-white transition">Panel Admin</a>
                        <?php else: ?>
                            <a href="<?= BASEURL; ?>/order" class="hover:text-white transition">Pesanan</a>
                        <?php endif; ?>
                        <a href="<?= BASEURL; ?>/auth/logout" class="hover:text-red-400 transition">Log out</a>
                    <?php else: ?>
                        <a href="<?= BASEURL; ?>/auth/login" class="hover:text-unsoed-yellow transition">Log in</a>
                        <a href="<?= BASEURL; ?>/auth/register" class="hover:text-unsoed-yellow transition">Create an account</a>
                    <?php endif; ?>
                </span>
            </div>
        </div>
    </div>

    <!-- Glassmorphism Navbar -->
    <nav class="sticky top-0 z-50 glass transition-all duration-300">
        <div class="container mx-auto px-4 py-3">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <a href="<?= BASEURL; ?>" class="flex items-center gap-3 group">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-unsoed-yellow to-yellow-500 flex items-center justify-center text-white shadow-lg shadow-unsoed-yellow/30 group-hover:rotate-12 transition-transform duration-300">
                        <i class="fas fa-book-reader text-2xl"></i>
                    </div>
                    <div class="font-serif text-2xl font-bold tracking-tight text-unsoed-blue">
                        UNSOED<span class="text-unsoed-yellow">PRESS</span>
                    </div>
                </a>

                <!-- Desktop Menu -->
                <div class="hidden lg:flex items-center space-x-5 font-medium text-sm ml-auto mr-6">
                    <?php
                    require_once '../app/models/CategoryModel.php';
                    require_once '../app/models/NotificationModel.php';
                    $catModel = new CategoryModel();
                    $navCategories = $catModel->getHierarchicalCategories();
                    
                    $notifModel = new NotificationModel();
                    $user_unread = 0;
                    $user_notifs = [];
                    if (isset($_SESSION['user_id'])) {
                        if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') {
                            $user_unread = $notifModel->getAdminUnreadCount();
                            $user_notifs = $notifModel->getAdminNotifications(7);
                        } else {
                            $user_unread = $notifModel->getUserUnreadCount($_SESSION['user_id']);
                            $user_notifs = $notifModel->getUserNotifications($_SESSION['user_id'], 7);
                        }
                    }
                    
                    // Urutan khusus agar persis susunan navigasi UGM Press
                    $customOrder = [
                        'Sosial & Humaniora' => 1,
                        'Sains & Teknologi' => 2,
                        'Kesehatan & Kedokteran' => 3,
                        'Agro & Fauna' => 4
                    ];
                    usort($navCategories, function($a, $b) use ($customOrder) {
                        $orderA = isset($customOrder[$a['name']]) ? $customOrder[$a['name']] : 999;
                        $orderB = isset($customOrder[$b['name']]) ? $customOrder[$b['name']] : 999;
                        return $orderA <=> $orderB;
                    });
                    ?>

                    <!-- Menu 1: Super Sale -->
                    <div class="relative group">
                        <a href="javascript:void(0)" class="flex items-center gap-1 hover:text-unsoed-yellow transition py-4 uppercase tracking-wide font-bold text-unsoed-darkblue">
                            SUPER SALE <i class="fas fa-chevron-down text-[10px] ml-0.5 opacity-60"></i>
                        </a>
                        <div class="absolute top-full left-0 w-52 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform origin-top scale-95 group-hover:scale-100 z-50">
                            <div class="glass rounded-xl shadow-xl p-2 flex flex-col">
                                <a href="<?= BASEURL; ?>/promo" class="px-4 py-2 hover:bg-gray-100 hover:text-unsoed-blue rounded-lg transition text-sm font-bold flex items-center justify-between text-amber-600">
                                    <span>Voucher & Promo</span>
                                    <span class="text-[10px] bg-amber-500 text-white px-2 py-0.5 rounded-full font-extrabold animate-pulse">KLAIM</span>
                                </a>
                                <a href="<?= BASEURL; ?>/book/promo" class="px-4 py-2 hover:bg-gray-100 hover:text-unsoed-blue rounded-lg transition text-sm font-bold flex items-center justify-between text-unsoed-blue">
                                    <span>Flash Sale</span>
                                    <span class="text-[10px] bg-red-500 text-white px-2 py-0.5 rounded-full font-extrabold animate-pulse">SALE</span>
                                </a>
                                <a href="<?= BASEURL; ?>/book/promo" class="px-4 py-2 hover:bg-gray-100 hover:text-unsoed-blue rounded-lg transition text-sm text-gray-700">
                                    Semua Promo
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Menu 2-5: Kategori Utama UGM Press -->
                    <?php foreach($navCategories as $cat): ?>
                        <?php if(!empty($cat['children'])): ?>
                        <div class="relative group">
                            <a href="<?= BASEURL; ?>/book/category/<?= $cat['id'] ?>" class="flex items-center gap-1 hover:text-unsoed-yellow transition py-4 uppercase tracking-wide font-bold text-unsoed-darkblue">
                                <?= $cat['name'] ?> <i class="fas fa-chevron-down text-[10px] ml-0.5 opacity-60"></i>
                            </a>
                            <div class="absolute top-full left-0 w-64 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform origin-top scale-95 group-hover:scale-100 z-50">
                                <div class="glass rounded-xl shadow-xl p-2 flex flex-col max-h-96 overflow-y-auto">
                                    <a href="<?= BASEURL; ?>/book/category/<?= $cat['id'] ?>" class="px-4 py-2 font-bold text-unsoed-blue hover:bg-gray-100 rounded-lg transition text-sm border-b border-gray-100">
                                        Lihat Semua <?= $cat['name'] ?>
                                    </a>
                                    <?php foreach($cat['children'] as $child): ?>
                                    <a href="<?= BASEURL; ?>/book/category/<?= $child['id'] ?>" class="px-4 py-2 hover:bg-gray-100 hover:text-unsoed-blue rounded-lg transition text-sm text-gray-700 font-normal">
                                        <?= $child['name'] ?>
                                    </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                        <?php else: ?>
                        <a href="<?= BASEURL; ?>/book/category/<?= $cat['id'] ?>" class="hover:text-unsoed-yellow transition uppercase tracking-wide font-bold text-unsoed-darkblue py-4"><?= $cat['name'] ?></a>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>

                <!-- Actions -->
                <div class="hidden md:flex items-center space-x-3">
                    <form action="<?= BASEURL; ?>/book/search" method="GET" class="relative group">
                        <input type="text" name="q" placeholder="Cari judul, penulis, ISBN..." class="pl-4 pr-10 py-2 rounded-full border border-gray-200 bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-unsoed-yellow/50 focus:border-unsoed-yellow transition-all w-48 group-hover:w-64 text-sm" required>
                        <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-unsoed-yellow transition">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                    
                    <?php if(isset($_SESSION['user_id'])): ?>
                    <!-- Notification Bell Dropdown (User/Admin) -->
                    <div class="relative group inline-block">
                        <a href="javascript:void(0)" class="relative p-2 text-gray-600 hover:text-unsoed-blue transition flex items-center justify-center">
                            <i class="fas fa-bell text-xl"></i>
                            <?php if($user_unread > 0): ?>
                            <span class="absolute top-0 right-0 w-5 h-5 bg-red-500 text-white text-[10px] font-bold flex items-center justify-center rounded-full border-2 border-white translate-x-1 -translate-y-1 animate-pulse"><?= $user_unread ?></span>
                            <?php endif; ?>
                        </a>
                        <div class="absolute right-0 top-full mt-2 w-80 bg-white rounded-2xl shadow-2xl border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform origin-top-right scale-95 group-hover:scale-100 z-50">
                            <div class="p-3.5 bg-unsoed-darkblue text-white rounded-t-2xl flex items-center justify-between">
                                <span class="font-bold text-sm flex items-center gap-2">
                                    <i class="fas fa-bell text-unsoed-yellow"></i> Notifikasi Anda
                                </span>
                                <?php if($user_unread > 0): ?>
                                <a href="<?= BASEURL ?>/notification/read_all" class="text-[11px] text-unsoed-lightyellow hover:underline">Tandai Dibaca</a>
                                <?php endif; ?>
                            </div>
                            <div class="max-h-80 overflow-y-auto divide-y divide-gray-100">
                                <?php if(empty($user_notifs)): ?>
                                    <div class="p-6 text-center text-gray-400 text-xs">Belum ada notifikasi baru.</div>
                                <?php else: foreach($user_notifs as $n): ?>
                                    <a href="<?= BASEURL ?>/notification/read/<?= $n['id'] ?>?link=<?= urlencode($n['link'] ?? '#') ?>" class="block p-3 hover:bg-gray-50 transition <?= $n['is_read'] ? 'opacity-60 bg-white' : 'bg-blue-50/40 font-semibold' ?>">
                                        <div class="flex items-start gap-2.5">
                                            <div class="w-2 h-2 rounded-full mt-1.5 flex-shrink-0 <?= $n['is_read'] ? 'bg-gray-300' : 'bg-blue-600' ?>"></div>
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
                    <?php endif; ?>

                    <a href="<?= BASEURL; ?>/cart" class="relative p-2 text-gray-600 hover:text-unsoed-blue transition">
                        <i class="fas fa-shopping-cart text-xl"></i>
                        <?php 
                            $cart_count = 0;
                            if(isset($_SESSION['cart'])) {
                                foreach($_SESSION['cart'] as $qty) {
                                    $cart_count += $qty;
                                }
                            }
                        ?>
                        <?php if($cart_count > 0): ?>
                        <span class="absolute top-0 right-0 w-5 h-5 bg-red-500 text-white text-xs font-bold flex items-center justify-center rounded-full border-2 border-white translate-x-1 -translate-y-1"><?= $cart_count ?></span>
                        <?php endif; ?>
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <div class="flex items-center gap-2 lg:hidden">
                    <?php if(isset($_SESSION['user_id'])): ?>
                    <div class="relative group inline-block">
                        <a href="javascript:void(0)" class="relative p-2 text-gray-600 hover:text-unsoed-blue transition flex items-center justify-center">
                            <i class="fas fa-bell text-xl"></i>
                            <?php if($user_unread > 0): ?>
                            <span class="absolute top-0 right-0 w-5 h-5 bg-red-500 text-white text-[10px] font-bold flex items-center justify-center rounded-full border-2 border-white translate-x-1 -translate-y-1"><?= $user_unread ?></span>
                            <?php endif; ?>
                        </a>
                        <div class="absolute right-0 top-full mt-2 w-72 bg-white rounded-2xl shadow-2xl border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                            <div class="p-3 bg-unsoed-darkblue text-white rounded-t-2xl flex items-center justify-between">
                                <span class="font-bold text-xs"><i class="fas fa-bell text-unsoed-yellow"></i> Notifikasi</span>
                                <?php if($user_unread > 0): ?>
                                <a href="<?= BASEURL ?>/notification/read_all" class="text-[10px] text-unsoed-lightyellow hover:underline">Tandai Dibaca</a>
                                <?php endif; ?>
                            </div>
                            <div class="max-h-60 overflow-y-auto divide-y divide-gray-100">
                                <?php if(empty($user_notifs)): ?>
                                    <div class="p-4 text-center text-gray-400 text-xs">Belum ada notifikasi.</div>
                                <?php else: foreach($user_notifs as $n): ?>
                                    <a href="<?= BASEURL ?>/notification/read/<?= $n['id'] ?>?link=<?= urlencode($n['link'] ?? '#') ?>" class="block p-2.5 hover:bg-gray-50 text-xs <?= $n['is_read'] ? 'opacity-60 bg-white' : 'bg-blue-50/40 font-semibold' ?>">
                                        <div class="text-gray-800 font-bold line-clamp-1"><?= htmlspecialchars($n['title']) ?></div>
                                        <div class="text-[11px] text-gray-600 font-normal line-clamp-2"><?= htmlspecialchars($n['message']) ?></div>
                                    </a>
                                <?php endforeach; endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <a href="<?= BASEURL; ?>/cart" class="relative p-2 text-gray-600 hover:text-unsoed-blue transition">
                        <i class="fas fa-shopping-cart text-xl"></i>
                        <?php if($cart_count > 0): ?>
                        <span class="absolute top-0 right-0 w-5 h-5 bg-red-500 text-white text-xs font-bold flex items-center justify-center rounded-full border-2 border-white translate-x-1 -translate-y-1"><?= $cart_count ?></span>
                        <?php endif; ?>
                    </a>
                    <button id="mobile-menu-btn" class="text-2xl text-unsoed-blue p-2 focus:outline-none">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile Drawer Panel -->
            <div id="mobile-menu-panel" class="hidden lg:hidden mt-4 pt-4 border-t border-gray-200/60 transition-all duration-300">
                <form action="<?= BASEURL; ?>/book/search" method="GET" class="relative mb-4">
                    <input type="text" name="q" placeholder="Cari buku..." class="w-full pl-4 pr-10 py-2 rounded-full border border-gray-200 bg-gray-50 focus:bg-white text-sm" required>
                    <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
                
                <div class="flex flex-col space-y-2 font-bold text-sm text-unsoed-darkblue">
                    <a href="<?= BASEURL; ?>/book/promo" class="py-2 flex items-center justify-between text-unsoed-blue border-b border-gray-100">
                        <span>SUPER SALE (Flash Sale)</span>
                        <span class="text-[10px] bg-red-500 text-white px-2 py-0.5 rounded-full">SALE</span>
                    </a>
                    <?php foreach($navCategories as $cat): ?>
                        <div class="py-2 border-b border-gray-100">
                            <a href="<?= BASEURL; ?>/book/category/<?= $cat['id'] ?>" class="block uppercase tracking-wide text-unsoed-blue font-bold"><?= $cat['name'] ?></a>
                            <?php if(!empty($cat['children'])): ?>
                                <div class="pl-4 mt-2 grid grid-cols-2 gap-1.5 font-normal text-xs text-gray-600">
                                    <?php foreach($cat['children'] as $child): ?>
                                        <a href="<?= BASEURL; ?>/book/category/<?= $child['id'] ?>" class="hover:text-unsoed-yellow py-0.5">• <?= $child['name'] ?></a>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                    <a href="<?= BASEURL; ?>/profile" class="py-2 block text-unsoed-blue border-b border-gray-100 uppercase tracking-wide font-bold">PROFILE / TENTANG KAMI</a>
                    <a href="<?= BASEURL; ?>/penerbitan" class="py-2 block text-unsoed-blue border-b border-gray-100 uppercase tracking-wide font-bold">LAYANAN PENERBITAN</a>
                    <a href="<?= BASEURL; ?>/carabelanja" class="py-2 block text-unsoed-blue border-b border-gray-100 uppercase tracking-wide font-bold">CARA BELANJA</a>
                    <a href="<?= BASEURL; ?>/ebook" class="py-2 block text-unsoed-blue border-b border-gray-100 uppercase tracking-wide font-bold">E-BOOK & DIGITAL</a>
                    <a href="<?= BASEURL; ?>/book" class="py-2 block text-unsoed-blue border-b border-gray-100 uppercase tracking-wide font-bold">KATALOG BUKU</a>
                    <a href="<?= BASEURL; ?>/news" class="py-2 block text-unsoed-blue border-b border-gray-100 uppercase tracking-wide font-bold">BERITA UNSOED PRESS</a>
                    <a href="<?= BASEURL; ?>/gallery" class="py-2 block text-unsoed-blue border-b border-gray-100 uppercase tracking-wide font-bold">GALLERY FOTO & VIDEO</a>
                    <a href="<?= BASEURL; ?>/contact" class="py-2 block text-unsoed-blue uppercase tracking-wide font-bold">CONTACT US</a>
                </div>
            </div>
        </div>
    </nav>
