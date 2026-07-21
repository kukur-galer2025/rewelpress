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

    <!-- Login Card -->
    <div class="bg-white/90 backdrop-blur-md rounded-3xl shadow-2xl border border-white p-8 md:p-10">
        <h2 class="text-2xl font-bold text-gray-800 mb-2">Selamat Datang Kembali!</h2>
        <p class="text-gray-500 mb-8 text-sm">Masuk ke akun Anda untuk melanjutkan aktivitas.</p>

        <?php if(isset($data['error'])): ?>
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r-lg">
                <p class="text-sm text-red-700 font-medium"><?= $data['error'] ?></p>
            </div>
        <?php endif; ?>
        
        <?php if(isset($_GET['reset']) && $_GET['reset'] == 'success'): ?>
            <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-r-lg">
                <p class="text-sm text-green-700 font-medium">Password berhasil direset! Silakan login.</p>
            </div>
        <?php endif; ?>

        <form action="<?= BASEURL; ?>/auth/login" method="POST" class="space-y-6">
            <div>
                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Alamat Email</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fas fa-envelope text-gray-400"></i>
                    </div>
                    <input type="email" name="email" id="email" class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-unsoed-yellow/50 focus:border-unsoed-yellow transition-all" placeholder="email@contoh.com" required>
                </div>
            </div>

            <div>
                <div class="flex justify-between items-center mb-2">
                    <label for="password" class="block text-sm font-semibold text-gray-700">Kata Sandi</label>
                    <a href="<?= BASEURL; ?>/auth/forgot_password" class="text-sm font-medium text-unsoed-blue hover:text-unsoed-yellow transition-colors">Lupa sandi?</a>
                </div>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fas fa-lock text-gray-400"></i>
                    </div>
                    <input type="password" name="password" id="password" class="w-full pl-11 pr-12 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-unsoed-yellow/50 focus:border-unsoed-yellow transition-all" placeholder="••••••••" required>
                    <button type="button" onclick="togglePassword('password', 'eye-icon-login')" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-unsoed-blue focus:outline-none">
                        <i id="eye-icon-login" class="fas fa-eye"></i>
                    </button>
                </div>
            </div>

            <script>
                function togglePassword(inputId, iconId) {
                    const input = document.getElementById(inputId);
                    const icon = document.getElementById(iconId);
                    if (input.type === "password") {
                        input.type = "text";
                        icon.classList.remove("fa-eye");
                        icon.classList.add("fa-eye-slash");
                    } else {
                        input.type = "password";
                        icon.classList.remove("fa-eye-slash");
                        icon.classList.add("fa-eye");
                    }
                }
            </script>

            <button type="submit" class="w-full bg-unsoed-blue text-white py-3 rounded-xl font-bold shadow-lg shadow-unsoed-blue/30 hover:-translate-y-1 hover:shadow-xl hover:bg-unsoed-darkblue transition-all duration-300">
                Masuk
            </button>
        </form>

        <div class="mt-8 text-center">
            <p class="text-sm text-gray-600">
                Belum punya akun? <a href="<?= BASEURL; ?>/auth/register" class="font-bold text-unsoed-blue hover:text-unsoed-yellow transition-colors">Daftar Sekarang</a>
            </p>
        </div>
    </div>
    
    <div class="text-center mt-8 text-xs text-gray-400">
        &copy; <?= date('Y') ?> Universitas Jenderal Soedirman.
    </div>
</div>
