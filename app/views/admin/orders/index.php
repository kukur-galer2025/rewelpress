<div class="mb-8 flex items-center justify-between">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Manajemen Pesanan</h1>
        <p class="text-gray-500 mt-1">Daftar semua transaksi yang dilakukan pelanggan.</p>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100 text-xs uppercase text-gray-500 font-bold tracking-wider">
                    <th class="p-4 pl-6">ID / Waktu</th>
                    <th class="p-4">Pelanggan</th>
                    <th class="p-4">Total Belanja</th>
                    <th class="p-4">Status</th>
                    <th class="p-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php foreach($data['orders'] as $order): ?>
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="p-4 pl-6">
                        <p class="font-bold text-gray-800">#<?= $order['id'] ?></p>
                        <p class="text-xs text-gray-500"><?= date('d M Y, H:i', strtotime($order['created_at'])) ?></p>
                    </td>
                    <td class="p-4 text-sm font-semibold text-gray-700">
                        <?= $order['user_name'] ?>
                    </td>
                    <td class="p-4 font-bold text-unsoed-blue">
                        Rp <?= number_format($order['total_amount'], 0, ',', '.') ?>
                    </td>
                    <td class="p-4">
                        <?php if($order['status'] == 'pending'): ?>
                            <span class="px-2 py-1 bg-yellow-50 text-yellow-600 rounded text-xs font-bold uppercase">Pending</span>
                        <?php elseif($order['status'] == 'paid'): ?>
                            <span class="px-2 py-1 bg-blue-50 text-blue-600 rounded text-xs font-bold uppercase animate-pulse">Menunggu Konfirmasi</span>
                        <?php elseif($order['status'] == 'confirmed'): ?>
                            <span class="px-2 py-1 bg-green-50 text-green-600 rounded text-xs font-bold uppercase">Selesai</span>
                        <?php elseif($order['status'] == 'rejected'): ?>
                            <span class="px-2 py-1 bg-red-50 text-red-600 rounded text-xs font-bold uppercase">Ditolak</span>
                        <?php endif; ?>
                    </td>
                    <td class="p-4 text-center">
                        <a href="<?= BASEURL; ?>/admin/order_detail/<?= $order['id'] ?>" class="inline-block px-4 py-2 bg-gray-100 text-gray-600 font-semibold text-xs rounded hover:bg-unsoed-yellow hover:text-white transition">
                            Lihat Detail
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
                
                <?php if(empty($data['orders'])): ?>
                <tr>
                    <td colspan="5" class="p-8 text-center text-gray-500">Belum ada pesanan masuk.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
