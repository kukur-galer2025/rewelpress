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
            <a href="<?= BASEURL; ?>/book/category/<?= $data['buku']['category_slug'] ?>" class="hover:text-unsoed-blue transition"><?= $data['buku']['category_name'] ?></a>
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
                        <p class="text-lg text-gray-600 font-medium flex flex-wrap items-center gap-1">
                            <span>Penulis:</span> 
                            <?php 
                            // Split by semicolon OR comma if semicolon doesn't exist (for backward compatibility)
                            $delimiter = strpos($data['buku']['author'], ';') !== false ? ';' : (strpos($data['buku']['author'], ', ') !== false ? ',' : ';');
                            $authors = array_map('trim', explode($delimiter, $data['buku']['author']));
                            $authorLinks = [];
                            foreach ($authors as $author) {
                                $authorLinks[] = '<a href="' . BASEURL . '/penulis/detail/' . urlencode($author) . '" class="text-unsoed-blue hover:text-unsoed-yellow hover:underline font-bold transition">' . htmlspecialchars($author) . '</a>';
                            }
                            echo implode('<span class="text-gray-400">,</span> ', $authorLinks);
                            ?>
                        </p>
                    </div>

                    <div class="mb-8">
                        <div class="flex items-end gap-4 mb-2">
                            <span class="text-4xl font-extrabold text-unsoed-blue">Rp <?= number_format($data['buku']['price'], 0, ',', '.') ?></span>
                            <?php if($data['buku']['old_price'] > 0): ?>
                                <span class="text-xl text-red-500 line-through mb-1">Rp <?= number_format($data['buku']['old_price'], 0, ',', '.') ?></span>
                            <?php endif; ?>
                        </div>
                        <p class="text-sm text-green-600 font-medium"><i class="fas fa-check-circle mr-1"></i> Stok Tersedia</p>
                    </div>

                    <!-- Action Buttons -->
                    <?php if(isset($_GET['error']) && $_GET['error'] == 'stock'): ?>
                    <div class="mb-4 bg-red-100 border border-red-200 text-red-600 px-4 py-3 rounded-2xl shadow-sm text-sm font-bold flex items-center gap-2.5">
                        <i class="fas fa-exclamation-circle text-lg"></i> Gagal menambahkan: Kuantitas melebihi sisa stok yang tersedia.
                    </div>
                    <?php endif; ?>
                    <div class="flex flex-wrap gap-4 mb-10 pb-10 border-b border-gray-200">
                        <form action="<?= BASEURL; ?>/cart/add/<?= $data['buku']['id'] ?>" method="POST" class="flex items-center gap-4">
                            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                            <div class="flex items-center border border-gray-300 rounded-full bg-white px-2 py-1 h-12 w-32">
                                <button type="button" class="w-8 h-8 rounded-full hover:bg-gray-100 flex items-center justify-center text-gray-600 transition" onclick="document.getElementById('qty').value = Math.max(1, parseInt(document.getElementById('qty').value) - 1)">
                                    <i class="fas fa-minus text-xs"></i>
                                </button>
                                <input type="number" name="qty" id="qty" value="1" min="1" max="<?= $data['buku']['stock'] ?>" class="w-10 text-center font-bold text-gray-800 bg-transparent outline-none appearance-none">
                                <button type="button" class="w-8 h-8 rounded-full hover:bg-gray-100 flex items-center justify-center text-gray-600 transition" onclick="let inp=document.getElementById('qty'); if(parseInt(inp.value) < <?= $data['buku']['stock'] ?>) { inp.value = parseInt(inp.value) + 1; } else { alert('Maksimal stok yang tersedia adalah <?= $data['buku']['stock'] ?>'); }">
                                    <i class="fas fa-plus text-xs"></i>
                                </button>
                            </div>
                            <button type="submit" class="h-12 bg-unsoed-blue text-white px-8 rounded-full font-semibold shadow-lg shadow-unsoed-blue/30 hover:-translate-y-1 hover:shadow-xl hover:bg-unsoed-darkblue transition-all duration-300 flex items-center gap-2">
                                <i class="fas fa-shopping-cart"></i> Tambah ke Keranjang
                            </button>
                        </form>
                    </div>

                    <!-- Tabs Information -->
                    <div class="mt-8 pt-8 border-t border-gray-200">
                        <h3 class="text-2xl font-serif font-bold text-gray-900 mb-6 border-l-4 border-unsoed-yellow pl-4">Sinopsis Buku</h3>
                        <div class="prose prose-blue max-w-none text-gray-600 leading-relaxed mb-10 text-justify">
                            <?php if(!empty($data['buku']['synopsis'])): ?>
                                <?= nl2br(htmlspecialchars($data['buku']['synopsis'])) ?>
                            <?php else: ?>
                                <p>Buku <strong><?= $data['buku']['title'] ?></strong> karya <?= $data['buku']['author'] ?> ini merupakan literatur penting di bidang <?= $data['buku']['category_name'] ?>. Disusun secara komprehensif berdasarkan riset terbaru, buku ini ditujukan bagi mahasiswa, praktisi, dan akademisi yang ingin memperdalam pengetahuan mereka.</p>
                            <?php endif; ?>
                        </div>
                        
                        <h3 class="text-2xl font-serif font-bold text-gray-900 mb-6 border-l-4 border-unsoed-yellow pl-4">Detail Spesifikasi</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <!-- Left Col -->
                            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] hover:shadow-[0_8px_30px_-4px_rgba(0,0,0,0.1)] transition-shadow duration-300 space-y-4">
                                <div class="flex justify-between items-center border-b border-gray-50 pb-3 group">
                                    <span class="text-gray-500 font-medium flex items-center gap-2"><i class="fas fa-building text-unsoed-blue/70 w-5"></i> Penerbit</span>
                                    <span class="text-gray-900 font-bold text-right ml-4 group-hover:text-unsoed-blue transition-colors">Unsoed Press</span>
                                </div>
                                <div class="flex justify-between items-center border-b border-gray-50 pb-3 group">
                                    <span class="text-gray-500 font-medium flex items-center gap-2"><i class="fas fa-calendar-alt text-unsoed-blue/70 w-5"></i> Tahun Terbit</span>
                                    <span class="text-gray-900 font-bold text-right ml-4 group-hover:text-unsoed-blue transition-colors"><?= !empty($data['buku']['publication_year']) ? $data['buku']['publication_year'] : date('Y', strtotime($data['buku']['created_at'])) ?></span>
                                </div>
                                <div class="flex justify-between items-center pb-1 group">
                                    <span class="text-gray-500 font-medium flex items-center gap-2"><i class="fas fa-barcode text-unsoed-blue/70 w-5"></i> ISBN</span>
                                    <span class="text-gray-900 font-bold text-right ml-4 group-hover:text-unsoed-blue transition-colors"><?= !empty($data['buku']['isbn']) ? $data['buku']['isbn'] : '-' ?></span>
                                </div>
                            </div>
                            
                            <!-- Right Col -->
                            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] hover:shadow-[0_8px_30px_-4px_rgba(0,0,0,0.1)] transition-shadow duration-300 space-y-4">
                                <div class="flex justify-between items-center border-b border-gray-50 pb-3 group">
                                    <span class="text-gray-500 font-medium flex items-center gap-2"><i class="fas fa-file-alt text-unsoed-blue/70 w-5"></i> Hal & Bahasa</span>
                                    <span class="text-gray-900 font-bold text-right ml-4 group-hover:text-unsoed-blue transition-colors">
                                        <?= !empty($data['buku']['pages']) ? $data['buku']['pages'] . ' hal' : '-' ?> 
                                        <?= !empty($data['buku']['language']) ? ' <span class="text-gray-300">&bull;</span> ' . $data['buku']['language'] : '' ?>
                                    </span>
                                </div>
                                <div class="flex justify-between items-center border-b border-gray-50 pb-3 group">
                                    <span class="text-gray-500 font-medium flex items-center gap-2"><i class="fas fa-weight-hanging text-unsoed-blue/70 w-5"></i> Dimensi & Berat</span>
                                    <span class="text-gray-900 font-bold text-right ml-4 group-hover:text-unsoed-blue transition-colors">
                                        <?= !empty($data['buku']['dimensions']) ? $data['buku']['dimensions'] : '-' ?> 
                                        <?= !empty($data['buku']['weight']) ? ' <span class="text-gray-300">&bull;</span> ' . $data['buku']['weight'] . ' gr' : '' ?>
                                    </span>
                                </div>
                                <div class="flex justify-between items-center pb-1 group">
                                    <span class="text-gray-500 font-medium flex items-center gap-2"><i class="fas fa-layer-group text-unsoed-blue/70 w-5"></i> Kover & Edisi</span>
                                    <span class="text-gray-900 font-bold text-right ml-4 group-hover:text-unsoed-blue transition-colors">
                                        <?= !empty($data['buku']['cover_type']) ? $data['buku']['cover_type'] : '-' ?> 
                                        <?= !empty($data['buku']['edition']) ? ' <span class="text-gray-300">&bull;</span> ' . $data['buku']['edition'] : '' ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Ulasan Produk -->
                    <div class="mt-12 pt-8 border-t border-gray-200">
                        <div class="flex items-center justify-between mb-8">
                            <h3 class="text-2xl font-serif font-bold text-gray-900 border-l-4 border-unsoed-yellow pl-4">Ulasan Pembeli</h3>
                            <div class="flex items-center gap-2">
                                <span class="text-2xl font-bold text-gray-900"><?= number_format($data['buku']['avg_rating'], 1) ?></span>
                                <div class="text-unsoed-yellow text-xl">
                                    <?php
                                    $rating = round($data['buku']['avg_rating']);
                                    for ($i = 1; $i <= 5; $i++) {
                                        if ($i <= $rating) echo '<i class="fas fa-star"></i>';
                                        else echo '<i class="far fa-star"></i>';
                                    }
                                    ?>
                                </div>
                                <span class="text-gray-500 ml-2">(<?= $data['buku']['review_count'] ?> ulasan)</span>
                            </div>
                        </div>

                        <?php if (isset($_SESSION['flash_success'])): ?>
                            <div class="mb-6 p-4 bg-green-50 text-green-700 rounded-xl border border-green-200 flex items-center gap-3">
                                <i class="fas fa-check-circle"></i> <?= $_SESSION['flash_success']; unset($_SESSION['flash_success']); ?>
                            </div>
                        <?php endif; ?>

                        <?php if (isset($_SESSION['review_success'])): ?>
                        <!-- Review Success Modal -->
                        <div id="reviewSuccessModal" class="fixed inset-0 z-[60] overflow-y-auto bg-gray-900/60 backdrop-blur-sm flex items-center justify-center p-4">
                            <div class="bg-white rounded-3xl w-full max-w-sm shadow-2xl overflow-hidden text-center p-8 transform transition-all scale-100 opacity-100 animate-[pulse_0.5s_ease-in-out]">
                                <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-5 border-4 border-white shadow-lg">
                                    <i class="fas fa-check text-4xl text-green-500"></i>
                                </div>
                                <h3 class="text-2xl font-bold text-gray-900 mb-2">Terima Kasih!</h3>
                                <p class="text-gray-500 mb-6"><?= $_SESSION['review_success']; ?></p>
                                <button type="button" onclick="document.getElementById('reviewSuccessModal').classList.add('hidden')" class="w-full btn-primary py-3">Tutup</button>
                            </div>
                        </div>
                        <?php unset($_SESSION['review_success']); ?>
                        <?php endif; ?>
                        <?php if (isset($_SESSION['flash_error'])): ?>
                            <div class="mb-6 p-4 bg-red-50 text-red-700 rounded-xl border border-red-200 flex items-center gap-3">
                                <i class="fas fa-exclamation-circle"></i> <?= $_SESSION['flash_error']; unset($_SESSION['flash_error']); ?>
                            </div>
                        <?php endif; ?>

                        <div class="mb-8">
                            <?php if ($data['can_review']['can_review']): ?>
                                <button onclick="document.getElementById('reviewModal').classList.remove('hidden')" class="btn-primary flex items-center gap-2">
                                    <i class="fas fa-edit"></i> Tulis Ulasan
                                </button>
                            <?php else: ?>
                                <div class="p-4 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-600 flex items-start gap-3">
                                    <i class="fas fa-info-circle text-unsoed-blue mt-0.5"></i>
                                    <p>Anda hanya dapat memberikan ulasan pada produk yang telah Anda beli dan pesanan telah selesai.</p>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="space-y-6">
                            <?php if (empty($data['reviews'])): ?>
                                <p class="text-gray-500 italic text-center py-8">Belum ada ulasan untuk produk ini.</p>
                            <?php else: ?>
                                <?php foreach ($data['reviews'] as $rev): ?>
                                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex gap-4">
                                        <div class="w-12 h-12 rounded-full bg-unsoed-blue text-white flex items-center justify-center font-bold text-xl shrink-0">
                                            <?= strtoupper(substr(htmlspecialchars($rev['user_name']), 0, 1)) ?>
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex justify-between items-start mb-2">
                                                <div>
                                                    <h4 class="font-bold text-gray-900"><?= htmlspecialchars($rev['user_name']) ?></h4>
                                                    <span class="text-xs text-gray-500"><?= date('d M Y', strtotime($rev['created_at'])) ?></span>
                                                </div>
                                                <div class="text-unsoed-yellow text-sm">
                                                    <?php
                                                    for ($i = 1; $i <= 5; $i++) {
                                                        if ($i <= $rev['rating']) echo '<i class="fas fa-star"></i>';
                                                        else echo '<i class="far fa-star"></i>';
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                            <p class="text-gray-700 leading-relaxed"><?= nl2br(htmlspecialchars($rev['comment'])) ?></p>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

<!-- Review Modal -->
<div id="reviewModal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-gray-900/50 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl w-full max-w-md shadow-2xl overflow-hidden transform transition-all">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <h3 class="text-xl font-bold text-gray-900">Tulis Ulasan</h3>
            <button type="button" onclick="document.getElementById('reviewModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 transition">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <div class="p-6">
            <form action="<?= BASEURL; ?>/review/submit" method="POST" class="space-y-4">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                <input type="hidden" name="item_type" value="book">
                <input type="hidden" name="item_id" value="<?= $data['buku']['id'] ?>">
                <input type="hidden" name="slug" value="<?= htmlspecialchars($data['buku']['slug'] ?? '') ?>">
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Penilaian Anda</label>
                    <select name="rating" required class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-unsoed-blue/20 outline-none">
                        <option value="5">5 Bintang - Sangat Bagus</option>
                        <option value="4">4 Bintang - Bagus</option>
                        <option value="3">3 Bintang - Cukup</option>
                        <option value="2">2 Bintang - Kurang</option>
                        <option value="1">1 Bintang - Sangat Kurang</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Ulasan</label>
                    <textarea name="comment" rows="4" placeholder="Bagaimana pendapat Anda tentang buku ini?" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-unsoed-blue/20 outline-none resize-none"></textarea>
                </div>

                <div class="pt-4 flex gap-3">
                    <button type="button" onclick="document.getElementById('reviewModal').classList.add('hidden')" class="w-1/2 py-3 px-4 rounded-xl border border-gray-300 text-gray-700 font-semibold hover:bg-gray-50 transition text-center">Batal</button>
                    <button type="submit" class="w-1/2 btn-primary py-3 text-center">Kirim Ulasan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        if (sessionStorage.getItem('openReviewModal') === '1') {
            sessionStorage.removeItem('openReviewModal');
            <?php if ($data['can_review']['can_review']): ?>
                document.getElementById('reviewModal').classList.remove('hidden');
                // Scroll to reviews section smoothly
                setTimeout(() => {
                    document.getElementById('reviewModal').scrollIntoView({ behavior: 'smooth' });
                }, 100);
            <?php endif; ?>
        }
    });
</script>
