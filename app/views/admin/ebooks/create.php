<div class="mb-8 flex items-center justify-between">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Tambah E-Book Baru</h1>
        <p class="text-gray-500 mt-1">Unggah edisi digital dari katalog buku fisik atau publikasi e-book mandiri.</p>
    </div>
    <a href="<?= BASEURL; ?>/admin/ebooks" class="px-5 py-2.5 rounded-2xl border border-gray-200 text-gray-600 hover:bg-gray-100 font-bold text-sm transition flex items-center gap-2">
        <i class="fas fa-arrow-left"></i> Kembali ke Daftar
    </a>
</div>

<?php if(isset($_GET['msg']) && $_GET['msg'] == 'error'): ?>
<div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-2xl shadow-sm font-bold flex items-center gap-2.5" role="alert">
    <i class="fas fa-exclamation-circle text-lg"></i> Gagal menyimpan data E-Book. Pastikan semua kolom wajib telah diisi dengan benar.
</div>
<?php endif; ?>

<div class="max-w-4xl bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 bg-unsoed-darkblue text-white flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-unsoed-yellow text-white flex items-center justify-center text-lg font-bold">
            <i class="fas fa-file-pdf"></i>
        </div>
        <div>
            <h3 class="font-bold text-lg">Formulir Publikasi E-Book</h3>
            <p class="text-xs text-gray-300">File PDF akan dienkripsi / dilindungi watermarking pada sistem.</p>
        </div>
    </div>

    <form action="<?= BASEURL; ?>/admin/store_ebook" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
        
        <!-- Pilihan Buku Fisik -->
        <div class="bg-blue-50/60 p-5 rounded-2xl border border-blue-100 space-y-2">
            <label class="block text-sm font-bold text-gray-800">
                <i class="fas fa-book text-unsoed-blue mr-1.5"></i> Hubungkan dengan Buku Fisik di Katalog (Opsional)
            </label>
            <select name="book_id" id="selectBookId" onchange="autoFillFromBook()" class="w-full px-4 py-3 rounded-2xl border border-gray-200 bg-white focus:ring-2 focus:ring-unsoed-blue/30 focus:border-unsoed-blue transition text-sm font-semibold">
                <option value="">-- Buat Standalone E-Book (Tidak Terhubung ke Buku Fisik) --</option>
                <?php foreach($data['books'] as $b): ?>
                    <option value="<?= $b['id'] ?>" data-title="<?= htmlspecialchars($b['title']) ?>" data-price="<?= $b['price'] ?>">
                        [#<?= $b['id'] ?>] <?= htmlspecialchars($b['title']) ?> (Penulis: <?= htmlspecialchars($b['author']) ?>)
                    </option>
                <?php endforeach; ?>
            </select>
            <p class="text-xs text-gray-500">* Jika dipilih, informasi cover, penulis, dan ISBN akan otomatis mengikuti buku fisik tersebut.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <label class="block text-sm font-bold text-gray-700 mb-2">
                    Judul E-Book / Publikasi Digital <span class="text-red-500">*</span>
                </label>
                <input type="text" name="title" id="inputTitle" required placeholder="Contoh: Metodologi Penelitian Sosial (Edisi Digital)" class="w-full px-4 py-3 rounded-2xl border border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-unsoed-blue/30 focus:border-unsoed-blue transition text-sm font-semibold">
            </div>

            <div>
                <label for="parent_category" class="block text-sm font-bold text-gray-700 mb-2">Kategori Utama (Opsional, khusus Standalone)</label>
                <select id="parent_category" class="w-full px-4 py-3 rounded-2xl border border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-unsoed-blue/30 focus:border-unsoed-blue transition text-sm">
                    <option value="">-- Pilih Kategori Utama --</option>
                    <?php foreach($data['categories'] as $cat): ?>
                        <option value="<?= $cat['id'] ?>"><?= $cat['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div>
                <label for="category_id" class="block text-sm font-bold text-gray-700 mb-2">Sub-Kategori</label>
                <select name="category_id" id="category_id" class="w-full px-4 py-3 rounded-2xl border border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-unsoed-blue/30 focus:border-unsoed-blue transition text-sm" disabled>
                    <option value="">-- Pilih Kategori Utama Dulu --</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">
                    Ukuran File E-Book
                </label>
                <input type="text" name="file_size" value="15.5 MB" placeholder="Contoh: 12.8 MB" class="w-full px-4 py-3 rounded-2xl border border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-unsoed-blue/30 focus:border-unsoed-blue transition text-sm">
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">
                    Jumlah Halaman Total
                </label>
                <input type="number" name="page_count" value="200" placeholder="200" class="w-full px-4 py-3 rounded-2xl border border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-unsoed-blue/30 focus:border-unsoed-blue transition text-sm">
            </div>
        </div>

        <!-- Spesifikasi Harga & Gratis -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-5 bg-gray-50 rounded-2xl border border-gray-200">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">
                    Harga Jual E-Book (Rp)
                </label>
                <div class="relative">
                    <span class="absolute left-4 top-3.5 text-gray-400 font-bold text-sm">Rp</span>
                    <input type="text" name="ebook_price" id="inputEbookPrice" value="50000" placeholder="50000" class="w-full pl-11 pr-4 py-3 rounded-2xl border border-gray-200 bg-white focus:ring-2 focus:ring-unsoed-blue/30 focus:border-unsoed-blue transition text-sm font-bold text-unsoed-blue">
                </div>
                <p class="text-[11px] text-gray-400 mt-1">* Rekomendasi: 30% lebih murah dari edisi cetak.</p>
            </div>

            <div class="flex flex-col justify-center space-y-3">
                <label class="block text-sm font-bold text-gray-700">
                    Opsi Open Access (Gratis)
                </label>
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="is_free" id="checkIsFree" value="1" onchange="toggleFreePrice()" class="w-5 h-5 rounded border-gray-300 text-unsoed-blue focus:ring-unsoed-blue">
                    <span class="text-sm font-bold text-green-700 bg-green-50 px-3 py-1 rounded-lg border border-green-200">
                        <i class="fas fa-gift mr-1"></i> Gratis / Open Access (Rp 0)
                    </span>
                </label>
                
                <label class="flex items-center gap-3 mt-4 cursor-pointer">
                    <input type="checkbox" name="is_flashsale" value="1" class="w-5 h-5 text-red-600 border-gray-300 rounded focus:ring-red-500">
                    <span class="text-sm font-bold text-red-600 bg-red-50 px-2 py-1 rounded">Flash Sale</span>
                </label>
                <p class="text-[11px] text-gray-500">* Centang Flash Sale untuk memunculkan lencana promosi.</p>
            </div>
        </div>

        <!-- Upload File -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="border-2 border-dashed border-gray-200 rounded-2xl p-5 text-center hover:border-unsoed-blue transition bg-gray-50/50">
                <i class="fas fa-file-pdf text-3xl text-red-500 mb-2 block"></i>
                <label class="block text-sm font-bold text-gray-800 mb-1">Upload File E-Book Lengkap (.pdf)</label>
                <p class="text-xs text-gray-400 mb-3">File PDF penuh untuk dibaca/diunduh oleh pembeli resmi.</p>
                <input type="file" name="file_pdf_upload" accept=".pdf,.epub" class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-unsoed-blue file:text-white hover:file:bg-blue-800">
            </div>

            <div class="border-2 border-dashed border-gray-200 rounded-2xl p-5 text-center hover:border-green-500 transition bg-gray-50/50">
                <i class="fas fa-file-alt text-3xl text-green-500 mb-2 block"></i>
                <label class="block text-sm font-bold text-gray-800 mb-1">Upload Preview Sampel (.pdf)</label>
                <p class="text-xs text-gray-400 mb-3">Sampel Bab 1 / Daftar Isi agar publik dapat mencoba sebelum membeli.</p>
                <input type="file" name="preview_pdf_upload" accept=".pdf" class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-green-600 file:text-white hover:file:bg-green-700">
            </div>
        </div>

        <!-- Status -->
        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">
                Status Publikasi <span class="text-red-500">*</span>
            </label>
            <select name="status" class="w-full px-4 py-3 rounded-2xl border border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-unsoed-blue/30 focus:border-unsoed-blue transition text-sm font-semibold">
                <option value="active">Aktif (Tampilkan di Katalog E-Book)</option>
                <option value="inactive">Nonaktif (Sembunyikan / Draf)</option>
            </select>
        </div>

        <div class="pt-4 border-t border-gray-100 flex items-center justify-end gap-3">
            <a href="<?= BASEURL; ?>/admin/ebooks" class="px-6 py-3 rounded-2xl border border-gray-200 text-gray-600 hover:bg-gray-100 font-bold text-sm transition">
                Batal
            </a>
            <button type="submit" class="btn-primary flex items-center gap-2">
                <i class="fas fa-save"></i> Simpan E-Book
            </button>
        </div>
    </form>
</div>

<script>
function autoFillFromBook() {
    const select = document.getElementById('selectBookId');
    const selectedOption = select.options[select.selectedIndex];
    
    if(selectedOption.value !== "") {
        const title = selectedOption.getAttribute('data-title');
        const price = parseFloat(selectedOption.getAttribute('data-price')) || 0;
        
        // Set Judul Ebook
        document.getElementById('inputTitle').value = title + " (Edisi Digital)";
        
        // Set diskon 30% dari harga normal
        const diskonPrice = Math.round(price * 0.7 / 100) * 100;
        document.getElementById('inputEbookPrice').value = diskonPrice > 0 ? diskonPrice : 0;
    }
}

function toggleFreePrice() {
    const check = document.getElementById('checkIsFree');
    const priceInput = document.getElementById('inputEbookPrice');
    
    if(check.checked) {
        priceInput.value = '0';
        priceInput.setAttribute('readonly', 'readonly');
        priceInput.classList.add('bg-gray-100', 'text-gray-400');
    } else {
        priceInput.removeAttribute('readonly');
        priceInput.classList.remove('bg-gray-100', 'text-gray-400');
        autoFillFromBook();
    }
}
</script>

<script>
    const categoriesData = <?= json_encode($data['categories']) ?>;
    const parentSelect = document.getElementById('parent_category');
    const childSelect = document.getElementById('category_id');

    parentSelect.addEventListener('change', function() {
        const parentId = this.value;
        childSelect.innerHTML = '<option value="">-- Pilih Sub-Kategori --</option>';
        
        if (!parentId) {
            childSelect.disabled = true;
            childSelect.innerHTML = '<option value="">-- Pilih Kategori Utama Dulu --</option>';
            return;
        }

        const parent = categoriesData.find(c => c.id == parentId);
        
        if (parent && parent.children && parent.children.length > 0) {
            childSelect.disabled = false;
            
            const optionUmum = document.createElement('option');
            optionUmum.value = parent.id;
            optionUmum.textContent = "Umum / Semua " + parent.name;
            childSelect.appendChild(optionUmum);
            
            parent.children.forEach(child => {
                const option = document.createElement('option');
                option.value = child.id;
                option.textContent = child.name;
                childSelect.appendChild(option);
            });
        } else if (parent) {
            childSelect.disabled = false;
            const option = document.createElement('option');
            option.value = parent.id;
            option.textContent = parent.name + " (Tanpa Sub)";
            option.selected = true;
            childSelect.appendChild(option);
        }
    });
</script>
