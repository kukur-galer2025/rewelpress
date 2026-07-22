<div class="container mx-auto px-4 py-8 md:py-12">
    <div class="max-w-5xl mx-auto bg-white rounded-[2rem] shadow-2xl overflow-hidden flex flex-col md:flex-row-reverse min-h-[600px] border border-gray-100">
        
        <!-- Right Side: Image & Badges (Reversed for Register) -->
        <div class="md:w-1/2 relative bg-unsoed-yellow hidden md:block group">
            <img src="https://images.unsplash.com/photo-1457369804613-52c61a468e7d?auto=format&fit=crop&q=80" alt="Unsoed Press Bookstore" class="absolute inset-0 w-full h-full object-cover opacity-60 group-hover:scale-105 transition-transform duration-700">
            <div class="absolute inset-0 bg-gradient-to-t from-unsoed-darkblue via-unsoed-darkblue/70 to-transparent"></div>
            <div class="absolute inset-0 p-12 flex flex-col justify-end text-right items-end">
                <div class="flex items-center gap-3 mb-6">
                    <span class="px-4 py-1.5 bg-unsoed-yellow rounded-full text-unsoed-darkblue text-xs font-bold tracking-widest uppercase shadow-lg shadow-unsoed-yellow/30">Member</span>
                    <span class="px-4 py-1.5 bg-white/20 backdrop-blur-md rounded-full text-white text-xs font-bold tracking-widest uppercase border border-white/30">Free</span>
                </div>
                <h2 class="text-4xl font-serif font-bold text-white mb-4 leading-tight">Mulai Perjalanan Intelektual Anda</h2>
                <p class="text-white/80 leading-relaxed max-w-sm">Buat akun sekarang dan nikmati kemudahan membeli buku cetak maupun digital, serta akses eksklusif ke berbagai promo.</p>
                
                <div class="mt-8">
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 backdrop-blur-md rounded-xl border border-white/20">
                        <i class="fas fa-check-circle text-unsoed-yellow"></i>
                        <span class="text-sm font-medium text-white">Diskon Khusus Mahasiswa</span>
                    </div>
                </div>
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
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Buat Akun Baru</h2>
                <p class="text-gray-500 text-sm">Bergabunglah bersama ribuan pembaca setia lainnya.</p>
            </div>

            <?php if(isset($data['error'])): ?>
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r-lg flex items-center gap-3">
                    <i class="fas fa-exclamation-circle text-red-500"></i>
                    <p class="text-sm text-red-700 font-medium"><?= $data['error'] ?></p>
                </div>
            <?php endif; ?>
            
            <?php if(isset($data['success'])): ?>
                <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-r-lg flex items-center gap-3">
                    <i class="fas fa-check-circle text-green-500"></i>
                    <p class="text-sm text-green-700 font-medium"><?= $data['success'] ?></p>
                </div>
            <?php endif; ?>

            <form action="<?= BASEURL; ?>/auth/register" method="POST" class="space-y-5">
                <div>
                    <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none transition-colors group-focus-within:text-unsoed-blue text-gray-400">
                            <i class="fas fa-user"></i>
                        </div>
                        <input type="text" name="name" id="name" class="w-full pl-11 pr-4 py-3.5 bg-gray-50/50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-unsoed-blue/20 focus:border-unsoed-blue transition-all" placeholder="Nama Anda" required>
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-sm font-bold text-gray-700 mb-2">Alamat Email</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none transition-colors group-focus-within:text-unsoed-blue text-gray-400">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <input type="email" name="email" id="email" class="w-full pl-11 pr-4 py-3.5 bg-gray-50/50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-unsoed-blue/20 focus:border-unsoed-blue transition-all" placeholder="email@contoh.com" required>
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-bold text-gray-700 mb-2">Kata Sandi</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none transition-colors group-focus-within:text-unsoed-blue text-gray-400">
                            <i class="fas fa-lock"></i>
                        </div>
                        <input type="password" name="password" id="password" class="w-full pl-11 pr-12 py-3.5 bg-gray-50/50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-unsoed-blue/20 focus:border-unsoed-blue transition-all" placeholder="Minimal 6 karakter" minlength="6" required>
                        <button type="button" onclick="togglePassword('password', 'eye-icon-register')" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-unsoed-blue focus:outline-none transition-colors">
                            <i id="eye-icon-register" class="fas fa-eye"></i>
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

                <button type="submit" class="w-full bg-unsoed-darkblue text-white py-3.5 rounded-xl font-bold shadow-lg shadow-unsoed-darkblue/30 hover:-translate-y-0.5 hover:shadow-xl hover:bg-unsoed-blue transition-all duration-300 mt-6 flex items-center justify-center gap-2 group">
                    Daftar Sekarang
                    <i class="fas fa-arrow-right opacity-70 group-hover:translate-x-1 transition-transform"></i>
                </button>

                <div class="relative flex items-center justify-center my-6">
                    <div class="absolute border-t border-gray-200 w-full"></div>
                    <div class="relative bg-white px-4 text-sm text-gray-500 font-medium">Atau</div>
                </div>

                <a href="<?= BASEURL; ?>/auth/google_login" class="w-full bg-white border border-gray-200 text-gray-700 py-3.5 rounded-xl font-bold hover:-translate-y-0.5 hover:shadow-md hover:bg-gray-50 transition-all duration-300 flex items-center justify-center gap-3">
                    <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-5 h-5" alt="Google">
                    Daftar dengan Google
                </a>
            </form>

            <div class="mt-8 pt-8 border-t border-gray-100 text-center">
                <p class="text-sm text-gray-500">
                    Sudah memiliki akun? <a href="<?= BASEURL; ?>/auth/login" class="font-bold text-unsoed-blue hover:text-unsoed-yellow transition-colors ml-1">Masuk di sini</a>
                </p>
            </div>
            
            <!-- Absolute background decoration -->
            <div class="absolute top-0 left-0 -mt-16 -ml-16 w-32 h-32 bg-unsoed-yellow/10 rounded-full blur-3xl pointer-events-none"></div>
        </div>
    </div>
</div>
