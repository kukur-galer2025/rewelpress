<div class="w-full max-w-md mx-auto">
    <!-- Logo -->
    <div class="text-center mb-8">
        <a href="<?= BASEURL; ?>" class="inline-flex items-center gap-3 group">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-unsoed-yellow to-yellow-500 flex items-center justify-center text-white shadow-lg shadow-unsoed-yellow/30 group-hover:rotate-12 transition-transform duration-300">
                <i class="fas fa-book-reader text-2xl"></i>
            </div>
            <div class="font-serif text-3xl font-bold tracking-tight text-unsoed-blue">
                UNSOED<span class="text-unsoed-yellow">PRESS</span>
            </div>
        </a>
    </div>

    <!-- Forgot Password Card -->
    <div class="bg-white/90 backdrop-blur-md rounded-3xl shadow-2xl border border-white p-8 md:p-10">
        <div class="w-16 h-16 bg-blue-50 text-unsoed-blue rounded-full flex items-center justify-center text-2xl mb-6 mx-auto">
            <i class="fas fa-key"></i>
        </div>
        <h2 class="text-2xl font-bold text-gray-800 mb-2 text-center">Lupa Kata Sandi?</h2>
        <p class="text-gray-500 mb-8 text-sm text-center">Jangan khawatir! Masukkan alamat email yang terdaftar dan kami akan mengirimkan instruksi pemulihan.</p>

        <?php if(isset($data['error'])): ?>
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r-lg">
                <p class="text-sm text-red-700 font-medium"><?= $data['error'] ?></p>
            </div>
        <?php endif; ?>
        
        <?php if(isset($data['success'])): ?>
            <div class="bg-green-50 border border-green-200 p-4 mb-6 rounded-xl">
                <p class="text-sm text-green-700 font-medium text-center"><?= $data['success'] ?></p>
            </div>
        <?php else: ?>
            <form action="<?= BASEURL; ?>/auth/forgot_password" method="POST" class="space-y-6">
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Alamat Email Terdaftar</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <input type="email" name="email" id="email" class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-unsoed-yellow/50 focus:border-unsoed-yellow transition-all" placeholder="email@contoh.com" required>
                    </div>
                </div>

                <button type="submit" class="w-full bg-unsoed-blue text-white py-3 rounded-xl font-bold shadow-lg shadow-unsoed-blue/30 hover:-translate-y-1 hover:shadow-xl hover:bg-unsoed-darkblue transition-all duration-300">
                    Kirim Link Pemulihan
                </button>
            </form>
        <?php endif; ?>

        <div class="mt-8 text-center">
            <a href="<?= BASEURL; ?>/auth/login" class="text-sm font-bold text-gray-600 hover:text-unsoed-blue transition-colors flex items-center justify-center gap-2">
                <i class="fas fa-arrow-left"></i> Kembali ke Login
            </a>
        </div>
    </div>
    
    <div class="text-center mt-8 text-xs text-gray-400">
        &copy; <?= date('Y') ?> Universitas Jenderal Soedirman.
    </div>
</div>
