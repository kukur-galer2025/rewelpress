<!-- Page Header -->
<div class="bg-unsoed-darkblue py-10 relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-r from-unsoed-darkblue to-unsoed-blue"></div>
    <div class="container mx-auto px-4 relative z-10">
        <div class="flex items-center gap-3 mb-2">
            <h1 class="text-3xl font-serif font-bold text-white">Selesaikan Pembayaran Anda</h1>
            <span class="bg-teal-500/80 backdrop-blur border border-teal-400 text-white text-[10px] font-bold px-2.5 py-1 rounded-md uppercase tracking-widest shadow-sm"><i class="fas fa-book mr-1"></i> Beli Buku Fisik</span>
        </div>
        <p class="text-gray-300 text-sm">Pesanan #<?= esc($data['order']['id']) ?></p>
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

                    <?php if (isset($data['order']['delivery_method'])): ?>
                    <h3 class="text-lg font-bold text-gray-800 mb-3">Informasi Pengiriman</h3>
                    <div class="bg-gray-50 border border-gray-200 p-5 rounded-2xl mb-8">
                        <div class="mb-3">
                            <span class="text-xs font-bold text-gray-500 uppercase block mb-1">Metode Penerimaan</span>
                            <span class="font-semibold text-gray-800 text-sm">
                                <?= $data['order']['delivery_method'] == 'shipping' ? '<i class="fas fa-truck text-unsoed-blue mr-2"></i> Kirim via Kurir (Ongkir DFOD)' : '<i class="fas fa-store text-amber-500 mr-2"></i> Ambil di Kantor Unsoed Press' ?>
                            </span>
                        </div>
                        <?php if ($data['order']['delivery_method'] == 'shipping' && !empty($data['order']['shipping_address'])): ?>
                        <div class="pt-3 border-t border-gray-200 mt-2">
                            <span class="text-xs font-bold text-gray-500 uppercase block mb-1">Alamat Tujuan</span>
                            <p class="text-sm text-gray-700 leading-relaxed"><?= nl2br(htmlspecialchars($data['order']['shipping_address'])) ?></p>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>

                    <h3 class="text-lg font-bold text-gray-800 mb-4">Metode Pembayaran</h3>
                    <div class="space-y-6">
                        <!-- QRIS -->
                        <div class="border rounded-2xl p-4">
                            <div class="flex items-center gap-3 font-bold text-gray-800 mb-4">
                                <i class="fas fa-qrcode text-unsoed-yellow text-xl"></i> QRIS
                            </div>
                            <?php if(!empty($data['settings']['qris_image'])): ?>
                                <img src="<?= esc($data['settings']['qris_image']) ?>" alt="QRIS" class="w-full max-w-[200px] mx-auto rounded-xl shadow-sm">
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

                    <form action="<?= BASEURL; ?>/order/pay/<?= esc($data['order']['id']) ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
<?= csrf_field() ?><?php if(isset($data['error'])): ?>
                            <div class="bg-red-50 p-3 rounded-lg border border-red-200 text-sm text-red-600 mb-4">
                                <i class="fas fa-exclamation-circle mr-1"></i> <?= esc($data['error']) ?>
                            </div>
                        <?php endif; ?>

                        <div>
                            <div id="dropzone" class="border-2 border-dashed border-gray-300 rounded-2xl p-8 text-center hover:bg-gray-50 transition cursor-pointer relative overflow-hidden h-64 flex flex-col items-center justify-center" onclick="document.getElementById('receipt').click()">
                                <div id="upload_placeholder">
                                    <i class="fas fa-file-invoice-dollar text-5xl text-gray-400 mb-4"></i>
                                    <p class="text-base text-gray-600 font-semibold mb-1">Pilih File Bukti Bayar</p>
                                    <p class="text-xs text-gray-400">JPG, PNG, JPEG (Maks 5MB)</p>
                                </div>
                                <img id="preview" src="" class="hidden absolute inset-0 w-full h-full object-contain p-2" alt="Preview">
                                <input type="file" name="receipt" id="receipt" class="hidden" accept="image/jpeg, image/png, image/jpg" required>
                            </div>
                            <p id="error_msg" class="text-red-500 text-sm mt-2 hidden text-center font-medium"></p>
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

<script>
    const fileInput = document.getElementById('receipt');
    const preview = document.getElementById('preview');
    const placeholder = document.getElementById('upload_placeholder');
    const errorMsg = document.getElementById('error_msg');
    const maxFileSize = 5 * 1024 * 1024; // 5MB

    fileInput.addEventListener('change', function() {
        const file = this.files[0];
        errorMsg.classList.add('hidden');
        errorMsg.textContent = '';
        
        if (file) {
            // Validation
            const validTypes = ['image/jpeg', 'image/png', 'image/jpg'];
            if (!validTypes.includes(file.type)) {
                errorMsg.innerHTML = '<i class="fas fa-exclamation-triangle mr-1"></i> Error: Tipe file harus JPG, JPEG, atau PNG!';
                errorMsg.classList.remove('hidden');
                this.value = ''; // clear input
                resetPreview();
                return;
            }

            if (file.size > maxFileSize) {
                errorMsg.innerHTML = '<i class="fas fa-exclamation-triangle mr-1"></i> Error: Ukuran file maksimal 5MB!';
                errorMsg.classList.remove('hidden');
                this.value = '';
                resetPreview();
                return;
            }

            // Preview
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
            }
            reader.readAsDataURL(file);
        } else {
            resetPreview();
        }
    });

    function resetPreview() {
        preview.src = '';
        preview.classList.add('hidden');
        placeholder.classList.remove('hidden');
    }
</script>
<?= csrf_field() ?>
