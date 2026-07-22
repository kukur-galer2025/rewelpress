<div class="mb-8 flex items-center justify-between">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Edit Data E-Book</h1>
        <p class="text-gray-500 mt-1">Perbarui spesifikasi, harga, atau ganti file PDF e-book dan sampel.</p>
    </div>
    <a href="<?= BASEURL; ?>/admin/ebooks" class="px-5 py-2.5 rounded-2xl border border-gray-200 text-gray-600 hover:bg-gray-100 font-bold text-sm transition flex items-center gap-2">
        <i class="fas fa-arrow-left"></i> Kembali ke Daftar
    </a>
</div>

<div class="max-w-4xl bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 bg-unsoed-darkblue text-white flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-unsoed-yellow text-white flex items-center justify-center text-lg font-bold">
            <i class="fas fa-edit"></i>
        </div>
        <div>
            <h3 class="font-bold text-lg">Edit E-Book: <?= htmlspecialchars($data['ebook']['title']) ?></h3>
            <p class="text-xs text-gray-300">ID E-Book: #<?= $data['ebook']['id'] ?> | Terdaftar pada <?= date('d M Y', strtotime($data['ebook']['created_at'])) ?></p>
        </div>
    </div>

    <form action="<?= BASEURL; ?>/admin/update_ebook" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
        <input type="hidden" name="id" value="<?= $data['ebook']['id'] ?>">
        <input type="hidden" name="file_pdf" value="<?= htmlspecialchars($data['ebook']['file_pdf'] ?? '') ?>">
        <input type="hidden" name="preview_pdf" value="<?= htmlspecialchars($data['ebook']['preview_pdf'] ?? '') ?>">
        
        <!-- Pilihan Buku Fisik -->
        <div class="bg-blue-50/60 p-5 rounded-2xl border border-blue-100 space-y-2">
            <label class="block text-sm font-bold text-gray-800">
                <i class="fas fa-book text-unsoed-blue mr-1.5"></i> Hubungan dengan Buku Fisik di Katalog
            </label>
            <select name="book_id" id="selectBookId" class="w-full px-4 py-3 rounded-2xl border border-gray-200 bg-white focus:ring-2 focus:ring-unsoed-blue/30 focus:border-unsoed-blue transition text-sm font-semibold">
                <option value="">-- Standalone E-Book (Tidak Terhubung) --</option>
                <?php foreach($data['books'] as $b): ?>
                    <option value="<?= $b['id'] ?>" <?= ($data['ebook']['book_id'] == $b['id']) ? 'selected' : '' ?>>
                        [#<?= $b['id'] ?>] <?= htmlspecialchars($b['title']) ?> (Penulis: <?= htmlspecialchars($b['author']) ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <label class="block text-sm font-bold text-gray-700 mb-2">
                    Judul E-Book / Publikasi Digital <span class="text-red-500">*</span>
                </label>
                <input type="text" name="title" required value="<?= htmlspecialchars($data['ebook']['title']) ?>" class="w-full px-4 py-3 rounded-2xl border border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-unsoed-blue/30 focus:border-unsoed-blue transition text-sm font-semibold">
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
                <input type="text" name="file_size" value="<?= htmlspecialchars($data['ebook']['file_size'] ?? '15 MB') ?>" class="w-full px-4 py-3 rounded-2xl border border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-unsoed-blue/30 focus:border-unsoed-blue transition text-sm">
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">
                    Jumlah Halaman Total
                </label>
                <input type="number" name="page_count" value="<?= $data['ebook']['page_count'] ?? 200 ?>" class="w-full px-4 py-3 rounded-2xl border border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-unsoed-blue/30 focus:border-unsoed-blue transition text-sm">
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
                    <input type="text" name="ebook_price" id="inputEbookPrice" value="<?= floatval($data['ebook']['ebook_price']) ?>" class="w-full pl-11 pr-4 py-3 rounded-2xl border border-gray-200 bg-white focus:ring-2 focus:ring-unsoed-blue/30 focus:border-unsoed-blue transition text-sm font-bold text-unsoed-blue" <?= $data['ebook']['is_free'] == 1 ? 'readonly' : '' ?>>
                </div>
            </div>

            <div class="flex flex-col justify-center space-y-3">
                <label class="block text-sm font-bold text-gray-700">
                    Opsi Open Access (Gratis)
                </label>
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="is_free" id="checkIsFree" value="1" onchange="toggleFreePrice()" <?= $data['ebook']['is_free'] == 1 ? 'checked' : '' ?> class="w-5 h-5 rounded border-gray-300 text-unsoed-blue focus:ring-unsoed-blue">
                    <span class="text-sm font-bold text-green-700 bg-green-50 px-3 py-1 rounded-lg border border-green-200">
                        <i class="fas fa-gift mr-1"></i> Gratis / Open Access (Rp 0)
                    </span>
                </label>
                
                <label class="flex items-center gap-3 mt-4 cursor-pointer">
                    <input type="checkbox" name="is_flashsale" value="1" <?= isset($data['ebook']['is_flashsale']) && $data['ebook']['is_flashsale'] ? 'checked' : '' ?> class="w-5 h-5 text-red-600 border-gray-300 rounded focus:ring-red-500">
                    <span class="text-sm font-bold text-red-600 bg-red-50 px-2 py-1 rounded">Flash Sale</span>
                </label>
                <p class="text-[11px] text-gray-500">* Centang Flash Sale untuk memunculkan lencana promosi.</p>
            </div>
        </div>

        <!-- Upload File -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="border-2 border-dashed border-gray-200 rounded-2xl p-5 text-center hover:border-unsoed-blue transition bg-gray-50/50">
                <i class="fas fa-file-pdf text-3xl text-red-500 mb-2 block"></i>
                <label class="block text-sm font-bold text-gray-800 mb-1">Ganti File E-Book (.pdf)</label>
                <p class="text-xs text-gray-400 mb-2">Biarkan kosong jika tidak ingin mengganti file PDF saat ini.</p>
                <?php if(!empty($data['ebook']['file_pdf'])): ?>
                    <span class="inline-block text-[10px] bg-blue-100 text-unsoed-blue px-2 py-1 rounded font-bold mb-3">
                        File aktif: <?= htmlspecialchars($data['ebook']['file_pdf']) ?>
                    </span>
                <?php endif; ?>
                <input type="file" name="file_pdf_upload" accept=".pdf,.epub" class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-unsoed-blue file:text-white hover:file:bg-blue-800">
            </div>

            <div class="border-2 border-dashed border-gray-200 rounded-2xl p-5 text-center hover:border-green-500 transition bg-gray-50/50">
                <i class="fas fa-file-alt text-3xl text-green-500 mb-2 block"></i>
                <label class="block text-sm font-bold text-gray-800 mb-1">Ganti Preview Sampel (.pdf)</label>
                <p class="text-xs text-gray-400 mb-2">Biarkan kosong jika tidak ingin mengganti file sampel saat ini.</p>
                <?php if(!empty($data['ebook']['preview_pdf'])): ?>
                    <span class="inline-block text-[10px] bg-green-100 text-green-700 px-2 py-1 rounded font-bold mb-3">
                        Preview aktif: <?= htmlspecialchars($data['ebook']['preview_pdf']) ?>
                    </span>
                <?php endif; ?>
                <input type="file" name="preview_pdf_upload" accept=".pdf" class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-green-600 file:text-white hover:file:bg-green-700">
            </div>
        </div>

        <!-- Status -->
        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">
                Status Publikasi <span class="text-red-500">*</span>
            </label>
            <select name="status" class="w-full px-4 py-3 rounded-2xl border border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-unsoed-blue/30 focus:border-unsoed-blue transition text-sm font-semibold">
                <option value="active" <?= $data['ebook']['status'] == 'active' ? 'selected' : '' ?>>Aktif (Tampilkan di Katalog E-Book)</option>
                <option value="inactive" <?= $data['ebook']['status'] == 'inactive' ? 'selected' : '' ?>>Nonaktif (Sembunyikan / Draf)</option>
            </select>
        </div>

        <div class="pt-4 border-t border-gray-100 flex items-center justify-end gap-3">
            <a href="<?= BASEURL; ?>/admin/ebooks" class="px-6 py-3 rounded-2xl border border-gray-200 text-gray-600 hover:bg-gray-100 font-bold text-sm transition">
                Batal
            </a>
            <button type="submit" class="btn-primary flex items-center gap-2">
                <i class="fas fa-check"></i> Simpan Perubahan
            </button>
        </div>
    </form>
</div>

<script>
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
    }
}
</script>

<script>
    const categoriesData = <?= json_encode($data['categories']) ?>;
    const parentSelect = document.getElementById('parent_category');
    const childSelect = document.getElementById('category_id');
    const currentCategoryId = <?= $data['ebook']['category_id'] ?? 'null' ?>;

    function populateChildren(parentId, selectedChildId = null) {
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
            if (parent.id == selectedChildId) optionUmum.selected = true;
            childSelect.appendChild(optionUmum);
            
            parent.children.forEach(child => {
                const option = document.createElement('option');
                option.value = child.id;
                option.textContent = child.name;
                if (child.id == selectedChildId) option.selected = true;
                childSelect.appendChild(option);
            });
        } else if(parent) {
            childSelect.disabled = false;
            const option = document.createElement('option');
            option.value = parent.id;
            option.textContent = parent.name + " (Tanpa Sub)";
            option.selected = true;
            childSelect.appendChild(option);
        }
    }

    parentSelect.addEventListener('change', function() {
        populateChildren(this.value);
    });

    // Preselect on load
    if (currentCategoryId) {
        let initialParentId = null;
        const isParent = categoriesData.find(c => c.id == currentCategoryId);
        if (isParent) {
            initialParentId = currentCategoryId;
        } else {
            for(let i = 0; i < categoriesData.length; i++) {
                if(categoriesData[i].children) {
                    const foundChild = categoriesData[i].children.find(child => child.id == currentCategoryId);
                    if(foundChild) {
                        initialParentId = categoriesData[i].id;
                        break;
                    }
                }
            }
        }

        if (initialParentId) {
            parentSelect.value = initialParentId;
            populateChildren(initialParentId, currentCategoryId);
        }
    }
</script>
