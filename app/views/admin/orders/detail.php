<div class="mb-8 flex items-center justify-between">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Detail Pesanan #<?= esc($data['order']['id']) ?></h1>
        <p class="text-gray-500 mt-1">Informasi pelanggan, item, dan bukti pembayaran.</p>
    </div>
    <div class="flex items-center gap-3">
        <a href="<?= BASEURL; ?>/admin/resend_invoice/<?= esc($data['order']['id']) ?>" class="bg-unsoed-yellow text-white px-4 py-2 rounded-lg font-bold shadow hover:bg-yellow-600 transition flex items-center gap-2 text-sm" onclick="return confirmAction(this.href, 'Kirim Invoice', 'Kirim ulang email invoice ke pelanggan ini?', 'info')">
            <i class="fas fa-envelope"></i> Kirim Invoice
        </a>
        <a href="<?= BASEURL; ?>/admin/orders" class="text-gray-500 hover:text-unsoed-blue transition font-semibold flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <div class="lg:col-span-2 space-y-8">
        <!-- Customer & Order Info -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-wrap gap-12">
            <div>
                <p class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-1">Pelanggan</p>
                <p class="font-bold text-gray-800"><?= esc($data['order']['user_name']) ?></p>
                <p class="text-sm text-gray-500"><?= esc($data['order']['email']) ?></p>
            </div>
            <div>
                <p class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-1">Tanggal Pesanan</p>
                <p class="font-bold text-gray-800"><?= date('d F Y', strtotime($data['order']['created_at'])) ?></p>
                <p class="text-sm text-gray-500"><?= date('H:i:s', strtotime($data['order']['created_at'])) ?></p>
            </div>
            <div>
                <p class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-1">Status</p>
                <?php if($data['order']['status'] == 'pending'): ?>
                    <span class="text-yellow-600 font-bold uppercase">Belum Bayar</span>
                <?php elseif($data['order']['status'] == 'paid'): ?>
                    <span class="text-blue-600 font-bold uppercase">Menunggu Konfirmasi</span>
                <?php elseif($data['order']['status'] == 'confirmed'): ?>
                    <span class="text-green-600 font-bold uppercase">Selesai Dikonfirmasi</span>
                <?php else: ?>
                    <span class="text-red-600 font-bold uppercase">Ditolak</span>
                <?php endif; ?>
            </div>
            <div>
                <p class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-1">Pengiriman</p>
                <?php if(isset($data['order']['delivery_method'])): ?>
                    <p class="font-bold text-gray-800 text-sm mb-1">
                        <?= $data['order']['delivery_method'] == 'shipping' ? '<i class="fas fa-truck text-unsoed-blue w-4"></i> Kurir (DFOD)' : '<i class="fas fa-store text-amber-500 w-4"></i> Ambil Sendiri' ?>
                    </p>
                    <?php if($data['order']['delivery_method'] == 'shipping' && !empty($data['order']['shipping_address'])): ?>
                        <p class="text-xs text-gray-600 max-w-[200px] leading-relaxed break-words"><?= nl2br(htmlspecialchars($data['order']['shipping_address'])) ?></p>
                    <?php endif; ?>
                <?php else: ?>
                    <p class="text-gray-500 text-sm">-</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Items -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <h3 class="font-bold text-gray-800 p-6 border-b border-gray-100 text-lg">Item yang Dipesan</h3>
            <table class="w-full text-left">
                <thead class="bg-gray-50 text-xs uppercase text-gray-500">
                    <tr>
                        <th class="p-4 pl-6">Buku</th>
                        <th class="p-4 text-center">Harga</th>
                        <th class="p-4 text-center">Qty</th>
                        <th class="p-4 text-right pr-6">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php foreach($data['order']['items'] as $item): ?>
                    <tr>
                        <td class="p-4 pl-6 flex items-center gap-4">
                            <?php $img_src = !empty($item['image']) ? $item['image'] : 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?auto=format&fit=crop&q=80&w=400'; ?>
                            <img src="<?= esc($img_src) ?>" class="w-10 h-14 object-cover rounded shadow-sm">
                            <span class="font-semibold text-gray-800 line-clamp-1"><?= esc($item['title']) ?></span>
                        </td>
                        <td class="p-4 text-center text-sm text-gray-600">Rp <?= number_format($item['price'], 0, ',', '.') ?></td>
                        <td class="p-4 text-center font-bold text-gray-800"><?= esc($item['quantity']) ?></td>
                        <td class="p-4 text-right pr-6 font-bold text-unsoed-blue">Rp <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="p-6 bg-gray-50 flex justify-between items-center border-t border-gray-100">
                <span class="font-bold text-gray-700 text-lg">Total Pembayaran</span>
                <span class="font-extrabold text-2xl text-unsoed-blue">Rp <?= number_format($data['order']['total_amount'], 0, ',', '.') ?></span>
            </div>
        </div>
    </div>

    <!-- Payment Proof & Action -->
    <div class="space-y-6">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="font-bold text-gray-800 mb-4 text-lg">Bukti Pembayaran</h3>
            
            <?php if(!empty($data['order']['payment_receipt'])): ?>
                <div class="border rounded-xl p-2 mb-6 bg-gray-50 text-center">
                    <img src="<?= esc($data['order']['payment_receipt']) ?>" alt="Bukti Transfer" class="max-w-full h-auto max-h-96 mx-auto rounded shadow-sm cursor-pointer" onclick="window.open(this.src)">
                    <p class="text-xs text-gray-400 mt-2">Klik gambar untuk memperbesar</p>
                </div>
                
                <?php if($data['order']['status'] == 'paid'): ?>
                    <div class="flex flex-col gap-3">
                        <a href="<?= BASEURL; ?>/admin/update_order/<?= esc($data['order']['id']) ?>/confirmed" class="bg-green-500 text-white text-center py-3 rounded-xl font-bold shadow-lg shadow-green-500/30 hover:bg-green-600 transition" onclick="return confirmAction(this.href, 'Konfirmasi Pesanan', 'Konfirmasi bahwa uang telah diterima dan pesanan valid?', 'warning')">
                            <i class="fas fa-check-circle mr-2"></i> Konfirmasi Pesanan
                        </a>
                        <a href="<?= BASEURL; ?>/admin/update_order/<?= esc($data['order']['id']) ?>/rejected" class="bg-red-50 text-red-500 border border-red-200 text-center py-3 rounded-xl font-bold hover:bg-red-500 hover:text-white transition" onclick="return confirmAction(this.href, 'Tolak Pesanan', 'Tolak pesanan ini karena bukti palsu/tidak valid?')">
                            <i class="fas fa-times-circle mr-2"></i> Tolak Bukti Bayar
                        </a>
                    </div>
                <?php else: ?>
                    <div class="bg-gray-100 text-center py-3 rounded-xl font-bold text-gray-500">
                        Aksi Tidak Tersedia (Status: <?= strtoupper($data['order']['status']) ?>)
                    </div>
                <?php endif; ?>

            <?php else: ?>
                <div class="w-full h-48 border-2 border-dashed border-gray-300 rounded-xl flex items-center justify-center flex-col text-gray-400">
                    <i class="fas fa-file-invoice-dollar text-4xl mb-2"></i>
                    <p class="text-sm">Pelanggan belum mengunggah resi.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
</div>
