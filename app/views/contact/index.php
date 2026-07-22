<!-- Header Title Banner -->
<div class="bg-[#f3f4f6] border-b border-gray-200 py-8">
    <div class="container mx-auto px-4 max-w-[1200px] flex flex-col md:flex-row md:items-center justify-between gap-4">
        <h1 class="text-3xl md:text-4xl font-serif font-light text-gray-600 uppercase tracking-wide">CONTACT US</h1>
        <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider flex items-center gap-2">
            <a href="<?= BASEURL; ?>" class="hover:text-unsoed-blue transition">HOME</a>
            <span>/</span>
            <span class="text-gray-700 font-bold">CONTACT US</span>
        </div>
    </div>
</div>

<div class="container mx-auto px-4 max-w-[1200px] py-14 space-y-16">

    <?php if(isset($_GET['msg']) && $_GET['msg'] == 'success'): ?>
        <div class="bg-green-100 border-l-4 border-green-500 text-green-800 p-4 rounded shadow-sm flex items-center justify-between" role="alert">
            <div class="flex items-center gap-3">
                <i class="fas fa-check-circle text-2xl text-green-600"></i>
                <div>
                    <p class="font-bold">Pesan Berhasil Terkirim!</p>
                    <p class="text-sm">Terima kasih telah menghubungi kami. Tim Unsoed Press akan segera menindaklanjuti pesan Anda melalui email.</p>
                </div>
            </div>
            <button onclick="this.parentElement.remove()" class="text-green-700 hover:text-green-900 font-bold text-lg">&times;</button>
        </div>
    <?php endif; ?>

    <!-- Bagian Atas: Office Info & Contact Form (Sesuai Contoh UGM Press) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
        
        <!-- Kolom Kiri: OUR OFFICE -->
        <div class="lg:col-span-1">
            <div class="bg-[#0f3460] text-white font-bold px-5 py-3.5 text-sm uppercase tracking-wider rounded-t-lg shadow-sm">
                OUR OFFICE
            </div>
            <div class="bg-white border border-gray-200 rounded-b-lg p-6 shadow-sm space-y-6 text-sm text-gray-700 leading-relaxed divide-y divide-gray-100">
                
                <!-- Penerbit dan Percetakan -->
                <div class="pt-2 first:pt-0">
                    <h4 class="font-bold text-gray-900 mb-1.5 italic">Penerbit dan Percetakan</h4>
                    <p class="text-gray-600">
                        Dukuhbandong, Grendeng, Kec. Purwokerto Utara, Kabupaten Banyumas, Jawa Tengah 53125
                    </p>
                    <p class="mt-2 text-gray-800 font-medium">
                        <i class="fas fa-phone-alt text-unsoed-blue mr-1.5"></i> Telp: (0281) 626070
                    </p>
                </div>

                <!-- Marketing & Media Sosial -->
                <div class="pt-4">
                    <h4 class="font-bold text-gray-900 mb-1.5 italic">Marketing & Layanan</h4>
                    <ul class="space-y-1.5 text-gray-600">
                        <li><i class="fab fa-whatsapp text-green-600 w-5"></i> WhatsApp: (+62) 856 0011 0828</li>
                        <li><i class="fab fa-instagram text-pink-600 w-5"></i> Instagram: @unsoedpress</li>
                        <li><i class="fab fa-facebook text-blue-600 w-5"></i> Facebook: Unsoed Press</li>
                        <li><i class="fas fa-envelope text-red-600 w-5"></i> E-mail: unsoedpress@gmail.com</li>
                    </ul>
                </div>

                <!-- Jam Layanan -->
                <div class="pt-4">
                    <h4 class="font-bold text-gray-900 mb-1">Jam Layanan Admin & Pengiriman Buku:</h4>
                    <p class="text-gray-600 font-medium">
                        Senin s.d. Jumat<br>
                        <span class="text-unsoed-blue font-bold">Pukul 07.30 WIB s.d. 16.00 WIB</span>
                    </p>
                </div>

            </div>
        </div>

        <!-- Kolom Kanan: CONTACT FORM -->
        <div class="lg:col-span-2">
            <div class="border-b-2 border-unsoed-yellow pb-3 mb-6 flex items-center justify-between">
                <h2 class="font-bold text-gray-800 text-lg uppercase tracking-wider">CONTACT FORM</h2>
            </div>
            
            <p class="text-gray-600 text-sm mb-8">
                Untuk menghubungi kami, silahkan isi data Anda pada formulir dibawah
            </p>

            <form action="<?= BASEURL; ?>/contact/send" method="POST" class="space-y-6">
                <div>
                    <input type="text" name="full_name" required class="w-full px-4 py-3 bg-gray-100/80 border border-transparent focus:border-unsoed-blue focus:bg-white rounded-lg text-sm transition outline-none" placeholder="Full Name">
                </div>
                <div>
                    <input type="email" name="email" required class="w-full px-4 py-3 bg-gray-100/80 border border-transparent focus:border-unsoed-blue focus:bg-white rounded-lg text-sm transition outline-none" placeholder="Email">
                </div>
                <div>
                    <input type="text" name="subject" required class="w-full px-4 py-3 bg-gray-100/80 border border-transparent focus:border-unsoed-blue focus:bg-white rounded-lg text-sm transition outline-none" placeholder="Subject">
                </div>
                <div>
                    <textarea name="message" rows="5" required class="w-full px-4 py-3 bg-gray-100/80 border border-transparent focus:border-unsoed-blue focus:bg-white rounded-lg text-sm transition outline-none resize-none" placeholder="Message"></textarea>
                </div>

                <!-- Simulasi reCAPTCHA -->
                <div class="border border-gray-300 rounded-lg p-3 bg-white shadow-sm flex items-center justify-between max-w-xs">
                    <label class="flex items-center gap-3 cursor-pointer select-none">
                        <input type="checkbox" required class="w-5 h-5 text-unsoed-blue rounded focus:ring-unsoed-blue border-gray-300">
                        <span class="text-sm font-medium text-gray-700">I'm not a robot</span>
                    </label>
                    <img src="https://www.gstatic.com/recaptcha/api2/logo_48.png" alt="reCAPTCHA" class="h-8 opacity-90">
                </div>

                <div>
                    <button type="submit" class="w-full py-4 bg-[#0f3460] text-white font-bold text-sm tracking-widest uppercase hover:bg-blue-900 transition-all duration-300 shadow-lg hover:shadow-xl rounded-lg">
                        SEND MESSAGE
                    </button>
                </div>
            </form>
        </div>

    </div>

    <!-- Bagian Bawah: Peta Lokasi (Ditaruh Di Bawah Sesuai Request User) -->
    <div class="space-y-3">
        <div class="border-b-2 border-unsoed-yellow pb-3 mb-4">
            <h3 class="font-bold text-gray-800 text-lg uppercase tracking-wider">LOKASI KANTOR KAMI</h3>
        </div>
        
        <div class="rounded-t-2xl overflow-hidden shadow-lg border border-gray-200 aspect-[21/9] md:aspect-[3/1] w-full bg-gray-100">
            <iframe 
                src="https://www.google.com/maps?q=Dukuhbandong,+Grendeng,+Kec.+Purwokerto+Utara,+Kabupaten+Banyumas,+Jawa+Tengah+53125&output=embed" 
                width="100%" 
                height="100%" 
                style="border:0;" 
                allowfullscreen="" 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
        <!-- Banner Alamat Biru Gelap Di Bawah Peta (Persis UGM Press) -->
        <div class="bg-[#0f3460] text-white font-semibold text-center py-4 px-6 text-sm tracking-wide rounded-b-2xl shadow-md border-t border-blue-900">
            UNSOED PRESS, Dukuhbandong, Grendeng, Kec. Purwokerto Utara, Kabupaten Banyumas, Jawa Tengah 53125
        </div>
    </div>

</div>
