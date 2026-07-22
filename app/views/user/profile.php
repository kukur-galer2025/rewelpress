<?php $user = $data['user']; ?>

<div class="bg-unsoed-darkblue py-12 relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-r from-unsoed-darkblue to-unsoed-blue opacity-90"></div>
    <div class="container mx-auto px-4 relative z-10 text-center">
        <h1 class="text-4xl md:text-5xl font-serif font-bold text-white mb-4">Profil Saya</h1>
        <p class="text-blue-100 max-w-2xl mx-auto">Kelola informasi akun dan pengaturan keamanan Anda.</p>
    </div>
</div>

<section class="py-16 bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 max-w-3xl">
        
        <?php if(isset($_SESSION['flash_success'])): ?>
            <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-r-lg flex items-center gap-3">
                <i class="fas fa-check-circle text-green-500"></i>
                <p class="text-sm text-green-700 font-medium"><?= esc($_SESSION['flash_success']) ?></p>
            </div>
            <?php unset($_SESSION['flash_success']); ?>
        <?php endif; ?>

        <?php if(isset($_SESSION['flash_error'])): ?>
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r-lg flex items-center gap-3">
                <i class="fas fa-exclamation-circle text-red-500"></i>
                <p class="text-sm text-red-700 font-medium"><?= esc($_SESSION['flash_error']) ?></p>
            </div>
            <?php unset($_SESSION['flash_error']); ?>
        <?php endif; ?>

        <form action="<?= BASEURL ?>/user/update_profile" method="POST">
<?= csrf_field() ?><!-- Info Dasar -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 mb-6">
                <h2 class="text-lg font-bold text-gray-800 mb-6 flex items-center gap-2">
                    <i class="fas fa-user-circle text-unsoed-blue"></i> Informasi Akun
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap</label>
                        <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-unsoed-blue/20 focus:border-unsoed-blue outline-none transition text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Alamat Email</label>
                        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-unsoed-blue/20 focus:border-unsoed-blue outline-none transition text-sm">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Nomor Telepon</label>
                        <input type="tel" name="phone" value="<?= htmlspecialchars($user['phone'] ?? '') ?>" placeholder="08xxxxxxxxxx"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-unsoed-blue/20 focus:border-unsoed-blue outline-none transition text-sm">
                    </div>
                </div>
            </div>

            <!-- Ubah Password -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 mb-6">
                <h2 class="text-lg font-bold text-gray-800 mb-2 flex items-center gap-2">
                    <i class="fas fa-lock text-unsoed-yellow"></i> Ubah Kata Sandi
                </h2>
                <p class="text-xs text-gray-500 mb-6">Kosongkan jika tidak ingin mengubah kata sandi.</p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Password Saat Ini</label>
                        <input type="password" name="current_password" placeholder="Masukkan password lama Anda"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-unsoed-blue/20 focus:border-unsoed-blue outline-none transition text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Password Baru</label>
                        <input type="password" name="new_password" placeholder="Minimal 6 karakter"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-unsoed-blue/20 focus:border-unsoed-blue outline-none transition text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Konfirmasi Password Baru</label>
                        <input type="password" name="confirm_password" placeholder="Ketik ulang password baru"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-unsoed-blue/20 focus:border-unsoed-blue outline-none transition text-sm">
                    </div>
                </div>
            </div>

            <!-- Submit -->
            <div class="flex justify-end">
                <button type="submit" class="bg-unsoed-blue text-white px-8 py-3 rounded-xl font-bold shadow-lg shadow-unsoed-blue/20 hover:-translate-y-0.5 hover:shadow-xl transition-all flex items-center gap-2">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</section>
<?= csrf_field() ?>
