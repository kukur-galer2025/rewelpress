<div class="container mx-auto px-4 py-8 md:py-12">
    <div class="max-w-5xl mx-auto bg-white rounded-[2rem] shadow-2xl overflow-hidden flex flex-col md:flex-row min-h-[600px] border border-gray-100">
        
        <!-- Left Side: Image & Badges -->
        <div class="md:w-1/2 relative bg-gray-900 hidden md:block group">
            <img src="https://images.unsplash.com/photo-1434030216411-0b793f4b4173?auto=format&fit=crop&q=80" alt="Unsoed Press Support" class="absolute inset-0 w-full h-full object-cover opacity-50 group-hover:scale-105 transition-transform duration-700 grayscale mix-blend-overlay">
            <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-800/80 to-transparent"></div>
            <div class="absolute inset-0 p-12 flex flex-col justify-end">
                <div class="w-16 h-16 rounded-2xl bg-white/10 backdrop-blur-md flex items-center justify-center text-white mb-8 border border-white/20 shadow-xl">
                    <i class="fas fa-shield-alt text-3xl text-unsoed-yellow"></i>
                </div>
                <h2 class="text-4xl font-serif font-bold text-white mb-4 leading-tight">Keamanan Akun Anda Prioritas Kami</h2>
                <p class="text-gray-300 leading-relaxed">Jangan khawatir jika Anda melupakan kata sandi. Kami akan membantu Anda memulihkan akses ke akun Unsoed Press Anda dengan cepat dan aman.</p>
            </div>
        </div>

        <!-- Right Side: Form -->
        <div class="md:w-1/2 p-8 md:p-14 flex flex-col justify-center bg-white relative">
            
            <!-- Mobile Logo -->
            <div class="md:hidden text-center mb-8">
                <a href="<?= BASEURL; ?>" class="inline-flex items-center gap-2">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-unsoed-yellow to-yellow-500 flex items-center justify-center text-white shadow-lg">
                        <i class="fas fa-book-reader text-xl"></i>
                    </div>
                    <div class="font-serif text-2xl font-bold text-unsoed-blue">UNSOED<span class="text-unsoed-yellow">PRESS</span></div>
                </a>
            </div>

            <div class="mb-10 text-center md:text-left">
                <a href="<?= BASEURL; ?>" class="inline-flex items-center gap-2 text-sm font-semibold text-unsoed-blue hover:text-unsoed-yellow transition-colors mb-6 group">
                    <i class="fas fa-arrow-left group-hover:-translate-x-1 transition-transform"></i> Kembali ke Beranda
                </a>
                <div class="w-16 h-16 bg-blue-50 text-unsoed-blue rounded-full flex items-center justify-center text-2xl mb-6 mx-auto md:mx-0">
                    <i class="fas fa-key"></i>
                </div>
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Lupa Kata Sandi?</h2>
                <p class="text-gray-500 text-sm">Masukkan alamat email yang terdaftar. Kami akan mengirimkan tautan untuk mengatur ulang kata sandi Anda.</p>
            </div>

            <?php if(isset($data['error'])): ?>
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r-lg flex items-center gap-3">
                    <i class="fas fa-exclamation-circle text-red-500"></i>
                    <p class="text-sm text-red-700 font-medium"><?= esc($data['error']) ?></p>
                </div>
            <?php endif; ?>
            
            <?php if(isset($data['success'])): ?>
                <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-r-lg flex items-center gap-3">
                    <i class="fas fa-check-circle text-green-500"></i>
                    <p class="text-sm text-green-700 font-medium"><?= esc($data['success']) ?></p>
                </div>
            <?php endif; ?>

            <form action="<?= BASEURL; ?>/auth/forgot_password" method="POST" class="space-y-6">
<?= csrf_field() ?><div>
                    <label for="email" class="block text-sm font-bold text-gray-700 mb-2">Alamat Email Terdaftar</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none transition-colors group-focus-within:text-unsoed-blue text-gray-400">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <input type="email" name="email" id="email" class="w-full pl-11 pr-4 py-3.5 bg-gray-50/50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-unsoed-blue/20 focus:border-unsoed-blue transition-all" placeholder="email@contoh.com" required>
                    </div>
                </div>

                <button type="submit" class="w-full bg-gray-900 text-white py-3.5 rounded-xl font-bold shadow-lg shadow-gray-900/30 hover:-translate-y-0.5 hover:shadow-xl hover:bg-gray-800 transition-all duration-300 flex items-center justify-center gap-2 group mt-4">
                    Kirim Tautan Reset
                    <i class="fas fa-paper-plane opacity-70 group-hover:translate-x-1 group-hover:-translate-y-1 transition-transform"></i>
                </button>
            </form>

            <!-- WA Help Block -->
            <div class="mt-6 bg-green-50 rounded-xl p-4 flex items-start gap-3 border border-green-100">
                <i class="fab fa-whatsapp text-2xl text-green-500 mt-0.5"></i>
                <div>
                    <p class="text-sm text-gray-700 leading-relaxed">
                        Jika tautan reset tidak terkirim atau Anda mengalami masalah, silakan hubungi Admin via WhatsApp.
                    </p>
                    <a href="https://wa.me/6285600110828" target="_blank" class="inline-block mt-2 text-sm font-bold text-green-600 hover:text-green-700 transition">
                        Chat Admin (+62 856-0011-0828) &rarr;
                    </a>
                </div>
            </div>

            <div class="mt-8 pt-8 border-t border-gray-100 text-center">
                <a href="<?= BASEURL; ?>/auth/login" class="inline-flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-unsoed-blue transition-colors">
                    <i class="fas fa-arrow-left"></i> Kembali ke Halaman Login
                </a>
            </div>
            
        </div>
    </div>
</div>
<?= csrf_field() ?>
