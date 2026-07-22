<div class="p-6 md:p-10">
    <!-- Header -->
    <div class="flex items-center gap-4 mb-8">
        <a href="<?= BASEURL; ?>/admin/categories" class="w-10 h-10 bg-white border border-gray-200 rounded-xl flex items-center justify-center text-gray-500 hover:bg-gray-50 hover:text-unsoed-blue transition-colors">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-1">Edit Kategori</h1>
            <p class="text-gray-500 text-sm">Perbarui informasi kategori atau subkategori.</p>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden max-w-3xl">
        <div class="p-6 md:p-8">
            <form action="<?= BASEURL; ?>/admin/edit_category/<?= esc($data['category']['id']) ?>" method="POST" class="space-y-6">
<?= csrf_field() ?><div>
                    <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Nama Kategori <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" value="<?= esc($data['category']['name']) ?>" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-unsoed-blue/30 focus:border-unsoed-blue transition-all" required>
                    <p class="text-xs text-gray-400 mt-2"><i class="fas fa-info-circle mr-1"></i> Slug saat ini: <code><?= esc($data['category']['slug']) ?></code> (akan diperbarui otomatis)</p>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-3">Tipe Kategori <span class="text-red-500">*</span></label>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <label class="flex items-center gap-2 cursor-pointer bg-gray-50 px-4 py-3 border border-gray-200 rounded-xl flex-1 hover:border-unsoed-blue transition-colors">
                            <input type="radio" name="category_type" value="main" class="text-unsoed-blue focus:ring-unsoed-blue w-4 h-4" <?= is_null($data['category']['parent_id']) ? 'checked' : '' ?> onclick="toggleParentSelect()">
                            <span class="font-medium text-gray-700">Kategori Utama</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer bg-gray-50 px-4 py-3 border border-gray-200 rounded-xl flex-1 hover:border-unsoed-blue transition-colors">
                            <input type="radio" name="category_type" value="sub" class="text-unsoed-blue focus:ring-unsoed-blue w-4 h-4" <?= !is_null($data['category']['parent_id']) ? 'checked' : '' ?> onclick="toggleParentSelect()">
                            <span class="font-medium text-gray-700">Sub-Kategori</span>
                        </label>
                    </div>
                </div>

                <div id="parent_select_container" class="<?= is_null($data['category']['parent_id']) ? 'hidden' : '' ?> transition-all duration-300">
                    <label for="parent_id" class="block text-sm font-bold text-gray-700 mb-2">Pilih Kategori Utama (Induk) <span class="text-red-500">*</span></label>
                    <select name="parent_id" id="parent_id" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-unsoed-blue/30 focus:border-unsoed-blue transition-all" <?= !is_null($data['category']['parent_id']) ? 'required' : '' ?>>
                        <option value="">-- Pilih Induk Kategori --</option>
                        <?php foreach($data['parent_categories'] as $parent): ?>
                            <?php 
                                // Jangan tampilkan diri sendiri sebagai parent, dan hanya tampilkan root category
                                if(is_null($parent['parent_id']) && $parent['id'] != $data['category']['id']): 
                            ?>
                                <option value="<?= esc($parent['id']) ?>" <?= ($data['category']['parent_id'] == $parent['id']) ? 'selected' : '' ?>>
                                    <?= esc($parent['name']) ?>
                                </option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>

                <script>
                    function toggleParentSelect() {
                        const type = document.querySelector('input[name="category_type"]:checked').value;
                        const container = document.getElementById('parent_select_container');
                        const select = document.getElementById('parent_id');
                        
                        if(type === 'sub') {
                            container.classList.remove('hidden');
                            select.setAttribute('required', 'required');
                        } else {
                            container.classList.add('hidden');
                            select.removeAttribute('required');
                            select.value = '';
                        }
                    }
                </script>

                <div class="pt-6 border-t border-gray-100 flex justify-end gap-3">
                    <a href="<?= BASEURL; ?>/admin/categories" class="px-6 py-3 bg-gray-100 text-gray-600 rounded-xl font-bold hover:bg-gray-200 transition-colors">Batal</a>
                    <button type="submit" class="px-8 py-3 bg-unsoed-yellow text-white rounded-xl font-bold shadow-lg shadow-unsoed-yellow/30 hover:-translate-y-1 hover:shadow-xl transition-all duration-300 flex items-center gap-2">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= csrf_field() ?>
