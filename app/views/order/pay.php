<!-- Page Header -->
<div class="bg-unsoed-darkblue py-10 relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-r from-unsoed-darkblue to-unsoed-blue"></div>
    <div class="container mx-auto px-4 relative z-10">
        <h1 class="text-3xl font-serif font-bold text-white mb-2">Selesaikan Pembayaran Anda</h1>
        <p class="text-gray-300 text-sm">Pesanan #<?= $data['order']['id'] ?></p>
    </div>
</div>

<section class="py-12 bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 max-w-4xl">
        
        <div class="bg-white rounded-3xl p-8 shadow-xl border border-gray-100 mb-8">
            <div class="flex flex-col md:flex-row gap-12">
                <!-- Left: Info & QRIS -->
                <div class="w-full md:w-1/2 border-r border-gray-100 pr-0 md:pr-8">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Total Tagihan</h3>
                    <div class="bg-blue-50 text-unsoed-blue p-6 rounded-2xl mb-8 border border-blue-100">
                        <span class="text-sm font-semibold uppercase tracking-wider block mb-1">Bayar Sesuai Nominal:</span>
                        <span class="text-4xl font-extrabold">Rp <?= number_format($data['order']['total_amount'], 0, ',', '.') ?></span>
                    </div>

                    <h3 class="text-lg font-bold text-gray-800 mb-4">Metode Pembayaran</h3>
                    <div class="space-y-6">
                        <!-- QRIS -->
                        <div class="border rounded-2xl p-4">
                            <div class="flex items-center gap-3 font-bold text-gray-800 mb-4">
                                <i class="fas fa-qrcode text-unsoed-yellow text-xl"></i> QRIS
                            </div>
                            <?php if(!empty($data['settings']['qris_image'])): ?>
                                <img src="<?= $data['settings']['qris_image'] ?>" alt="QRIS" class="w-full max-w-[200px] mx-auto rounded-xl shadow-sm">
                            <?php else: ?>
                                <p class="text-sm text-gray-500 text-center">QRIS belum tersedia.</p>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Transfer Bank -->
                        <div class="border rounded-2xl p-4">
                            <div class="flex items-center gap-3 font-bold text-gray-800 mb-2">
                                <i class="fas fa-university text-unsoed-yellow text-xl"></i> Transfer Bank
                            </div>
                            <p class="text-sm text-gray-600 whitespace-pre-line leading-relaxed"><?= !empty($data['settings']['bank_accounts']) ? $data['settings']['bank_accounts'] : 'Belum ada rekening.' ?></p>
                        </div>
                    </div>
                </div>

                <!-- Right: Upload Form -->
                <div class="w-full md:w-1/2 pt-4 md:pt-0">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Konfirmasi Pembayaran</h3>
                    <p class="text-sm text-gray-500 mb-6">Setelah Anda melakukan transfer, unggah bukti pembayaran Anda di sini agar Admin dapat memproses pesanan Anda.</p>

                    <form action="<?= BASEURL; ?>/order/pay/<?= $data['order']['id'] ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
                        <div>
                            <div class="border-2 border-dashed border-gray-300 rounded-2xl p-8 text-center hover:bg-gray-50 transition cursor-pointer relative" onclick="document.getElementById('receipt').click()">
                                <i class="fas fa-file-invoice-dollar text-5xl text-gray-400 mb-4"></i>
                                <p class="text-base text-gray-600 font-semibold mb-1">Pilih File Bukti Bayar</p>
                                <p class="text-xs text-gray-400">JPG, PNG, JPEG (Maks 2MB)</p>
                                <input type="file" name="receipt" id="receipt" class="hidden" accept="image/*" required>
                            </div>
                        </div>

                        <button type="submit" class="btn-primary w-full shadow-xl">
                            <i class="fas fa-upload mr-2"></i> Unggah Bukti Bayar
                        </button>
                    </form>
                    
                    <?php if($data['order']['status'] != 'pending'): ?>
                        <div class="mt-6 bg-yellow-50 p-4 rounded-xl border border-yellow-200 text-sm text-yellow-700">
                            <strong>Status:</strong> Anda sudah mengunggah bukti bayar. Menunggu konfirmasi admin.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>
</section>
