<?php
$order    = $data['order'];
$settings = $data['settings'];
$isPaid   = in_array($order['status'], ['paid', 'confirmed', 'rejected']);
?>

<!-- Header -->
<div class="bg-unsoed-darkblue py-10 relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-r from-unsoed-darkblue to-unsoed-blue"></div>
    <div class="container mx-auto px-4 max-w-[900px] relative z-10">
        <div class="flex items-center gap-3 mb-2">
            <a href="<?= BASEURL ?>/ebook/detail/<?= esc($order['ebook_id']) ?>" class="text-white/60 hover:text-white text-sm transition flex items-center gap-1">
                <i class="fas fa-arrow-left text-xs"></i> Kembali
            </a>
        </div>
        <h1 class="text-3xl font-serif font-bold text-white">Pembayaran E-Book</h1>
        <p class="text-gray-300 text-sm mt-1">Pesanan #EBO-<?= esc($order['id']) ?> · <?= htmlspecialchars($order['ebook_title']) ?></p>
    </div>
</div>

<section class="py-12 bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 max-w-[900px]">

        <!-- Flash Messages -->
        <?php if(isset($_GET['msg'])): ?>
            <?php if($_GET['msg'] == 'receipt_uploaded'): ?>
                <div class="mb-6 bg-green-50 border border-green-300 text-green-700 px-4 py-3 rounded-2xl flex items-center gap-3 font-semibold shadow-sm">
                    <i class="fas fa-check-circle text-xl"></i>
                    <div>
                        <p class="font-bold">Bukti pembayaran berhasil diunggah!</p>
                        <p class="text-sm font-normal">Admin akan memverifikasi dalam 1×24 jam. Anda akan mendapat notifikasi setelah dikonfirmasi.</p>
                    </div>
                </div>
            <?php elseif($_GET['msg'] == 'upload_error'): ?>
                <div class="mb-6 bg-red-50 border border-red-300 text-red-700 px-4 py-3 rounded-2xl flex items-center gap-3 font-semibold">
                    <i class="fas fa-exclamation-triangle"></i> Gagal mengunggah file. Pastikan format file adalah JPG/PNG dan ukuran maksimal 2MB.
                </div>
            <?php elseif($_GET['msg'] == 'invalid_file'): ?>
                <div class="mb-6 bg-red-50 border border-red-300 text-red-700 px-4 py-3 rounded-2xl flex items-center gap-3 font-semibold">
                    <i class="fas fa-exclamation-triangle"></i> Format file tidak valid. Gunakan JPG, PNG, atau PDF.
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <!-- Status Badge -->
        <div class="mb-6 flex items-center gap-3">
            <?php
            $statusMap = [
                'pending'   => ['bg-blue-100 text-blue-700 border-blue-200',   'fas fa-hourglass-half', 'Menunggu Pembayaran'],
                'paid'      => ['bg-yellow-100 text-yellow-700 border-yellow-200', 'fas fa-clock',      'Menunggu Verifikasi Admin'],
                'confirmed' => ['bg-green-100 text-green-700 border-green-200', 'fas fa-check-circle', 'Pembayaran Dikonfirmasi'],
                'rejected'  => ['bg-red-100 text-red-700 border-red-200',       'fas fa-times-circle', 'Pembayaran Ditolak'],
            ];
            [$statusCls, $statusIcon, $statusLabel] = $statusMap[$order['status']] ?? $statusMap['pending'];
            ?>
            <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full border text-xs font-extrabold uppercase tracking-wider <?= esc($statusCls) ?>">
                <i class="<?= esc($statusIcon) ?>"></i> <?= esc($statusLabel) ?>
            </span>
        </div>

        <div class="bg-white rounded-3xl p-8 shadow-xl border border-gray-100 mb-8">
            <div class="flex flex-col md:flex-row gap-10">

                <!-- Kiri: Nominal & Info Pembayaran -->
                <div class="w-full md:w-1/2 md:border-r border-gray-100 md:pr-10">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Total Tagihan</h3>
                    <div class="bg-blue-50 text-unsoed-blue p-6 rounded-2xl mb-6 border border-blue-100">
                        <span class="text-sm font-semibold uppercase tracking-wider block mb-1">Bayar Tepat Sesuai Nominal:</span>
                        <span class="text-4xl font-extrabold">Rp <?= number_format($order['amount'], 0, ',', '.') ?></span>
                        <p class="text-xs text-blue-400 mt-1">untuk E-Book: <?= htmlspecialchars($order['ebook_title']) ?></p>
                        
                        <?php if(!empty($order['discount_amount']) && floatval($order['discount_amount']) > 0): ?>
                            <div class="mt-3 pt-3 border-t border-blue-200/60 flex items-center justify-between text-xs text-green-700 font-bold">
                                <span><i class="fas fa-tag mr-1"></i> Diskon (<?= htmlspecialchars($order['voucher_code']) ?>):</span>
                                <span>- Rp <?= number_format($order['discount_amount'], 0, ',', '.') ?></span>
                            </div>
                        <?php endif; ?>
                    </div>

                    <?php if($order['status'] === 'pending'): ?>
                        <!-- Widget Voucher di Pembayaran -->
                        <div class="bg-white rounded-2xl p-4 border border-gray-200 mb-6 shadow-sm">
                            <p class="text-xs font-bold text-gray-800 mb-2 flex items-center gap-1.5">
                                <i class="fas fa-ticket-alt text-amber-500"></i> Punya Kode Voucher / Diskon?
                            </p>

                            <?php if(isset($_GET['voucher_err'])): ?>
                                <p class="text-[11px] text-red-600 font-semibold mb-2"><i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($_GET['voucher_err']) ?></p>
                            <?php endif; ?>

                            <?php if(!empty($order['voucher_code'])): ?>
                                <div class="flex items-center justify-between bg-green-50 px-3 py-2 rounded-xl border border-green-200 text-xs font-bold text-green-800">
                                    <span>Voucher aktif: <?= htmlspecialchars($order['voucher_code']) ?> (-Rp <?= number_format($order['discount_amount'], 0, ',', '.') ?>)</span>
                                    <a href="<?= BASEURL ?>/ebook/remove_voucher_pay/<?= esc($order['id']) ?>" class="text-red-500 hover:text-red-700 font-bold text-sm" title="Hapus"><i class="fas fa-times"></i></a>
                                </div>
                            <?php else: ?>
                                <form action="<?= BASEURL ?>/ebook/apply_voucher_pay/<?= esc($order['id']) ?>" method="POST" class="flex gap-2">
<?= csrf_field() ?><input type="text" name="voucher_code" placeholder="Ketik kode promo..." 
                                           class="flex-1 px-3 py-2 rounded-xl border border-gray-300 focus:border-unsoed-blue text-xs font-mono font-bold uppercase">
                                    <button type="submit" class="bg-unsoed-blue hover:bg-blue-800 text-white px-4 py-2 rounded-xl font-bold text-xs shadow transition">Pakai</button>
                                </form>

                                <?php if(!empty($data['active_vouchers'])): ?>
                                    <div class="mt-3 pt-3 border-t border-gray-100 space-y-1.5 max-h-36 overflow-y-auto">
                                        <?php foreach($data['active_vouchers'] as $av): ?>
                                            <div class="p-2 bg-amber-50/70 border border-amber-200 rounded-xl flex items-center justify-between text-xs">
                                                <div>
                                                    <span class="font-mono font-extrabold text-amber-900 bg-amber-100 px-1.5 py-0.5 rounded text-[10px]"><?= htmlspecialchars($av['code']) ?></span>
                                                    <span class="text-gray-700 text-[11px] font-semibold ml-1"><?= htmlspecialchars($av['title']) ?></span>
                                                </div>
                                                <form action="<?= BASEURL ?>/ebook/apply_voucher_pay/<?= esc($order['id']) ?>" method="POST">
<?= csrf_field() ?><input type="hidden" name="voucher_code" value="<?= htmlspecialchars($av['code']) ?>">
                                                    <button type="submit" class="px-2 py-1 bg-amber-500 hover:bg-amber-600 text-white text-[10px] font-bold rounded-lg transition">Pakai</button>
                                                </form>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <h3 class="text-lg font-bold text-gray-800 mb-4">Metode Pembayaran</h3>
                    <div class="space-y-4">
                        <!-- QRIS -->
                        <div class="border rounded-2xl p-4">
                            <div class="flex items-center gap-3 font-bold text-gray-800 mb-3">
                                <i class="fas fa-qrcode text-unsoed-yellow text-xl"></i> QRIS
                            </div>
                            <?php if(!empty($settings['qris_image'])): ?>
                                <img src="<?= esc($settings['qris_image']) ?>" alt="QRIS" class="w-full max-w-[180px] mx-auto rounded-xl shadow-sm border">
                            <?php else: ?>
                                <p class="text-sm text-gray-400 text-center py-4">QRIS belum tersedia. Hubungi admin.</p>
                            <?php endif; ?>
                        </div>

                        <!-- Transfer Bank -->
                        <div class="border rounded-2xl p-4">
                            <div class="flex items-center gap-3 font-bold text-gray-800 mb-2">
                                <i class="fas fa-university text-unsoed-yellow text-xl"></i> Transfer Bank
                            </div>
                            <pre class="text-sm text-gray-600 whitespace-pre-wrap leading-relaxed font-sans"><?= !empty($settings['bank_accounts']) ? htmlspecialchars($settings['bank_accounts']) : 'Rekening belum tersedia. Hubungi admin.' ?></pre>
                        </div>
                    </div>
                </div>

                <!-- Kanan: Upload Bukti / Status -->
                <div class="w-full md:w-1/2 pt-4 md:pt-0">
                    <?php if($order['status'] === 'confirmed'): ?>
                        <!-- SUDAH DIKONFIRMASI: Tampilkan tombol unduh -->
                        <div class="text-center py-8">
                            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-check-circle text-green-600 text-4xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800 mb-2">Pembayaran Terverifikasi!</h3>
                            <p class="text-gray-500 text-sm mb-6">E-Book Anda sudah siap untuk diunduh. Selamat membaca!</p>
                            <a href="<?= BASEURL ?>/ebook/download/<?= esc($order['ebook_id']) ?>"
                               class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-green-600 to-teal-600 text-white font-bold rounded-2xl shadow-lg hover:from-green-700 hover:to-teal-700 transition text-sm">
                                <i class="fas fa-cloud-download-alt text-lg"></i> Unduh E-Book Sekarang
                            </a>
                        </div>

                    <?php elseif($order['status'] === 'rejected'): ?>
                        <!-- DITOLAK -->
                        <div class="text-center py-8">
                            <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-times-circle text-red-500 text-4xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800 mb-2">Pembayaran Ditolak</h3>
                            <p class="text-gray-500 text-sm mb-4">Maaf, pembayaran Anda tidak dapat diverifikasi.</p>
                            <?php if(!empty($order['note'])): ?>
                                <div class="bg-red-50 border border-red-200 rounded-xl p-3 text-sm text-red-700 mb-4">
                                    <strong>Catatan Admin:</strong> <?= htmlspecialchars($order['note']) ?>
                                </div>
                            <?php endif; ?>
                            <p class="text-xs text-gray-400">Silakan hubungi admin Unsoed Press untuk informasi lebih lanjut.</p>
                        </div>

                    <?php elseif($order['status'] === 'paid'): ?>
                        <!-- SUDAH UPLOAD, MENUNGGU VERIFIKASI -->
                        <div class="text-center py-6">
                            <div class="w-20 h-20 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-hourglass-half text-yellow-500 text-4xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800 mb-2">Menunggu Verifikasi</h3>
                            <p class="text-gray-500 text-sm mb-4">Bukti pembayaran Anda sudah diterima. Admin akan memverifikasi dalam 1×24 jam kerja.</p>
                            <?php if(!empty($order['payment_receipt'])): ?>
                                <div class="bg-gray-50 border border-gray-200 rounded-2xl p-3 text-left">
                                    <p class="text-xs font-semibold text-gray-500 mb-2">Bukti Bayar yang Diunggah:</p>
                                    <img src="<?= htmlspecialchars($order['payment_receipt']) ?>" alt="Bukti Bayar" class="w-full rounded-xl border max-h-48 object-contain bg-white">
                                </div>
                            <?php endif; ?>
                        </div>

                    <?php else: ?>
                        <!-- PENDING: Form upload bukti bayar -->
                        <h3 class="text-xl font-bold text-gray-800 mb-3">Unggah Bukti Pembayaran</h3>
                        <p class="text-sm text-gray-500 mb-5">Setelah transfer, unggah foto/screenshot bukti transfer Anda. Admin akan memverifikasi dalam 1×24 jam.</p>

                        <form action="<?= BASEURL ?>/ebook/pay/<?= esc($order['id']) ?>" method="POST" enctype="multipart/form-data" class="space-y-5">
<?= csrf_field() ?><!-- Drop zone -->
                            <div class="border-2 border-dashed border-gray-300 rounded-2xl p-8 text-center hover:bg-gray-50 hover:border-unsoed-blue transition cursor-pointer relative"
                                 id="dropzone" onclick="document.getElementById('receipt').click()">
                                <i class="fas fa-file-invoice-dollar text-5xl text-gray-300 mb-3" id="dropzoneIcon"></i>
                                <p class="text-base text-gray-600 font-semibold mb-1" id="dropzoneLabel">Klik atau Seret File ke Sini</p>
                                <p class="text-xs text-gray-400">JPG, PNG, atau PDF · Maks 2MB</p>
                                <input type="file" name="receipt" id="receipt" class="hidden" accept="image/*,.pdf" required onchange="previewFile(this)">
                            </div>

                            <!-- Preview -->
                            <div id="previewArea" class="hidden">
                                <img id="previewImg" src="" alt="Preview" class="w-full max-h-48 object-contain rounded-xl border border-gray-200 bg-gray-50">
                                <p id="previewName" class="text-xs text-gray-500 mt-2 text-center font-mono"></p>
                            </div>

                            <button type="submit"
                                    class="w-full py-3.5 bg-gradient-to-r from-unsoed-blue to-blue-700 hover:from-blue-800 hover:to-blue-900 text-white font-bold rounded-2xl shadow-lg transition flex items-center justify-center gap-2">
                                <i class="fas fa-upload"></i> Kirim Bukti Pembayaran
                            </button>
                        </form>
                    <?php endif; ?>
                </div>

            </div>
        </div>

    </div>
</section>

<script>
function previewFile(input) {
    const preview = document.getElementById('previewArea');
    const previewImg = document.getElementById('previewImg');
    const previewName = document.getElementById('previewName');
    const dropzoneIcon = document.getElementById('dropzoneIcon');
    const dropzoneLabel = document.getElementById('dropzoneLabel');

    if (input.files && input.files[0]) {
        const file = input.files[0];
        previewName.textContent = file.name + ' (' + (file.size / 1024).toFixed(0) + ' KB)';
        dropzoneLabel.textContent = '✅ File dipilih: ' + file.name;
        dropzoneIcon.className = 'fas fa-check-circle text-5xl text-green-500 mb-3';

        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = e => { previewImg.src = e.target.result; preview.classList.remove('hidden'); };
            reader.readAsDataURL(file);
        } else {
            previewImg.src = '';
            preview.classList.add('hidden');
        }
    }
}
</script>
<?= csrf_field() ?>
