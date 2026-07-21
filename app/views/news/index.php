<?php
$featured = null;
$regular_news = [];

if (!empty($data['news'])) {
    // Sort array by created_at descending (assuming model returns it this way, but just in case)
    $featured = $data['news'][0];
    if(count($data['news']) > 1) {
        $regular_news = array_slice($data['news'], 1);
    }
}
?>

<div class="bg-white py-12 md:py-16 min-h-screen">
    <div class="container mx-auto px-4 lg:px-8 max-w-7xl">
        
        <!-- Header: Editorial Style -->
        <div class="flex flex-col md:flex-row md:items-end justify-between border-b-2 border-gray-900 pb-6 mb-12">
            <div>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-black text-gray-900 tracking-tight font-serif uppercase">Jurnal & Berita</h1>
                <p class="text-gray-500 mt-3 font-medium text-lg">Kabar terbaru, agenda, dan liputan dari dapur redaksi Unsoed Press.</p>
            </div>
            <div class="mt-6 md:mt-0 text-sm font-bold text-gray-400 uppercase tracking-widest bg-gray-50 px-4 py-2 rounded-full">
                Edisi <?= date('F Y') ?>
            </div>
        </div>

        <?php if(empty($data['news'])): ?>
            <div class="py-20 text-center">
                <div class="text-gray-200 mb-6">
                    <i class="far fa-newspaper text-8xl"></i>
                </div>
                <h3 class="text-2xl font-serif font-bold text-gray-800 mb-2">Peti Berita Kosong</h3>
                <p class="text-gray-500">Redaksi belum menerbitkan liputan atau agenda terbaru untuk saat ini.</p>
            </div>
        <?php else: ?>
            
            <!-- FEATURED ARTICLE (Sorotan Utama) -->
            <div class="group mb-16">
                <a href="<?= BASEURL; ?>/news/read/<?= $featured['slug'] ?>" class="flex flex-col lg:flex-row gap-8 lg:gap-12 items-center">
                    
                    <!-- Cover Image -->
                    <div class="w-full lg:w-2/3 h-[300px] sm:h-[450px] lg:h-[550px] relative overflow-hidden rounded-lg bg-gray-100 shadow-md">
                        <?php 
                        $feat_images = [];
                        if(!empty($featured['image'])) {
                            $decoded = json_decode($featured['image'], true);
                            $feat_images = is_array($decoded) ? $decoded : (is_string($featured['image']) && filter_var($featured['image'], FILTER_VALIDATE_URL) ? [$featured['image']] : []);
                        }
                        ?>
                        <?php if(!empty($feat_images)): ?>
                            <img src="<?= $feat_images[0] ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-1000 ease-out">
                        <?php else: ?>
                            <div class="w-full h-full flex items-center justify-center text-gray-300 bg-gray-50">
                                <i class="fas fa-image text-6xl"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Content -->
                    <div class="w-full lg:w-1/3 flex flex-col justify-center">
                        <div class="flex items-center gap-3 mb-5">
                            <span class="px-3 py-1 bg-unsoed-darkblue text-unsoed-yellow text-xs font-bold uppercase tracking-wider rounded-sm">Sorotan Utama</span>
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">
                                <?= date('d M Y', strtotime($featured['created_at'])) ?>
                            </span>
                        </div>
                        
                        <h2 class="text-3xl lg:text-4xl xl:text-5xl font-bold font-serif text-gray-900 leading-tight mb-5 group-hover:text-unsoed-blue transition-colors">
                            <?= $featured['title'] ?>
                        </h2>
                        
                        <p class="text-gray-600 text-lg leading-relaxed mb-8 line-clamp-4">
                            <?= strip_tags(substr($featured['content'], 0, 400)) ?>...
                        </p>
                        
                        <span class="inline-flex items-center gap-2 text-unsoed-blue font-bold uppercase tracking-widest text-sm group-hover:text-unsoed-darkblue transition-colors">
                            Baca Liputan Lengkap <i class="fas fa-long-arrow-alt-right transition-transform duration-300 group-hover:translate-x-3"></i>
                        </span>
                    </div>
                </a>
            </div>

            <hr class="border-t-2 border-gray-100 mb-12">

            <!-- LATEST NEWS GRID -->
            <?php if(!empty($regular_news)): ?>
                <div class="flex justify-between items-center mb-10">
                    <h3 class="text-2xl font-bold font-serif text-gray-900 border-l-4 border-unsoed-yellow pl-4">Berita Lainnya</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-16">
                    <?php foreach($regular_news as $news): ?>
                        <a href="<?= BASEURL; ?>/news/read/<?= $news['slug'] ?>" class="group block">
                            <div class="w-full aspect-[4/3] bg-gray-100 mb-6 overflow-hidden rounded-lg shadow-sm group-hover:shadow-md transition-shadow">
                                <?php 
                                $reg_images = [];
                                if(!empty($news['image'])) {
                                    $decoded = json_decode($news['image'], true);
                                    $reg_images = is_array($decoded) ? $decoded : (is_string($news['image']) && filter_var($news['image'], FILTER_VALIDATE_URL) ? [$news['image']] : []);
                                }
                                ?>
                                <?php if(!empty($reg_images)): ?>
                                    <img src="<?= $reg_images[0] ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out">
                                <?php else: ?>
                                    <div class="w-full h-full flex items-center justify-center text-gray-300">
                                        <i class="fas fa-image text-3xl"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="flex items-center gap-2 text-xs font-bold text-unsoed-blue uppercase tracking-wider mb-3">
                                <i class="far fa-calendar-alt"></i> <?= date('d M Y', strtotime($news['created_at'])) ?>
                            </div>
                            
                            <h4 class="text-xl font-bold font-serif text-gray-900 leading-snug mb-3 group-hover:text-unsoed-blue transition-colors line-clamp-3">
                                <?= $news['title'] ?>
                            </h4>
                            
                            <p class="text-gray-500 text-sm line-clamp-3 leading-relaxed">
                                <?= strip_tags(substr($news['content'], 0, 200)) ?>...
                            </p>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            
        <?php endif; ?>

    </div>
</div>
