<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Kelola Gallery</h1>
        <p class="text-gray-500 mt-1">Atur album, foto dokumentasi, dan video promosi web Unsoed Press.</p>
    </div>
    
    <!-- Tab navigation -->
    <div class="flex items-center gap-2 bg-gray-100 p-1.5 rounded-2xl border border-gray-200 self-start md:self-auto">
        <a href="<?= BASEURL; ?>/admin/gallery" class="px-5 py-2.5 rounded-xl text-sm font-bold bg-white text-unsoed-blue shadow-sm flex items-center gap-2">
            <i class="fas fa-camera"></i> Foto & Album
        </a>
        <a href="<?= BASEURL; ?>/admin/gallery_videos" class="px-5 py-2.5 rounded-xl text-sm font-bold text-gray-600 hover:text-gray-900 transition flex items-center gap-2">
            <i class="fas fa-video"></i> Video YouTube
        </a>
    </div>
</div>

<?php if(isset($_GET['msg'])): ?>
    <div class="mb-6">
        <?php if($_GET['msg'] == 'success_add_album'): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline font-bold"><i class="fas fa-check-circle mr-2"></i>Album baru berhasil ditambahkan!</span>
            </div>
        <?php elseif($_GET['msg'] == 'success_add_photo'): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline font-bold"><i class="fas fa-check-circle mr-2"></i>Foto berhasil diunggah ke dalam album!</span>
            </div>
        <?php elseif($_GET['msg'] == 'success_delete_album'): ?>
            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline font-bold"><i class="fas fa-trash-alt mr-2"></i>Album dan seluruh fotonya berhasil dihapus!</span>
            </div>
        <?php elseif($_GET['msg'] == 'success_delete_photo'): ?>
            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline font-bold"><i class="fas fa-trash-alt mr-2"></i>Foto berhasil dihapus!</span>
            </div>
        <?php elseif($_GET['msg'] == 'error'): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline font-bold"><i class="fas fa-exclamation-triangle mr-2"></i>Terjadi kesalahan saat memproses data.</span>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>

<div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
    
    <!-- Kolom Kiri: Kelola Album -->
    <div class="lg:col-span-1 space-y-6">
        <!-- Form Tambah Album -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
            <h3 class="font-bold text-gray-800 text-lg mb-4 flex items-center gap-2">
                <i class="fas fa-folder-plus text-unsoed-yellow"></i> Buat Album Baru
            </h3>
            <form action="<?= BASEURL; ?>/admin/create_album" method="POST" class="space-y-4">
<?= csrf_field() ?><div>
                    <label class="block text-xs font-bold text-gray-600 uppercase mb-1.5">Nama Album</label>
                    <input type="text" name="title" required class="w-full px-3.5 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-unsoed-blue outline-none" placeholder="Contoh: Bazar Buku 2026">
                </div>
                <button type="submit" class="w-full py-2.5 bg-unsoed-blue text-white rounded-xl font-bold text-sm hover:bg-unsoed-darkblue transition shadow-md flex items-center justify-center gap-2">
                    <i class="fas fa-plus"></i> Simpan Album
                </button>
            </form>
        </div>

        <!-- Daftar Album -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
            <h3 class="font-bold text-gray-800 text-lg mb-4 flex items-center justify-between">
                <span>Daftar Album</span>
                <span class="text-xs bg-blue-50 text-unsoed-blue font-bold px-2.5 py-1 rounded-full"><?= count($data['albums']) ?></span>
            </h3>
            <div class="space-y-2">
                <a href="<?= BASEURL; ?>/admin/gallery" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition <?= empty($data['current_album_id']) ? 'bg-unsoed-blue text-white font-bold' : 'bg-gray-50 text-gray-700 hover:bg-gray-100' ?>">
                    <span class="truncate text-sm">Semua Foto</span>
                    <span class="text-xs font-bold px-2 py-0.5 rounded-full <?= empty($data['current_album_id']) ? 'bg-white/20 text-white' : 'bg-gray-200 text-gray-700' ?>"><?= count($data['photos'] ?? []) ?></span>
                </a>
                <?php foreach($data['albums'] as $album): ?>
                    <?php $isActive = ($data['current_album_id'] == $album['id']); ?>
                    <div class="flex items-center justify-between gap-2 px-3.5 py-2.5 rounded-xl transition <?= $isActive ? 'bg-unsoed-blue text-white font-bold' : 'bg-gray-50 text-gray-700 hover:bg-gray-100' ?>">
                        <a href="<?= BASEURL; ?>/admin/gallery/<?= esc($album['id']) ?>" class="flex-1 truncate text-sm">
                            <?= htmlspecialchars($album['title']) ?>
                        </a>
                        <span class="text-xs font-bold px-2 py-0.5 rounded-full <?= $isActive ? 'bg-white/20 text-white' : 'bg-gray-200 text-gray-700' ?>"><?= esc($album['photo_count']) ?></span>
                        <a href="<?= BASEURL; ?>/admin/delete_album/<?= esc($album['id']) ?>" onclick="return confirmAction(this.href, 'Hapus Album', 'Apakah Anda yakin menghapus album ini? Semua foto di dalamnya akan ikut terhapus.')" class="text-red-400 hover:text-red-600 transition p-1" title="Hapus Album">
                            <i class="fas fa-trash-alt text-xs"></i>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Kolom Kanan: Daftar Foto & Form Upload -->
    <div class="lg:col-span-3 space-y-8">
        
        <!-- Form Upload Foto -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
            <h3 class="font-bold text-gray-800 text-lg mb-4 flex items-center gap-2">
                <i class="fas fa-cloud-upload-alt text-unsoed-blue"></i> Tambah Foto ke dalam Album
            </h3>
            <form action="<?= BASEURL; ?>/admin/create_photo" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
<?= csrf_field() ?><div>
                    <label class="block text-xs font-bold text-gray-600 uppercase mb-1.5">Pilih Album</label>
                    <select name="album_id" required class="w-full px-3.5 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-unsoed-blue outline-none bg-white">
                        <?php foreach($data['albums'] as $album): ?>
                            <option value="<?= esc($album['id']) ?>" <?= ($data['current_album_id'] == $album['id']) ? 'selected' : '' ?>><?= htmlspecialchars($album['title']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-600 uppercase mb-1.5">Judul / Keterangan Foto</label>
                    <input type="text" name="title" required class="w-full px-3.5 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-unsoed-blue outline-none" placeholder="Contoh: Suasana Pameran Hari ke-1">
                </div>
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-gray-600 uppercase mb-1.5">File Foto (Maks 3MB)</label>
                    <input type="file" name="photo" accept="image/*" class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-unsoed-blue hover:file:bg-blue-100 transition">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Atau Gunakan URL Gambar Eksternal:</label>
                    <input type="url" name="image_url" class="w-full px-3.5 py-2 border border-gray-300 rounded-xl text-xs focus:ring-2 focus:ring-unsoed-blue outline-none" placeholder="https://images.unsplash.com/...">
                </div>
                <div>
                    <button type="submit" class="w-full py-2.5 bg-green-600 text-white rounded-xl font-bold text-sm hover:bg-green-700 transition shadow-md flex items-center justify-center gap-2">
                        <i class="fas fa-upload"></i> Upload Foto
                    </button>
                </div>
            </form>
        </div>

        <!-- Grid Foto -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
            <h3 class="font-bold text-gray-800 text-lg mb-6 flex items-center justify-between">
                <span>Daftar Foto Dokumentasi</span>
                <span class="text-xs text-gray-400 font-normal">Total <?= count($data['photos']) ?> Foto</span>
            </h3>

            <?php if(empty($data['photos'])): ?>
                <div class="py-16 text-center text-gray-400">
                    <i class="fas fa-image text-4xl mb-3 block text-gray-300"></i>
                    Belum ada foto dalam album yang dipilih.
                </div>
            <?php else: ?>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                    <?php foreach($data['photos'] as $photo): ?>
                        <div class="bg-gray-50 rounded-2xl overflow-hidden border border-gray-200 group relative flex flex-col">
                            <div class="aspect-[4/3] w-full overflow-hidden relative">
                                <img src="<?= esc($photo['image_url']) ?>" alt="<?= htmlspecialchars($photo['title']) ?>" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2">
                                    <a href="<?= BASEURL; ?>/admin/delete_photo/<?= esc($photo['id']) ?>" onclick="return confirmAction(this.href, 'Hapus Foto', 'Apakah Anda yakin ingin menghapus foto ini?')" class="w-9 h-9 rounded-full bg-red-600 text-white flex items-center justify-center shadow-lg hover:scale-110 transition" title="Hapus Foto">
                                        <i class="fas fa-trash-alt text-xs"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="p-2.5 bg-white border-t border-gray-100 flex-1 flex flex-col justify-between">
                                <span class="text-[10px] font-bold text-unsoed-blue uppercase block truncate"><?= htmlspecialchars($photo['album_title']) ?></span>
                                <h4 class="text-xs font-bold text-gray-700 truncate"><?= htmlspecialchars($photo['title']) ?></h4>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

    </div>
</div>
<?= csrf_field() ?>
