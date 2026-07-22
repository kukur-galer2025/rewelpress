<div class="p-6 md:p-10">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-1">Kelola Kategori</h1>
            <p class="text-gray-500 text-sm">Manajemen hirarki kategori dan subkategori buku.</p>
        </div>
        <a href="<?= BASEURL; ?>/admin/create_category" class="bg-unsoed-yellow text-white px-6 py-2.5 rounded-xl font-bold hover:bg-yellow-500 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 flex items-center gap-2">
            <i class="fas fa-plus"></i> Tambah Kategori
        </a>
    </div>

    <!-- Alerts handled globally via Toast -->

    <!-- Info Super Sale / Promo -->
    <div class="bg-gradient-to-r from-red-50 to-orange-50 border border-red-100 rounded-2xl p-5 mb-8 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-red-500 text-white rounded-xl flex items-center justify-center text-xl font-bold flex-shrink-0 shadow-md">
                <i class="fas fa-bolt animate-bounce"></i>
            </div>
            <div>
                <h4 class="font-bold text-gray-800 text-base">Menu Khusus: SUPER SALE (Flash Sale)</h4>
                <p class="text-xs text-gray-600 mt-0.5">Super Sale adalah <strong class="text-red-600">Fitur Diskon Dinamis</strong> (bukan kategori subjek buku). Buku dari kategori manapun yang memiliki <strong>Harga Coret &gt; Harga Jual</strong> akan otomatis masuk ke halaman Super Sale di Homepage!</p>
            </div>
        </div>
        <a href="<?= BASEURL; ?>/admin/books" class="px-4 py-2 bg-red-500 text-white text-xs font-bold rounded-xl hover:bg-red-600 transition shadow-sm flex-shrink-0 flex items-center gap-1.5">
            <i class="fas fa-tags"></i> Atur Harga Coret Buku
        </a>
    </div>

    <!-- Category Tree -->
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4 border-b border-gray-100 pb-3">Struktur Kategori</h3>
            
            <?php if(empty($data['categories'])): ?>
                <div class="text-center py-12">
                    <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-tags text-3xl text-gray-300"></i>
                    </div>
                    <p class="text-gray-500 font-medium">Belum ada kategori.</p>
                </div>
            <?php else: ?>
                <div class="space-y-3">
                    <?php foreach($data['categories'] as $cat): ?>
                        <div class="bg-gray-50 rounded-xl p-4 border border-gray-100 flex flex-col md:flex-row justify-between items-start md:items-center group hover:bg-white hover:border-unsoed-blue/30 hover:shadow-md transition-all">
                            <div class="flex items-center gap-3 mb-3 md:mb-0">
                                <div class="w-10 h-10 bg-unsoed-blue/10 text-unsoed-blue rounded-lg flex items-center justify-center font-bold">
                                    <i class="fas fa-folder"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-800 text-lg"><?= esc($cat['name']) ?></h4>
                                    <span class="text-xs text-gray-500 font-medium font-mono"><?= esc($cat['slug']) ?></span>
                                </div>
                            </div>
                            <div class="flex gap-2 w-full md:w-auto justify-end">
                                <a href="<?= BASEURL; ?>/admin/edit_category/<?= esc($cat['id']) ?>" class="px-3 py-1.5 bg-blue-50 text-unsoed-blue text-sm rounded-lg hover:bg-unsoed-blue hover:text-white transition-colors">
                                    <i class="fas fa-edit mr-1"></i> Edit
                                </a>
                                <a href="<?= BASEURL; ?>/admin/delete_category/<?= esc($cat['id']) ?>" onclick="return confirmAction(this.href, 'Hapus Kategori', 'Yakin ingin menghapus kategori ini dan seluruh subkategorinya?');" class="px-3 py-1.5 bg-red-50 text-red-500 text-sm rounded-lg hover:bg-red-500 hover:text-white transition-colors">
                                    <i class="fas fa-trash-alt mr-1"></i> Hapus
                                </a>
                            </div>
                        </div>

                        <!-- Subcategories -->
                        <?php if(!empty($cat['children'])): ?>
                            <div class="pl-8 md:pl-16 space-y-2 mt-2 mb-4 relative">
                                <!-- Connecting Line -->
                                <div class="absolute left-6 md:left-10 top-0 bottom-6 w-px bg-gray-200"></div>
                                
                                <?php foreach($cat['children'] as $child): ?>
                                    <div class="relative bg-white rounded-xl p-3 border border-gray-100 flex flex-col md:flex-row justify-between items-start md:items-center group hover:border-unsoed-yellow/50 transition-all">
                                        <!-- Horizontal Line -->
                                        <div class="absolute -left-6 w-6 top-1/2 h-px bg-gray-200"></div>
                                        
                                        <div class="flex items-center gap-3 mb-2 md:mb-0">
                                            <div class="w-8 h-8 bg-unsoed-yellow/10 text-unsoed-yellow rounded-md flex items-center justify-center text-sm">
                                                <i class="fas fa-tag"></i>
                                            </div>
                                            <div>
                                                <h5 class="font-bold text-gray-700"><?= esc($child['name']) ?></h5>
                                                <span class="text-[10px] text-gray-400 font-mono"><?= esc($child['slug']) ?></span>
                                            </div>
                                        </div>
                                        <div class="flex gap-2">
                                            <a href="<?= BASEURL; ?>/admin/edit_category/<?= esc($child['id']) ?>" class="text-xs text-gray-400 hover:text-unsoed-blue transition-colors px-2 py-1"><i class="fas fa-edit"></i></a>
                                            <a href="<?= BASEURL; ?>/admin/delete_category/<?= esc($child['id']) ?>" onclick="return confirmAction(this.href, 'Hapus Sub-Kategori', 'Yakin ingin menghapus sub-kategori ini?');" class="text-xs text-gray-400 hover:text-red-500 transition-colors px-2 py-1"><i class="fas fa-trash"></i></a>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
