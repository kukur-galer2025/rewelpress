<div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Berita & Agenda</h1>
        <p class="text-gray-500 mt-1">Kelola publikasi berita, artikel, dan agenda kegiatan</p>
    </div>
    <a href="<?= BASEURL; ?>/admin/create_news" class="bg-unsoed-yellow text-white px-5 py-2.5 rounded-lg font-semibold hover:bg-yellow-500 transition shadow-lg shadow-yellow-500/30 flex items-center gap-2">
        <i class="fas fa-plus"></i> Tulis Berita
    </a>
</div>

<?php if(isset($_GET['msg'])): ?>
    <?php if($_GET['msg'] == 'success_add'): ?>
        <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-r-lg">
            <p class="text-sm text-green-700 font-medium">Berita berhasil ditambahkan!</p>
        </div>
    <?php elseif($_GET['msg'] == 'success_edit'): ?>
        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6 rounded-r-lg">
            <p class="text-sm text-blue-700 font-medium">Berita berhasil diperbarui!</p>
        </div>
    <?php elseif($_GET['msg'] == 'success_delete'): ?>
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r-lg">
            <p class="text-sm text-red-700 font-medium">Berita berhasil dihapus!</p>
        </div>
    <?php endif; ?>
<?php endif; ?>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50/50 border-b border-gray-100">
                    <th class="py-4 px-6 font-semibold text-gray-600 text-sm">Berita</th>
                    <th class="py-4 px-6 font-semibold text-gray-600 text-sm">Tanggal Dibuat</th>
                    <th class="py-4 px-6 font-semibold text-gray-600 text-sm text-center">Dilihat</th>
                    <th class="py-4 px-6 font-semibold text-gray-600 text-sm text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php if(empty($data['news'])): ?>
                <tr>
                    <td colspan="4" class="py-8 text-center text-gray-400">Belum ada berita yang diterbitkan.</td>
                </tr>
                <?php else: ?>
                    <?php foreach ($data['news'] as $news): ?>
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-4">
                                <div class="w-16 h-16 rounded-lg bg-gray-200 overflow-hidden flex-shrink-0">
                                    <?php 
                                        $admin_images = [];
                                        if(!empty($news['image'])) {
                                            $decoded = json_decode($news['image'], true);
                                            $admin_images = is_array($decoded) ? $decoded : (is_string($news['image']) && filter_var($news['image'], FILTER_VALIDATE_URL) ? [$news['image']] : []);
                                        }
                                    ?>
                                    <?php if(!empty($admin_images)): ?>
                                        <img src="<?= $admin_images[0] ?>" alt="Cover" class="w-full h-full object-cover">
                                    <?php else: ?>
                                        <div class="w-full h-full flex items-center justify-center text-gray-400"><i class="fas fa-image"></i></div>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-800 text-sm mb-1 leading-snug line-clamp-2"><?= $news['title'] ?></h3>
                                    <p class="text-xs text-gray-500 line-clamp-1"><?= strip_tags(substr($news['content'], 0, 80)) ?>...</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-6 text-sm text-gray-600">
                            <?= date('d M Y', strtotime($news['created_at'])) ?>
                        </td>
                        <td class="py-4 px-6 text-sm text-gray-600 text-center">
                            <span class="bg-blue-50 text-blue-600 px-2.5 py-1 rounded-full text-xs font-semibold">
                                <?= $news['views'] ?> x
                            </span>
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex justify-end gap-2">
                                <a href="<?= BASEURL; ?>/admin/edit_news/<?= $news['id'] ?>" class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center hover:bg-indigo-600 hover:text-white transition">
                                    <i class="fas fa-edit text-sm"></i>
                                </a>
                                <form action="<?= BASEURL; ?>/admin/delete_news/<?= $news['id'] ?>" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?');" class="inline">
                                    <button type="submit" class="w-8 h-8 rounded-lg bg-red-50 text-red-600 flex items-center justify-center hover:bg-red-600 hover:text-white transition">
                                        <i class="fas fa-trash text-sm"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
