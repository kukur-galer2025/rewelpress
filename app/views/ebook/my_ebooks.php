<!-- Breadcrumb -->
<div class="bg-gray-50 py-4 border-b border-gray-100">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center text-sm text-gray-500">
            <a href="<?= BASEURL; ?>" class="hover:text-unsoed-blue transition"><i class="fas fa-home"></i></a>
            <span class="mx-2"><i class="fas fa-chevron-right text-[10px]"></i></span>
            <a href="<?= BASEURL; ?>/user/profile" class="hover:text-unsoed-blue transition">Akun Saya</a>
            <span class="mx-2"><i class="fas fa-chevron-right text-[10px]"></i></span>
            <span class="text-gray-800 font-medium">E-Book Saya</span>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-10 min-h-[60vh]">
    <div class="flex flex-col lg:flex-row gap-8">
        
        <!-- Sidebar Menu -->
        <div class="lg:w-1/4">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-24">
                <div class="flex items-center gap-4 mb-6 pb-6 border-b border-gray-100">
                    <div class="w-16 h-16 rounded-full bg-unsoed-blue/10 flex items-center justify-center text-unsoed-blue text-2xl font-bold">
                        <?= strtoupper(substr($_SESSION['user_name'], 0, 1)) ?>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800"><?= esc($_SESSION['user_name']) ?></h3>
                        <p class="text-xs text-gray-500">Member Unsoed Press</p>
                    </div>
                </div>
                
                <nav class="space-y-2">
                    <a href="<?= BASEURL; ?>/user/profile" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-600 hover:bg-gray-50 hover:text-unsoed-blue transition-colors font-medium">
                        <i class="fas fa-user w-5 text-center"></i> Profil Saya
                    </a>
                    <a href="<?= BASEURL; ?>/order" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-600 hover:bg-gray-50 hover:text-unsoed-blue transition-colors font-medium">
                        <i class="fas fa-shopping-bag w-5 text-center"></i> Riwayat Pesanan
                    </a>
                    <a href="<?= BASEURL; ?>/ebook/my_ebooks" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-unsoed-blue/5 text-unsoed-blue font-bold transition-colors">
                        <i class="fas fa-tablet-alt w-5 text-center"></i> E-Book Saya
                    </a>
                    <div class="pt-4 mt-4 border-t border-gray-100">
                        <a href="<?= BASEURL; ?>/auth/logout" class="flex items-center gap-3 px-4 py-3 rounded-xl text-red-500 hover:bg-red-50 transition-colors font-medium">
                            <i class="fas fa-sign-out-alt w-5 text-center"></i> Keluar
                        </a>
                    </div>
                </nav>
            </div>
        </div>

        <!-- E-book List -->
        <div class="lg:w-3/4">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                            <i class="fas fa-book-reader text-unsoed-blue"></i> Rak E-Book Saya
                        </h2>
                        <p class="text-sm text-gray-500 mt-1">Koleksi publikasi digital dan e-book berbayar yang Anda miliki.</p>
                    </div>
                </div>

                <?php if(empty($data['my_ebooks'])): ?>
                    <div class="text-center py-16 bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                        <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm">
                            <i class="fas fa-folder-open text-3xl text-gray-300"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-700 mb-2">Rak E-Book Kosong</h3>
                        <p class="text-gray-500 mb-6 max-w-md mx-auto text-sm">Anda belum memiliki koleksi E-Book. Yuk, jelajahi katalog kami dan temukan berbagai bacaan menarik!</p>
                        <a href="<?= BASEURL; ?>/ebook" class="inline-flex items-center justify-center px-6 py-3 bg-unsoed-blue text-white rounded-xl font-bold hover:bg-unsoed-darkblue hover:shadow-lg transition-all gap-2">
                            <i class="fas fa-search"></i> Jelajahi Katalog
                        </a>
                    </div>
                <?php else: ?>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        <?php foreach($data['my_ebooks'] as $ebook): ?>
                            <div class="bg-white border border-gray-100 rounded-2xl p-4 flex flex-col hover:shadow-xl transition-all duration-300 group">
                                <div class="relative w-full aspect-[3/4] bg-gray-100 rounded-xl overflow-hidden mb-4">
                                    <?php $img_src = !empty($ebook['cover_image']) ? $ebook['cover_image'] : 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?auto=format&fit=crop&q=80&w=400'; ?>
                                    <img src="<?= esc($img_src) ?>" alt="<?= esc($ebook['title']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-4">
                                        <a href="<?= BASEURL; ?>/ebook/download/<?= esc($ebook['id']) ?>" class="w-full text-center px-4 py-2 bg-unsoed-yellow text-white font-bold rounded-lg hover:bg-yellow-500 transition shadow-lg flex items-center justify-center gap-2">
                                            <i class="fas fa-cloud-download-alt"></i> Unduh
                                        </a>
                                    </div>
                                </div>
                                <div class="flex-grow flex flex-col">
                                    <span class="text-[10px] text-unsoed-blue font-bold uppercase tracking-wider mb-1 line-clamp-1">
                                        <?= esc($ebook['category_name']) ?>
                                    </span>
                                    <h3 class="font-bold text-gray-800 text-sm leading-snug mb-2 line-clamp-2" title="<?= esc($ebook['title']) ?>">
                                        <?= esc($ebook['title']) ?>
                                    </h3>
                                    <p class="text-xs text-gray-500 mt-auto"><i class="fas fa-pen-nib mr-1 text-gray-300"></i> <?= esc($ebook['author']) ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>
