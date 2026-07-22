<div class="container mx-auto px-4 py-8 md:py-12">
    <div class="max-w-5xl mx-auto bg-white rounded-[2rem] shadow-2xl overflow-hidden flex flex-col md:flex-row-reverse min-h-[600px] border border-gray-100">
        
        <!-- Right Side: Image & Badges (Reversed for Reset) -->
        <div class="md:w-1/2 relative bg-gray-900 hidden md:block group">
            <img src="https://images.unsplash.com/photo-1555664424-778a1e5e1b48?auto=format&fit=crop&q=80" alt="Unsoed Press Security" class="absolute inset-0 w-full h-full object-cover opacity-50 group-hover:scale-105 transition-transform duration-700 grayscale mix-blend-overlay">
            <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-800/80 to-transparent"></div>
            <div class="absolute inset-0 p-12 flex flex-col justify-end text-right items-end">
                <div class="w-16 h-16 rounded-2xl bg-white/10 backdrop-blur-md flex items-center justify-center text-white mb-8 border border-white/20 shadow-xl">
                    <i class="fas fa-lock text-3xl text-unsoed-yellow"></i>
                </div>
                <h2 class="text-4xl font-serif font-bold text-white mb-4 leading-tight">Buat Kata Sandi Baru</h2>
                <p class="text-gray-300 leading-relaxed max-w-sm">Pastikan kata sandi baru Anda kuat dan mudah diingat. Kombinasikan huruf, angka, dan simbol untuk keamanan maksimal.</p>
            </div>
        </div>

        <!-- Left Side: Form -->
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

            <div class="mb-10">
                <a href="<?= BASEURL; ?>" class="inline-flex items-center gap-2 text-sm font-semibold text-unsoed-blue hover:text-unsoed-yellow transition-colors mb-6 group">
                    <i class="fas fa-arrow-left group-hover:-translate-x-1 transition-transform"></i> Kembali ke Beranda
                </a>
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Amankan Akun Anda</h2>
                <p class="text-gray-500 text-sm">Langkah terakhir untuk mengembalikan akses akun Anda.</p>
            </div>

            <?php if(isset($data['error'])): ?>
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r-lg flex items-center gap-3">
                    <i class="fas fa-exclamation-circle text-red-500"></i>
                    <p class="text-sm text-red-700 font-medium"><?= $data['error'] ?></p>
                </div>
            <?php endif; ?>

            <form action="<?= BASEURL; ?>/auth/reset_password/<?= $data['token'] ?>" method="POST" class="space-y-5">
                <div>
                    <label for="password" class="block text-sm font-bold text-gray-700 mb-2">Kata Sandi Baru</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none transition-colors group-focus-within:text-unsoed-blue text-gray-400">
                            <i class="fas fa-lock"></i>
                        </div>
                        <input type="password" name="password" id="password" class="w-full pl-11 pr-12 py-3.5 bg-gray-50/50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-unsoed-blue/20 focus:border-unsoed-blue transition-all" placeholder="Minimal 6 karakter" minlength="6" required>
                        <button type="button" onclick="togglePassword('password', 'eye-icon-reset1')" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-unsoed-blue focus:outline-none transition-colors">
                            <i id="eye-icon-reset1" class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div>
                    <label for="password_confirm" class="block text-sm font-bold text-gray-700 mb-2">Konfirmasi Kata Sandi Baru</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none transition-colors group-focus-within:text-unsoed-blue text-gray-400">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <input type="password" name="password_confirm" id="password_confirm" class="w-full pl-11 pr-12 py-3.5 bg-gray-50/50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-unsoed-blue/20 focus:border-unsoed-blue transition-all" placeholder="Ketik ulang kata sandi" minlength="6" required>
                        <button type="button" onclick="togglePassword('password_confirm', 'eye-icon-reset2')" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-unsoed-blue focus:outline-none transition-colors">
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

                <button type="submit" class="w-full bg-gray-900 text-white py-3.5 rounded-xl font-bold shadow-lg shadow-gray-900/30 hover:-translate-y-0.5 hover:shadow-xl hover:bg-gray-800 transition-all duration-300 flex items-center justify-center gap-2 group mt-6">
                    Simpan & Login
                    <i class="fas fa-arrow-right opacity-70 group-hover:translate-x-1 transition-transform"></i>
                </button>
            </form>
            
        </div>
    </div>
</div>
