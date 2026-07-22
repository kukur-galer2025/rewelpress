<?php
// Decode atau ambil gambar
$read_images = [];
if(!empty($data['news']['image'])) {
    $decoded = json_decode($data['news']['image'], true);
    $read_images = is_array($decoded) ? $decoded : (is_string($data['news']['image']) && filter_var($data['news']['image'], FILTER_VALIDATE_URL) ? [$data['news']['image']] : []);
}
$mainImageUrl = !empty($read_images) ? $read_images[0] : '';
$formattedDate = date('F d, Y', strtotime($data['news']['created_at']));
?>

<!-- Header Title Banner -->
<div class="bg-[#f3f4f6] border-b border-gray-200 py-8">
    <div class="container mx-auto px-4 max-w-[1200px] flex flex-col md:flex-row md:items-center justify-between gap-4">
        <h1 class="text-3xl md:text-4xl font-serif font-light text-gray-500 uppercase tracking-wide">EVENT & AGENDA</h1>
        <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider flex items-center gap-2 flex-wrap">
            <a href="<?= BASEURL; ?>" class="hover:text-unsoed-blue transition">HOME</a>
            <span>/</span>
            <a href="<?= BASEURL; ?>/news" class="hover:text-unsoed-blue transition">EVENT & AGENDA</a>
            <span>/</span>
            <span class="text-gray-600 font-bold truncate max-w-[280px] md:max-w-[400px]" title="<?= htmlspecialchars($data['news']['title']) ?>">
                <?= strtoupper(substr($data['news']['title'], 0, 70)) . (strlen($data['news']['title']) > 70 ? '...' : '') ?>
            </span>
        </div>
    </div>
</div>

<div class="container mx-auto px-4 max-w-[1200px] py-14">

    <!-- Layout 2 Kolom (Sesuai Referensi input_file_0.png) -->
    <div class="flex flex-col md:flex-row gap-10 lg:gap-14 items-start">
        
        <!-- Kolom Kiri: Tanggal Posting & Share (Lebar 220px) -->
        <div class="w-full md:w-[220px] flex-shrink-0 space-y-8 pt-1 md:sticky md:top-28">
            
            <!-- Tanggal Posting -->
            <div>
                <h4 class="font-bold text-gray-800 text-base mb-2.5">Tanggal Posting</h4>
                <div class="flex items-center gap-2 text-sm text-gray-500 font-medium">
                    <i class="far fa-calendar-alt text-gray-400"></i>
                    <span><?= $formattedDate ?></span>
                </div>
            </div>

            <!-- Share -->
            <div>
                <h4 class="font-bold text-gray-800 text-base mb-3">Share</h4>
                <div class="flex items-center gap-2.5">
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']) ?>" target="_blank" class="w-9 h-9 rounded-full bg-[#1877f2] text-white flex items-center justify-center hover:opacity-90 transition shadow-sm" title="Share to Facebook">
                        <i class="fab fa-facebook-f text-sm"></i>
                    </a>
                    <a href="https://twitter.com/intent/tweet?url=<?= urlencode('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']) ?>&text=<?= urlencode($data['news']['title']) ?>" target="_blank" class="w-9 h-9 rounded-full bg-[#1da1f2] text-white flex items-center justify-center hover:opacity-90 transition shadow-sm" title="Share to Twitter">
                        <i class="fab fa-twitter text-sm"></i>
                    </a>
                    <a href="https://api.whatsapp.com/send?text=<?= urlencode($data['news']['title'] . ' - http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']) ?>" target="_blank" class="w-9 h-9 rounded-full bg-[#25d366] text-white flex items-center justify-center hover:opacity-90 transition shadow-sm" title="Share to WhatsApp">
                        <i class="fab fa-whatsapp text-sm"></i>
                    </a>
                    <button onclick="navigator.clipboard.writeText(window.location.href); alert('Tautan berita berhasil disalin ke clipboard!')" class="w-9 h-9 rounded-full bg-gray-600 text-white flex items-center justify-center hover:opacity-90 transition shadow-sm" title="Copy Link">
                        <i class="fas fa-link text-sm"></i>
                    </button>
                </div>
            </div>

        </div>

        <!-- Kolom Kanan: Judul, Gambar, dan Isi Berita (Lebar Utama) -->
        <div class="flex-1 max-w-[880px] space-y-6">
            
            <!-- Title -->
            <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold font-serif text-gray-900 leading-snug uppercase tracking-normal">
                <?= htmlspecialchars($data['news']['title']) ?>
            </h2>

            <!-- Cover Image / Banner -->
            <?php if(!empty($mainImageUrl)): ?>
                <div class="w-full aspect-[16/10] bg-gray-100 rounded-lg overflow-hidden border border-gray-200 shadow-sm">
                    <img src="<?= $mainImageUrl ?>" alt="<?= htmlspecialchars($data['news']['title']) ?>" class="w-full h-full object-cover">
                </div>
            <?php endif; ?>

            <!-- Article Rich Content Body -->
            <div class="ql-snow pt-4">
                <div class="ql-editor prose prose-lg max-w-none text-gray-700 leading-relaxed space-y-5
                            prose-headings:font-serif prose-headings:font-bold prose-headings:text-gray-900 
                            prose-p:text-gray-700 prose-p:leading-relaxed prose-p:mb-5
                            prose-a:text-unsoed-blue prose-a:font-semibold hover:prose-a:underline
                            prose-img:rounded-lg prose-img:shadow-sm prose-img:border prose-img:border-gray-200
                            prose-strong:text-gray-900 prose-strong:font-bold
                            prose-blockquote:border-l-4 prose-blockquote:border-unsoed-blue prose-blockquote:bg-gray-50 prose-blockquote:py-2.5 prose-blockquote:px-6 prose-blockquote:text-gray-600 prose-blockquote:italic font-sans">
                    <?= $data['news']['content'] ?>
                </div>
            </div>

            <!-- Back to Index Button -->
            <div class="pt-12 border-t border-gray-200 flex justify-between items-center">
                <a href="<?= BASEURL; ?>/news" class="inline-flex items-center gap-2 text-xs font-bold text-unsoed-blue uppercase tracking-widest hover:text-blue-900 transition">
                    <i class="fas fa-arrow-left"></i> Kembali ke Daftar Berita & Agenda
                </a>
            </div>

        </div>

    </div>

</div>
