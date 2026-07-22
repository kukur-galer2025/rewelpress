<div class="mb-8 flex items-center justify-between">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Buat Voucher Baru</h1>
        <p class="text-gray-500 mt-1 text-sm">Buat kode diskon baru untuk promosi publikasi buku atau e-book.</p>
    </div>
    <a href="<?= BASEURL; ?>/admin/vouchers" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2.5 rounded-xl font-bold text-sm transition flex items-center gap-2">
        <i class="fas fa-arrow-left"></i> Kembali ke Daftar
    </a>
</div>

<div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-200 max-w-3xl">
    <form action="<?= BASEURL; ?>/admin/create_voucher" method="POST" class="space-y-6">
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-2">Kode Voucher <span class="text-red-500">*</span></label>
                <input type="text" name="code" required placeholder="Contoh: UNSOED2026" 
                       class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-unsoed-blue focus:ring-2 focus:ring-blue-100 font-mono font-bold uppercase text-gray-800">
                <p class="text-[11px] text-gray-400 mt-1">Gunakan huruf besar dan angka tanpa spasi.</p>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-2">Berlaku Untuk <span class="text-red-500">*</span></label>
                <select name="applicable_to" required class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-unsoed-blue focus:ring-2 focus:ring-blue-100 font-medium text-gray-800">
                    <option value="all">Semua Produk (Buku Fisik & E-Book)</option>
                    <option value="book">Khusus Buku Fisik Cetakan</option>
                    <option value="ebook">Khusus E-Book Digital</option>
                </select>
            </div>
        </div>

        <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-2">Judul / Nama Promo <span class="text-red-500">*</span></label>
            <input type="text" name="title" required placeholder="Contoh: Diskon Grand Launching Unsoed Press" 
                   class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-unsoed-blue focus:ring-2 focus:ring-blue-100 font-semibold text-gray-800">
        </div>

        <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-2">Deskripsi & Syarat Ketentuan</label>
            <textarea name="description" rows="3" placeholder="Contoh: Potongan harga Rp 15.000 untuk pembelian semua produk tanpa minimum transaksi." 
                      class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-unsoed-blue focus:ring-2 focus:ring-blue-100 text-sm text-gray-800"></textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-2 border-t border-gray-100">
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-2">Tipe Diskon <span class="text-red-500">*</span></label>
                <select name="discount_type" id="discount_type" onchange="toggleDiscountFields()" required class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-unsoed-blue focus:ring-2 focus:ring-blue-100 font-medium text-gray-800">
                    <option value="nominal">Nominal (Rp)</option>
                    <option value="percent">Persentase (%)</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-2">Nilai Diskon <span class="text-red-500">*</span></label>
                <input type="number" step="0.01" name="discount_value" required placeholder="Contoh: 15000 atau 20" 
                       class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-unsoed-blue focus:ring-2 focus:ring-blue-100 font-bold text-gray-800">
            </div>

            <div id="max_discount_box">
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-2">Maksimal Diskon (Rp)</label>
                <input type="number" step="0.01" name="max_discount" placeholder="Opsional (untuk %)" 
                       class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-unsoed-blue focus:ring-2 focus:ring-blue-100 text-gray-800">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-2">Minimum Belanja (Rp)</label>
                <input type="number" step="0.01" name="min_purchase" value="0" 
                       class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-unsoed-blue focus:ring-2 focus:ring-blue-100 text-gray-800 font-semibold">
                <p class="text-[11px] text-gray-400 mt-1">Isi 0 jika tanpa minimum pembelian.</p>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-2">Kuota Pemakaian</label>
                <input type="number" name="quota" value="0" 
                       class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-unsoed-blue focus:ring-2 focus:ring-blue-100 text-gray-800 font-semibold">
                <p class="text-[11px] text-gray-400 mt-1">Isi 0 untuk kuota tidak terbatas (unlimited).</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-2 border-t border-gray-100">
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-2">Tanggal Mulai (Opsional)</label>
                <input type="datetime-local" name="start_date" 
                       class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-unsoed-blue focus:ring-2 focus:ring-blue-100 text-gray-800 text-sm">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-2">Tanggal Berakhir (Opsional)</label>
                <input type="datetime-local" name="end_date" 
                       class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-unsoed-blue focus:ring-2 focus:ring-blue-100 text-gray-800 text-sm">
            </div>
        </div>

        <div class="pt-4 border-t border-gray-100 flex items-center justify-between">
            <label class="flex items-center gap-3 cursor-pointer">
                <input type="checkbox" name="is_active" value="1" checked class="w-5 h-5 text-unsoed-blue rounded focus:ring-unsoed-blue">
                <span class="font-bold text-gray-800 text-sm">Langsung Aktifkan Voucher Ini</span>
            </label>

            <button type="submit" class="bg-unsoed-blue hover:bg-blue-800 text-white px-8 py-3 rounded-xl font-bold text-sm shadow-lg transition">
                <i class="fas fa-save mr-2"></i> Simpan Voucher
            </button>
        </div>

    </form>
</div>
