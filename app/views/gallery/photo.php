<!-- Header Title Banner -->
<div class="bg-[#f3f4f6] border-b border-gray-200 py-8">
    <div class="container mx-auto px-4 max-w-[1200px] flex flex-col md:flex-row md:items-center justify-between gap-4">
        <h1 class="text-3xl md:text-4xl font-serif font-light text-gray-600 uppercase tracking-wide">GALLERY</h1>
        <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider flex items-center gap-2">
            <a href="<?= BASEURL; ?>" class="hover:text-unsoed-blue transition">HOME</a>
            <span>/</span>
            <span class="text-gray-700 font-bold">GALLERY</span>
        </div>
    </div>
</div>

<div class="container mx-auto px-4 max-w-[1200px] py-14">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
        
        <!-- Left Sidebar: GALLERY ALBUM -->
        <div class="md:col-span-1">
            <div class="bg-[#0f3460] text-white font-bold px-5 py-3.5 text-sm uppercase tracking-wider rounded-t-lg shadow-sm">
                GALLERY ALBUM
            </div>
            <div class="bg-white border border-gray-200 rounded-b-lg divide-y divide-gray-100 shadow-sm text-sm">
                <a href="<?= BASEURL; ?>/gallery/photo" class="block px-5 py-3.5 transition <?= empty($data['current_album_id']) ? 'bg-blue-50/80 text-unsoed-blue font-bold pl-6 border-l-4 border-unsoed-blue' : 'text-gray-600 hover:bg-gray-50 hover:text-unsoed-blue pl-5' ?>">
                    Semua Foto (<?= count($data['photos'] ?? []) ?>)
                </a>
                <?php foreach ($data['albums'] as $album): ?>
                    <?php $isActive = ($data['current_album_id'] == $album['id']); ?>
                    <a href="<?= BASEURL; ?>/gallery/photo/<?= $album['id'] ?>" class="block px-5 py-3.5 transition <?= $isActive ? 'bg-blue-50/80 text-unsoed-blue font-bold pl-6 border-l-4 border-unsoed-blue' : 'text-gray-600 hover:bg-gray-50 hover:text-unsoed-blue pl-5' ?>">
                        <?= htmlspecialchars($album['title']) ?> (<?= $album['photo_count'] ?>)
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Right Content: Photos Grid -->
        <div class="md:col-span-3">
            <?php if (empty($data['photos'])): ?>
                <div class="bg-white rounded-2xl border border-gray-200 p-12 text-center text-gray-400">
                    <i class="fas fa-images text-5xl mb-4 block text-gray-300"></i>
                    Belum ada foto dalam album ini.
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    <?php foreach ($data['photos'] as $photo): ?>
                        <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100 group flex flex-col cursor-pointer" onclick="openPhotoModal('<?= $photo['image_url'] ?>', '<?= htmlspecialchars($photo['title'], ENT_QUOTES) ?>')">
                            <div class="aspect-[4/3] w-full overflow-hidden bg-gray-100 relative">
                                <img src="<?= $photo['image_url'] ?>" alt="<?= htmlspecialchars($photo['title']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                <div class="absolute inset-0 bg-black/30 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                    <span class="w-10 h-10 rounded-full bg-white/90 text-unsoed-blue flex items-center justify-center shadow-md">
                                        <i class="fas fa-search-plus"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="p-3 text-center flex-1 flex items-center justify-center bg-white">
                                <h4 class="text-xs font-bold text-gray-700 line-clamp-2 group-hover:text-unsoed-blue transition-colors leading-snug">
                                    <?= htmlspecialchars($photo['title']) ?>
                                </h4>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Pagination (Persis contoh UGM Press) -->
                <div class="mt-12 flex items-center justify-start gap-1.5 text-sm font-semibold">
                    <span class="w-9 h-9 flex items-center justify-center bg-[#0f3460] text-white rounded shadow-sm">1</span>
                    <a href="#" class="w-9 h-9 flex items-center justify-center bg-white border border-gray-200 text-gray-600 rounded hover:bg-gray-50 transition">2</a>
                    <a href="#" class="w-9 h-9 flex items-center justify-center bg-white border border-gray-200 text-gray-600 rounded hover:bg-gray-50 transition">3</a>
                    <a href="#" class="w-9 h-9 flex items-center justify-center bg-white border border-gray-200 text-gray-600 rounded hover:bg-gray-50 transition">4</a>
                    <a href="#" class="w-9 h-9 flex items-center justify-center bg-white border border-gray-200 text-gray-600 rounded hover:bg-gray-50 transition">&rsaquo;</a>
                    <a href="#" class="w-9 h-9 flex items-center justify-center bg-white border border-gray-200 text-gray-600 rounded hover:bg-gray-50 transition">&raquo;</a>
                </div>
            <?php endif; ?>
        </div>

    </div>
</div>

<!-- Modal Preview Foto (Lightbox) -->
<div id="photoModal" class="fixed inset-0 z-50 bg-black/80 hidden flex items-center justify-center p-4 backdrop-blur-sm" onclick="closePhotoModal()">
    <div class="relative max-w-4xl max-h-[90vh] bg-white rounded-2xl overflow-hidden shadow-2xl flex flex-col" onclick="event.stopPropagation()">
        <button onclick="closePhotoModal()" class="absolute top-4 right-4 z-10 w-10 h-10 rounded-full bg-black/50 text-white hover:bg-red-600 transition flex items-center justify-center text-lg">
            <i class="fas fa-times"></i>
        </button>
        <div class="overflow-auto max-h-[75vh] flex items-center justify-center bg-black">
            <img id="modalImage" src="" class="max-w-full max-h-[75vh] object-contain">
        </div>
        <div class="p-4 bg-white border-t border-gray-100 text-center">
            <h3 id="modalTitle" class="font-bold text-gray-800 text-base"></h3>
        </div>
    </div>
</div>

<script>
function openPhotoModal(url, title) {
    document.getElementById('modalImage').src = url;
    document.getElementById('modalTitle').textContent = title;
    document.getElementById('photoModal').classList.remove('hidden');
}
function closePhotoModal() {
    document.getElementById('photoModal').classList.add('hidden');
}
</script>
