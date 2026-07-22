<div class="mb-8 flex items-center justify-between">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Tambah Pengguna Baru</h1>
        <p class="text-gray-500 mt-1">Buat akun admin atau pelanggan (*customer*) baru dengan lengkap.</p>
    </div>
    <a href="<?= BASEURL; ?>/admin/users" class="px-5 py-2.5 rounded-2xl border border-gray-200 text-gray-600 hover:bg-gray-100 font-bold text-sm transition flex items-center gap-2">
        <i class="fas fa-arrow-left"></i> Kembali ke Daftar
    </a>
</div>

<?php if(isset($_GET['msg']) && $_GET['msg'] == 'email_exists'): ?>
<div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-2xl shadow-sm font-bold flex items-center gap-2.5" role="alert">
    <i class="fas fa-exclamation-circle text-lg"></i> Alamat email yang Anda masukkan sudah terdaftar di sistem. Silakan gunakan email lain.
</div>
<?php endif; ?>

<div class="max-w-3xl bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 bg-unsoed-darkblue text-white flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-unsoed-yellow text-white flex items-center justify-center text-lg font-bold">
            <i class="fas fa-user-plus"></i>
        </div>
        <div>
            <h3 class="font-bold text-lg">Formulir Pendaftaran Akun</h3>
            <p class="text-xs text-gray-300">Pastikan alamat email aktif dan kata sandi disimpan dengan baik.</p>
        </div>
    </div>

    <form action="<?= BASEURL; ?>/admin/store_user" method="POST" class="p-8 space-y-6">
<?= csrf_field() ?><div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">
                    Nama Lengkap <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" required placeholder="Contoh: Budi Santoso, S.T." class="w-full px-4 py-3 rounded-2xl border border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-unsoed-blue/30 focus:border-unsoed-blue transition text-sm">
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">
                    Alamat Email <span class="text-red-500">*</span>
                </label>
                <input type="email" name="email" required placeholder="budi@unsoed.ac.id" class="w-full px-4 py-3 rounded-2xl border border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-unsoed-blue/30 focus:border-unsoed-blue transition text-sm">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">
                    Peran (Role Akses) <span class="text-red-500">*</span>
                </label>
                <select name="role" required class="w-full px-4 py-3 rounded-2xl border border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-unsoed-blue/30 focus:border-unsoed-blue transition text-sm font-semibold">
                    <option value="customer">Customer (Pelanggan / Pembeli)</option>
                    <option value="admin">Admin (Pengelola Panel)</option>
                </select>
                <p class="text-xs text-gray-400 mt-1.5">* Admin memiliki hak akses penuh ke seluruh menu kelola.</p>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">
                    Nomor Telepon / WhatsApp
                </label>
                <input type="text" name="phone" placeholder="081234567890" class="w-full px-4 py-3 rounded-2xl border border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-unsoed-blue/30 focus:border-unsoed-blue transition text-sm">
            </div>
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">
                Kata Sandi (Password) <span class="text-red-500">*</span>
            </label>
            <input type="text" name="password" required value="unsoed123" class="w-full px-4 py-3 rounded-2xl border border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-unsoed-blue/30 focus:border-unsoed-blue font-mono text-sm transition">
            <p class="text-xs text-gray-500 mt-1.5">* Default kata sandi adalah <code class="bg-gray-100 px-2 py-0.5 rounded text-unsoed-blue font-bold font-mono">unsoed123</code>. Anda dapat menggantinya sesuai keinginan.</p>
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">
                Alamat Lengkap / Instansi
            </label>
            <textarea name="address" rows="3" placeholder="Contoh: Jl. HR Bunyamin No. 708, Purwokerto..." class="w-full px-4 py-3 rounded-2xl border border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-unsoed-blue/30 focus:border-unsoed-blue transition text-sm"></textarea>
        </div>

        <div class="pt-4 border-t border-gray-100 flex items-center justify-end gap-3">
            <a href="<?= BASEURL; ?>/admin/users" class="px-6 py-3 rounded-2xl border border-gray-200 text-gray-600 hover:bg-gray-100 font-bold text-sm transition">
                Batal
            </a>
            <button type="submit" class="btn-primary flex items-center gap-2">
                <i class="fas fa-save"></i> Simpan Pengguna
            </button>
        </div>
    </form>
</div>
<?= csrf_field() ?>
