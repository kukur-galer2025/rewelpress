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
    
    <!-- Tailwind CSS (CDN for Development) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'unsoed-yellow': '#F2A900',
                        'unsoed-blue': '#005587',
                        'unsoed-darkblue': '#003B5C',
                    },
                    fontFamily: {
                        'sans': ['Outfit', 'sans-serif'],
                        'serif': ['Playfair Display', 'serif'],
                    },
                    boxShadow: {
                        'card': '0 10px 40px -10px rgba(0,0,0,0.08)',
                    }
                }
            }
        }
    </script>
    <style type="text/tailwindcss">
        @layer utilities {
            .glass {
                @apply bg-white/80 backdrop-blur-lg border border-white/20 shadow-xl;
            }
            .btn-primary {
                @apply bg-unsoed-yellow text-white px-6 py-3 rounded-xl font-bold hover:bg-yellow-500 hover:shadow-lg hover:-translate-y-1 transition-all duration-300;
            }
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
            <div class="flex-1 overflow-y-auto py-6 flex flex-col gap-2 px-4">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 px-2">Menu Utama</p>
                <a href="<?= BASEURL; ?>/admin" class="flex items-center gap-3 px-4 py-3 rounded-xl text-white/80 hover:text-white hover:bg-white/10 transition-all <?php echo (strpos($_SERVER['REQUEST_URI'], '/admin') !== false && strpos($_SERVER['REQUEST_URI'], '/admin/books') === false) ? 'bg-unsoed-blue font-bold text-white shadow-lg' : ''; ?>">
                    <i class="fas fa-tachometer-alt w-5"></i> Dashboard
                </a>
                <a href="<?= BASEURL; ?>/admin/books" class="flex items-center gap-3 px-4 py-3 rounded-xl text-white/80 hover:text-white hover:bg-white/10 transition-all <?php echo (strpos($_SERVER['REQUEST_URI'], '/admin/books') !== false) ? 'bg-unsoed-blue font-bold text-white shadow-lg' : ''; ?>">
                    <i class="fas fa-book w-5"></i> Kelola Buku
                </a>
                <a href="<?= BASEURL; ?>/admin/orders" class="flex items-center gap-3 px-4 py-3 rounded-xl text-white/80 hover:text-white hover:bg-white/10 transition-all <?php echo (strpos($_SERVER['REQUEST_URI'], '/admin/orders') !== false || strpos($_SERVER['REQUEST_URI'], '/admin/order_detail') !== false) ? 'bg-unsoed-blue font-bold text-white shadow-lg' : ''; ?>">
                    <i class="fas fa-shopping-cart w-5"></i> Pesanan Masuk
                </a>
                <a href="<?= BASEURL; ?>/admin/news" class="flex items-center gap-3 px-4 py-3 rounded-xl text-white/80 hover:text-white hover:bg-white/10 transition-all <?php echo (strpos($_SERVER['REQUEST_URI'], '/admin/news') !== false) ? 'bg-unsoed-blue font-bold text-white shadow-lg' : ''; ?>">
                    <i class="fas fa-newspaper w-5"></i> Berita / Agenda
                </a>
                
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 px-2 mt-6">Sistem</p>
                <a href="<?= BASEURL; ?>/admin/settings" class="flex items-center gap-3 px-4 py-3 rounded-xl text-white/80 hover:text-white hover:bg-white/10 transition-all <?php echo (strpos($_SERVER['REQUEST_URI'], '/admin/settings') !== false) ? 'bg-unsoed-blue font-bold text-white shadow-lg' : ''; ?>">
                    <i class="fas fa-cog w-5"></i> Pengaturan
                </a>
                <a href="<?= BASEURL; ?>/admin/categories" class="flex items-center gap-3 px-4 py-3 rounded-xl text-white/80 hover:text-white hover:bg-white/10 transition-all <?php echo (strpos($_SERVER['REQUEST_URI'], '/admin/categories') !== false || strpos($_SERVER['REQUEST_URI'], '/admin/create_category') !== false || strpos($_SERVER['REQUEST_URI'], '/admin/edit_category') !== false) ? 'bg-white/10 text-white font-bold' : ''; ?>">
                    <i class="fas fa-tags w-5"></i> Kategori
                </a>
                <a href="<?= BASEURL; ?>" target="_blank" class="flex items-center gap-3 px-4 py-3 rounded-xl text-white/80 hover:text-unsoed-yellow hover:bg-white/10 transition-all mt-auto">
                    <i class="fas fa-external-link-alt w-5"></i> Lihat Website
                </a>
            </div>
            
            <!-- User Profile -->
            <div class="h-20 bg-black/20 flex items-center px-6 gap-3">
                <div class="w-10 h-10 rounded-full bg-unsoed-yellow text-white flex items-center justify-center font-bold text-lg">
                    <?= substr($_SESSION['user_name'], 0, 1) ?>
                </div>
                <div class="flex-1 overflow-hidden">
                    <p class="text-sm font-bold text-white truncate"><?= $_SESSION['user_name'] ?></p>
                    <p class="text-xs text-gray-400 capitalize"><?= $_SESSION['user_role'] ?></p>
                </div>
                <a href="<?= BASEURL; ?>/auth/logout" class="text-gray-400 hover:text-red-400 transition" title="Logout">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col h-full relative overflow-y-auto bg-gray-50">
            <!-- Header (Mobile) -->
            <header class="h-20 bg-white shadow-sm flex items-center justify-between px-6 md:justify-end z-10">
                <button class="md:hidden text-gray-600 hover:text-unsoed-blue">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <div class="flex items-center gap-4">
                    <button class="text-gray-400 hover:text-unsoed-yellow relative">
                        <i class="fas fa-bell text-xl"></i>
                        <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
                    </button>
                </div>
            </header>
            
            <!-- Content -->
            <div class="p-6 md:p-10 flex-1">
