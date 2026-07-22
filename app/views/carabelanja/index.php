<!-- Header Title Banner -->
<div class="bg-[#f3f4f6] border-b border-gray-200 py-8">
    <div class="container mx-auto px-4 max-w-[1200px] flex flex-col md:flex-row md:items-center justify-between gap-4">
        <h1 class="text-3xl md:text-4xl font-serif font-light text-gray-600 uppercase tracking-wide">CARA BELANJA</h1>
        <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider flex items-center gap-2">
            <a href="<?= BASEURL; ?>" class="hover:text-unsoed-blue transition">HOME</a>
            <span>/</span>
            <span class="text-gray-700 font-bold">CARA BELANJA</span>
        </div>
    </div>
</div>

<div class="container mx-auto px-4 max-w-[1200px] py-14 space-y-16">

    <!-- Title Intro -->
    <div class="text-center max-w-3xl mx-auto space-y-3">
        <div class="inline-block px-4 py-1.5 bg-yellow-50 text-yellow-700 font-bold text-xs uppercase tracking-wider rounded-full border border-yellow-200">
            Panduan Pembelian Online
        </div>
        <h2 class="text-3xl md:text-4xl font-serif font-bold text-gray-900">
            5 Langkah Mudah Membeli Buku di <span class="text-unsoed-blue">Unsoed Press</span>
        </h2>
        <p class="text-gray-600 text-sm md:text-base leading-relaxed">
            Pemesanan buku cetak asli (original) dari terbitan Unsoed Press kini dapat dilakukan secara langsung, aman, dan cepat melalui platform toko online kami.
        </p>
    </div>

    <!-- 5 Langkah Pembelian (Grid Cards visual) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        
        <!-- Step 1 -->
        <div class="bg-white rounded-3xl p-8 border border-gray-200 shadow-sm relative group hover:border-unsoed-blue transition space-y-4">
            <div class="flex items-center justify-between">
                <div class="w-14 h-14 rounded-2xl bg-blue-50 text-unsoed-blue flex items-center justify-center text-2xl font-bold group-hover:bg-unsoed-blue group-hover:text-white transition-colors">
                    <i class="fas fa-search"></i>
                </div>
                <span class="text-4xl font-extrabold text-gray-100 font-serif group-hover:text-blue-100 transition-colors">01</span>
            </div>
            <h3 class="text-xl font-bold text-gray-900">Cari & Pilih Buku</h3>
            <p class="text-sm text-gray-600 leading-relaxed">
                Telusuri koleksi katalog buku kami berdasarkan Kategori (Sains, Humaniora, Kedokteran, dll), promo Super Sale, ataupun gunakan kolom pencarian di bagian atas untuk mencari judul/penulis yang Anda inginkan.
            </p>
        </div>

        <!-- Step 2 -->
        <div class="bg-white rounded-3xl p-8 border border-gray-200 shadow-sm relative group hover:border-unsoed-blue transition space-y-4">
            <div class="flex items-center justify-between">
                <div class="w-14 h-14 rounded-2xl bg-yellow-50 text-yellow-600 flex items-center justify-center text-2xl font-bold group-hover:bg-yellow-500 group-hover:text-white transition-colors">
                    <i class="fas fa-cart-plus"></i>
                </div>
                <span class="text-4xl font-extrabold text-gray-100 font-serif group-hover:text-yellow-100 transition-colors">02</span>
            </div>
            <h3 class="text-xl font-bold text-gray-900">Masukkan ke Keranjang</h3>
            <p class="text-sm text-gray-600 leading-relaxed">
                Klik tombol <strong class="text-gray-800">+ Keranjang</strong> pada kartu buku atau halaman detail buku. Anda dapat menambahkan beberapa judul buku sekaligus sebelum melanjutkan ke proses checkout.
            </p>
        </div>

        <!-- Step 3 -->
        <div class="bg-white rounded-3xl p-8 border border-gray-200 shadow-sm relative group hover:border-unsoed-blue transition space-y-4">
            <div class="flex items-center justify-between">
                <div class="w-14 h-14 rounded-2xl bg-purple-50 text-purple-700 flex items-center justify-center text-2xl font-bold group-hover:bg-purple-600 group-hover:text-white transition-colors">
                    <i class="fas fa-clipboard-check"></i>
                </div>
                <span class="text-4xl font-extrabold text-gray-100 font-serif group-hover:text-purple-100 transition-colors">03</span>
            </div>
            <h3 class="text-xl font-bold text-gray-900">Periksa Keranjang & Checkout</h3>
            <p class="text-sm text-gray-600 leading-relaxed">
                Buka halaman <strong class="text-gray-800">Keranjang Belanja</strong> dengan mengklik ikon troli di pojok kanan atas. Pastikan judul dan jumlah buku sudah benar, lalu klik tombol <strong class="text-unsoed-blue">Checkout</strong>.
            </p>
        </div>

        <!-- Step 4 -->
        <div class="bg-white rounded-3xl p-8 border border-gray-200 shadow-sm relative group hover:border-unsoed-blue transition space-y-4">
            <div class="flex items-center justify-between">
                <div class="w-14 h-14 rounded-2xl bg-green-50 text-green-600 flex items-center justify-center text-2xl font-bold group-hover:bg-green-600 group-hover:text-white transition-colors">
                    <i class="fas fa-money-check-alt"></i>
                </div>
                <span class="text-4xl font-extrabold text-gray-100 font-serif group-hover:text-green-100 transition-colors">04</span>
            </div>
            <h3 class="text-xl font-bold text-gray-900">Transfer & Pembayaran</h3>
            <p class="text-sm text-gray-600 leading-relaxed">
                Lakukan transfer pembayaran sesuai total tagihan ke rekening resmi Unsoed Press. Setelah mentransfer, unggah bukti pembayaran di menu pesanan agar dapat segera diverifikasi oleh admin.
            </p>
        </div>

        <!-- Step 5 -->
        <div class="bg-white rounded-3xl p-8 border border-gray-200 shadow-sm relative group hover:border-unsoed-blue transition space-y-4 lg:col-span-2">
            <div class="flex items-center justify-between">
                <div class="w-14 h-14 rounded-2xl bg-red-50 text-red-600 flex items-center justify-center text-2xl font-bold group-hover:bg-red-600 group-hover:text-white transition-colors">
                    <i class="fas fa-shipping-fast"></i>
                </div>
                <span class="text-4xl font-extrabold text-gray-100 font-serif group-hover:text-red-100 transition-colors">05</span>
            </div>
            <h3 class="text-xl font-bold text-gray-900">Pengiriman & Pelacakan Resi</h3>
            <p class="text-sm text-gray-600 leading-relaxed">
                Pesanan yang telah diverifikasi akan langsung dikemas secara rapi dengan pengaman (bubble wrap tebal) dan dikirimkan melalui jasa ekspedisi terpercaya (JNE / J&T / Pos Indonesia). Nomor resi pengiriman dapat dilacak secara real-time di halaman riwayat pesanan Anda.
            </p>
        </div>

    </div>

    <!-- Informasi Pembayaran & Pengiriman -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        
        <div class="bg-gray-50 rounded-3xl p-8 border border-gray-200 space-y-4">
            <h3 class="text-xl font-serif font-bold text-gray-900 flex items-center gap-2.5">
                <i class="fas fa-university text-unsoed-blue"></i> Rekening Resmi Pembayaran
            </h3>
            <p class="text-sm text-gray-600">Seluruh transaksi pembelian buku dijamin keamanannya dan hanya ditujukan ke rekening resmi badan penerbit:</p>
            <div class="bg-white p-5 rounded-2xl border border-gray-200 space-y-3">
                <div class="flex items-center justify-between border-b border-gray-100 pb-2.5">
                    <span class="font-bold text-gray-800 text-sm">Bank BNI (Cabang Purwokerto)</span>
                    <span class="px-2.5 py-0.5 bg-blue-50 text-unsoed-blue font-bold text-xs rounded">BNI</span>
                </div>
                <div>
                    <span class="text-xs text-gray-400 block">Nomor Rekening:</span>
                    <span class="text-lg font-mono font-bold text-gray-900 tracking-wide">0123-4567-8900</span>
                </div>
                <div>
                    <span class="text-xs text-gray-400 block">Atas Nama:</span>
                    <span class="text-sm font-bold text-gray-800">RPL 028 UNSOED PRESS</span>
                </div>
            </div>
        </div>

        <div class="bg-gray-50 rounded-3xl p-8 border border-gray-200 space-y-4">
            <h3 class="text-xl font-serif font-bold text-gray-900 flex items-center gap-2.5">
                <i class="fas fa-box-open text-green-600"></i> Standar Pengemasan & Ekspedisi
            </h3>
            <p class="text-sm text-gray-600">Kami menjaga agar setiap buku sampai ke tangan Anda dalam kondisi sempurna tanpa cacat:</p>
            <ul class="space-y-3 text-sm text-gray-700">
                <li class="flex items-start gap-3">
                    <i class="fas fa-shield-alt text-green-600 mt-1 flex-shrink-0"></i>
                    <span><strong>Triple Protection:</strong> Buku dibungkus plastik segel (shrink wrap), dilapisi bubble wrap tebal berlapis, dan dimasukkan ke dalam kardus khusus buku.</span>
                </li>
                <li class="flex items-start gap-3">
                    <i class="fas fa-truck text-green-600 mt-1 flex-shrink-0"></i>
                    <span><strong>Pilihan Kurir Luas:</strong> JNE Express, J&T Express, SiCepat, Pos Indonesia, maupun ambil langsung di toko fisik Unsoed Press (Grendeng).</span>
                </li>
            </ul>
        </div>

    </div>

    <!-- FAQ (Pertanyaan Sering Diajukan) -->
    <div class="bg-white rounded-3xl p-8 md:p-12 border border-gray-200 shadow-sm space-y-6">
        <h3 class="text-2xl font-serif font-bold text-gray-900 text-center mb-6">Pertanyaan Sering Diajukan (FAQ)</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
            <div class="p-5 rounded-2xl bg-gray-50 border border-gray-100 space-y-2">
                <h4 class="font-bold text-gray-900 flex items-center gap-2">
                    <i class="fas fa-question-circle text-unsoed-blue"></i> Apakah bisa membeli langsung di kantor Unsoed Press?
                </h4>
                <p class="text-gray-600 leading-relaxed">
                    Tentu! Anda bisa datang langsung ke kantor/toko buku fisik Unsoed Press di Dukuhbandong, Grendeng, Purwokerto Utara pada hari kerja (Senin - Jumat, pukul 07.30 - 16.00 WIB).
                </p>
            </div>

            <div class="p-5 rounded-2xl bg-gray-50 border border-gray-100 space-y-2">
                <h4 class="font-bold text-gray-900 flex items-center gap-2">
                    <i class="fas fa-question-circle text-unsoed-blue"></i> Bagaimana jika buku yang dipesan mengalami kerusakan jalan?
                </h4>
                <p class="text-gray-600 leading-relaxed">
                    Jika buku yang diterima rusak atau cacat cetak (halaman terbalik/hilang), kami akan menggantinya dengan buku baru 100% gratis dengan syarat melampirkan video unboxing.
                </p>
            </div>

            <div class="p-5 rounded-2xl bg-gray-50 border border-gray-100 space-y-2">
                <h4 class="font-bold text-gray-900 flex items-center gap-2">
                    <i class="fas fa-question-circle text-unsoed-blue"></i> Apakah melayani pembelian instansi / pengadaan perpustakaan?
                </h4>
                <p class="text-gray-600 leading-relaxed">
                    Ya, kami sangat berpengalaman melayani pengadaan buku untuk perpustakaan kampus, pemda, atau sekolah lengkap dengan faktur resmi, kuitansi bermaterai, dan kelengkapan administrasi pajak.
                </p>
            </div>

            <div class="p-5 rounded-2xl bg-gray-50 border border-gray-100 space-y-2">
                <h4 class="font-bold text-gray-900 flex items-center gap-2">
                    <i class="fas fa-question-circle text-unsoed-blue"></i> Berapa lama estimasi pengiriman buku setelah transfer?
                </h4>
                <p class="text-gray-600 leading-relaxed">
                    Pesanan yang dibayarkan sebelum pukul 14.00 WIB akan dikirim pada hari yang sama. Estimasi sampai untuk wilayah Jawa Tengah (1-2 hari) dan luar pulau Jawa (2-5 hari).
                </p>
            </div>
        </div>
    </div>

</div>
