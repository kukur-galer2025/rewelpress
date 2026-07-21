<!-- Page Header -->
<div class="bg-unsoed-darkblue py-10 relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-r from-unsoed-darkblue to-unsoed-blue"></div>
    <div class="container mx-auto px-4 relative z-10">
        <h1 class="text-3xl font-serif font-bold text-white mb-2">Riwayat Pesanan</h1>
        <p class="text-gray-300 text-sm">Pantau status pesanan dan pembelian buku Anda.</p>
    </div>
</div>

<section class="py-12 bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 max-w-5xl">
        
        <?php if(isset($_GET['msg']) && $_GET['msg'] == 'success_upload'): ?>
            <div class="bg-green-50 border border-green-200 p-4 mb-8 rounded-xl flex items-center gap-3">
                <i class="fas fa-check-circle text-green-500 text-xl"></i>
                <p class="text-sm text-green-700 font-medium">Bukti pembayaran berhasil diunggah! Pesanan Anda sedang diproses oleh Admin.</p>
            </div>
        <?php endif; ?>

        <?php if(empty($data['orders'])): ?>
            <div class="glass rounded-3xl p-12 text-center shadow-sm border border-gray-200">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-box-open text-4xl text-gray-400"></i>
                </div>
                <h2 class="text-xl font-bold text-gray-800 mb-2">Belum ada pesanan</h2>
                <p class="text-gray-500 mb-6">Anda belum pernah melakukan pemesanan buku.</p>
                <a href="<?= BASEURL; ?>" class="btn-primary inline-block">Mulai Belanja</a>
            </div>
        <?php else: ?>
            <div class="space-y-6">
                <?php foreach($data['orders'] as $order): ?>
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center border-b border-gray-100 pb-4 mb-4 gap-4">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Pesanan <span class="font-bold text-gray-800">#<?= $order['id'] ?></span></p>
                            <p class="text-xs text-gray-400"><?= date('d M Y, H:i', strtotime($order['created_at'])) ?></p>
                        </div>
                        
                        <div>
                            <?php if($order['status'] == 'pending'): ?>
                                <span class="px-3 py-1 bg-yellow-50 text-yellow-600 border border-yellow-200 rounded-full text-xs font-bold uppercase tracking-wider">Menunggu Pembayaran</span>
                            <?php elseif($order['status'] == 'paid'): ?>
                                <span class="px-3 py-1 bg-blue-50 text-blue-600 border border-blue-200 rounded-full text-xs font-bold uppercase tracking-wider">Menunggu Konfirmasi</span>
                            <?php elseif($order['status'] == 'confirmed'): ?>
                                <span class="px-3 py-1 bg-green-50 text-green-600 border border-green-200 rounded-full text-xs font-bold uppercase tracking-wider">Selesai / Diproses</span>
                            <?php elseif($order['status'] == 'rejected'): ?>
                                <span class="px-3 py-1 bg-red-50 text-red-600 border border-red-200 rounded-full text-xs font-bold uppercase tracking-wider">Ditolak</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="flex justify-between items-center mt-6">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Total Belanja</p>
                            <p class="text-lg font-bold text-unsoed-blue">Rp <?= number_format($order['total_amount'], 0, ',', '.') ?></p>
                        </div>
                        
                        <?php if($order['status'] == 'pending'): ?>
                            <a href="<?= BASEURL; ?>/order/pay/<?= $order['id'] ?>" class="bg-unsoed-yellow text-white px-5 py-2 rounded-lg font-bold shadow-md hover:bg-yellow-500 transition text-sm">
                                <i class="fas fa-credit-card mr-1"></i> Bayar Sekarang
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>
</section>
