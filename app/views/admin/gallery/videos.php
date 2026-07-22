<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Kelola Gallery YouTube Video</h1>
        <p class="text-gray-500 mt-1">Kelola video promosi, tutorial, dan liputan acara Unsoed Press.</p>
    </div>
    
    <!-- Tab navigation -->
    <div class="flex items-center gap-2 bg-gray-100 p-1.5 rounded-2xl border border-gray-200 self-start md:self-auto">
        <a href="<?= BASEURL; ?>/admin/gallery" class="px-5 py-2.5 rounded-xl text-sm font-bold text-gray-600 hover:text-gray-900 transition flex items-center gap-2">
            <i class="fas fa-camera"></i> Foto & Album
        </a>
        <a href="<?= BASEURL; ?>/admin/gallery_videos" class="px-5 py-2.5 rounded-xl text-sm font-bold bg-white text-unsoed-blue shadow-sm flex items-center gap-2">
            <i class="fas fa-video"></i> Video YouTube
        </a>
    </div>
</div>

<?php if(isset($_GET['msg'])): ?>
    <div class="mb-6">
        <?php if($_GET['msg'] == 'success_add_video'): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline font-bold"><i class="fas fa-check-circle mr-2"></i>Video baru berhasil ditambahkan!</span>
            </div>
        <?php elseif($_GET['msg'] == 'success_delete_video'): ?>
            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline font-bold"><i class="fas fa-trash-alt mr-2"></i>Video berhasil dihapus!</span>
            </div>
        <?php elseif($_GET['msg'] == 'error'): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline font-bold"><i class="fas fa-exclamation-triangle mr-2"></i>Terjadi kesalahan saat memproses data.</span>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <!-- Kolom Kiri: Form Tambah Video -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 sticky top-24">
            <h3 class="font-bold text-gray-800 text-lg mb-4 flex items-center gap-2">
                <i class="fab fa-youtube text-red-600 text-2xl"></i> Tambah Video YouTube
            </h3>
            <form action="<?= BASEURL; ?>/admin/create_video" method="POST" class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-gray-600 uppercase mb-1.5">Judul Video <span class="text-red-500">*</span></label>
                    <input type="text" name="title" required class="w-full px-3.5 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-unsoed-blue outline-none" placeholder="Contoh: Cara Belanja Online di Unsoed Press">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-600 uppercase mb-1.5">URL Video YouTube <span class="text-red-500">*</span></label>
                    <input type="text" name="youtube_url" required class="w-full px-3.5 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-unsoed-blue outline-none" placeholder="https://www.youtube.com/watch?v=... atau link embed">
                    <p class="text-[11px] text-gray-400 mt-1">Sistem otomatis mengubah link standar YouTube menjadi embed player.</p>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-600 uppercase mb-1.5">URL Thumbnail (Opsional)</label>
                    <input type="url" name="thumbnail_url" class="w-full px-3.5 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-unsoed-blue outline-none" placeholder="https://images.unsplash.com/...">
                </div>
                <button type="submit" class="w-full py-2.5 bg-red-600 text-white rounded-xl font-bold text-sm hover:bg-red-700 transition shadow-md flex items-center justify-center gap-2">
                    <i class="fas fa-plus"></i> Simpan Video
                </button>
            </form>
        </div>
    </div>

    <!-- Kolom Kanan: Daftar Video -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
            <h3 class="font-bold text-gray-800 text-lg mb-6 flex items-center justify-between">
                <span>Daftar Video Galeri</span>
                <span class="text-xs bg-red-50 text-red-600 font-bold px-2.5 py-1 rounded-full"><?= count($data['videos']) ?> Video</span>
            </h3>

            <?php if(empty($data['videos'])): ?>
                <div class="py-16 text-center text-gray-400">
                    <i class="fas fa-video text-4xl mb-3 block text-gray-300"></i>
                    Belum ada video yang diunggah.
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <?php foreach($data['videos'] as $video): ?>
                        <div class="bg-gray-50 rounded-2xl overflow-hidden border border-gray-200 flex flex-col group">
                            <div class="aspect-video w-full bg-black relative">
                                <?php if(strpos($video['youtube_url'], 'embed') !== false): ?>
                                    <iframe src="<?= $video['youtube_url'] ?>" title="<?= htmlspecialchars($video['title']) ?>" class="w-full h-full border-0" allowfullscreen></iframe>
                                <?php else: ?>
                                    <img src="<?= !empty($video['thumbnail_url']) ? $video['thumbnail_url'] : 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=600&q=80' ?>" class="w-full h-full object-cover">
                                <?php endif; ?>
                            </div>
                            <div class="p-3.5 bg-white border-t border-gray-100 flex-1 flex items-center justify-between gap-3">
                                <h4 class="text-xs font-bold text-gray-800 line-clamp-2 uppercase flex-1"><?= htmlspecialchars($video['title']) ?></h4>
                                <a href="<?= BASEURL; ?>/admin/delete_video/<?= $video['id'] ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus video ini?')" class="w-8 h-8 rounded-lg bg-red-50 text-red-600 hover:bg-red-600 hover:text-white transition flex items-center justify-center flex-shrink-0" title="Hapus Video">
                                    <i class="fas fa-trash-alt text-xs"></i>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

</div>
