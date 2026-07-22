<div class="mb-8 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Kelola Voucher & Promo</h1>
        <p class="text-gray-500 mt-1 text-sm">Buat kode diskon, atur kuota, dan pantau pemakaian promo oleh pembeli.</p>
    </div>
    <a href="<?= BASEURL; ?>/admin/create_voucher" class="bg-unsoed-blue hover:bg-blue-800 text-white px-5 py-2.5 rounded-xl font-bold text-sm shadow-md transition flex items-center gap-2">
        <i class="fas fa-plus"></i> Buat Voucher Baru
    </a>
</div>

<!-- Flash Messages -->
<?php if(isset($_GET['msg'])): ?>
    <?php
    $m = $_GET['msg'];
    $msgs = [
        'success_create' => ['bg-green-50 border-green-300 text-green-800', 'Voucher baru berhasil dibuat!'],
        'success_update' => ['bg-green-50 border-green-300 text-green-800', 'Voucher berhasil diperbarui!'],
        'success_delete' => ['bg-green-50 border-green-300 text-green-800', 'Voucher berhasil dihapus!'],
        'error'          => ['bg-red-50 border-red-300 text-red-800',       'Terjadi kesalahan saat menyimpan data.'],
    ];
    if(isset($msgs[$m])): [$cls, $text] = $msgs[$m]; ?>
    <div class="mb-6 border p-4 rounded-2xl flex items-center gap-3 <?= $cls ?>">
        <i class="fas fa-check-circle text-lg"></i>
        <span class="text-sm font-bold"><?= $text ?></span>
    </div>
    <?php endif; ?>
<?php endif; ?>

<div class="bg-white rounded-3xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200 text-[11px] font-extrabold uppercase tracking-wider text-gray-500">
                    <th class="py-4 px-6">Kode & Judul</th>
                    <th class="py-4 px-6">Diskon</th>
                    <th class="py-4 px-6">Berlaku Untuk</th>
                    <th class="py-4 px-6">Min. Belanja</th>
                    <th class="py-4 px-6">Kuota & Terpakai</th>
                    <th class="py-4 px-6">Masa Berlaku</th>
                    <th class="py-4 px-6">Status</th>
                    <th class="py-4 px-6 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                <?php if(empty($data['vouchers'])): ?>
                    <tr>
                        <td colspan="8" class="py-12 text-center text-gray-400">Belum ada data voucher. Klik tombol Buat Voucher Baru di atas.</td>
                    </tr>
                <?php else: foreach($data['vouchers'] as $v): ?>
                <tr class="hover:bg-gray-50/80 transition">
                    <td class="py-4 px-6">
                        <span class="font-mono font-extrabold text-unsoed-blue bg-blue-50 px-2.5 py-1 rounded-lg text-xs block w-fit mb-1 border border-blue-100">
                            <?= htmlspecialchars($v['code']) ?>
                        </span>
                        <p class="font-bold text-gray-800 text-sm"><?= htmlspecialchars($v['title']) ?></p>
                        <?php if(!empty($v['description'])): ?>
                            <p class="text-xs text-gray-400 line-clamp-1 mt-0.5"><?= htmlspecialchars($v['description']) ?></p>
                        <?php endif; ?>
                    </td>

                    <td class="py-4 px-6 font-bold text-gray-800">
                        <?php if($v['discount_type'] === 'percent'): ?>
                            <span class="text-green-600 font-extrabold"><?= floatval($v['discount_value']) ?>%</span>
                            <?php if(!empty($v['max_discount']) && $v['max_discount'] > 0): ?>
                                <span class="text-[10px] text-gray-400 block font-normal">Maks. Rp <?= number_format($v['max_discount'], 0, ',', '.') ?></span>
                            <?php endif; ?>
                        <?php else: ?>
                            <span class="text-unsoed-blue font-extrabold">Rp <?= number_format($v['discount_value'], 0, ',', '.') ?></span>
                        <?php endif; ?>
                    </td>

                    <td class="py-4 px-6">
                        <?php if($v['applicable_to'] === 'ebook'): ?>
                            <span class="bg-red-50 text-red-600 text-[10px] font-extrabold px-2.5 py-1 rounded-full uppercase border border-red-100">E-Book</span>
                        <?php elseif($v['applicable_to'] === 'book'): ?>
                            <span class="bg-amber-50 text-amber-700 text-[10px] font-extrabold px-2.5 py-1 rounded-full uppercase border border-amber-100">Buku Fisik</span>
                        <?php else: ?>
                            <span class="bg-blue-50 text-unsoed-blue text-[10px] font-extrabold px-2.5 py-1 rounded-full uppercase border border-blue-100">Semua Produk</span>
                        <?php endif; ?>
                    </td>

                    <td class="py-4 px-6 font-medium text-gray-600">
                        <?= $v['min_purchase'] > 0 ? 'Rp ' . number_format($v['min_purchase'], 0, ',', '.') : '-' ?>
                    </td>

                    <td class="py-4 px-6">
                        <div class="flex items-center gap-2">
                            <span class="font-bold text-gray-800"><?= number_format($v['used_count']) ?></span>
                            <span class="text-gray-400 text-xs">/ <?= $v['quota'] > 0 ? number_format($v['quota']) : '∞' ?></span>
                        </div>
                        <?php if($v['quota'] > 0): ?>
                            <?php $pct = min(100, round(($v['used_count'] / $v['quota']) * 100)); ?>
                            <div class="w-20 bg-gray-200 h-1.5 rounded-full mt-1 overflow-hidden">
                                <div class="bg-unsoed-blue h-full" style="width: <?= $pct ?>%;"></div>
                            </div>
                        <?php endif; ?>
                    </td>

                    <td class="py-4 px-6 text-xs text-gray-500">
                        <?php if(!empty($v['start_date'])): ?>
                            <div><strong>Mulai:</strong> <?= date('d/m/y H:i', strtotime($v['start_date'])) ?></div>
                        <?php endif; ?>
                        <?php if(!empty($v['end_date'])): ?>
                            <div><strong>Akhir:</strong> <?= date('d/m/y H:i', strtotime($v['end_date'])) ?></div>
                        <?php else: ?>
                            <span class="text-gray-400 italic">Tanpa batas waktu</span>
                        <?php endif; ?>
                    </td>

                    <td class="py-4 px-6">
                        <?php if($v['is_active'] == 1): ?>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-green-50 text-green-700 border border-green-200 rounded-full text-xs font-bold">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Aktif
                            </span>
                        <?php else: ?>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-gray-100 text-gray-500 border border-gray-200 rounded-full text-xs font-bold">
                                <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span> Nonaktif
                            </span>
                        <?php endif; ?>
                    </td>

                    <td class="py-4 px-6 text-right space-x-2 whitespace-nowrap">
                        <a href="<?= BASEURL; ?>/admin/edit_voucher/<?= $v['id'] ?>" class="p-2 bg-blue-50 text-unsoed-blue hover:bg-blue-100 rounded-xl transition inline-block font-semibold text-xs">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="<?= BASEURL; ?>/admin/delete_voucher/<?= $v['id'] ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus voucher ini?')" class="p-2 bg-red-50 text-red-600 hover:bg-red-100 rounded-xl transition inline-block font-semibold text-xs">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; endif; ?>
            </tbody>
        </table>
    </div>
</div>
