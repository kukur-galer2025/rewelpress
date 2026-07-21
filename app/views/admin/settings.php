<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800">Pengaturan Pembayaran</h1>
    <p class="text-gray-500 mt-1">Konfigurasi metode pembayaran untuk pelanggan.</p>
</div>

<?php if(isset($_GET['msg']) && $_GET['msg'] == 'success'): ?>
    <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-r-lg">
        <p class="text-sm text-green-700 font-medium">Pengaturan berhasil diperbarui!</p>
    </div>
<?php endif; ?>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8 max-w-4xl">
    <form action="<?= BASEURL; ?>/admin/update_settings" method="POST" enctype="multipart/form-data" class="space-y-8">
        
        <input type="hidden" name="old_qris" value="<?= isset($data['settings']['qris_image']) ? $data['settings']['qris_image'] : '' ?>">

        <div>
            <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Informasi Rekening Bank</h3>
            <label for="bank_accounts" class="block text-sm font-semibold text-gray-700 mb-2">Daftar Rekening Pembayaran</label>
            <p class="text-xs text-gray-500 mb-2">Tuliskan nama bank, nomor rekening, dan nama pemilik. (Bisa lebih dari satu, pisahkan dengan baris baru)</p>
            <textarea name="bank_accounts" id="bank_accounts" rows="5" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-unsoed-blue focus:border-unsoed-blue outline-none transition" required><?= isset($data['settings']['bank_accounts']) ? $data['settings']['bank_accounts'] : '' ?></textarea>
        </div>

        <div>
            <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">QRIS (Quick Response Code Indonesian Standard)</h3>
            <div class="flex flex-col md:flex-row gap-8 items-start">
                <div class="w-full md:w-1/2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Upload Gambar QRIS Baru</label>
                    <p class="text-xs text-gray-500 mb-2">Format yang didukung: JPG, PNG, JPEG.</p>
                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:bg-gray-50 transition cursor-pointer relative" onclick="document.getElementById('qris_image').click()">
                        <i class="fas fa-qrcode text-4xl text-gray-400 mb-2"></i>
                        <p class="text-sm text-gray-500 font-medium">Pilih file QRIS</p>
                        <input type="file" name="qris_image" id="qris_image" class="hidden" accept="image/*">
                    </div>
                </div>
                
                <div class="w-full md:w-1/2 bg-gray-50 rounded-xl p-6 border border-gray-100 flex flex-col items-center justify-center">
                    <p class="text-sm font-semibold text-gray-700 mb-4">QRIS Saat Ini:</p>
                    <?php if(!empty($data['settings']['qris_image'])): ?>
                        <img src="<?= $data['settings']['qris_image'] ?>" alt="QRIS" class="max-w-full h-auto max-h-64 rounded-lg shadow-sm">
                    <?php else: ?>
                        <div class="w-48 h-48 bg-gray-200 border-2 border-dashed border-gray-300 flex items-center justify-center rounded-lg">
                            <span class="text-gray-400 text-sm">Belum ada QRIS</span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="flex justify-end pt-6">
            <button type="submit" class="bg-unsoed-blue text-white px-8 py-3 rounded-lg font-bold hover:bg-unsoed-darkblue transition shadow-lg flex items-center gap-2">
                <i class="fas fa-save"></i> Simpan Pengaturan
            </button>
        </div>
    </form>
</div>
