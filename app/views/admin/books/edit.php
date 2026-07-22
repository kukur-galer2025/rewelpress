<div class="mb-8 flex items-center justify-between">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Edit Buku</h1>
        <p class="text-gray-500 mt-1">Perbarui detail informasi buku.</p>
    </div>
    <a href="<?= BASEURL; ?>/admin/books" class="text-gray-500 hover:text-unsoed-blue transition font-semibold flex items-center gap-2">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
    <form action="<?= BASEURL; ?>/admin/edit_book/<?= $data['buku']['id'] ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
        <input type="hidden" name="old_image" value="<?= $data['buku']['image'] ?>">
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Left Col -->
            <div class="space-y-6">
                <div>
                    <label for="title" class="block text-sm font-bold text-gray-700 mb-2">Judul Buku <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="title" value="<?= $data['buku']['title'] ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-unsoed-blue focus:border-unsoed-blue outline-none transition" required>
                </div>
                
                <div>
                    <label for="author" class="block text-sm font-bold text-gray-700 mb-2">Penulis <span class="text-red-500">*</span></label>
                    <input type="text" name="author" id="author" value="<?= $data['buku']['author'] ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-unsoed-blue focus:border-unsoed-blue outline-none transition" required>
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
                    const currentCategoryId = <?= $data['buku']['category_id'] ?>;

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
                </script>

                <div>
                    <label for="isbn" class="block text-sm font-bold text-gray-700 mb-2">ISBN</label>
                    <input type="text" name="isbn" id="isbn" value="<?= $data['buku']['isbn'] ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-unsoed-blue focus:border-unsoed-blue outline-none transition">
                </div>
                
                <div>
                    <label for="synopsis" class="block text-sm font-bold text-gray-700 mb-2">Sinopsis Buku</label>
                    <textarea name="synopsis" id="synopsis" rows="5" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-unsoed-blue focus:border-unsoed-blue outline-none transition resize-none"><?= htmlspecialchars($data['buku']['synopsis']) ?></textarea>
                </div>
            </div>

            <!-- Right Col -->
            <div class="space-y-6">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="price" class="block text-sm font-bold text-gray-700 mb-2">Harga Jual (Rp) <span class="text-red-500">*</span></label>
                        <input type="number" name="price" id="price" value="<?= $data['buku']['price'] ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-unsoed-blue focus:border-unsoed-blue outline-none transition" required>
                    </div>
                    <div>
                        <label for="old_price" class="block text-sm font-bold text-gray-700 mb-1 flex items-center justify-between">
                            <span>Harga Coret (Opsional)</span>
                            <span class="text-[10px] bg-red-500 text-white px-1.5 py-0.5 rounded font-bold">PROMO</span>
                        </label>
                        <input type="number" name="old_price" id="old_price" value="<?= $data['buku']['old_price'] ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-unsoed-blue focus:border-unsoed-blue outline-none transition" placeholder="Rp">
                        <p class="text-[11px] text-red-500 mt-1 font-medium"><i class="fas fa-bolt mr-0.5"></i> Isi lebih besar dari Harga Jual untuk otomatis tampil di menu SUPER SALE!</p>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label for="pages" class="block text-sm font-bold text-gray-700 mb-2">Halaman</label>
                        <input type="number" name="pages" id="pages" value="<?= $data['buku']['pages'] ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-unsoed-blue focus:border-unsoed-blue outline-none transition" placeholder="Jml Halaman">
                    </div>
                    <div>
                        <label for="weight" class="block text-sm font-bold text-gray-700 mb-2">Berat</label>
                        <input type="number" name="weight" id="weight" value="<?= $data['buku']['weight'] ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-unsoed-blue focus:border-unsoed-blue outline-none transition" placeholder="Gram">
                    </div>
                    <div>
                        <label for="publication_year" class="block text-sm font-bold text-gray-700 mb-2">Tahun Terbit</label>
                        <input type="number" name="publication_year" id="publication_year" value="<?= $data['buku']['publication_year'] ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-unsoed-blue focus:border-unsoed-blue outline-none transition" placeholder="YYYY">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Gambar Sampul Saat Ini</label>
                    <?php if(!empty($data['buku']['image'])): ?>
                        <img id="current_image" src="<?= $data['buku']['image'] ?>" class="h-32 object-contain mb-4 rounded border border-gray-200">
                    <?php else: ?>
                        <p id="no_image_text" class="text-sm text-gray-500 mb-4">Belum ada gambar.</p>
                        <img id="current_image" src="" class="hidden h-32 object-contain mb-4 rounded border border-gray-200">
                    <?php endif; ?>
                    
                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:bg-gray-50 transition cursor-pointer relative" onclick="document.getElementById('image').click()">
                        <i class="fas fa-image text-2xl text-gray-400 mb-2"></i>
                        <p class="text-sm text-gray-500 font-medium">Pilih file baru untuk mengganti</p>
                        <p class="text-xs text-gray-400 mt-1">Format: JPG, PNG (Maks 5MB)</p>
                        <input type="file" name="image" id="image" class="hidden" accept="image/*" onchange="previewImage(this)">
                    </div>
                </div>
                
                <script>
                    function previewImage(input) {
                        const preview = document.getElementById('current_image');
                        const noImageText = document.getElementById('no_image_text');
                        
                        if (input.files && input.files[0]) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                preview.src = e.target.result;
                                preview.classList.remove('hidden');
                                if(noImageText) noImageText.classList.add('hidden');
                            }
                            reader.readAsDataURL(input.files[0]);
                        }
                    }
                </script>
            </div>
        </div>

        <div class="flex justify-end border-t border-gray-100 pt-6 mt-6">
            <button type="submit" class="bg-unsoed-yellow text-white px-8 py-3 rounded-lg font-bold hover:bg-yellow-500 transition shadow-lg flex items-center gap-2">
                <i class="fas fa-save"></i> Perbarui Data
            </button>
        </div>
    </form>
</div>
