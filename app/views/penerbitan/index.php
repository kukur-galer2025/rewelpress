<!-- Header Title Banner -->
<div class="bg-[#f3f4f6] border-b border-gray-200 py-8">
    <div class="container mx-auto px-4 max-w-[1200px] flex flex-col md:flex-row md:items-center justify-between gap-4">
        <h1 class="text-3xl md:text-4xl font-serif font-light text-gray-600 uppercase tracking-wide">LAYANAN PENERBITAN</h1>
        <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider flex items-center gap-2">
            <a href="<?= BASEURL; ?>" class="hover:text-unsoed-blue transition">HOME</a>
            <span>/</span>
            <span class="text-gray-700 font-bold">PENERBITAN</span>
        </div>
    </div>
</div>

<div class="container mx-auto px-4 max-w-[1200px] py-14 space-y-20">

    <!-- Intro & Skema Penerbitan -->
    <div class="text-center max-w-3xl mx-auto space-y-4">
        <div class="inline-block px-4 py-1.5 bg-blue-50 text-unsoed-blue font-bold text-xs uppercase tracking-wider rounded-full border border-blue-100">
            Standar Mutu Perguruan Tinggi
        </div>
        <h2 class="text-3xl md:text-4xl font-serif font-bold text-gray-900 leading-tight">
            Prosedur & Alur Penerbitan Buku Ilmiah di <span class="text-unsoed-blue">Unsoed Press</span>
        </h2>
        <p class="text-gray-600 text-sm md:text-base leading-relaxed">
            Kami membuka kesempatan bagi para dosen, peneliti, praktisi, dan sivitas akademika Universitas Jenderal Soedirman maupun umum untuk menerbitkan buku ber-ISBN dengan proses yang transparan, profesional, dan akuntabel.
        </p>
    </div>

    <!-- 4 Skema Kategori Buku yang Diterbitkan -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-3xl border border-gray-200 shadow-sm hover:shadow-md transition space-y-3 flex flex-col justify-between">
            <div>
                <div class="w-12 h-12 rounded-2xl bg-blue-50 text-unsoed-blue flex items-center justify-center font-bold text-xl mb-4">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <h3 class="font-bold text-gray-900 text-lg">Buku Ajar (Textbook)</h3>
                <p class="text-xs text-gray-600 leading-relaxed mt-2">
                    Buku pegangan wajib perkuliahan yang disusun berdasarkan kurikulum semester untuk membantu mahasiswa memahami kompetensi mata kuliah tertentu.
                </p>
            </div>
            <span class="text-[11px] font-bold text-unsoed-blue pt-4 border-t border-gray-100 block">Kualifikasi: Dosen / Pengampu MK</span>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-gray-200 shadow-sm hover:shadow-md transition space-y-3 flex flex-col justify-between">
            <div>
                <div class="w-12 h-12 rounded-2xl bg-yellow-50 text-yellow-600 flex items-center justify-center font-bold text-xl mb-4">
                    <i class="fas fa-bookmark"></i>
                </div>
                <h3 class="font-bold text-gray-900 text-lg">Buku Referensi</h3>
                <p class="text-xs text-gray-600 leading-relaxed mt-2">
                    Buku ilmiah yang memuat landasan filosofis, teoritis, dan metodologis mendalam pada suatu cabang keilmuan khusus untuk peneliti atau akademisi.
                </p>
            </div>
            <span class="text-[11px] font-bold text-yellow-600 pt-4 border-t border-gray-100 block">Kualifikasi: Peneliti & Pakar Ilmu</span>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-gray-200 shadow-sm hover:shadow-md transition space-y-3 flex flex-col justify-between">
            <div>
                <div class="w-12 h-12 rounded-2xl bg-purple-50 text-purple-700 flex items-center justify-center font-bold text-xl mb-4">
                    <i class="fas fa-microscope"></i>
                </div>
                <h3 class="font-bold text-gray-900 text-lg">Monograf</h3>
                <p class="text-xs text-gray-600 leading-relaxed mt-2">
                    Karya tulis ilmiah yang merupakan rangkuman atau luaran akhir dari satu topik penelitian khusus yang telah diuji kebenarannya secara empiris.
                </p>
            </div>
            <span class="text-[11px] font-bold text-purple-700 pt-4 border-t border-gray-100 block">Kualifikasi: Hasil Hibah Riset</span>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-gray-200 shadow-sm hover:shadow-md transition space-y-3 flex flex-col justify-between">
            <div>
                <div class="w-12 h-12 rounded-2xl bg-green-50 text-green-600 flex items-center justify-center font-bold text-xl mb-4">
                    <i class="fas fa-users"></i>
                </div>
                <h3 class="font-bold text-gray-900 text-lg">Prosiding & Antologi</h3>
                <p class="text-xs text-gray-600 leading-relaxed mt-2">
                    Kumpulan makalah seminar ilmiah nasional/internasional atau antologi karya bersama yang diterbitkan secara komprehensif dan ber-ISBN.
                </p>
            </div>
            <span class="text-[11px] font-bold text-green-600 pt-4 border-t border-gray-100 block">Kualifikasi: Panitia Seminar / Komunitas</span>
        </div>
    </div>

    <!-- 6 Langkah Alur Penerbitan (Step by Step Timeline) -->
    <div class="bg-white rounded-3xl p-8 md:p-12 border border-gray-200 shadow-sm space-y-10">
        <div class="border-b border-gray-200 pb-6 flex items-center justify-between">
            <div>
                <h3 class="text-2xl font-serif font-bold text-gray-900">Alur Penerbitan dari Naskah Hingga Cetak</h3>
                <p class="text-gray-500 text-sm mt-1">Estimasi waktu normal pengerjaan: 3 s.d. 6 minggu bergantung pada kesiapan naskah.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 relative">
            
            <div class="space-y-3 relative pl-6 border-l-2 border-unsoed-blue">
                <span class="absolute -left-3 top-0 w-6 h-6 rounded-full bg-unsoed-blue text-white flex items-center justify-center text-xs font-bold shadow">1</span>
                <h4 class="font-bold text-gray-900 text-base">Pengajuan Naskah & Desk Review</h4>
                <p class="text-xs text-gray-600 leading-relaxed">
                    Penulis menyerahkan naskah lengkap format Word (doc/docx) beserta surat pernyataan keaslian karya. Tim redaksi melakukan uji kemiripan (Turnitin) dengan ambang batas maksimal <strong class="text-red-600">20%</strong>.
                </p>
            </div>

            <div class="space-y-3 relative pl-6 border-l-2 border-unsoed-blue">
                <span class="absolute -left-3 top-0 w-6 h-6 rounded-full bg-unsoed-blue text-white flex items-center justify-center text-xs font-bold shadow">2</span>
                <h4 class="font-bold text-gray-900 text-base">Peer-Review (Telaah Sejawat)</h4>
                <p class="text-xs text-gray-600 leading-relaxed">
                    Khusus buku ajar, referensi, dan monograf, naskah ditelaah oleh minimal 1 orang Mitra Bestari / Reviewer Ahli di bidang yang relevan untuk memastikan kedalaman substansi keilmuan.
                </p>
            </div>

            <div class="space-y-3 relative pl-6 border-l-2 border-unsoed-blue">
                <span class="absolute -left-3 top-0 w-6 h-6 rounded-full bg-unsoed-blue text-white flex items-center justify-center text-xs font-bold shadow">3</span>
                <h4 class="font-bold text-gray-900 text-base">Copyediting & Tata Letak (Layout)</h4>
                <p class="text-xs text-gray-600 leading-relaxed">
                    Editor bahasa memperbaiki tata tulis dan konsistensi istilah. Selanjutnya desainer tata letak merapikan format interior buku (halaman awal, daftar isi, bab, hingga indeks).
                </p>
            </div>

            <div class="space-y-3 relative pl-6 border-l-2 border-unsoed-blue">
                <span class="absolute -left-3 top-0 w-6 h-6 rounded-full bg-unsoed-blue text-white flex items-center justify-center text-xs font-bold shadow">4</span>
                <h4 class="font-bold text-gray-900 text-base">Desain Sampul & Proofreading</h4>
                <p class="text-xs text-gray-600 leading-relaxed">
                    Tim kreatif mendesain sampul depan dan belakang sesuai persetujuan penulis. Penulis memeriksa kembali draf cetak coba (proof print) akhir sebelum diajukan legalitasnya.
                </p>
            </div>

            <div class="space-y-3 relative pl-6 border-l-2 border-unsoed-blue">
                <span class="absolute -left-3 top-0 w-6 h-6 rounded-full bg-unsoed-blue text-white flex items-center justify-center text-xs font-bold shadow">5</span>
                <h4 class="font-bold text-gray-900 text-base">Pengurusan ISBN & KDT</h4>
                <p class="text-xs text-gray-600 leading-relaxed">
                    Unsoed Press mendaftarkan International Standard Book Number (ISBN) dan Katalog Dalam Terbitan (KDT) secara resmi ke Perpustakaan Nasional Republik Indonesia.
                </p>
            </div>

            <div class="space-y-3 relative pl-6 border-l-2 border-green-500">
                <span class="absolute -left-3 top-0 w-6 h-6 rounded-full bg-green-500 text-white flex items-center justify-center text-xs font-bold shadow">6</span>
                <h4 class="font-bold text-gray-900 text-base">Cetak & Distribusi (Serah Simpan)</h4>
                <p class="text-xs text-gray-600 leading-relaxed">
                    Buku dicetak sesuai kesepakatan (Print on Demand atau Offset massal). Pelaksanaan serah simpan karya cetak ke Perpusnas RI & Perpusda, serta distribusi melalui toko online Unsoed Press.
                </p>
            </div>

        </div>
    </div>

    <!-- Syarat & Kelengkapan Pengajuan -->
    <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-start">
        <div class="md:col-span-7 bg-white rounded-3xl p-8 border border-gray-200 shadow-sm space-y-4">
            <h3 class="text-xl font-serif font-bold text-gray-900 flex items-center gap-2">
                <i class="fas fa-file-contract text-unsoed-blue"></i> Kelengkapan Berkas Pengajuan
            </h3>
            <p class="text-sm text-gray-600">Saat mengajukan naskah ke redaksi Unsoed Press, mohon pastikan berkas-berkas berikut telah disiapkan:</p>
            <ul class="space-y-2.5 text-sm text-gray-700">
                <li class="flex items-start gap-2.5">
                    <i class="fas fa-check text-green-600 mt-1 flex-shrink-0"></i>
                    <span><strong>Naskah Lengkap (.docx):</strong> Halaman judul, kata pengantar, daftar isi, bab isi lengkap, daftar pustaka, glosarium (opsional), dan indeks (opsional).</span>
                </li>
                <li class="flex items-start gap-2.5">
                    <i class="fas fa-check text-green-600 mt-1 flex-shrink-0"></i>
                    <span><strong>Sinopsis / Abstrak Buku:</strong> Ringkasan singkat isi buku (maksimal 300 kata) yang akan dicantumkan di halaman belakang sampul (blurb).</span>
                </li>
                <li class="flex items-start gap-2.5">
                    <i class="fas fa-check text-green-600 mt-1 flex-shrink-0"></i>
                    <span><strong>Biodata Penulis (.docx / narasi):</strong> Profil singkat, riwayat pendidikan/pekerjaan, serta foto resmi masing-masing penulis beresolusi tinggi.</span>
                </li>
                <li class="flex items-start gap-2.5">
                    <i class="fas fa-check text-green-600 mt-1 flex-shrink-0"></i>
                    <span><strong>Surat Pernyataan Keaslian Karya:</strong> Surat bermaterai Rp10.000 yang menyatakan bahwa naskah bukan hasil plagiat dan belum pernah diterbitkan di penerbit lain.</span>
                </li>
            </ul>
        </div>

        <!-- Call to Action Box -->
        <div class="md:col-span-5 bg-[#0f3460] rounded-3xl p-8 text-white shadow-xl space-y-6">
            <h3 class="text-2xl font-serif font-bold text-unsoed-yellow">Siap Menerbitkan Karya Anda?</h3>
            <p class="text-sm text-gray-300 leading-relaxed">
                Tim redaksi kami siap mendampingi proses konsultasi dan penerbitan buku ilmiah Anda dengan pelayanan cepat, ramah, dan standar kualitas terbaik.
            </p>
            <div class="space-y-3 pt-2">
                <a href="https://wa.me/6285600110828" target="_blank" class="w-full py-3.5 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl text-sm flex items-center justify-center gap-2 transition shadow-md">
                    <i class="fab fa-whatsapp text-lg"></i> Konsultasi via WhatsApp Redaksi (085600110828)
                </a>
                <a href="<?= BASEURL; ?>/contact" class="w-full py-3.5 bg-white/10 hover:bg-white/20 text-white font-bold rounded-xl text-sm flex items-center justify-center gap-2 transition border border-white/20">
                    <i class="fas fa-envelope"></i> Kirim Pertanyaan lewat Form Kontak
                </a>
            </div>
            <p class="text-[11px] text-gray-400 text-center">
                Jam Layanan Konsultasi: Senin - Jumat (07.30 - 16.00 WIB)
            </p>
        </div>
    </div>

</div>
