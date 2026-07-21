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
    
    <!-- Tailwind CSS (CDN for Development) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        unsoed: {
                            blue: '#003B5C',
                            darkblue: '#002840',
                            yellow: '#F2A900',
                            lightyellow: '#FCD34D',
                        }
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        serif: ['Lora', 'serif'],
                    },
                    boxShadow: {
                        'glass': '0 8px 32px 0 rgba(0, 59, 92, 0.1)',
                        'card': '0 10px 40px -10px rgba(0,0,0,0.08)',
                    }
                }
            }
        }
    </script>
    
    <style type="text/tailwindcss">
        @layer utilities {
            .glass {
                @apply bg-white/80 backdrop-blur-md border border-white/20 shadow-glass;
            }
            .glass-dark {
                @apply bg-unsoed-blue/90 backdrop-blur-md border border-white/10;
            }
            .text-gradient {
                @apply bg-clip-text text-transparent bg-gradient-to-r from-unsoed-yellow to-yellow-300;
            }
            .btn-primary {
                @apply bg-unsoed-yellow text-white px-6 py-3 rounded-full font-semibold shadow-lg shadow-unsoed-yellow/30 hover:-translate-y-1 hover:shadow-xl hover:shadow-unsoed-yellow/40 transition-all duration-300;
            }
            /* Swiper custom styling */
            .swiper-button-next, .swiper-button-prev {
                @apply text-unsoed-blue bg-white w-12 h-12 rounded-full shadow-md transition-colors duration-300;
            }
            .swiper-button-next:hover, .swiper-button-prev:hover {
                @apply bg-unsoed-yellow text-white;
            }
            .swiper-button-next::after, .swiper-button-prev::after {
                @apply text-lg font-bold;
            }
            .swiper-pagination-bullet-active {
                @apply bg-unsoed-yellow;
            }
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased font-sans">

    <!-- Top Bar -->
    <div class="bg-unsoed-darkblue text-white/90 text-xs py-2.5 hidden md:block">
        <div class="container mx-auto px-4 flex justify-between items-center">
            <div class="flex space-x-5 font-medium tracking-wide">
                <a href="<?= BASEURL; ?>" class="hover:text-unsoed-yellow transition">Home</a>
                <a href="#" class="hover:text-unsoed-yellow transition">Profile</a>
                <a href="#" class="hover:text-unsoed-yellow transition">Penerbitan</a>
                <a href="<?= BASEURL; ?>/news" class="hover:text-unsoed-yellow transition">Berita Unsoed Press</a>
                <a href="#" class="hover:text-unsoed-yellow transition">Cara Belanja</a>
                <a href="#" class="hover:text-unsoed-yellow transition">Gallery</a>
                <a href="#" class="hover:text-unsoed-yellow transition">E-Book</a>
                <a href="#" class="hover:text-unsoed-yellow transition">Contact</a>
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
                <div class="hidden lg:flex items-center space-x-6 font-medium text-sm ml-auto mr-8">
                    <?php
                    require_once '../app/models/CategoryModel.php';
                    $catModel = new CategoryModel();
                    $navCategories = $catModel->getHierarchicalCategories();
                    
                    $count = 0;
                    foreach($navCategories as $cat): 
                        if($count >= 4) break;
                        $count++;
                    ?>
                        <?php if(!empty($cat['children'])): ?>
                        <div class="relative group">
                            <a href="<?= BASEURL; ?>/book/category/<?= $cat['id'] ?>" class="flex items-center gap-1 hover:text-unsoed-yellow transition py-4 uppercase tracking-wide font-bold text-unsoed-darkblue">
                                <?= $cat['name'] ?>
                            </a>
                            <div class="absolute top-full left-0 w-56 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform origin-top scale-95 group-hover:scale-100 z-50">
                                <div class="glass rounded-xl shadow-xl p-2 flex flex-col max-h-96 overflow-y-auto">
                                    <a href="<?= BASEURL; ?>/book/category/<?= $cat['id'] ?>" class="px-4 py-2 font-bold text-unsoed-blue hover:bg-gray-100 rounded-lg transition text-sm border-b border-gray-100">
                                        Lihat Semua <?= $cat['name'] ?>
                                    </a>
                                    <?php foreach($cat['children'] as $child): ?>
                                    <a href="<?= BASEURL; ?>/book/category/<?= $child['id'] ?>" class="px-4 py-2 hover:bg-gray-100 hover:text-unsoed-blue rounded-lg transition text-sm">
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
                <div class="hidden md:flex items-center space-x-4">
                    <form action="<?= BASEURL; ?>/book/search" method="GET" class="relative group">
                        <input type="text" name="q" placeholder="Cari buku..." class="pl-4 pr-10 py-2 rounded-full border border-gray-200 bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-unsoed-yellow/50 focus:border-unsoed-yellow transition-all w-48 group-hover:w-64" required>
                        <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-unsoed-yellow transition">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                    
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
                <button class="lg:hidden text-2xl text-unsoed-blue">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </nav>
