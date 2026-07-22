<div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Manajemen E-Book</h1>
        <p class="text-gray-500 mt-1">Kelola file digital (PDF/EPUB), sampel bab gratis, dan harga edisi e-book.</p>
    </div>
    <a href="<?= BASEURL; ?>/admin/create_ebook" class="btn-primary flex items-center justify-center gap-2 shadow-md w-full md:w-auto">
        <i class="fas fa-plus-circle"></i> Tambah E-Book Baru
    </a>
</div>

<?php if(isset($_GET['msg'])): ?>
    <div class="mb-6">
        <?php if($_GET['msg'] == 'success_add'): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-2xl shadow-sm font-bold flex items-center gap-2.5" role="alert">
                <i class="fas fa-check-circle text-lg"></i> E-Book baru berhasil ditambahkan dan siap diakses pengguna!
            </div>
        <?php elseif($_GET['msg'] == 'success_update'): ?>
            <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded-2xl shadow-sm font-bold flex items-center gap-2.5" role="alert">
                <i class="fas fa-info-circle text-lg"></i> Data E-Book berhasil diperbarui!
            </div>
        <?php elseif($_GET['msg'] == 'success_delete'): ?>
            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded-2xl shadow-sm font-bold flex items-center gap-2.5" role="alert">
                <i class="fas fa-trash-alt text-lg"></i> E-Book berhasil dihapus dari sistem!
            </div>
        <?php elseif($_GET['msg'] == 'error'): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-2xl shadow-sm font-bold flex items-center gap-2.5" role="alert">
                <i class="fas fa-exclamation-triangle text-lg"></i> Terjadi kesalahan saat memproses data e-book.
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>

<!-- Stats Banner Cepat -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-8">
    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-blue-50 text-unsoed-blue flex items-center justify-center text-xl font-bold">
            <i class="fas fa-tablet-alt"></i>
        </div>
        <div>
            <p class="text-xs font-semibold text-gray-400 uppercase">Total E-Book</p>
            <h4 class="text-xl font-extrabold text-gray-800"><?= count($data['ebooks']) ?> Judul</h4>
        </div>
    </div>
    <?php 
        $activeCount = 0;
        $totalDownloads = 0;
        foreach($data['ebooks'] as $e) {
            if($e['status'] == 'active') $activeCount++;
            $totalDownloads += $e['downloads_count'];
        }
    ?>
    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-green-50 text-green-600 flex items-center justify-center text-xl font-bold">
            <i class="fas fa-check-circle"></i>
        </div>
        <div>
            <p class="text-xs font-semibold text-gray-400 uppercase">E-Book Aktif</p>
            <h4 class="text-xl font-extrabold text-gray-800"><?= esc($activeCount) ?> Tersedia</h4>
        </div>
    </div>
    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-xl font-bold">
            <i class="fas fa-cloud-download-alt"></i>
        </div>
        <div>
            <p class="text-xs font-semibold text-gray-400 uppercase">Total Akses / Unduh</p>
            <h4 class="text-xl font-extrabold text-gray-800"><?= number_format($totalDownloads) ?> Kali</h4>
        </div>
    </div>
</div>

<div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-gray-50/50">
        <div class="flex items-center gap-2 font-bold text-gray-700">
            <i class="fas fa-file-pdf text-red-500"></i>
            <span>Daftar E-Book Terdaftar</span>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100 text-xs uppercase text-gray-500 font-bold tracking-wider">
                    <th class="p-4 pl-6">ID</th>
                    <th class="p-4">Buku & Judul E-Book</th>
                    <th class="p-4">Spesifikasi File</th>
                    <th class="p-4">Harga / Akses</th>
                    <th class="p-4">Status</th>
                    <th class="p-4">Unduhan</th>
                    <th class="p-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php if(empty($data['ebooks'])): ?>
                <tr>
                    <td colspan="7" class="p-12 text-center text-gray-400">
                        <i class="fas fa-book-reader text-4xl mb-3 block text-gray-200"></i>
                        Belum ada koleksi E-Book yang ditambahkan. Klik "Tambah E-Book Baru" di atas.
                    </td>
                </tr>
                <?php else: foreach($data['ebooks'] as $ebook): ?>
                <tr class="hover:bg-gray-50/80 transition-colors">
                    <td class="p-4 pl-6 font-bold text-gray-500 text-sm">
                        #<?= esc($ebook['id']) ?>
                    </td>
                    <td class="p-4">
                        <div class="flex items-center gap-3.5">
                            <div class="w-12 h-16 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0 border border-gray-200 shadow-sm">
                                <?php if(!empty($ebook['cover_image'])): ?>
                                    <?php
                                        $imgSrc = (strpos($ebook['cover_image'], 'http') === 0)
                                            ? $ebook['cover_image']
                                            : BASEURL . '/uploads/covers/' . $ebook['cover_image'];
                                    ?>
                                    <img src="<?= esc($imgSrc) ?>" class="w-full h-full object-cover">
                                <?php else: ?>
                                    <div class="w-full h-full bg-unsoed-darkblue text-white flex items-center justify-center text-xs font-bold p-1 text-center">PDF</div>
                                <?php endif; ?>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 text-sm line-clamp-1"><?= htmlspecialchars($ebook['title']) ?></h4>
                                <?php if(!empty($ebook['book_title']) && $ebook['book_title'] != $ebook['title']): ?>
                                    <p class="text-[11px] text-gray-500 line-clamp-1">Buku Fisik: <?= htmlspecialchars($ebook['book_title']) ?></p>
                                <?php endif; ?>
                                <p class="text-xs text-unsoed-blue font-medium mt-0.5">
                                    <i class="fas fa-user-edit text-[10px] mr-1"></i> <?= htmlspecialchars($ebook['book_author'] ?? 'Unsoed Press') ?>
                                </p>
                            </div>
                        </div>
                    </td>
                    <td class="p-4 text-xs space-y-1">
                        <div class="flex items-center gap-1.5 text-gray-700 font-semibold">
                            <i class="fas fa-file-pdf text-red-500"></i> <?= htmlspecialchars($ebook['file_size'] ?? '15 MB') ?>
                        </div>
                        <div class="text-gray-500">
                            <?= $ebook['page_count'] ?? 150 ?> Halaman
                        </div>
                        <?php if(!empty($ebook['file_pdf'])): ?>
                            <span class="inline-block text-[10px] bg-green-50 text-green-700 px-2 py-0.5 rounded border border-green-200 font-mono">
                                File: terunggah
                            </span>
                        <?php else: ?>
                            <span class="inline-block text-[10px] bg-yellow-50 text-yellow-700 px-2 py-0.5 rounded border border-yellow-200 font-mono">
                                File: belum ada
                            </span>
                        <?php endif; ?>
                    </td>
                    <td class="p-4">
                        <?php if($ebook['is_free'] == 1 || $ebook['ebook_price'] == 0): ?>
                            <span class="inline-flex items-center gap-1 px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-extrabold uppercase tracking-wider">
                                <i class="fas fa-gift"></i> GRATIS
                            </span>
                        <?php else: ?>
                            <span class="font-extrabold text-unsoed-blue text-sm block">
                                Rp <?= number_format($ebook['ebook_price'], 0, ',', '.') ?>
                            </span>
                            <?php if(!empty($ebook['normal_price']) && $ebook['normal_price'] > $ebook['ebook_price']): ?>
                                <span class="text-[10px] text-gray-400 line-through">
                                    Rp <?= number_format($ebook['normal_price'], 0, ',', '.') ?>
                                </span>
                            <?php endif; ?>
                        <?php endif; ?>
                    </td>
                    <td class="p-4">
                        <?php if($ebook['status'] == 'active'): ?>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-green-50 text-green-700 border border-green-200 rounded-full text-xs font-bold uppercase tracking-wider">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span> Aktif
                            </span>
                        <?php else: ?>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-gray-100 text-gray-600 border border-gray-200 rounded-full text-xs font-bold uppercase tracking-wider">
                                Nonaktif
                            </span>
                        <?php endif; ?>
                    </td>
                    <td class="p-4 text-sm font-extrabold text-gray-700">
                        <?= number_format($ebook['downloads_count']) ?> <span class="text-xs font-normal text-gray-400">kali</span>
                    </td>
                    <td class="p-4 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <a href="<?= BASEURL; ?>/admin/edit_ebook/<?= esc($ebook['id']) ?>" class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition flex items-center justify-center shadow-sm" title="Edit E-Book">
                                <i class="fas fa-edit text-sm"></i>
                            </a>
                            <a href="<?= BASEURL; ?>/admin/delete_ebook/<?= esc($ebook['id']) ?>" onclick="return confirmAction(this.href, 'Hapus E-Book', 'Apakah Anda yakin ingin menghapus E-Book <?= htmlspecialchars(addslashes($ebook['title'])) ?> ini secara permanen?')" class="w-9 h-9 rounded-xl bg-red-50 text-red-600 hover:bg-red-600 hover:text-white transition flex items-center justify-center shadow-sm" title="Hapus E-Book">
                                <i class="fas fa-trash-alt text-sm"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; endif; ?>
            </tbody>
        </table>
    </div>
</div>
