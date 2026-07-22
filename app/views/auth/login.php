<div class="container mx-auto px-4 py-8 md:py-12">
    <div class="max-w-5xl mx-auto bg-white rounded-[2rem] shadow-2xl overflow-hidden flex flex-col md:flex-row min-h-[600px] border border-gray-100">
        
        <!-- Left Side: Image & Badges -->
        <div class="md:w-1/2 relative bg-unsoed-darkblue hidden md:block group">
            <img src="https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?auto=format&fit=crop&q=80" alt="Unsoed Press Library" class="absolute inset-0 w-full h-full object-cover opacity-50 group-hover:scale-105 transition-transform duration-700">
            <div class="absolute inset-0 bg-gradient-to-t from-unsoed-darkblue via-unsoed-blue/60 to-transparent"></div>
            <div class="absolute inset-0 p-12 flex flex-col justify-end">
                <div class="flex items-center gap-3 mb-6">
                    <span class="px-4 py-1.5 bg-white/20 backdrop-blur-md rounded-full text-white text-xs font-bold tracking-widest uppercase border border-white/30">Official</span>
                    <span class="px-4 py-1.5 bg-unsoed-yellow rounded-full text-unsoed-darkblue text-xs font-bold tracking-widest uppercase shadow-lg shadow-unsoed-yellow/30">Trusted</span>
                </div>
                <h2 class="text-4xl font-serif font-bold text-white mb-4 leading-tight">Jelajahi Ilmu Pengetahuan Tanpa Batas</h2>
                <p class="text-white/80 leading-relaxed">Masuk untuk mengakses koleksi literatur unggulan, publikasi ilmiah, dan layanan penerbitan terbaik dari Universitas Jenderal Soedirman.</p>
                
                <div class="mt-8 flex items-center gap-4">
                    <div class="flex -space-x-3">
                        <img class="w-10 h-10 rounded-full border-2 border-unsoed-blue object-cover" src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=100&q=80">
                        <img class="w-10 h-10 rounded-full border-2 border-unsoed-blue object-cover" src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&w=100&q=80">
                        <img class="w-10 h-10 rounded-full border-2 border-unsoed-blue object-cover" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=100&q=80">
                        <div class="w-10 h-10 rounded-full border-2 border-unsoed-blue bg-white/20 backdrop-blur-sm flex items-center justify-center text-xs font-bold text-white">+10k</div>
                    </div>
                    <div class="text-sm text-white/80 font-medium">Pembaca aktif</div>
                </div>
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

            <div class="mb-10">
                <a href="<?= BASEURL; ?>" class="inline-flex items-center gap-2 text-sm font-semibold text-unsoed-blue hover:text-unsoed-yellow transition-colors mb-6 group">
                    <i class="fas fa-arrow-left group-hover:-translate-x-1 transition-transform"></i> Kembali ke Beranda
                </a>
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Selamat Datang!</h2>
                <p class="text-gray-500 text-sm">Silakan masuk menggunakan kredensial Anda.</p>
            </div>

            <?php if(isset($data['error'])): ?>
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r-lg flex items-center gap-3">
                    <i class="fas fa-exclamation-circle text-red-500"></i>
                    <p class="text-sm text-red-700 font-medium"><?= esc($data['error']) ?></p>
                </div>
            <?php endif; ?>
            
            <?php if(isset($_GET['reset']) && $_GET['reset'] == 'success'): ?>
                <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-r-lg flex items-center gap-3">
                    <i class="fas fa-check-circle text-green-500"></i>
                    <p class="text-sm text-green-700 font-medium">Password berhasil direset! Silakan login.</p>
                </div>
            <?php endif; ?>

            <form action="<?= BASEURL; ?>/auth/login" method="POST" class="space-y-6">
<?= csrf_field() ?><div>
                    <label for="email" class="block text-sm font-bold text-gray-700 mb-2">Alamat Email</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none transition-colors group-focus-within:text-unsoed-blue text-gray-400">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <input type="email" name="email" id="email" class="w-full pl-11 pr-4 py-3.5 bg-gray-50/50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-unsoed-blue/20 focus:border-unsoed-blue transition-all" placeholder="email@contoh.com" required>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between items-center mb-2">
                        <label for="password" class="block text-sm font-bold text-gray-700">Kata Sandi</label>
                        <a href="<?= BASEURL; ?>/auth/forgot_password" class="text-xs font-bold text-unsoed-blue hover:text-unsoed-yellow transition-colors">Lupa sandi?</a>
                    </div>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none transition-colors group-focus-within:text-unsoed-blue text-gray-400">
                            <i class="fas fa-lock"></i>
                        </div>
                        <input type="password" name="password" id="password" class="w-full pl-11 pr-12 py-3.5 bg-gray-50/50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-unsoed-blue/20 focus:border-unsoed-blue transition-all" placeholder="••••••••" required>
                        <button type="button" onclick="togglePassword('password', 'eye-icon-login')" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-unsoed-blue focus:outline-none transition-colors">
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

                <button type="submit" class="w-full bg-unsoed-darkblue text-white py-3.5 rounded-xl font-bold shadow-lg shadow-unsoed-darkblue/30 hover:-translate-y-0.5 hover:shadow-xl hover:bg-unsoed-blue transition-all duration-300 flex items-center justify-center gap-2 group mt-4">
                    Masuk Sekarang
                    <i class="fas fa-arrow-right opacity-70 group-hover:translate-x-1 transition-transform"></i>
                </button>

                <div class="relative flex items-center justify-center my-6">
                    <div class="absolute border-t border-gray-200 w-full"></div>
                    <div class="relative bg-white px-4 text-sm text-gray-500 font-medium">Atau</div>
                </div>

                <a href="<?= BASEURL; ?>/auth/google_login" class="w-full bg-white border border-gray-200 text-gray-700 py-3.5 rounded-xl font-bold hover:-translate-y-0.5 hover:shadow-md hover:bg-gray-50 transition-all duration-300 flex items-center justify-center gap-3">
                    <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-5 h-5" alt="Google">
                    Lanjutkan dengan Google
                </a>
            </form>

            <div class="mt-8 pt-8 border-t border-gray-100 text-center">
                <p class="text-sm text-gray-500">
                    Belum memiliki akun? <a href="<?= BASEURL; ?>/auth/register" class="font-bold text-unsoed-blue hover:text-unsoed-yellow transition-colors ml-1">Daftar Akun Baru</a>
                </p>
            </div>
            
            <!-- Absolute background decoration -->
            <div class="absolute top-0 right-0 -mt-16 -mr-16 w-32 h-32 bg-unsoed-yellow/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 -mb-16 -ml-16 w-32 h-32 bg-unsoed-blue/10 rounded-full blur-3xl pointer-events-none"></div>
        </div>
    </div>
</div>
<?= csrf_field() ?>
