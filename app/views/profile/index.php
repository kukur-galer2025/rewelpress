<!-- Header Title Banner -->
<div class="bg-[#f3f4f6] border-b border-gray-200 py-8">
    <div class="container mx-auto px-4 max-w-[1200px] flex flex-col md:flex-row md:items-center justify-between gap-4">
        <h1 class="text-3xl md:text-4xl font-serif font-light text-gray-600 uppercase tracking-wide">PROFILE & TENTANG KAMI</h1>
        <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider flex items-center gap-2">
            <a href="<?= BASEURL; ?>" class="hover:text-unsoed-blue transition">HOME</a>
            <span>/</span>
            <span class="text-gray-700 font-bold">PROFILE</span>
        </div>
    </div>
</div>

<div class="container mx-auto px-4 max-w-[1200px] py-14 space-y-20">

    <!-- Hero / Sejarah Singkat -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
        <div class="lg:col-span-7 space-y-6 text-gray-700 leading-relaxed">
            <div class="inline-block px-3.5 py-1.5 bg-blue-50 text-unsoed-blue font-bold text-xs uppercase tracking-wider rounded-full border border-blue-100">
                Badan Penerbit & Publikasi Resmi
            </div>
            <h2 class="text-3xl md:text-4xl font-serif font-bold text-gray-900 leading-tight">
                Membangun Peradaban Melalui <span class="text-unsoed-blue">Karya Ilmiah</span> & Publikasi Berkualitas
            </h2>
            <p class="text-base text-gray-600">
                <strong class="text-gray-900">UNSOED PRESS</strong> (Badan Penerbit dan Publikasi Universitas Jenderal Soedirman) adalah unit strategis perguruan tinggi yang bertugas memfasilitasi, menerbitkan, serta menyebarluaskan karya-karya akademis dari dosen, peneliti, dan sivitas akademika agar dapat diakses oleh masyarakat luas, baik di tingkat nasional maupun internasional.
            </p>
            <p class="text-base text-gray-600">
                Berdiri sebagai ujung tombak hilirisasi riset di kampus <em class="text-gray-800 font-semibold">Panglima Jenderal Soedirman</em>, kami berkomitmen menjaga standar tinggi dalam proses penyuntingan (editing), tata letak (layouting), review sejawat (peer-review), hingga pendistribusian buku referensi, monograf, buku ajar, prosiding, serta pengelolaan jurnal ilmiah bereputasi.
            </p>
            <div class="pt-4 flex flex-wrap items-center gap-4">
                <a href="<?= BASEURL; ?>/penerbitan" class="px-6 py-3.5 bg-[#0f3460] text-white rounded-xl font-bold text-sm tracking-wide hover:bg-blue-900 transition shadow-lg flex items-center gap-2">
                    <i class="fas fa-file-signature"></i> Ajukan Naskah Buku
                </a>
                <a href="<?= BASEURL; ?>/contact" class="px-6 py-3.5 bg-gray-100 text-gray-800 rounded-xl font-bold text-sm tracking-wide hover:bg-gray-200 transition">
                    Hubungi Redaksi
                </a>
            </div>
        </div>

        <div class="lg:col-span-5">
            <div class="relative bg-gradient-to-br from-[#0f3460] to-blue-900 rounded-3xl p-8 text-white shadow-2xl overflow-hidden">
                <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-unsoed-yellow/10 rounded-full blur-2xl"></div>
                <h3 class="font-serif text-2xl font-bold mb-6 text-unsoed-yellow flex items-center gap-2.5">
                    <i class="fas fa-award"></i> Statistik & Dedikasi
                </h3>
                <div class="grid grid-cols-2 gap-6 relative z-10">
                    <div class="bg-white/10 backdrop-blur-md p-5 rounded-2xl border border-white/10">
                        <span class="text-3xl md:text-4xl font-extrabold text-white block mb-1">500+</span>
                        <span class="text-xs text-blue-200 font-medium uppercase tracking-wider">Judul Buku Terbit</span>
                    </div>
                    <div class="bg-white/10 backdrop-blur-md p-5 rounded-2xl border border-white/10">
                        <span class="text-3xl md:text-4xl font-extrabold text-unsoed-yellow block mb-1">100%</span>
                        <span class="text-xs text-blue-200 font-medium uppercase tracking-wider">Ber-ISBN Perpusnas</span>
                    </div>
                    <div class="bg-white/10 backdrop-blur-md p-5 rounded-2xl border border-white/10">
                        <span class="text-3xl md:text-4xl font-extrabold text-white block mb-1">50+</span>
                        <span class="text-xs text-blue-200 font-medium uppercase tracking-wider">Jurnal Terakreditasi</span>
                    </div>
                    <div class="bg-white/10 backdrop-blur-md p-5 rounded-2xl border border-white/10">
                        <span class="text-3xl md:text-4xl font-extrabold text-unsoed-yellow block mb-1">34+</span>
                        <span class="text-xs text-blue-200 font-medium uppercase tracking-wider">Tahun Pengabdian</span>
                    </div>
                </div>
                <div class="mt-6 pt-6 border-t border-white/10 text-xs text-blue-200 italic text-center">
                    "Maju Terus Pantang Mundur - Tidak Kenal Menyerah"
                </div>
            </div>
        </div>
    </div>

    <!-- Visi & Misi -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Visi -->
        <div class="bg-white rounded-3xl p-8 md:p-10 border border-gray-200 shadow-sm relative overflow-hidden group hover:border-unsoed-blue transition">
            <div class="w-14 h-14 rounded-2xl bg-blue-50 text-unsoed-blue flex items-center justify-center text-2xl font-bold mb-6 group-hover:scale-110 transition-transform">
                <i class="fas fa-eye"></i>
            </div>
            <h3 class="text-2xl font-serif font-bold text-gray-900 mb-4">Visi Unsoed Press</h3>
            <p class="text-gray-600 leading-relaxed text-base">
                Menjadi lembaga penerbitan dan publikasi ilmiah perguruan tinggi yang <strong class="text-unsoed-blue">unggul, bereputasi internasional, dan inovatif</strong> dalam memfasilitasi pengembangan ilmu pengetahuan, teknologi, serta seni yang berkarakter pedesaan dan kearifan lokal.
            </p>
        </div>

        <!-- Misi -->
        <div class="bg-white rounded-3xl p-8 md:p-10 border border-gray-200 shadow-sm relative overflow-hidden group hover:border-unsoed-yellow transition">
            <div class="w-14 h-14 rounded-2xl bg-yellow-50 text-yellow-600 flex items-center justify-center text-2xl font-bold mb-6 group-hover:scale-110 transition-transform">
                <i class="fas fa-bullseye"></i>
            </div>
            <h3 class="text-2xl font-serif font-bold text-gray-900 mb-4">Misi Utama</h3>
            <ul class="space-y-3 text-gray-600 text-sm md:text-base leading-relaxed">
                <li class="flex items-start gap-3">
                    <i class="fas fa-check-circle text-yellow-500 mt-1 flex-shrink-0"></i>
                    <span>Menerbitkan buku ilmiah bermutu (buku ajar, referensi, monograf) dengan standar penyuntingan tinggi dan ber-ISBN resmi.</span>
                </li>
                <li class="flex items-start gap-3">
                    <i class="fas fa-check-circle text-yellow-500 mt-1 flex-shrink-0"></i>
                    <span>Mendorong peningkatan mutu dan akreditasi nasional/indeksasi internasional bagi seluruh jurnal ilmiah di lingkungan Unsoed.</span>
                </li>
                <li class="flex items-start gap-3">
                    <i class="fas fa-check-circle text-yellow-500 mt-1 flex-shrink-0"></i>
                    <span>Memperluas jejaring distribusi dan pemasaran buku ilmiah di pasar nasional dan global melalui platform digital maupun cetak.</span>
                </li>
            </ul>
        </div>
    </div>

    <!-- Ruang Lingkup & Layanan -->
    <div class="bg-gray-50 rounded-3xl p-8 md:p-12 border border-gray-200 space-y-10">
        <div class="text-center max-w-2xl mx-auto space-y-3">
            <h3 class="text-2xl md:text-3xl font-serif font-bold text-gray-900">Ruang Lingkup & Layanan Kami</h3>
            <p class="text-gray-600 text-sm md:text-base">Komitmen pelayanan satu pintu untuk memenuhi kebutuhan publikasi akademis dan pencetakan berkualitas tinggi.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm space-y-3">
                <div class="w-10 h-10 rounded-xl bg-blue-100 text-unsoed-blue flex items-center justify-center font-bold">
                    <i class="fas fa-book"></i>
                </div>
                <h4 class="font-bold text-gray-900 text-lg">Penerbitan Buku Ber-ISBN</h4>
                <p class="text-xs text-gray-600 leading-relaxed">
                    Layanan pengurusan ISBN resmi ke Perpustakaan Nasional RI untuk buku ajar, buku referensi, monograf, maupun fiksi ilmiah/populer.
                </p>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm space-y-3">
                <div class="w-10 h-10 rounded-xl bg-purple-100 text-purple-700 flex items-center justify-center font-bold">
                    <i class="fas fa-edit"></i>
                </div>
                <h4 class="font-bold text-gray-900 text-lg">Copyediting & Layouting</h4>
                <p class="text-xs text-gray-600 leading-relaxed">
                    Penyuntingan tata bahasa, penyesuaian gaya selingkung (style guide), pembuatan indeks, dan tata letak interior buku profesional.
                </p>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm space-y-3">
                <div class="w-10 h-10 rounded-xl bg-green-100 text-green-700 flex items-center justify-center font-bold">
                    <i class="fas fa-palette"></i>
                </div>
                <h4 class="font-bold text-gray-900 text-lg">Desain Sampul (Cover Design)</h4>
                <p class="text-xs text-gray-600 leading-relaxed">
                    Perancangan sampul buku yang menarik, estetis, dan mencerminkan substansi keilmuan dengan standar visual perbukuan modern.
                </p>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm space-y-3">
                <div class="w-10 h-10 rounded-xl bg-yellow-100 text-yellow-700 flex items-center justify-center font-bold">
                    <i class="fas fa-print"></i>
                </div>
                <h4 class="font-bold text-gray-900 text-lg">Percetakan Digital & Offset</h4>
                <p class="text-xs text-gray-600 leading-relaxed">
                    Fasilitas cetak buku (Print on Demand) mulai dari oplah terbatas hingga cetak offset massal untuk keperluan perkuliahan atau instansi.
                </p>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm space-y-3">
                <div class="w-10 h-10 rounded-xl bg-red-100 text-red-600 flex items-center justify-center font-bold">
                    <i class="fas fa-globe"></i>
                </div>
                <h4 class="font-bold text-gray-900 text-lg">Pengelolaan Jurnal OJS</h4>
                <p class="text-xs text-gray-600 leading-relaxed">
                    Pendampingan teknis dan tata kelola jurnal ilmiah berbasis Open Journal Systems (OJS) menuju akreditasi SINTA dan Scopus.
                </p>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm space-y-3">
                <div class="w-10 h-10 rounded-xl bg-teal-100 text-teal-700 flex items-center justify-center font-bold">
                    <i class="fas fa-tablet-alt"></i>
                </div>
                <h4 class="font-bold text-gray-900 text-lg">Publikasi E-Book Digital</h4>
                <p class="text-xs text-gray-600 leading-relaxed">
                    Konversi dan distribusi buku elektronik (E-Book PDF/EPUB) yang dilindungi secara digital dan dapat diakses kapan saja oleh mahasiswa.
                </p>
            </div>
        </div>
    </div>

</div>
