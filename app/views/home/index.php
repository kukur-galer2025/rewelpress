<?php
// Fallback data helper
$buku_terbaru = empty($data['buku_terbaru']) ? [] : $data['buku_terbaru'];
$buku_terpopuler = empty($data['buku_terpopuler']) ? [] : $data['buku_terpopuler'];
$buku_terlaris = empty($data['buku_terlaris']) ? [] : $data['buku_terlaris'];
$tokoh_penulis = empty($data['tokoh_penulis']) ? [] : $data['tokoh_penulis'];

// Helper to render book card
if (!function_exists('renderBookCard')) {
    function renderBookCard($buku) {
        $discount = 0;
        if(isset($buku['old_price']) && $buku['old_price'] > $buku['price']) {
            $discount = round((($buku['old_price'] - $buku['price']) / $buku['old_price']) * 100);
        }
        $img_src = !empty($buku['image']) ? $buku['image'] : 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?auto=format&fit=crop&q=80&w=400';
        $category = !empty($buku['category_name']) ? $buku['category_name'] : 'Umum';
        
        echo '<div class="group">';
        echo '<a href="'. BASEURL . '/book/detail/' . $buku['id'] . '" class="block bg-white relative">';
        
        // Image Container
        echo '<div class="relative overflow-hidden aspect-[3/4] bg-gray-100 rounded-xl shadow-sm border border-gray-100">';
        echo '<img src="' . $img_src . '" alt="' . $buku['title'] . '" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">';
        
        // Ribbon
        if($discount > 0) {
            echo '<div class="absolute top-0 right-0 bg-[#bb0000] text-white text-xs font-bold px-6 py-1 transform rotate-45 translate-x-5 translate-y-3 shadow-sm">';
            echo 'DISKON ' . $discount . '%';
            echo '</div>';
        }
        echo '</div>'; // End Image Container

        // Content
        echo '<div class="pt-4">';
        echo '<h3 class="text-[13px] font-bold text-gray-800 uppercase leading-snug mb-3 h-10 overflow-hidden group-hover:text-unsoed-blue transition-colors">' . $buku['title'] . '</h3>';
        
        echo '<p class="text-[11px] text-gray-400 mb-2">' . $category . '</p>';
        
        echo '<div class="border-t border-gray-300 pt-2 flex items-baseline justify-between">';
        if($discount > 0) {
            echo '<p class="text-xs text-[#bb0000] line-through font-medium">Rp' . number_format($buku['old_price'], 0, ',', '.') . '</p>';
        } else {
            echo '<div></div>'; // Spacer
        }
        echo '<p class="text-xl font-bold text-gray-900 tracking-tight">Rp' . number_format($buku['price'], 0, ',', '.') . '</p>';
        echo '</div>';

        echo '</div>';
        echo '</a>';
        echo '</div>';
    }
}
?>

<!-- Hero Section -->
<section class="relative h-[80vh] min-h-[600px] flex items-center justify-center overflow-hidden">
    <div class="swiper hero-swiper absolute inset-0 w-full h-full">
        <div class="swiper-wrapper">
            <!-- Slide 1 -->
            <div class="swiper-slide relative">
                <div class="absolute inset-0 bg-gradient-to-r from-unsoed-darkblue/90 to-unsoed-blue/50 z-10"></div>
                <img src="https://images.unsplash.com/photo-1507842217343-583bb7270b66?auto=format&fit=crop&q=80" alt="Library" class="absolute inset-0 w-full h-full object-cover">
                <div class="relative z-20 container mx-auto px-4 h-full flex items-center">
                    <div class="max-w-2xl text-white transform translate-y-8">
                        <span class="inline-block py-1 px-3 rounded-full bg-unsoed-yellow/20 border border-unsoed-yellow/50 text-unsoed-yellow text-sm font-semibold tracking-wider mb-4">UNIVERSITAS JENDERAL SOEDIRMAN</span>
                        <h1 class="text-5xl md:text-7xl font-serif font-bold leading-tight mb-6 text-gradient drop-shadow-lg">
                            Membangun Peradaban Lewat Tulisan
                        </h1>
                        <p class="text-lg md:text-xl text-gray-200 mb-10 font-light leading-relaxed">
                            Temukan ribuan karya akademis, hasil penelitian, dan referensi berstandar nasional untuk mendukung ekosistem pendidikan.
                        </p>
                        <div class="flex gap-4">
                            <a href="<?= BASEURL; ?>/book" class="btn-primary">
                                Jelajahi Katalog <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                            <a href="#" class="px-6 py-3 rounded-full font-semibold text-white border border-white/30 hover:bg-white/10 transition-all duration-300 glass-dark">
                                Cara Menerbitkan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Slide 2 -->
            <div class="swiper-slide relative">
                <div class="absolute inset-0 bg-gradient-to-l from-unsoed-darkblue/90 to-unsoed-blue/60 z-10"></div>
                <img src="https://images.unsplash.com/photo-1456513080510-7bf3a84b82f8?auto=format&fit=crop&q=80" alt="Study" class="absolute inset-0 w-full h-full object-cover">
                <div class="relative z-20 container mx-auto px-4 h-full flex items-center justify-end text-right">
                    <div class="max-w-2xl text-white">
                        <span class="inline-block py-1 px-3 rounded-full bg-white/20 border border-white/50 text-white text-sm font-semibold tracking-wider mb-4">LAYANAN PUBLIKASI</span>
                        <h1 class="text-5xl md:text-7xl font-serif font-bold leading-tight mb-6 drop-shadow-lg">
                            Wujudkan Naskah Anda Menjadi <span class="text-unsoed-yellow">Buku Berkualitas</span>
                        </h1>
                        <p class="text-lg md:text-xl text-gray-200 mb-10 font-light leading-relaxed">
                            Kami memfasilitasi penerbitan buku ber-ISBN dengan proses yang profesional, cepat, dan standar mutu tinggi.
                        </p>
                        <a href="#" class="btn-primary inline-block">
                            Kirim Naskah Sekarang <i class="fas fa-paper-plane ml-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Pagination & Navigation -->
        <div class="swiper-pagination !bottom-8"></div>
        <div class="swiper-button-prev !left-8 !w-14 !h-14 !hidden md:!flex"></div>
        <div class="swiper-button-next !right-8 !w-14 !h-14 !hidden md:!flex"></div>
    </div>
</section>

<!-- Features Section -->
<section class="py-12 -mt-16 relative z-30 mb-8">
    <div class="container mx-auto px-4 max-w-[1200px]">
        <div class="glass rounded-2xl p-8 grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="flex items-center gap-5">
                <div class="w-16 h-16 rounded-full bg-unsoed-blue/10 flex items-center justify-center text-unsoed-blue text-2xl">
                    <i class="fas fa-truck"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800 text-lg">Pengiriman Cepat</h3>
                    <p class="text-sm text-gray-500">Ke seluruh wilayah Indonesia</p>
                </div>
            </div>
            <div class="flex items-center gap-5 md:border-l md:border-gray-200 md:pl-8">
                <div class="w-16 h-16 rounded-full bg-unsoed-yellow/10 flex items-center justify-center text-unsoed-yellow text-2xl">
                    <i class="fas fa-certificate"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800 text-lg">Buku Original 100%</h3>
                    <p class="text-sm text-gray-500">Kualitas cetak premium</p>
                </div>
            </div>
            <div class="flex items-center gap-5 md:border-l md:border-gray-200 md:pl-8">
                <div class="w-16 h-16 rounded-full bg-green-500/10 flex items-center justify-center text-green-600 text-2xl">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800 text-lg">Pembayaran Aman</h3>
                    <p class="text-sm text-gray-500">Berbagai metode pembayaran</p>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="container mx-auto px-4 max-w-[1200px]">
    
    <?php if(isset($data['db_error']) && $data['db_error']): ?>
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-8 rounded-r-lg">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-red-500 mt-1"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">Koneksi Database Gagal</h3>
                    <div class="mt-2 text-sm text-red-700">
                        <p>Sistem tidak dapat terhubung ke database. Harap jalankan script <code>database.sql</code> dan pastikan konfigurasi di <code>config/database.php</code> sudah benar.</p>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- BUKU TERBARU -->
    <section class="mb-12">
        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center gap-3">
                <div class="w-1.5 h-6 bg-unsoed-yellow rounded-full"></div>
                <h2 class="text-base font-bold text-unsoed-darkblue uppercase tracking-wide">BUKU TERBARU</h2>
            </div>
            <a href="<?= BASEURL; ?>/book" class="text-xs text-unsoed-blue hover:text-unsoed-yellow transition-colors font-semibold bg-unsoed-blue/5 hover:bg-unsoed-blue/10 px-3 py-1.5 rounded-full">Lihat semua</a>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-5 gap-x-6 gap-y-10">
            <?php foreach ($buku_terbaru as $buku) { renderBookCard($buku); } ?>
        </div>
    </section>

    <!-- TERPOPULER -->
    <section class="mb-12">
        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center gap-3">
                <div class="w-1.5 h-6 bg-unsoed-yellow rounded-full"></div>
                <h2 class="text-base font-bold text-unsoed-darkblue uppercase tracking-wide">TERPOPULER</h2>
            </div>
            <a href="<?= BASEURL; ?>/book" class="text-xs text-unsoed-blue hover:text-unsoed-yellow transition-colors font-semibold bg-unsoed-blue/5 hover:bg-unsoed-blue/10 px-3 py-1.5 rounded-full">Lihat semua</a>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-5 gap-x-6 gap-y-10">
            <?php foreach ($buku_terpopuler as $buku) { renderBookCard($buku); } ?>
        </div>
    </section>

    <!-- BUKU TERLARIS -->
    <section class="mb-16">
        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center gap-3">
                <div class="w-1.5 h-6 bg-unsoed-yellow rounded-full"></div>
                <h2 class="text-base font-bold text-unsoed-darkblue uppercase tracking-wide">BUKU TERLARIS</h2>
            </div>
            <a href="<?= BASEURL; ?>/book" class="text-xs text-unsoed-blue hover:text-unsoed-yellow transition-colors font-semibold bg-unsoed-blue/5 hover:bg-unsoed-blue/10 px-3 py-1.5 rounded-full">Lihat semua</a>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-5 gap-x-6 gap-y-10">
            <?php foreach ($buku_terlaris as $buku) { renderBookCard($buku); } ?>
        </div>
    </section>

    <!-- TOKOH PENULIS -->
    <section class="mb-16">
        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center gap-3">
                <div class="w-1.5 h-6 bg-unsoed-yellow rounded-full"></div>
                <h2 class="text-base font-bold text-unsoed-darkblue uppercase tracking-wide">TOKOH PENULIS</h2>
            </div>
            <a href="#" class="text-xs text-unsoed-blue hover:text-unsoed-yellow transition-colors font-semibold bg-unsoed-blue/5 hover:bg-unsoed-blue/10 px-3 py-1.5 rounded-full">Lihat semua</a>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            <?php 
            $default_photos = [
                'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=200&h=200&q=80',
                'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&w=200&h=200&q=80',
                'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=200&h=200&q=80',
                'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&w=200&h=200&q=80',
                'https://images.unsplash.com/photo-1580489944761-15a19d654956?auto=format&fit=crop&w=200&h=200&q=80',
                'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=200&h=200&q=80'
            ];
            
            foreach ($tokoh_penulis as $index => $penulis): 
                $photo = $default_photos[$index % count($default_photos)];
            ?>
            <div class="text-center group cursor-pointer">
                <div class="text-[11px] font-bold text-gray-700 uppercase mb-3 h-8 flex items-center justify-center">
                    <?= $penulis['author'] ?>
                </div>
                <div class="aspect-square overflow-hidden bg-gray-200">
                    <img src="<?= $photo ?>" alt="<?= $penulis['author'] ?>" class="w-full h-full object-cover filter grayscale group-hover:grayscale-0 transition-all duration-500 transform group-hover:scale-105">
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- BOTTOM WIDGETS -->
    <section class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Video & Gallery -->
        <div class="border border-gray-200 bg-white shadow-sm">
            <div class="bg-gray-500 text-white text-center py-2 font-bold text-sm">
                Video & Gallery
            </div>
            <div class="p-4">
                <div class="aspect-video bg-gray-800 relative flex items-center justify-center cursor-pointer group mb-2">
                    <img src="https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?auto=format&fit=crop&w=600&q=80" alt="Video cover" class="absolute inset-0 w-full h-full object-cover opacity-60 group-hover:opacity-80 transition-opacity">
                    <div class="w-12 h-12 bg-red-600 rounded-full flex items-center justify-center text-white z-10">
                        <i class="fas fa-play ml-1"></i>
                    </div>
                </div>
                <a href="#" class="text-xs text-unsoed-darkblue hover:text-unsoed-yellow"><i class="fas fa-caret-right"></i> Gallery Selengkapnya</a>
            </div>
        </div>

        <!-- Agenda Terkini -->
        <div class="border border-gray-200 bg-white shadow-sm">
            <div class="bg-gray-500 text-white text-center py-2 font-bold text-sm">
                AGENDA TERKINI
            </div>
            <div class="p-4 space-y-4">
                <?php $agenda = empty($data['agenda_terkini']) ? [] : $data['agenda_terkini']; ?>
                <?php if(empty($agenda)): ?>
                    <p class="text-xs text-gray-500 italic">Belum ada agenda terkini.</p>
                <?php else: ?>
                    <?php foreach($agenda as $news): ?>
                    <?php 
                        $agenda_images = [];
                        if(!empty($news['image'])) {
                            $decoded = json_decode($news['image'], true);
                            $agenda_images = is_array($decoded) ? $decoded : (is_string($news['image']) && filter_var($news['image'], FILTER_VALIDATE_URL) ? [$news['image']] : []);
                        }
                    ?>
                    <div class="flex gap-3">
                        <div class="w-16 h-16 bg-gray-200 flex-shrink-0">
                            <?php if(!empty($agenda_images)): ?>
                                <img src="<?= $agenda_images[0] ?>" alt="Agenda" class="w-full h-full object-cover">
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs"><i class="fas fa-image"></i></div>
                            <?php endif; ?>
                        </div>
                        <div>
                            <div class="text-xs text-gray-500 flex items-center gap-1 mb-1">
                                <i class="far fa-calendar-alt"></i> <?= date('d M Y', strtotime($news['created_at'])) ?>
                            </div>
                            <a href="<?= BASEURL; ?>/news/read/<?= $news['slug'] ?>" class="text-sm font-medium text-unsoed-darkblue hover:text-unsoed-yellow leading-tight line-clamp-2">
                                <?= $news['title'] ?>
                            </a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
                
                <a href="<?= BASEURL; ?>/news" class="text-xs text-unsoed-darkblue hover:text-unsoed-yellow block mt-2"><i class="fas fa-caret-right"></i> Agenda Selengkapnya</a>
            </div>
        </div>

        <!-- Social Media & Widgets -->
        <div class="space-y-4">
            <div class="flex gap-2">
                <a href="#" class="w-10 h-10 bg-[#3b5998] text-white flex items-center justify-center hover:opacity-90 transition"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="w-10 h-10 bg-[#00aced] text-white flex items-center justify-center hover:opacity-90 transition"><i class="fab fa-twitter"></i></a>
                <a href="#" class="w-10 h-10 bg-[#bb0000] text-white flex items-center justify-center hover:opacity-90 transition"><i class="fab fa-youtube"></i></a>
                <a href="#" class="w-10 h-10 bg-gradient-to-tr from-[#f09433] via-[#dc2743] to-[#bc1888] text-white flex items-center justify-center hover:opacity-90 transition"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
    </section>

</div>
