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
            <a href="<?= BASEURL; ?>/penulis" class="text-xs text-unsoed-blue hover:text-unsoed-yellow transition-colors font-semibold bg-unsoed-blue/5 hover:bg-unsoed-blue/10 px-3 py-1.5 rounded-full">Lihat semua</a>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            <?php 
            if(empty($tokoh_penulis)): ?>
                <div class="col-span-full text-center py-6 text-gray-400 text-xs italic">Belum ada data tokoh penulis.</div>
            <?php else:
                foreach ($tokoh_penulis as $index => $penulis): 
                    $author_name = $penulis['name'] ?? $penulis['author'] ?? 'Penulis';
                    $photo = !empty($penulis['photo']) ? $penulis['photo'] : 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=300&h=300&q=80';
                    $affiliation = $penulis['affiliation'] ?? '';
                    $author_param = !empty($penulis['id']) ? $penulis['id'] : urlencode($author_name);
            ?>
            <a href="<?= BASEURL; ?>/penulis/detail/<?= $author_param ?>" class="text-center group block bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg border border-gray-100 transition-all duration-300 p-3">
                <div class="aspect-square overflow-hidden rounded-xl bg-gray-100 relative mb-3">
                    <img src="<?= $photo ?>" alt="<?= htmlspecialchars($author_name) ?>" class="w-full h-full object-cover filter grayscale group-hover:grayscale-0 transition-all duration-500 transform group-hover:scale-105">
                    <?php if(!empty($affiliation)): ?>
                        <div class="absolute inset-0 bg-gradient-to-t from-unsoed-darkblue/90 via-unsoed-darkblue/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-2 text-left">
                            <p class="text-[10px] text-white font-medium leading-tight line-clamp-3"><?= htmlspecialchars($affiliation) ?></p>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="text-[12px] font-bold text-gray-800 uppercase line-clamp-2 leading-snug group-hover:text-unsoed-blue transition-colors min-h-[34px] flex items-center justify-center">
                    <?= htmlspecialchars($author_name) ?>
                </div>
            </a>
            <?php endforeach; 
            endif; ?>
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
                <?php 
                $latestVideo = !empty($data['latest_video']) ? $data['latest_video'] : null;
                if ($latestVideo):
                    $vidTitle = htmlspecialchars($latestVideo['title']);
                    $vidThumb = !empty($latestVideo['thumbnail_url']) ? $latestVideo['thumbnail_url'] : 'https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?auto=format&fit=crop&w=600&q=80';
                    $vidUrl = $latestVideo['youtube_url'];
                ?>
                <div onclick="openVideoModal('<?= $vidUrl ?>', '<?= addslashes($vidTitle) ?>')" class="aspect-video bg-gray-900 relative rounded overflow-hidden flex items-center justify-center cursor-pointer group mb-2 shadow-inner">
                    <img src="<?= $vidThumb ?>" alt="<?= $vidTitle ?>" class="absolute inset-0 w-full h-full object-cover opacity-80 group-hover:opacity-90 group-hover:scale-105 transition-all duration-500">
                    <div class="w-12 h-12 bg-red-600 group-hover:bg-red-700 rounded-full flex items-center justify-center text-white z-10 shadow-lg transform group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-play ml-1 text-sm"></i>
                    </div>
                    <div class="absolute bottom-0 inset-x-0 bg-gradient-to-t from-black/80 to-transparent p-2 pt-6 opacity-90 group-hover:opacity-100 transition-opacity">
                        <p class="text-[11px] text-white font-medium line-clamp-1 leading-tight"><?= $vidTitle ?></p>
                    </div>
                </div>
                <?php else: ?>
                <div class="aspect-video bg-gray-100 rounded relative flex items-center justify-center mb-2 border border-dashed border-gray-300 text-gray-400 text-xs text-center p-3">
                    Belum ada video galeri yang diunggah.
                </div>
                <?php endif; ?>
                <a href="<?= BASEURL; ?>/gallery" class="text-xs text-unsoed-darkblue hover:text-unsoed-yellow font-medium block mt-3"><i class="fas fa-caret-right"></i> Gallery Selengkapnya</a>
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
