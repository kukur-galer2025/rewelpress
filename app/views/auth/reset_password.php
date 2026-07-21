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

    <!-- Reset Password Card -->
    <div class="bg-white/90 backdrop-blur-md rounded-3xl shadow-2xl border border-white p-8 md:p-10">
        <h2 class="text-2xl font-bold text-gray-800 mb-2">Buat Kata Sandi Baru</h2>
        <p class="text-gray-500 mb-8 text-sm">Pastikan kata sandi baru Anda kuat dan mudah diingat.</p>

        <?php if(isset($data['error'])): ?>
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r-lg">
                <p class="text-sm text-red-700 font-medium"><?= $data['error'] ?></p>
            </div>
        <?php endif; ?>

        <form action="<?= BASEURL; ?>/auth/reset_password/<?= $data['token'] ?>" method="POST" class="space-y-6">
            <div>
                <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Kata Sandi Baru</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fas fa-lock text-gray-400"></i>
                    </div>
                    <input type="password" name="password" id="password" class="w-full pl-11 pr-12 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-unsoed-yellow/50 focus:border-unsoed-yellow transition-all" placeholder="Minimal 6 karakter" minlength="6" required>
                    <button type="button" onclick="togglePassword('password', 'eye-icon-reset1')" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-unsoed-blue focus:outline-none">
                        <i id="eye-icon-reset1" class="fas fa-eye"></i>
                    </button>
                </div>
            </div>

            <div>
                <label for="password_confirm" class="block text-sm font-semibold text-gray-700 mb-2">Konfirmasi Kata Sandi Baru</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fas fa-check-circle text-gray-400"></i>
                    </div>
                    <input type="password" name="password_confirm" id="password_confirm" class="w-full pl-11 pr-12 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-unsoed-yellow/50 focus:border-unsoed-yellow transition-all" placeholder="Ketik ulang kata sandi" minlength="6" required>
                    <button type="button" onclick="togglePassword('password_confirm', 'eye-icon-reset2')" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-unsoed-blue focus:outline-none">
                        <i id="eye-icon-reset2" class="fas fa-eye"></i>
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
                Simpan & Login
            </button>
        </form>
    </div>
    
    <div class="text-center mt-8 text-xs text-gray-400">
        &copy; <?= date('Y') ?> Universitas Jenderal Soedirman.
    </div>
</div>
