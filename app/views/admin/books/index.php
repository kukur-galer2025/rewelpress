<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Kelola Buku</h1>
        <p class="text-gray-500 mt-1">Daftar semua buku yang tersedia di katalog.</p>
    </div>
    <div class="flex items-center gap-3">
        <a href="<?= BASEURL; ?>/book/promo" target="_blank" class="bg-red-50 text-red-600 border border-red-200 px-4 py-2.5 rounded-lg font-semibold hover:bg-red-500 hover:text-white transition flex items-center gap-2">
            <i class="fas fa-bolt"></i> Cek Super Sale
        </a>
        <a href="<?= BASEURL; ?>/admin/create_book" class="bg-unsoed-blue text-white px-5 py-2.5 rounded-lg font-semibold hover:bg-unsoed-darkblue transition shadow-lg flex items-center gap-2">
            <i class="fas fa-plus"></i> Tambah Buku
        </a>
    </div>
</div>



<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100 text-xs uppercase text-gray-500 font-bold tracking-wider">
                    <th class="p-4 pl-6">Info Buku</th>
                    <th class="p-4">Kategori</th>
                    <th class="p-4 text-center">Stok</th>
                    <th class="p-4">Harga</th>
                    <th class="p-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php foreach($data['books'] as $buku): ?>
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="p-4 pl-6 flex items-center gap-4">
                        <?php $img_src = !empty($buku['image']) ? $buku['image'] : 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?auto=format&fit=crop&q=80&w=400'; ?>
                        <img src="<?= esc($img_src) ?>" alt="<?= esc($buku['title']) ?>" class="w-12 h-16 object-cover rounded shadow-sm">
                        <div>
                            <p class="font-bold text-gray-800 line-clamp-1"><?= esc($buku['title']) ?></p>
                            <p class="text-sm text-gray-500"><?= esc($buku['author']) ?></p>
                            <?php if(isset($buku['avg_rating'])): ?>
                            <p class="text-[11px] font-bold text-amber-500 mt-1 flex items-center gap-1">
                                <i class="fas fa-star"></i> <?= $buku['avg_rating'] ?> (<?= $buku['review_count'] ?> ulasan)
                            </p>
                            <?php endif; ?>
                        </div>
                    </td>
                    <td class="p-4">
                        <span class="px-3 py-1.5 bg-blue-50 text-unsoed-blue text-xs font-bold rounded-full border border-blue-100/50 inline-block">
                            <?= !empty($buku['parent_category_name']) ? $buku['parent_category_name'] . ' <i class="fas fa-chevron-right text-[10px] mx-1 opacity-50"></i> ' : '' ?>
                            <?= esc($buku['category_name']) ?>
                        </span>
                    </td>
                    <td class="p-4 text-center">
                        <?php $stok = isset($buku['stock']) ? (int)$buku['stock'] : 0; ?>
                        <?php if($stok <= 0): ?>
                            <span class="px-3 py-1 bg-red-100 text-red-700 text-xs font-extrabold rounded-full border border-red-200 inline-flex items-center gap-1 shadow-sm">
                                <i class="fas fa-exclamation-circle"></i> Habis (0)
                            </span>
                        <?php elseif($stok <= 5): ?>
                            <span class="px-3 py-1 bg-amber-100 text-amber-800 text-xs font-extrabold rounded-full border border-amber-200 inline-flex items-center gap-1 shadow-sm animate-pulse">
                                <i class="fas fa-exclamation-triangle"></i> Sisa <?= $stok ?>
                            </span>
                        <?php else: ?>
                            <span class="px-3 py-1 bg-emerald-100 text-emerald-800 text-xs font-extrabold rounded-full border border-emerald-200 inline-flex items-center gap-1 shadow-sm">
                                <i class="fas fa-boxes"></i> <?= $stok ?> pcs
                            </span>
                        <?php endif; ?>
                    </td>
                    <td class="p-4">
                        <p class="font-bold text-gray-800">Rp <?= number_format($buku['price'], 0, ',', '.') ?></p>
                        <?php if($buku['old_price'] > $buku['price']): ?>
                            <?php $disc = round((($buku['old_price'] - $buku['price']) / $buku['old_price']) * 100); ?>
                            <div class="flex items-center gap-1.5 mt-1">
                                <span class="text-xs text-gray-400 line-through">Rp <?= number_format($buku['old_price'], 0, ',', '.') ?></span>
                                <span class="bg-red-500 text-white text-[10px] font-black px-1.5 py-0.5 rounded uppercase tracking-wide">🔥 -<?= esc($disc) ?>% PROMO</span>
                            </div>
                        <?php endif; ?>
                    </td>
                    <td class="p-4 text-center">
                        <div class="flex justify-center gap-2">
                            <a href="<?= BASEURL; ?>/admin/edit_book/<?= esc($buku['id']) ?>" class="w-8 h-8 rounded bg-gray-100 hover:bg-unsoed-yellow hover:text-white flex items-center justify-center text-gray-500 transition" title="Edit Stok & Info">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="<?= BASEURL; ?>/admin/delete_book/<?= esc($buku['id']) ?>" class="w-8 h-8 rounded bg-gray-100 hover:bg-red-500 hover:text-white flex items-center justify-center text-gray-500 transition" onclick="return confirmAction(this.href, 'Hapus Buku', 'Yakin ingin menghapus buku ini? Data tidak dapat dikembalikan.')" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                
                <?php if(empty($data['books'])): ?>
                <tr>
                    <td colspan="5" class="p-8 text-center text-gray-500">Belum ada data buku.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <div class="p-4 border-t border-gray-100 flex items-center justify-between text-sm text-gray-500">
        <p>Menampilkan <?= count($data['books']) ?> buku</p>
    </div>
</div>
