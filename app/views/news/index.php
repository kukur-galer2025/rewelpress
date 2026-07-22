<!-- Header Title Banner -->
<div class="bg-[#f3f4f6] border-b border-gray-200 py-8">
    <div class="container mx-auto px-4 max-w-[1200px] flex flex-col md:flex-row md:items-center justify-between gap-4">
        <h1 class="text-3xl md:text-4xl font-serif font-light text-gray-500 uppercase tracking-wide">EVENT & AGENDA</h1>
        <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider flex items-center gap-2">
            <a href="<?= BASEURL; ?>" class="hover:text-unsoed-blue transition">HOME</a>
            <span>/</span>
            <span class="text-gray-700 font-bold">EVENT & AGENDA</span>
        </div>
    </div>
</div>

<div class="container mx-auto px-4 max-w-[1200px] py-14">

    <?php if(empty($data['news'])): ?>
        <div class="py-20 text-center text-gray-400">
            <i class="far fa-newspaper text-6xl mb-4 block text-gray-200"></i>
            Belum ada berita atau agenda yang ditampilkan.
        </div>
    <?php else: ?>
        <div class="divide-y divide-gray-200">
            <?php foreach($data['news'] as $news): ?>
                <?php 
                    // Decode atau ambil gambar pertama
                    $news_images = [];
                    if(!empty($news['image'])) {
                        $decoded = json_decode($news['image'], true);
                        $news_images = is_array($decoded) ? $decoded : (is_string($news['image']) && filter_var($news['image'], FILTER_VALIDATE_URL) ? [$news['image']] : []);
                    }
                    $thumbUrl = !empty($news_images) ? $news_images[0] : 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=600&q=80';
                    
                    // Format tanggal e.g., "04 June 2026"
                    $formattedDate = date('d F Y', strtotime($news['created_at']));
                ?>
                <div class="py-8 first:pt-0 flex flex-col md:flex-row gap-6 lg:gap-8 items-start">
                    
                    <!-- Left Thumbnail (landscape ratio) -->
                    <a href="<?= BASEURL; ?>/news/read/<?= esc($news['slug']) ?>" class="w-full md:w-[280px] lg:w-[320px] aspect-[16/10] flex-shrink-0 bg-gray-100 rounded overflow-hidden border border-gray-200 shadow-sm group">
                        <img src="<?= esc($thumbUrl) ?>" alt="<?= htmlspecialchars($news['title']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out">
                    </a>

                    <!-- Middle Content (Title & Excerpt) -->
                    <div class="flex-1 space-y-3">
                        <h3 class="text-xl md:text-2xl font-bold font-serif text-gray-800 hover:text-unsoed-blue transition leading-snug">
                            <a href="<?= BASEURL; ?>/news/read/<?= esc($news['slug']) ?>">
                                <?= htmlspecialchars($news['title']) ?>
                            </a>
                        </h3>
                        
                        <p class="text-gray-500 text-sm leading-relaxed line-clamp-3 md:line-clamp-4">
                            <?= strip_tags($news['content']) ?>
                        </p>
                    </div>

                    <!-- Right Column (Tanggal Posting) -->
                    <div class="w-full md:w-[160px] flex-shrink-0 text-left pt-2 md:pt-0">
                        <span class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-1.5">Tanggal Posting</span>
                        <div class="flex items-center gap-2 text-xs text-gray-500 font-medium">
                            <i class="far fa-calendar-alt text-gray-400"></i>
                            <span><?= esc($formattedDate) ?></span>
                        </div>
                    </div>

                </div>
            <?php endforeach; ?>
        </div>

        <!-- Pagination -->
        <div class="flex items-center gap-1.5 pt-12">
            <span class="w-10 h-10 bg-[#0f3460] text-white font-bold flex items-center justify-center rounded text-sm shadow cursor-default">1</span>
            <a href="#" class="w-10 h-10 border border-gray-200 text-gray-600 font-bold flex items-center justify-center rounded text-sm hover:bg-gray-100 transition">2</a>
            <a href="#" class="w-10 h-10 border border-gray-200 text-gray-600 font-bold flex items-center justify-center rounded text-sm hover:bg-gray-100 transition">3</a>
            <a href="#" class="w-10 h-10 border border-gray-200 text-gray-600 font-bold flex items-center justify-center rounded text-sm hover:bg-gray-100 transition">4</a>
            <a href="#" class="w-10 h-10 border border-gray-200 text-gray-600 font-bold flex items-center justify-center rounded text-sm hover:bg-gray-100 transition">›</a>
            <a href="#" class="w-10 h-10 border border-gray-200 text-gray-600 font-bold flex items-center justify-center rounded text-sm hover:bg-gray-100 transition">»</a>
        </div>
    <?php endif; ?>

</div>
