<!-- Header Title Banner -->
<div class="bg-[#f3f4f6] border-b border-gray-200 py-8">
    <div class="container mx-auto px-4 max-w-[1200px] flex flex-col md:flex-row md:items-center justify-between gap-4">
        <h1 class="text-3xl md:text-4xl font-serif font-light text-gray-600 uppercase tracking-wide">VIDEO</h1>
        <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider flex items-center gap-2">
            <a href="<?= BASEURL; ?>" class="hover:text-unsoed-blue transition">HOME</a>
            <span>/</span>
            <span class="text-gray-700 font-bold">VIDEO</span>
        </div>
    </div>
</div>

<div class="container mx-auto px-4 max-w-[1200px] py-14">
    <?php if (empty($data['videos'])): ?>
        <div class="bg-white rounded-2xl border border-gray-200 p-16 text-center text-gray-400">
            <i class="fas fa-video text-5xl mb-4 block text-gray-300"></i>
            Belum ada video yang diunggah ke galeri.
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
            <?php foreach ($data['videos'] as $video): ?>
                <?php 
                    // Pastikan url dalam format embed bersih untuk dimainkan di modal
                    $embedUrl = $video['youtube_url'];
                    if (strpos($embedUrl, 'watch?v=') !== false) {
                        parse_str(parse_url($embedUrl, PHP_URL_QUERY), $params);
                        if (isset($params['v'])) {
                            $embedUrl = 'https://www.youtube.com/embed/' . $params['v'];
                        }
                    } elseif (strpos($embedUrl, 'youtu.be/') !== false) {
                        $parts = explode('youtu.be/', $embedUrl);
                        if (isset($parts[1])) {
                            $embedUrl = 'https://www.youtube.com/embed/' . trim($parts[1]);
                        }
                    }

                    // Ambil thumbnail otomatis dari YouTube jika thumbnail_url kosong/default
                    $thumbUrl = $video['thumbnail_url'];
                    if (empty($thumbUrl) || $thumbUrl == 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=600&q=80') {
                        if (preg_match('/embed\/([a-zA-Z0-9_-]+)/', $embedUrl, $matches)) {
                            $thumbUrl = 'https://img.youtube.com/vi/' . $matches[1] . '/hqdefault.jpg';
                        }
                    }
                ?>
                <div onclick="openVideoModal('<?= esc($embedUrl) ?>', '<?= htmlspecialchars($video['title'], ENT_QUOTES) ?>')" class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-300 border border-gray-200 flex flex-col cursor-pointer group transform hover:-translate-y-1.5">
                    <!-- Thumbnail Preview + Play Overlay -->
                    <div class="aspect-video w-full bg-gray-900 relative overflow-hidden">
                        <img src="<?= esc($thumbUrl) ?>" alt="<?= htmlspecialchars($video['title']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        
                        <!-- Dark Gradient Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent flex flex-col items-center justify-center group-hover:bg-black/40 transition-colors duration-300">
                            <!-- Big Red Play Button -->
                            <span class="w-16 h-16 rounded-full bg-red-600 text-white flex items-center justify-center text-2xl shadow-xl shadow-red-600/40 group-hover:scale-110 group-hover:bg-red-500 transition-all duration-300">
                                <i class="fas fa-play ml-1"></i>
                            </span>
                            <span class="text-white/80 text-xs font-semibold mt-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300 tracking-wider uppercase">
                                <i class="fas fa-expand-alt mr-1"></i> Klik untuk putar (Layar Besar)
                            </span>
                        </div>
                    </div>
                    <!-- Title -->
                    <div class="p-4 bg-gray-900 text-white text-center min-h-[56px] flex items-center justify-center border-t border-gray-800">
                        <h4 class="text-xs font-bold uppercase tracking-wider line-clamp-2 leading-relaxed group-hover:text-unsoed-yellow transition-colors">
                            <?= htmlspecialchars($video['title']) ?>
                        </h4>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Pagination -->
        <div class="mt-12 flex items-center justify-start gap-1.5 text-sm font-semibold">
            <a href="#" class="w-9 h-9 flex items-center justify-center bg-[#0f3460] text-white rounded shadow-sm">1</a>
            <a href="#" class="w-9 h-9 flex items-center justify-center bg-white border border-gray-200 text-gray-800 rounded hover:bg-gray-50 transition">2</a>
            <a href="#" class="px-3 h-9 flex items-center justify-center bg-white border border-gray-200 text-gray-800 rounded hover:bg-gray-50 transition font-normal">next</a>
            <a href="#" class="w-9 h-9 flex items-center justify-center bg-white border border-gray-200 text-gray-800 rounded hover:bg-gray-50 transition">&raquo;</a>
        </div>
    <?php endif; ?>
</div>
