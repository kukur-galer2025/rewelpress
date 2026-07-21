<?php
$read_images = [];
if(!empty($data['news']['image'])) {
    $decoded = json_decode($data['news']['image'], true);
    $read_images = is_array($decoded) ? $decoded : (is_string($data['news']['image']) && filter_var($data['news']['image'], FILTER_VALIDATE_URL) ? [$data['news']['image']] : []);
}
?>
<div class="bg-gray-50 pb-16 min-h-screen font-sans">
    
    <!-- Hero / Title Section -->
    <div class="bg-white border-b border-gray-200">
        <div class="container mx-auto px-4 max-w-5xl pt-10 pb-12">
            <!-- Breadcrumb -->
            <nav class="flex text-sm text-unsoed-blue font-bold uppercase tracking-widest mb-6" aria-label="Breadcrumb">
                <a href="<?= BASEURL; ?>/news" class="hover:text-unsoed-darkblue transition-colors">Jurnal Utama</a>
                <span class="mx-3 text-gray-300">|</span>
                <span class="text-gray-400">Liputan</span>
            </nav>
            
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-black text-gray-900 mb-6 font-serif leading-tight">
                <?= $data['news']['title'] ?>
            </h1>

            <div class="flex flex-wrap items-center justify-between border-t border-gray-100 pt-6 mt-6">
                <div class="flex items-center gap-4 text-sm text-gray-600 mb-4 md:mb-0">
                    <div class="flex items-center gap-2">
                        <div class="w-10 h-10 bg-unsoed-yellow text-white rounded-full flex items-center justify-center font-bold text-lg shadow-sm">
                            UP
                        </div>
                        <div>
                            <div class="font-bold text-gray-900">Redaksi Unsoed Press</div>
                            <div class="text-xs text-gray-500"><?= date('d F Y', strtotime($data['news']['created_at'])) ?> &middot; <?= $data['news']['views'] ?> tayangan</div>
                        </div>
                    </div>
                </div>
                
                <div class="flex items-center gap-3">
                    <button class="w-10 h-10 rounded-full border border-gray-200 text-gray-500 flex items-center justify-center hover:border-unsoed-blue hover:text-unsoed-blue transition-colors shadow-sm">
                        <i class="fab fa-facebook-f"></i>
                    </button>
                    <button class="w-10 h-10 rounded-full border border-gray-200 text-gray-500 flex items-center justify-center hover:border-blue-400 hover:text-blue-400 transition-colors shadow-sm">
                        <i class="fab fa-twitter"></i>
                    </button>
                    <button class="w-10 h-10 rounded-full border border-gray-200 text-gray-500 flex items-center justify-center hover:border-green-500 hover:text-green-500 transition-colors shadow-sm">
                        <i class="fab fa-whatsapp text-lg"></i>
                    </button>
                    <button class="w-10 h-10 rounded-full border border-gray-200 text-gray-500 flex items-center justify-center hover:border-gray-800 hover:text-gray-800 transition-colors shadow-sm" onclick="navigator.clipboard.writeText(window.location.href); alert('Tautan disalin!')">
                        <i class="fas fa-link"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="container mx-auto px-4 max-w-7xl pt-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            
            <!-- Left Article Column -->
            <div class="lg:col-span-8">
                <article class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden mb-12">
                    
                    <!-- Cover Image / Gallery -->
                    <?php if(!empty($read_images)): ?>
                        <?php if(count($read_images) == 1): ?>
                            <div class="w-full aspect-[2/1] bg-gray-100 relative">
                                <img src="<?= $read_images[0] ?>" alt="<?= $data['news']['title'] ?>" class="w-full h-full object-cover">
                            </div>
                        <?php else: ?>
                            <!-- Swiper Slider -->
                            <div class="w-full aspect-[2/1] bg-gray-100 relative group swiper news-gallery-swiper">
                                <div class="swiper-wrapper">
                                    <?php foreach($read_images as $img): ?>
                                        <div class="swiper-slide w-full h-full">
                                            <img src="<?= $img ?>" alt="<?= $data['news']['title'] ?>" class="w-full h-full object-cover">
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <div class="swiper-button-next !text-white !bg-black/40 hover:!bg-black/70 !w-12 !h-12 !rounded-full opacity-0 group-hover:opacity-100 transition-opacity !right-4"></div>
                                <div class="swiper-button-prev !text-white !bg-black/40 hover:!bg-black/70 !w-12 !h-12 !rounded-full opacity-0 group-hover:opacity-100 transition-opacity !left-4"></div>
                                <div class="swiper-pagination"></div>
                            </div>
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    new Swiper('.news-gallery-swiper', {
                                        loop: true,
                                        autoplay: { delay: 4000, disableOnInteraction: false },
                                        navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
                                        pagination: { el: '.swiper-pagination', clickable: true },
                                    });
                                });
                            </script>
                        <?php endif; ?>
                    <?php endif; ?>

                    <div class="p-6 md:p-10 lg:p-12">
                        <!-- Quill Content -->
                        <div class="ql-snow">
                            <div class="ql-editor prose prose-lg md:prose-xl prose-gray max-w-none 
                                        prose-headings:font-serif prose-headings:font-bold prose-headings:text-gray-900 
                                        prose-p:text-gray-700 prose-p:leading-relaxed prose-p:mb-6
                                        prose-a:text-unsoed-blue prose-a:font-semibold hover:prose-a:text-unsoed-yellow
                                        prose-img:rounded-xl prose-img:shadow-md prose-img:mx-auto
                                        prose-blockquote:border-l-4 prose-blockquote:border-unsoed-yellow prose-blockquote:bg-gray-50 prose-blockquote:py-2 prose-blockquote:px-6 prose-blockquote:text-gray-600 prose-blockquote:italic prose-blockquote:font-serif">
                                <?= $data['news']['content'] ?>
                            </div>
                        </div>

                        <!-- Tags / Footer -->
                        <div class="mt-12 pt-6 border-t border-gray-100 flex flex-wrap gap-2">
                            <span class="px-3 py-1 bg-gray-100 text-gray-600 text-xs font-bold uppercase tracking-wider rounded-sm hover:bg-gray-200 cursor-pointer transition-colors">Unsoed Press</span>
                            <span class="px-3 py-1 bg-gray-100 text-gray-600 text-xs font-bold uppercase tracking-wider rounded-sm hover:bg-gray-200 cursor-pointer transition-colors">Buku Baru</span>
                            <span class="px-3 py-1 bg-gray-100 text-gray-600 text-xs font-bold uppercase tracking-wider rounded-sm hover:bg-gray-200 cursor-pointer transition-colors">Penerbitan</span>
                        </div>
                    </div>
                </article>
            </div>

            <!-- Right Sidebar: Related / Terkini -->
            <div class="lg:col-span-4 space-y-10">
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 md:p-8 sticky top-28">
                    <h3 class="text-xl font-bold font-serif text-gray-900 border-l-4 border-unsoed-yellow pl-4 mb-6 uppercase tracking-wide">
                        Kabar Terkini
                    </h3>
                    
                    <div class="space-y-6">
                        <?php if(!empty($data['related_news'])): ?>
                            <?php foreach($data['related_news'] as $rel): ?>
                                <?php if($rel['id'] == $data['news']['id']) continue; // skip self ?>
                                <a href="<?= BASEURL; ?>/news/read/<?= $rel['slug'] ?>" class="group flex gap-4 items-start">
                                    <div class="w-24 h-24 bg-gray-100 rounded-md flex-shrink-0 overflow-hidden shadow-sm">
                                        <?php 
                                            $rel_images = [];
                                            if(!empty($rel['image'])) {
                                                $decoded = json_decode($rel['image'], true);
                                                $rel_images = is_array($decoded) ? $decoded : (is_string($rel['image']) && filter_var($rel['image'], FILTER_VALIDATE_URL) ? [$rel['image']] : []);
                                            }
                                        ?>
                                        <?php if(!empty($rel_images)): ?>
                                            <img src="<?= $rel_images[0] ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                        <?php else: ?>
                                            <div class="w-full h-full flex items-center justify-center text-gray-300"><i class="fas fa-image"></i></div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="flex-1">
                                        <div class="text-xs text-unsoed-blue font-bold uppercase tracking-wider mb-1">
                                            <?= date('d M Y', strtotime($rel['created_at'])) ?>
                                        </div>
                                        <h4 class="text-sm font-bold text-gray-900 group-hover:text-unsoed-blue transition-colors line-clamp-3 leading-snug">
                                            <?= $rel['title'] ?>
                                        </h4>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    
                    <a href="<?= BASEURL; ?>/news" class="mt-8 block w-full text-center py-3 border-2 border-unsoed-darkblue text-unsoed-darkblue font-bold uppercase tracking-widest text-xs hover:bg-unsoed-darkblue hover:text-white transition-colors rounded-sm">
                        Indeks Berita
                    </a>
                </div>
            </div>
            
        </div>
    </div>
</div>
