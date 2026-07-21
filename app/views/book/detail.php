<!-- Breadcrumb -->
<div class="bg-white border-b border-gray-200 py-3">
    <div class="container mx-auto px-4">
        <div class="flex text-sm text-gray-500">
            <a href="<?= BASEURL; ?>" class="hover:text-unsoed-blue transition">Beranda</a>
            <span class="mx-2">/</span>
            <?php if(!empty($data['buku']['parent_category_name'])): ?>
                <span class="hover:text-unsoed-blue transition"><?= $data['buku']['parent_category_name'] ?></span>
                <span class="mx-2">/</span>
            <?php endif; ?>
            <a href="<?= BASEURL; ?>/book/category/<?= $data['buku']['category_id'] ?>" class="hover:text-unsoed-blue transition"><?= $data['buku']['category_name'] ?></a>
            <span class="mx-2">/</span>
            <span class="text-gray-800 font-medium truncate"><?= $data['buku']['title'] ?></span>
        </div>
    </div>
</div>

<section class="py-12 bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4">
        <div class="glass rounded-3xl p-6 md:p-10 shadow-xl border border-white">
            <div class="flex flex-col md:flex-row gap-12">
                
                <!-- Book Image (Left) -->
                <div class="md:w-1/3">
                    <div class="relative group perspective-1000">
                        <div class="absolute inset-0 bg-unsoed-yellow/20 blur-2xl rounded-3xl transform group-hover:scale-105 transition duration-500"></div>
                        <div class="relative bg-white p-4 rounded-2xl shadow-card border border-gray-100 transform transition-transform duration-500 group-hover:-translate-y-2 group-hover:rotate-2">
                            <?php 
                                $discount = 0;
                                if($data['buku']['old_price'] > $data['buku']['price']) {
                                    $discount = round((($data['buku']['old_price'] - $data['buku']['price']) / $data['buku']['old_price']) * 100);
                                }
                            ?>
                            <?php if($discount > 0): ?>
                            <div class="absolute top-0 right-0 z-20 w-16 h-16 bg-red-500 text-white rounded-bl-3xl rounded-tr-xl flex flex-col items-center justify-center font-bold text-sm shadow-lg transform translate-x-2 -translate-y-2">
                                <span><?= $discount ?>%</span>
                                <span class="text-[10px] uppercase">OFF</span>
                            </div>
                            <?php endif; ?>
                            
                            <?php $img_src = !empty($data['buku']['image']) ? $data['buku']['image'] : 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?auto=format&fit=crop&q=80&w=400'; ?>
                            <img src="<?= $img_src ?>" alt="<?= $data['buku']['title'] ?>" class="w-full h-auto rounded-xl object-cover aspect-[3/4]">
                        </div>
                    </div>
                </div>

                <!-- Book Details (Right) -->
                <div class="md:w-2/3 flex flex-col">
                    <div class="mb-6">
                        <span class="inline-block py-1 px-3 rounded-full bg-unsoed-blue/10 text-unsoed-blue text-xs font-bold tracking-widest uppercase mb-4">
                            <?= !empty($data['buku']['parent_category_name']) ? $data['buku']['parent_category_name'] . ' &bull; ' : '' ?><?= $data['buku']['category_name'] ?>
                        </span>
                        <h1 class="text-3xl md:text-5xl font-serif font-bold text-gray-900 leading-tight mb-4">
                            <?= $data['buku']['title'] ?>
                        </h1>
                        <p class="text-lg text-gray-600 font-medium">Penulis: <span class="text-unsoed-blue"><?= $data['buku']['author'] ?></span></p>
                    </div>

                    <div class="mb-8">
                        <div class="flex items-end gap-4 mb-2">
                            <span class="text-4xl font-extrabold text-unsoed-blue">Rp <?= number_format($data['buku']['price'], 0, ',', '.') ?></span>
                            <?php if($data['buku']['old_price'] > 0): ?>
                                <span class="text-xl text-gray-400 line-through mb-1">Rp <?= number_format($data['buku']['old_price'], 0, ',', '.') ?></span>
                            <?php endif; ?>
                        </div>
                        <p class="text-sm text-green-600 font-medium"><i class="fas fa-check-circle mr-1"></i> Stok Tersedia</p>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-wrap gap-4 mb-10 pb-10 border-b border-gray-200">
                        <form action="<?= BASEURL; ?>/cart/add/<?= $data['buku']['id'] ?>" method="POST" class="flex items-center gap-4">
                            <div class="flex items-center border border-gray-300 rounded-full bg-white px-2 py-1 h-12 w-32">
                                <button type="button" class="w-8 h-8 rounded-full hover:bg-gray-100 flex items-center justify-center text-gray-600 transition" onclick="document.getElementById('qty').value = Math.max(1, parseInt(document.getElementById('qty').value) - 1)">
                                    <i class="fas fa-minus text-xs"></i>
                                </button>
                                <input type="number" name="qty" id="qty" value="1" min="1" class="w-10 text-center font-bold text-gray-800 bg-transparent outline-none appearance-none">
                                <button type="button" class="w-8 h-8 rounded-full hover:bg-gray-100 flex items-center justify-center text-gray-600 transition" onclick="document.getElementById('qty').value = parseInt(document.getElementById('qty').value) + 1">
                                    <i class="fas fa-plus text-xs"></i>
                                </button>
                            </div>
                            <button type="submit" class="h-12 bg-unsoed-blue text-white px-8 rounded-full font-semibold shadow-lg shadow-unsoed-blue/30 hover:-translate-y-1 hover:shadow-xl hover:bg-unsoed-darkblue transition-all duration-300 flex items-center gap-2">
                                <i class="fas fa-shopping-cart"></i> Tambah ke Keranjang
                            </button>
                        </form>
                    </div>

                    <!-- Tabs Information -->
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 mb-4 border-l-4 border-unsoed-yellow pl-3">Sinopsis & Spesifikasi</h3>
                        <p class="text-gray-600 leading-relaxed mb-6">
                            <?php if(!empty($data['buku']['synopsis'])): ?>
                                <?= nl2br(htmlspecialchars($data['buku']['synopsis'])) ?>
                            <?php else: ?>
                                Buku <strong><?= $data['buku']['title'] ?></strong> karya <?= $data['buku']['author'] ?> ini merupakan literatur penting di bidang <?= $data['buku']['category_name'] ?>. 
                                Disusun secara komprehensif berdasarkan riset terbaru, buku ini ditujukan bagi mahasiswa, praktisi, dan akademisi yang ingin memperdalam pengetahuan mereka.
                            <?php endif; ?>
                        </p>
                        
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 bg-gray-50 rounded-2xl p-6 border border-gray-100">
                            <div>
                                <span class="block text-xs text-gray-500 mb-1">ISBN</span>
                                <span class="font-semibold text-gray-800 text-sm"><?= !empty($data['buku']['isbn']) ? $data['buku']['isbn'] : '-' ?></span>
                            </div>
                            <div>
                                <span class="block text-xs text-gray-500 mb-1">Tahun Terbit</span>
                                <span class="font-semibold text-gray-800 text-sm"><?= !empty($data['buku']['publication_year']) ? $data['buku']['publication_year'] : date('Y', strtotime($data['buku']['created_at'])) ?></span>
                            </div>
                            <div>
                                <span class="block text-xs text-gray-500 mb-1">Halaman</span>
                                <span class="font-semibold text-gray-800 text-sm"><?= !empty($data['buku']['pages']) ? $data['buku']['pages'] . ' Halaman' : '-' ?></span>
                            </div>
                            <div>
                                <span class="block text-xs text-gray-500 mb-1">Berat</span>
                                <span class="font-semibold text-gray-800 text-sm"><?= !empty($data['buku']['weight']) ? $data['buku']['weight'] . ' Gram' : '-' ?></span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
