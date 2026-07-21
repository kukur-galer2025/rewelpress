<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Kelola Buku</h1>
        <p class="text-gray-500 mt-1">Daftar semua buku yang tersedia di katalog.</p>
    </div>
    <a href="<?= BASEURL; ?>/admin/create_book" class="bg-unsoed-blue text-white px-5 py-2.5 rounded-lg font-semibold hover:bg-unsoed-darkblue transition shadow-lg flex items-center gap-2">
        <i class="fas fa-plus"></i> Tambah Buku
    </a>
</div>

<?php if(isset($_GET['msg'])): ?>
    <?php if($_GET['msg'] == 'success_add'): ?>
        <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-r-lg">
            <p class="text-sm text-green-700 font-medium">Buku berhasil ditambahkan!</p>
        </div>
    <?php elseif($_GET['msg'] == 'success_edit'): ?>
        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6 rounded-r-lg">
            <p class="text-sm text-blue-700 font-medium">Data buku berhasil diperbarui!</p>
        </div>
    <?php elseif($_GET['msg'] == 'success_delete'): ?>
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r-lg">
            <p class="text-sm text-red-700 font-medium">Buku berhasil dihapus!</p>
        </div>
    <?php endif; ?>
<?php endif; ?>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100 text-xs uppercase text-gray-500 font-bold tracking-wider">
                    <th class="p-4 pl-6">Info Buku</th>
                    <th class="p-4">Kategori</th>
                    <th class="p-4">Harga</th>
                    <th class="p-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php foreach($data['books'] as $buku): ?>
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="p-4 pl-6 flex items-center gap-4">
                        <?php $img_src = !empty($buku['image']) ? $buku['image'] : 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?auto=format&fit=crop&q=80&w=400'; ?>
                        <img src="<?= $img_src ?>" alt="<?= $buku['title'] ?>" class="w-12 h-16 object-cover rounded shadow-sm">
                        <div>
                            <p class="font-bold text-gray-800 line-clamp-1"><?= $buku['title'] ?></p>
                            <p class="text-sm text-gray-500"><?= $buku['author'] ?></p>
                        </div>
                    </td>
                    <td class="p-4">
                        <span class="px-3 py-1.5 bg-blue-50 text-unsoed-blue text-xs font-bold rounded-full border border-blue-100/50 inline-block">
                            <?= !empty($buku['parent_category_name']) ? $buku['parent_category_name'] . ' <i class="fas fa-chevron-right text-[10px] mx-1 opacity-50"></i> ' : '' ?>
                            <?= $buku['category_name'] ?>
                        </span>
                    </td>
                    <td class="p-4">
                        <p class="font-bold text-gray-800">Rp <?= number_format($buku['price'], 0, ',', '.') ?></p>
                        <?php if($buku['old_price'] > 0): ?>
                            <p class="text-xs text-red-400 line-through">Rp <?= number_format($buku['old_price'], 0, ',', '.') ?></p>
                        <?php endif; ?>
                    </td>
                    <td class="p-4 text-center">
                        <div class="flex justify-center gap-2">
                            <a href="<?= BASEURL; ?>/admin/edit_book/<?= $buku['id'] ?>" class="w-8 h-8 rounded bg-gray-100 hover:bg-unsoed-yellow hover:text-white flex items-center justify-center text-gray-500 transition" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="<?= BASEURL; ?>/admin/delete_book/<?= $buku['id'] ?>" class="w-8 h-8 rounded bg-gray-100 hover:bg-red-500 hover:text-white flex items-center justify-center text-gray-500 transition" onclick="return confirm('Yakin ingin menghapus buku ini?')" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                
                <?php if(empty($data['books'])): ?>
                <tr>
                    <td colspan="4" class="p-8 text-center text-gray-500">Belum ada data buku.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <div class="p-4 border-t border-gray-100 flex items-center justify-between text-sm text-gray-500">
        <p>Menampilkan <?= count($data['books']) ?> buku</p>
    </div>
</div>
