<div class="mb-8 flex items-center justify-between">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Tambah Buku</h1>
        <p class="text-gray-500 mt-1">Masukkan detail buku baru ke dalam katalog.</p>
    </div>
    <a href="<?= BASEURL; ?>/admin/books" class="text-gray-500 hover:text-unsoed-blue transition font-semibold flex items-center gap-2">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
    <form action="<?= BASEURL; ?>/admin/create_book" method="POST" enctype="multipart/form-data" class="space-y-6">
        <?= csrf_field() ?>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Left Col -->
            <div class="space-y-6">
                <div>
                    <label for="title" class="block text-sm font-bold text-gray-700 mb-2">Judul Buku <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="title" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-unsoed-blue focus:border-unsoed-blue outline-none transition" required>
                </div>
                
                <div>
                    <label for="author" class="block text-sm font-bold text-gray-700 mb-2">Penulis <span class="text-red-500">*</span></label>
                    <select name="author[]" id="author" multiple="multiple" class="select2-multiple w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-unsoed-blue focus:border-unsoed-blue outline-none transition" required>
                        <?php foreach($data['authors'] as $auth): ?>
                            <option value="<?= htmlspecialchars($auth['name']) ?>"><?= htmlspecialchars($auth['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="parent_category" class="block text-sm font-bold text-gray-700 mb-2">Kategori Utama <span class="text-red-500">*</span></label>
                        <select id="parent_category" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-unsoed-blue/30 focus:border-unsoed-blue transition-all" required>
                            <option value="">-- Pilih Kategori Utama --</option>
                            <?php foreach($data['categories'] as $cat): ?>
                                <option value="<?= $cat['id'] ?>"><?= $cat['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label for="category_id" class="block text-sm font-bold text-gray-700 mb-2">Sub-Kategori <span class="text-red-500">*</span></label>
                        <select name="category_id" id="category_id" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-unsoed-blue/30 focus:border-unsoed-blue transition-all" required disabled>
                            <option value="">-- Pilih Kategori Utama Dulu --</option>
                        </select>
                    </div>
                </div>

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

                <div>
                    <label for="isbn" class="block text-sm font-bold text-gray-700 mb-2">ISBN</label>
                    <input type="text" name="isbn" id="isbn" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-unsoed-blue focus:border-unsoed-blue outline-none transition">
                </div>
                
                <div>
                    <label for="synopsis" class="block text-sm font-bold text-gray-700 mb-2">Sinopsis Buku</label>
                    <textarea name="synopsis" id="synopsis" rows="5" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-unsoed-blue focus:border-unsoed-blue outline-none transition resize-none"></textarea>
                </div>
            </div>

            <!-- Right Col -->
            <div class="space-y-6">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="price" class="block text-sm font-bold text-gray-700 mb-2">Harga Jual (Rp) <span class="text-red-500">*</span></label>
                        <input type="number" name="price" id="price" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-unsoed-blue focus:border-unsoed-blue outline-none transition" required>
                    </div>
                    <div>
                        <label for="old_price" class="block text-sm font-bold text-gray-700 mb-1 flex items-center justify-between">
                            <span>Harga Coret (Opsional)</span>
                            <span class="text-[10px] bg-red-500 text-white px-1.5 py-0.5 rounded font-bold">PROMO</span>
                        </label>
                        <input type="number" name="old_price" id="old_price" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-unsoed-blue focus:border-unsoed-blue outline-none transition" placeholder="Rp">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="edition" class="block text-sm font-bold text-gray-700 mb-2">Edisi / Cetakan</label>
                        <input type="text" name="edition" id="edition" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-unsoed-blue focus:border-unsoed-blue outline-none transition" placeholder="Contoh: Cetak 1">
                    </div>
                    <div>
                        <label for="dimensions" class="block text-sm font-bold text-gray-700 mb-2">Dimensi Fisik</label>
                        <input type="text" name="dimensions" id="dimensions" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-unsoed-blue focus:border-unsoed-blue outline-none transition" placeholder="Contoh: 14 x 21 cm">
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label for="cover_type" class="block text-sm font-bold text-gray-700 mb-2">Jenis Kover</label>
                        <select name="cover_type" id="cover_type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-unsoed-blue focus:border-unsoed-blue outline-none transition">
                            <option value="">-- Pilih Kover --</option>
                            <option value="Soft Cover">Soft Cover</option>
                            <option value="Hard Cover">Hard Cover</option>
                        </select>
                    </div>
                    <div>
                        <label for="language" class="block text-sm font-bold text-gray-700 mb-2">Bahasa</label>
                        <select name="language" id="language" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-unsoed-blue focus:border-unsoed-blue outline-none transition">
                            <option value="Bahasa Indonesia">Indonesia</option>
                            <option value="English">English</option>
                            <option value="Bilingual">Bilingual</option>
                        </select>
                    </div>
                    <div>
                        <label for="status" class="block text-sm font-bold text-gray-700 mb-2">Status</label>
                        <select name="status" id="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-unsoed-blue focus:border-unsoed-blue outline-none transition">
                            <option value="published">Published</option>
                            <option value="draft">Draft</option>
                            <option value="archived">Archived</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="stock" class="block text-sm font-bold text-gray-700 mb-2">Stok Tersedia <span class="text-red-500">*</span></label>
                        <input type="number" name="stock" id="stock" value="0" min="0" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-unsoed-blue focus:border-unsoed-blue outline-none transition" required>
                    </div>
                    <div class="flex flex-col justify-center">
                        <label class="flex items-center gap-2 mt-6 cursor-pointer">
                            <input type="checkbox" name="is_flashsale" value="1" class="w-5 h-5 text-red-600 border-gray-300 rounded focus:ring-red-500">
                            <span class="text-sm font-bold text-red-600 bg-red-50 px-2 py-1 rounded">Flash Sale</span>
                        </label>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label for="pages" class="block text-sm font-bold text-gray-700 mb-2">Halaman</label>
                        <input type="number" name="pages" id="pages" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-unsoed-blue focus:border-unsoed-blue outline-none transition" placeholder="Jml Halaman">
                    </div>
                    <div>
                        <label for="weight" class="block text-sm font-bold text-gray-700 mb-2">Berat</label>
                        <input type="number" name="weight" id="weight" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-unsoed-blue focus:border-unsoed-blue outline-none transition" placeholder="Gram">
                    </div>
                    <div>
                        <label for="publication_year" class="block text-sm font-bold text-gray-700 mb-2">Tahun Terbit</label>
                        <input type="number" name="publication_year" id="publication_year" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-unsoed-blue focus:border-unsoed-blue outline-none transition" placeholder="YYYY">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Upload Sampul Buku</label>
                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:bg-gray-50 transition cursor-pointer relative overflow-hidden min-h-[160px] flex items-center justify-center" onclick="document.getElementById('image').click()">
                        <div id="upload_placeholder">
                            <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-2"></i>
                            <p class="text-sm text-gray-500 font-medium">Klik untuk memilih file gambar</p>
                            <p class="text-xs text-gray-400 mt-1">Format: JPG, PNG (Maks 5MB)</p>
                        </div>
                        <img id="image_preview" src="" class="hidden absolute inset-0 w-full h-full object-contain bg-white">
                        <input type="file" name="image" id="image" class="hidden" accept="image/*" onchange="previewImage(this)">
                    </div>
                </div>
                
                <script>
                    function previewImage(input) {
                        const preview = document.getElementById('image_preview');
                        const placeholder = document.getElementById('upload_placeholder');
                        if (input.files && input.files[0]) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                preview.src = e.target.result;
                                preview.classList.remove('hidden');
                                placeholder.classList.add('hidden');
                            }
                            reader.readAsDataURL(input.files[0]);
                        } else {
                            preview.src = "";
                            preview.classList.add('hidden');
                            placeholder.classList.remove('hidden');
                        }
                    }
                </script>
            </div>
        </div>

        <div class="flex justify-end border-t border-gray-100 pt-6 mt-6">
            <button type="submit" class="bg-unsoed-blue text-white px-8 py-3 rounded-lg font-bold hover:bg-unsoed-darkblue transition shadow-lg flex items-center gap-2">
                <i class="fas fa-save"></i> Simpan Buku
            </button>
        </div>
    </form>
</div>
