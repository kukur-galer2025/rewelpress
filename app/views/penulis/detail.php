<!-- Header Title Banner -->
<div class="bg-[#f3f4f6] border-b border-gray-200 py-8">
    <div class="container mx-auto px-4 max-w-[1200px] flex flex-col md:flex-row md:items-center justify-between gap-4">
        <h1 class="text-3xl md:text-4xl font-serif font-light text-gray-600 uppercase tracking-wide">PENULIS</h1>
        <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider flex items-center gap-2">
            <a href="<?= BASEURL; ?>" class="hover:text-unsoed-blue transition">HOME</a>
            <span>/</span>
            <a href="<?= BASEURL; ?>/penulis" class="hover:text-unsoed-blue transition">PENULIS</a>
            <span>/</span>
            <span class="text-gray-700 font-bold"><?= htmlspecialchars(strtoupper($data['author']['name'])) ?></span>
        </div>
    </div>
</div>

<!-- Main Author Profile Section -->
<div class="container mx-auto px-4 max-w-[1200px] py-14">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-10">
        <!-- Left Col: Photograph & Share -->
        <div class="md:col-span-1 space-y-8">
            <div>
                <h3 class="text-xl font-serif font-bold text-gray-800 mb-4 pb-2 border-b-2 border-gray-200 inline-block">Photograph</h3>
                <div class="w-full aspect-[3/4] bg-gray-100 overflow-hidden rounded-xl shadow-md border border-gray-200 relative group">
                    <?php $photo = !empty($data['author']['photo']) ? $data['author']['photo'] : 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=400&h=400&q=80'; ?>
                    <img src="<?= $photo ?>" alt="<?= htmlspecialchars($data['author']['name']) ?>" class="w-full h-full object-cover filter grayscale group-hover:grayscale-0 transition-all duration-500">
                </div>
            </div>

            <!-- Share Section -->
            <div>
                <h3 class="text-xl font-serif font-bold text-gray-800 mb-4 pb-2 border-b-2 border-gray-200 inline-block">Share</h3>
                <div class="flex items-center gap-3">
                    <?php $page_url = urlencode(BASEURL . '/penulis/detail/' . ($data['author']['id'] ? $data['author']['id'] : urlencode($data['author']['name']))); ?>
                    <?php $share_text = urlencode('Profil Tokoh Penulis: ' . $data['author']['name'] . ' - Unsoed Press'); ?>
                    
                    <a href="https://api.whatsapp.com/send?text=<?= $share_text ?>%20<?= $page_url ?>" target="_blank" class="w-10 h-10 rounded-full bg-[#25D366] text-white flex items-center justify-center text-lg hover:scale-110 hover:shadow-lg transition-all" title="Bagikan ke WhatsApp">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?= $page_url ?>" target="_blank" class="w-10 h-10 rounded-full bg-[#1877F2] text-white flex items-center justify-center text-lg hover:scale-110 hover:shadow-lg transition-all" title="Bagikan ke Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="https://twitter.com/intent/tweet?url=<?= $page_url ?>&text=<?= $share_text ?>" target="_blank" class="w-10 h-10 rounded-full bg-[#1DA1F2] text-white flex items-center justify-center text-lg hover:scale-110 hover:shadow-lg transition-all" title="Bagikan ke Twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <button onclick="copyToClipboard(window.location.href)" class="w-10 h-10 rounded-full bg-gray-600 text-white flex items-center justify-center text-lg hover:bg-unsoed-blue hover:scale-110 hover:shadow-lg transition-all" title="Salin Tautan">
                        <i class="fas fa-link"></i>
                    </button>
                </div>
                <span id="copy_msg" class="text-xs text-green-600 font-semibold mt-2 block hidden"><i class="fas fa-check mr-1"></i>Tautan berhasil disalin!</span>
            </div>
        </div>

        <!-- Right Col: Author Profile Details -->
        <div class="md:col-span-3">
            <h2 class="text-3xl md:text-4xl font-serif font-bold text-unsoed-darkblue mb-3 tracking-tight">
                <?= htmlspecialchars($data['author']['name']) ?>
            </h2>

            <?php if(!empty($data['author']['affiliation'])): ?>
                <div class="inline-block bg-unsoed-yellow/10 border border-unsoed-yellow/40 text-unsoed-yellow text-sm font-bold px-3 py-1 rounded-md mb-6">
                    <i class="fas fa-university mr-1.5"></i> <?= htmlspecialchars($data['author']['affiliation']) ?>
                </div>
            <?php endif; ?>

            <!-- Biography Paragraphs -->
            <div class="text-gray-600 leading-relaxed text-base md:text-lg font-light space-y-4 mb-12">
                <?php if(!empty($data['author']['bio'])): ?>
                    <?php 
                    $paragraphs = explode("\n", trim($data['author']['bio']));
                    foreach($paragraphs as $p):
                        if(trim($p) !== ''):
                    ?>
                        <p class="text-justify"><?= nl2br(htmlspecialchars(trim($p))) ?></p>
                    <?php 
                        endif;
                    endforeach; 
                    ?>
                <?php else: ?>
                    <p class="text-gray-400 italic">Biografi detail penulis belum tersedia.</p>
                <?php endif; ?>
            </div>

            <!-- Buku Karya Penulis -->
            <div class="border-t border-gray-200 pt-10">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-1.5 h-6 bg-unsoed-yellow rounded-full"></div>
                    <h3 class="text-xl md:text-2xl font-serif font-bold text-unsoed-darkblue">
                        Buku Karya <?= htmlspecialchars($data['author']['name']) ?>
                    </h3>
                </div>

                <?php if(empty($data['books'])): ?>
                    <div class="bg-gray-50 border border-gray-200 rounded-2xl p-8 text-center text-gray-400">
                        <i class="fas fa-book-open text-4xl mb-3 block text-gray-300"></i>
                        Belum ada judul buku di katalog yang dikaitkan dengan penulis ini.
                    </div>
                <?php else: ?>
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">
                        <?php foreach($data['books'] as $buku): ?>
                            <a href="<?= BASEURL; ?>/book/detail/<?= $buku['id'] ?>" class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300 flex flex-col group border border-gray-100 relative">
                                <?php if($buku['old_price'] > $buku['price']): ?>
                                    <?php $disc = round((($buku['old_price'] - $buku['price']) / $buku['old_price']) * 100); ?>
                                    <div class="absolute top-2 right-2 z-20">
                                        <span class="bg-red-500 text-white text-[10px] font-black px-2 py-0.5 rounded shadow-md">
                                            -<?= $disc ?>%
                                        </span>
                                    </div>
                                <?php endif; ?>

                                <div class="relative w-full pt-[140%] bg-gray-100 overflow-hidden">
                                    <?php $img_src = !empty($buku['image']) ? $buku['image'] : 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?auto=format&fit=crop&q=80&w=400'; ?>
                                    <img src="<?= $img_src ?>" alt="<?= htmlspecialchars($buku['title']) ?>" class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                </div>

                                <div class="p-4 flex-1 flex flex-col justify-between">
                                    <div>
                                        <span class="text-[10px] font-bold text-unsoed-blue uppercase tracking-wider block mb-1">
                                            <?= !empty($buku['category_name']) ? htmlspecialchars($buku['category_name']) : 'Umum' ?>
                                        </span>
                                        <h4 class="font-bold text-gray-800 text-sm line-clamp-2 group-hover:text-unsoed-blue transition-colors mb-2 leading-snug">
                                            <?= htmlspecialchars($buku['title']) ?>
                                        </h4>
                                    </div>

                                    <div class="pt-2 border-t border-gray-100 flex items-baseline justify-between">
                                        <?php if($buku['old_price'] > $buku['price']): ?>
                                            <span class="text-xs text-gray-400 line-through">Rp <?= number_format($buku['old_price'], 0, ',', '.') ?></span>
                                        <?php else: ?>
                                            <span></span>
                                        <?php endif; ?>
                                        <span class="font-black text-gray-900 text-base">Rp <?= number_format($buku['price'], 0, ',', '.') ?></span>
                                    </div>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        const msg = document.getElementById('copy_msg');
        if(msg) {
            msg.classList.remove('hidden');
            setTimeout(function() {
                msg.classList.add('hidden');
            }, 3000);
        }
    });
}
</script>
