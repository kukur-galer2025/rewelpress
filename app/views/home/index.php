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
        
        echo '<div class="group h-full">';
        echo '<a href="'. BASEURL . '/book/detail/' . $buku['slug'] . '" class="block bg-white relative h-full rounded-2xl shadow-sm hover:shadow-xl border border-gray-100/60 hover:border-unsoed-blue/20 transition-all duration-300 transform hover:-translate-y-1 overflow-hidden">';
        
        // Image Container
        echo '<div class="relative overflow-hidden aspect-[3/4] bg-gray-50">';
        echo '<img src="' . $img_src . '" alt="' . htmlspecialchars($buku['title']) . '" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-in-out">';
        
        // Glow effect on hover
        echo '<div class="absolute inset-0 bg-gradient-to-t from-unsoed-darkblue/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>';
        
        // Quick view / cart button overlay
        echo '<div class="absolute bottom-4 left-0 right-0 flex justify-center opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-y-4 group-hover:translate-y-0 z-20">';
        echo '<span class="bg-unsoed-yellow text-unsoed-darkblue text-xs font-bold px-4 py-2 rounded-full shadow-lg flex items-center gap-2"><i class="fas fa-shopping-cart"></i> Lihat Detail</span>';
        echo '</div>';

        // Ribbon
        if(isset($buku['is_flashsale']) && $buku['is_flashsale'] == 1) {
            echo '<div class="absolute top-0 right-0 bg-gradient-to-r from-red-600 to-red-500 text-white text-[10px] font-bold px-8 py-1.5 transform rotate-45 translate-x-6 translate-y-3 shadow-md flex items-center gap-1 z-10">';
            echo '<i class="fas fa-bolt animate-pulse"></i> FLASH SALE';
            echo '</div>';
        } else if($discount > 0) {
            echo '<div class="absolute top-0 right-0 bg-gradient-to-r from-[#bb0000] to-red-600 text-white text-[10px] font-bold px-8 py-1.5 transform rotate-45 translate-x-6 translate-y-3 shadow-md z-10">';
            echo 'DISKON ' . $discount . '%';
            echo '</div>';
        }

        // Stock Indicator
        if(isset($buku['stock']) && $buku['stock'] <= 0) {
            echo '<div class="absolute inset-0 bg-black/50 backdrop-blur-[2px] flex items-center justify-center z-10">';
            echo '<span class="bg-black/80 text-white font-bold text-xs px-4 py-2 rounded-lg border border-gray-600 shadow-xl">STOK HABIS</span>';
            echo '</div>';
        }
        echo '</div>'; // End Image Container

        // Content
        echo '<div class="p-4 flex flex-col justify-between h-[110px]">';
        echo '<div>';
        echo '<p class="text-[10px] text-unsoed-blue font-bold uppercase tracking-wider mb-1">' . esc($category) . '</p>';
        echo '<h3 class="text-xs md:text-[13px] font-bold text-gray-800 leading-snug line-clamp-2 group-hover:text-unsoed-blue transition-colors" title="'.htmlspecialchars($buku['title']).'">' . esc($buku['title']) . '</h3>';
        echo '</div>';
        
        echo '<div class="flex items-baseline justify-between mt-2">';
        if($discount > 0) {
            echo '<div class="flex flex-col">';
            echo '<p class="text-[10px] text-red-500 line-through font-medium leading-none">Rp' . number_format($buku['old_price'], 0, ',', '.') . '</p>';
            echo '<p class="text-base md:text-lg font-extrabold text-gray-900 tracking-tight leading-none mt-1">Rp' . number_format($buku['price'], 0, ',', '.') . '</p>';
            echo '</div>';
        } else {
            echo '<p class="text-base md:text-lg font-extrabold text-gray-900 tracking-tight leading-none mt-auto">Rp' . number_format($buku['price'], 0, ',', '.') . '</p>';
        }
        echo '</div>';

        echo '</div>';
        echo '</a>';
        echo '</div>';
    }
}
?>

<!-- Hero Section -->
<section class="relative h-[85vh] min-h-[600px] flex items-center justify-center overflow-hidden">
    <div class="swiper hero-swiper absolute inset-0 w-full h-full">
        <div class="swiper-wrapper">
            <!-- Slide 1 -->
            <div class="swiper-slide relative">
                <div class="absolute inset-0 bg-gradient-to-r from-unsoed-darkblue/95 via-unsoed-darkblue/80 to-unsoed-blue/30 z-10"></div>
                <img src="https://images.unsplash.com/photo-1507842217343-583bb7270b66?auto=format&fit=crop&q=80" alt="Library" class="absolute inset-0 w-full h-full object-cover">
                <div class="relative z-20 container mx-auto px-4 md:px-24 lg:px-32 h-full flex items-center">
                    <div class="max-w-2xl text-white transform translate-y-8 p-6 md:p-10 rounded-3xl backdrop-blur-md bg-white/5 border border-white/10 shadow-2xl" data-aos="fade-up">
                        <span class="inline-block py-1.5 px-4 rounded-full bg-unsoed-yellow/20 border border-unsoed-yellow/50 text-unsoed-yellow text-xs font-bold tracking-widest mb-6">UNIVERSITAS JENDERAL SOEDIRMAN</span>
                        <h1 class="text-4xl md:text-5xl lg:text-6xl font-serif font-bold leading-tight mb-6 text-gradient drop-shadow-xl">
                            Membangun Peradaban Lewat Tulisan
                        </h1>
                        <p class="text-base md:text-lg text-gray-200 mb-8 font-light leading-relaxed opacity-90">
                            Temukan ribuan karya akademis, hasil penelitian, dan referensi berstandar nasional untuk mendukung ekosistem pendidikan.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4">
                            <a href="<?= BASEURL; ?>/book" class="btn-primary text-center shadow-lg hover:shadow-unsoed-yellow/50">
                                Jelajahi Katalog <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                            </a>
                            <a href="<?= BASEURL; ?>/penerbitan" class="px-6 py-3.5 rounded-full font-semibold text-white border border-white/30 hover:bg-white/10 transition-all duration-300 text-center flex items-center justify-center gap-2">
                                <i class="fas fa-book-open"></i> Cara Menerbitkan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Slide 2 -->
            <div class="swiper-slide relative">
                <div class="absolute inset-0 bg-gradient-to-l from-unsoed-darkblue/95 via-unsoed-darkblue/80 to-unsoed-blue/30 z-10"></div>
                <img src="https://images.unsplash.com/photo-1456513080510-7bf3a84b82f8?auto=format&fit=crop&q=80" alt="Study" class="absolute inset-0 w-full h-full object-cover">
                <div class="relative z-20 container mx-auto px-4 md:px-24 lg:px-32 h-full flex items-center justify-end text-left md:text-right">
                    <div class="max-w-2xl text-white p-6 md:p-10 rounded-3xl backdrop-blur-md bg-white/5 border border-white/10 shadow-2xl" data-aos="fade-left" data-aos-delay="200">
                        <span class="inline-block py-1.5 px-4 rounded-full bg-white/20 border border-white/50 text-white text-xs font-bold tracking-widest mb-6 md:ml-auto">LAYANAN PUBLIKASI</span>
                        <h1 class="text-4xl md:text-5xl lg:text-6xl font-serif font-bold leading-tight mb-6 drop-shadow-xl">
                            Wujudkan Naskah Anda Menjadi <span class="text-unsoed-yellow">Buku Berkualitas</span>
                        </h1>
                        <p class="text-base md:text-lg text-gray-200 mb-8 font-light leading-relaxed opacity-90">
                            Kami memfasilitasi penerbitan buku ber-ISBN dengan proses yang profesional, cepat, dan standar mutu tinggi.
                        </p>
                        <div class="flex md:justify-end">
                            <a href="<?= BASEURL; ?>/penerbitan" class="btn-primary inline-block text-center w-full sm:w-auto shadow-lg hover:shadow-unsoed-yellow/50">
                                Kirim Naskah Sekarang <i class="fas fa-paper-plane ml-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Pagination & Navigation -->
        <div class="swiper-pagination !bottom-10"></div>
    </div>
</section>
<!-- Features Section -->
<section class="py-12 -mt-16 relative z-30 mb-8 px-4 lg:px-0">
    <div class="container mx-auto px-4 max-w-[1200px]">
        <div class="bg-white/90 backdrop-blur-xl rounded-3xl p-8 grid grid-cols-1 md:grid-cols-3 gap-8 shadow-2xl border border-white/50" data-aos="fade-up" data-aos-delay="100">
            <div class="text-center group hover:-translate-y-2 transition-transform duration-300">
                <div class="w-16 h-16 bg-gradient-to-br from-unsoed-blue/10 to-unsoed-blue/5 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform shadow-inner text-unsoed-blue">
                    <i class="fas fa-truck text-2xl"></i>
                </div>
                <h3 class="font-bold text-gray-900 mb-2">Pengiriman Cepat</h3>
                <p class="text-sm text-gray-600">Ke seluruh wilayah Indonesia</p>
            </div>
            <div class="text-center group hover:-translate-y-2 transition-transform duration-300 relative before:hidden md:before:block before:absolute before:left-0 before:top-1/4 before:bottom-1/4 before:w-px before:bg-gray-200 after:hidden md:after:block after:absolute after:right-0 after:top-1/4 after:bottom-1/4 after:w-px after:bg-gray-200">
                <div class="w-16 h-16 bg-gradient-to-br from-unsoed-yellow/20 to-unsoed-yellow/5 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform shadow-inner text-unsoed-yellow">
                    <i class="fas fa-certificate text-2xl"></i>
                </div>
                <h3 class="font-bold text-gray-900 mb-2">Buku Original 100%</h3>
                <p class="text-sm text-gray-600">Kualitas cetak premium</p>
            </div>
            <div class="text-center group hover:-translate-y-2 transition-transform duration-300">
                <div class="w-16 h-16 bg-gradient-to-br from-green-500/10 to-green-500/5 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform shadow-inner text-green-600">
                    <i class="fas fa-shield-alt text-2xl"></i>
                </div>
                <h3 class="font-bold text-gray-900 mb-2">Pembayaran Aman</h3>
                <p class="text-sm text-gray-600">Berbagai metode pembayaran</p>
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
        <div class="flex justify-between items-center mb-6" data-aos="fade-right">
            <div class="flex items-center gap-3">
                <div class="w-1.5 h-6 bg-unsoed-yellow rounded-full"></div>
                <h2 class="text-base font-bold text-unsoed-darkblue uppercase tracking-wide">BUKU TERBARU</h2>
            </div>
            <a href="<?= BASEURL; ?>/book" class="text-xs text-unsoed-blue hover:text-unsoed-yellow transition-colors font-semibold bg-unsoed-blue/5 hover:bg-unsoed-blue/10 px-4 py-2 rounded-full flex items-center gap-2">Lihat semua <i class="fas fa-arrow-right text-[10px]"></i></a>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-5 gap-x-6 gap-y-10" data-aos="fade-up" data-aos-delay="150">
            <?php foreach ($buku_terbaru as $buku) { renderBookCard($buku); } ?>
        </div>
    </section>

    <!-- TERPOPULER -->
    <section class="mb-12 bg-gray-50/50 py-8 px-4 -mx-4 md:rounded-3xl border border-gray-100">
        <div class="flex justify-between items-center mb-6" data-aos="fade-right">
            <div class="flex items-center gap-3">
                <div class="w-1.5 h-6 bg-unsoed-blue rounded-full"></div>
                <h2 class="text-base font-bold text-unsoed-darkblue uppercase tracking-wide">TERPOPULER</h2>
            </div>
            <a href="<?= BASEURL; ?>/book" class="text-xs text-unsoed-blue hover:text-unsoed-yellow transition-colors font-semibold bg-unsoed-blue/5 hover:bg-unsoed-blue/10 px-4 py-2 rounded-full flex items-center gap-2">Lihat semua <i class="fas fa-arrow-right text-[10px]"></i></a>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-5 gap-x-6 gap-y-10" data-aos="fade-up" data-aos-delay="150">
            <?php foreach ($buku_terpopuler as $buku) { renderBookCard($buku); } ?>
        </div>
    </section>

    <!-- TERLARIS / FAVORIT -->
    <section class="mb-12">
        <div class="flex justify-between items-center mb-6" data-aos="fade-right">
            <div class="flex items-center gap-3">
                <div class="w-1.5 h-6 bg-green-500 rounded-full"></div>
                <h2 class="text-base font-bold text-unsoed-darkblue uppercase tracking-wide">TERLARIS / FAVORIT</h2>
            </div>
            <a href="<?= BASEURL; ?>/book" class="text-xs text-unsoed-blue hover:text-unsoed-yellow transition-colors font-semibold bg-unsoed-blue/5 hover:bg-unsoed-blue/10 px-4 py-2 rounded-full flex items-center gap-2">Lihat semua <i class="fas fa-arrow-right text-[10px]"></i></a>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-5 gap-x-6 gap-y-10" data-aos="fade-up" data-aos-delay="150">
            <?php foreach ($buku_terlaris as $buku) { renderBookCard($buku); } ?>
        </div>
    </section>

    <!-- E-BOOK DIGITAL -->
    <section class="mb-16 relative">
        <div class="absolute inset-0 bg-gradient-to-r from-unsoed-blue/5 to-unsoed-darkblue/5 rounded-3xl transform -skew-y-1 z-0"></div>
        <div class="relative z-10 py-10 px-4 md:px-8">
            <div class="flex justify-between items-center mb-8" data-aos="fade-right">
                <div class="flex items-center gap-3">
                    <div class="w-1.5 h-6 bg-purple-500 rounded-full"></div>
                    <h2 class="text-base md:text-lg font-bold text-unsoed-darkblue uppercase tracking-wide flex items-center gap-2"><i class="fas fa-tablet-alt text-purple-500"></i> E-BOOK DIGITAL</h2>
                </div>
                <a href="<?= BASEURL; ?>/ebook" class="text-xs text-unsoed-blue hover:text-unsoed-yellow transition-colors font-semibold bg-white shadow-sm hover:shadow-md px-4 py-2 rounded-full flex items-center gap-2">Lihat semua <i class="fas fa-arrow-right text-[10px]"></i></a>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-5 gap-x-6 gap-y-10" data-aos="fade-up" data-aos-delay="150">
            <?php 
            $latest_ebooks = !empty($data['latest_ebooks']) ? $data['latest_ebooks'] : [];
            if(empty($latest_ebooks)): ?>
                <div class="col-span-full text-center py-6 text-gray-400 text-xs italic">Belum ada koleksi E-Book digital.</div>
            <?php else:
                foreach ($latest_ebooks as $ebook):
                    $img_src = !empty($ebook['cover_image']) ? (strpos($ebook['cover_image'], 'http') === 0 ? $ebook['cover_image'] : BASEURL . '/uploads/covers/' . $ebook['cover_image']) : 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?auto=format&fit=crop&q=80&w=400';
            ?>
            <div class="group h-full">
                <a href="<?= BASEURL; ?>/ebook/detail/<?= esc($ebook['id']) ?>" class="block bg-white relative h-full rounded-2xl shadow-sm hover:shadow-xl border border-purple-100/60 hover:border-purple-300/50 transition-all duration-300 transform hover:-translate-y-1 overflow-hidden">
                    <div class="relative overflow-hidden aspect-[3/4] bg-gray-50">
                        <img src="<?= esc($img_src) ?>" alt="<?= htmlspecialchars($ebook['title'] ?? $ebook['book_title'] ?? '') ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-in-out">
                        
                        <div class="absolute inset-0 bg-gradient-to-t from-purple-900/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-0"></div>
                        
                        <div class="absolute top-2 left-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-[10px] font-bold px-2 py-1 rounded shadow flex items-center gap-1 z-10">
                            <i class="fas fa-tablet-alt"></i> E-BOOK
                        </div>
                        
                        <!-- Quick view / cart button overlay -->
                        <div class="absolute bottom-4 left-0 right-0 flex justify-center opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-y-4 group-hover:translate-y-0 z-20">
                            <span class="bg-purple-600 text-white text-xs font-bold px-4 py-2 rounded-full shadow-lg flex items-center gap-2"><i class="fas fa-book-reader"></i> Baca E-Book</span>
                        </div>

                        <?php if(isset($ebook['is_flashsale']) && $ebook['is_flashsale'] == 1): ?>
                            <div class="absolute top-0 right-0 bg-gradient-to-r from-red-600 to-red-500 text-white text-[10px] font-bold px-8 py-1.5 transform rotate-45 translate-x-6 translate-y-3 shadow-md flex items-center gap-1 z-10">
                                <i class="fas fa-bolt animate-pulse"></i> FLASH SALE
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="p-4 flex flex-col justify-between h-[110px]">
                        <div>
                            <h3 class="text-xs md:text-[13px] font-bold text-gray-800 uppercase leading-snug mb-1 line-clamp-2 group-hover:text-purple-600 transition-colors" title="<?= htmlspecialchars($ebook['title'] ?? $ebook['book_title'] ?? '') ?>"><?= htmlspecialchars($ebook['title'] ?? $ebook['book_title'] ?? '') ?></h3>
                            <p class="text-[10px] text-gray-400 mb-2 truncate"><i class="fas fa-user-edit mr-1"></i> <?= htmlspecialchars($ebook['book_author'] ?? 'Penulis') ?></p>
                        </div>
                        
                        <div class="flex items-baseline justify-between mt-2">
                            <?php 
                                $isFree = isset($ebook['is_free']) && $ebook['is_free'] == 1;
                                $harga = isset($ebook['ebook_price']) ? floatval($ebook['ebook_price']) : 0;
                            ?>
                            <?php if($isFree || $harga == 0): ?>
                                <span class="text-xs font-bold text-green-600 bg-green-50 px-2 py-0.5 rounded border border-green-200 mt-auto">GRATIS</span>
                            <?php else: ?>
                                <span class="text-base md:text-lg font-extrabold text-gray-900 tracking-tight leading-none mt-auto">Rp<?= number_format($harga, 0, ',', '.') ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                </a>
            </div>
            <?php endforeach; endif; ?>
        </div>
    </section>

    <!-- TOKOH PENULIS -->
    <section class="mb-16">
        <div class="flex justify-between items-center mb-6" data-aos="fade-right">
            <div class="flex items-center gap-3">
                <div class="w-1.5 h-6 bg-unsoed-yellow rounded-full"></div>
                <h2 class="text-base font-bold text-unsoed-darkblue uppercase tracking-wide">TOKOH PENULIS</h2>
            </div>
            <a href="<?= BASEURL; ?>/penulis" class="text-xs text-unsoed-blue hover:text-unsoed-yellow transition-colors font-semibold bg-unsoed-blue/5 hover:bg-unsoed-blue/10 px-4 py-2 rounded-full flex items-center gap-2">Lihat semua <i class="fas fa-arrow-right text-[10px]"></i></a>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4" data-aos="fade-up" data-aos-delay="150">
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
            <a href="<?= BASEURL; ?>/penulis/detail/<?= esc($author_param) ?>" class="text-center group block bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg border border-gray-100 transition-all duration-300 p-3">
                <div class="aspect-square overflow-hidden rounded-xl bg-gray-100 relative mb-3">
                    <img src="<?= esc($photo) ?>" alt="<?= htmlspecialchars($author_name) ?>" class="w-full h-full object-cover filter grayscale group-hover:grayscale-0 transition-all duration-500 transform group-hover:scale-105">
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

    <!-- TESTIMONI PEMBACA & PENULIS -->
    <section class="mb-16">
        <div class="flex justify-between items-center mb-6" data-aos="fade-right">
            <div class="flex items-center gap-3">
                <div class="w-1.5 h-6 bg-unsoed-yellow rounded-full"></div>
                <h2 class="text-base font-bold text-unsoed-darkblue uppercase tracking-wide">ULASAN & TESTIMONI</h2>
            </div>
        </div>
        
        <div class="swiper testimoni-swiper overflow-visible pb-12" data-aos="fade-up" data-aos-delay="150">
            <div class="swiper-wrapper">
                <!-- Testimoni 1 -->
                <div class="swiper-slide h-auto p-2 pb-4">
                    <div class="bg-white rounded-3xl p-8 shadow-sm hover:shadow-md border border-gray-100 relative transition-all duration-300 h-full flex flex-col group">
                        <i class="fas fa-quote-right text-6xl text-gray-100 absolute top-6 right-6 transition-colors"></i>
                        <div class="flex items-center gap-4 mb-6 relative z-10">
                            <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?auto=format&fit=crop&w=150&q=80" alt="Siti Rahma" class="w-14 h-14 rounded-full object-cover border-2 border-unsoed-yellow p-0.5">
                            <div>
                                <h4 class="font-bold text-gray-900 text-sm">Siti Rahma</h4>
                                <p class="text-[11px] font-medium text-gray-500 uppercase tracking-wider">Mahasiswa S2</p>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600 leading-relaxed italic relative z-10 flex-grow">"Buku-buku terbitan Unsoed Press sangat membantu untuk referensi tesis saya. Kualitas cetaknya premium dan pengirimannya juga cepat!"</p>
                        <div class="mt-6 flex text-unsoed-yellow text-[10px] gap-1 relative z-10">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                        </div>
                    </div>
                </div>

                <!-- Testimoni 2 -->
                <div class="swiper-slide h-auto p-2 pb-4">
                    <div class="bg-white rounded-3xl p-8 shadow-sm hover:shadow-md border border-gray-100 relative transition-all duration-300 h-full flex flex-col group">
                        <i class="fas fa-quote-right text-6xl text-gray-100 absolute top-6 right-6 transition-colors"></i>
                        <div class="flex items-center gap-4 mb-6 relative z-10">
                            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&w=150&q=80" alt="Dr. Budi Santoso" class="w-14 h-14 rounded-full object-cover border-2 border-unsoed-blue p-0.5">
                            <div>
                                <h4 class="font-bold text-gray-900 text-sm">Dr. Budi Santoso</h4>
                                <p class="text-[11px] font-medium text-gray-500 uppercase tracking-wider">Dosen & Peneliti</p>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600 leading-relaxed italic relative z-10 flex-grow">"Pelayanan penerbitan di sini sangat profesional. Naskah diedit dengan rapi dan proses pengurusan ISBN-nya sangat transparan dan mudah."</p>
                        <div class="mt-6 flex text-unsoed-yellow text-[10px] gap-1 relative z-10">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                        </div>
                    </div>
                </div>

                <!-- Testimoni 3 -->
                <div class="swiper-slide h-auto p-2 pb-4">
                    <div class="bg-white rounded-3xl p-8 shadow-sm hover:shadow-md border border-gray-100 relative transition-all duration-300 h-full flex flex-col group">
                        <i class="fas fa-quote-right text-6xl text-gray-100 absolute top-6 right-6 transition-colors"></i>
                        <div class="flex items-center gap-4 mb-6 relative z-10">
                            <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=150&q=80" alt="Amanda Wijaya" class="w-14 h-14 rounded-full object-cover border-2 border-green-500 p-0.5">
                            <div>
                                <h4 class="font-bold text-gray-900 text-sm">Amanda Wijaya</h4>
                                <p class="text-[11px] font-medium text-gray-500 uppercase tracking-wider">Pembaca Setia</p>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600 leading-relaxed italic relative z-10 flex-grow">"Pilihan e-book-nya luar biasa. Saya bisa langsung baca materi perkuliahan lewat HP. Harganya pun juga sangat bersahabat untuk kantong mahasiswa."</p>
                        <div class="mt-6 flex text-unsoed-yellow text-[10px] gap-1 relative z-10">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-pagination !-bottom-2"></div>
        </div>
    </section>

    <!-- BOTTOM WIDGETS -->
    <section class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Video & Gallery (Diperbagus) -->
        <div class="border border-gray-200 bg-white shadow-sm overflow-hidden rounded-xl group" data-aos="fade-up">
            <div class="bg-unsoed-darkblue text-white text-center py-3 font-bold text-sm tracking-wide">
                <i class="fas fa-camera-retro mr-2"></i> GALERI MULTIMEDIA
            </div>
            <div class="p-5">
                <!-- Video Section -->
                <?php 
                $latestVideo = !empty($data['latest_video']) ? $data['latest_video'] : null;
                if ($latestVideo):
                    $vidTitle = htmlspecialchars($latestVideo['title']);
                    $vidThumb = !empty($latestVideo['thumbnail_url']) ? $latestVideo['thumbnail_url'] : 'https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?auto=format&fit=crop&w=600&q=80';
                    $vidUrl = $latestVideo['youtube_url'];
                ?>
                <div onclick="openVideoModal('<?= esc($vidUrl) ?>', '<?= addslashes($vidTitle) ?>')" class="aspect-video bg-gray-900 relative rounded-xl overflow-hidden flex items-center justify-center cursor-pointer group/video mb-4 shadow-sm border border-gray-200">
                    <img src="<?= esc($vidThumb) ?>" alt="<?= esc($vidTitle) ?>" class="absolute inset-0 w-full h-full object-cover opacity-80 group-hover/video:opacity-90 group-hover/video:scale-105 transition-all duration-500">
                    <div class="w-14 h-14 bg-red-600 group-hover/video:bg-red-700 rounded-full flex items-center justify-center text-white z-10 shadow-lg transform group-hover/video:scale-110 transition-transform duration-300">
                        <i class="fas fa-play ml-1 text-lg"></i>
                    </div>
                    <div class="absolute bottom-0 inset-x-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent p-3 pt-8 opacity-90 group-hover/video:opacity-100 transition-opacity">
                        <p class="text-xs text-white font-medium line-clamp-2 leading-tight drop-shadow-md"><?= esc($vidTitle) ?></p>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Photo Section -->
                <?php $latest_photos = !empty($data['latest_photos']) ? array_slice($data['latest_photos'], 0, 3) : []; ?>
                <?php if(!empty($latest_photos)): ?>
                <div class="grid grid-cols-3 gap-2 mb-4">
                    <?php foreach($latest_photos as $photo): ?>
                        <div class="aspect-square bg-gray-100 rounded-lg overflow-hidden group/photo cursor-pointer relative shadow-sm border border-gray-200">
                            <img src="<?= esc($photo['image_url']) ?>" alt="<?= htmlspecialchars($photo['title']) ?>" class="w-full h-full object-cover group-hover/photo:scale-110 transition-transform duration-500">
                            <div class="absolute inset-0 bg-black/0 group-hover/photo:bg-black/30 transition-colors flex items-center justify-center">
                                <i class="fas fa-search-plus text-white opacity-0 group-hover/photo:opacity-100 transition-opacity scale-50 group-hover/photo:scale-100 transform duration-300"></i>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
                
                <a href="<?= BASEURL; ?>/gallery" class="w-full text-center text-xs text-unsoed-darkblue hover:text-white border border-unsoed-darkblue hover:bg-unsoed-darkblue font-semibold block py-2.5 rounded-lg transition-colors mt-2">
                    Jelajahi Semua Galeri &rarr;
                </a>
            </div>
        </div>

        <!-- Agenda Terkini -->
        <div class="border border-gray-200 bg-white shadow-sm overflow-hidden rounded-xl" data-aos="fade-up" data-aos-delay="100">
            <div class="bg-unsoed-darkblue text-white text-center py-3 font-bold text-sm tracking-wide">
                <i class="far fa-calendar-alt mr-2"></i> AGENDA TERKINI
            </div>
            <div class="p-5 space-y-5">
                <?php $agenda = empty($data['agenda_terkini']) ? [] : $data['agenda_terkini']; ?>
                <?php if(empty($agenda)): ?>
                    <p class="text-xs text-gray-500 italic text-center py-4">Belum ada agenda terkini.</p>
                <?php else: ?>
                    <?php foreach($agenda as $news): ?>
                    <?php 
                        $agenda_images = [];
                        if(!empty($news['image'])) {
                            $decoded = json_decode($news['image'], true);
                            $agenda_images = is_array($decoded) ? $decoded : (is_string($news['image']) && filter_var($news['image'], FILTER_VALIDATE_URL) ? [$news['image']] : []);
                        }
                    ?>
                    <div class="flex gap-4 group">
                        <div class="w-20 h-20 bg-gray-100 flex-shrink-0 rounded-lg overflow-hidden relative shadow-sm border border-gray-200">
                            <?php if(!empty($agenda_images)): ?>
                                <img src="<?= esc($agenda_images[0]) ?>" alt="Agenda" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center text-gray-400"><i class="fas fa-image text-2xl"></i></div>
                            <?php endif; ?>
                            <div class="absolute inset-0 bg-unsoed-darkblue/10 group-hover:bg-transparent transition-colors"></div>
                        </div>
                        <div class="flex flex-col justify-center">
                            <div class="text-[10px] text-gray-500 font-semibold uppercase tracking-wider flex items-center gap-1.5 mb-1.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-unsoed-yellow"></span> <?= date('d M Y', strtotime($news['created_at'])) ?>
                            </div>
                            <a href="<?= BASEURL; ?>/news/read/<?= esc($news['slug']) ?>" class="text-sm font-bold text-gray-800 hover:text-unsoed-blue leading-snug line-clamp-2 transition-colors">
                                <?= esc($news['title']) ?>
                            </a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
                
                <a href="<?= BASEURL; ?>/news" class="w-full text-center text-xs text-unsoed-darkblue hover:text-white border border-unsoed-darkblue hover:bg-unsoed-darkblue font-semibold block py-2.5 rounded-lg transition-colors mt-2">
                    Agenda Selengkapnya &rarr;
                </a>
            </div>
        </div>

        <!-- Social Media & Widgets -->
        <div class="space-y-6" data-aos="fade-up" data-aos-delay="200">
            <div class="border border-gray-200 bg-white shadow-sm overflow-hidden rounded-xl p-6 text-center">
                <h3 class="font-bold text-gray-800 mb-4">Terhubung Dengan Kami</h3>
                <div class="flex justify-center gap-3">
                    <a href="#" class="w-12 h-12 rounded-full bg-[#3b5998] text-white flex items-center justify-center hover:-translate-y-1 hover:shadow-lg transition-all duration-300 text-lg"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="w-12 h-12 rounded-full bg-[#00aced] text-white flex items-center justify-center hover:-translate-y-1 hover:shadow-lg transition-all duration-300 text-lg"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="w-12 h-12 rounded-full bg-[#bb0000] text-white flex items-center justify-center hover:-translate-y-1 hover:shadow-lg transition-all duration-300 text-lg"><i class="fab fa-youtube"></i></a>
                    <a href="#" class="w-12 h-12 rounded-full bg-gradient-to-tr from-[#f09433] via-[#dc2743] to-[#bc1888] text-white flex items-center justify-center hover:-translate-y-1 hover:shadow-lg transition-all duration-300 text-lg"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
    </section>

</div>
