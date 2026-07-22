<!-- Header Title Banner -->
<div class="bg-[#f3f4f6] border-b border-gray-200 py-8">
    <div class="container mx-auto px-4 max-w-[1200px] flex flex-col md:flex-row md:items-center justify-between gap-4">
        <h1 class="text-3xl md:text-4xl font-serif font-light text-gray-600 uppercase tracking-wide">DAFTAR PENULIS</h1>
        <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider flex items-center gap-2">
            <a href="<?= BASEURL; ?>" class="hover:text-unsoed-blue transition">HOME</a>
            <span>/</span>
            <span class="text-gray-700 font-bold">PENULIS</span>
        </div>
    </div>
</div>

<div class="container mx-auto px-4 max-w-[1200px] py-14">
    <?php if(empty($data['authors'])): ?>
        <div class="text-center py-16 text-gray-400 font-medium">
            <i class="fas fa-users text-5xl mb-4 block text-gray-300"></i>
            Belum ada data tokoh penulis yang terdaftar.
        </div>
    <?php else: ?>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6">
            <?php foreach ($data['authors'] as $penulis): ?>
                <?php $photo = !empty($penulis['photo']) ? $penulis['photo'] : 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=300&h=300&q=80'; ?>
                <a href="<?= BASEURL; ?>/penulis/detail/<?= urlencode($penulis['name']) ?>" class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 border border-gray-100 flex flex-col group p-4 text-center">
                    <div class="aspect-square w-full rounded-xl overflow-hidden bg-gray-100 mb-3 relative">
                        <img src="<?= esc($photo) ?>" alt="<?= htmlspecialchars($penulis['name']) ?>" class="w-full h-full object-cover filter grayscale group-hover:grayscale-0 transition-all duration-500 transform group-hover:scale-105">
                    </div>
                    <h3 class="font-bold text-gray-800 text-xs uppercase leading-snug group-hover:text-unsoed-blue transition-colors line-clamp-2 min-h-[32px] flex items-center justify-center">
                        <?= htmlspecialchars($penulis['name']) ?>
                    </h3>
                    <?php if(!empty($penulis['affiliation'])): ?>
                        <p class="text-[10px] text-gray-500 line-clamp-1 mt-1 font-medium"><?= htmlspecialchars($penulis['affiliation']) ?></p>
                    <?php endif; ?>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
