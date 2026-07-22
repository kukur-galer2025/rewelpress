<div class="mb-8 flex items-center justify-between">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Edit Data Pengguna</h1>
        <p class="text-gray-500 mt-1">Perbarui profil, peran akses, atau reset kata sandi pengguna.</p>
    </div>
    <a href="<?= BASEURL; ?>/admin/users" class="px-5 py-2.5 rounded-2xl border border-gray-200 text-gray-600 hover:bg-gray-100 font-bold text-sm transition flex items-center gap-2">
        <i class="fas fa-arrow-left"></i> Kembali ke Daftar
    </a>
</div>

<div class="max-w-3xl bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 bg-unsoed-darkblue text-white flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-unsoed-yellow text-white flex items-center justify-center text-lg font-bold">
            <i class="fas fa-user-edit"></i>
        </div>
        <div>
            <h3 class="font-bold text-lg">Edit Pengguna: <?= htmlspecialchars($data['user']['name']) ?></h3>
            <p class="text-xs text-gray-300">ID Akun: #<?= $data['user']['id'] ?> | Terdaftar pada <?= date('d M Y', strtotime($data['user']['created_at'])) ?></p>
        </div>
    </div>

    <form action="<?= BASEURL; ?>/admin/update_user" method="POST" class="p-8 space-y-6">
        <input type="hidden" name="id" value="<?= $data['user']['id'] ?>">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">
                    Nama Lengkap <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" required value="<?= htmlspecialchars($data['user']['name']) ?>" class="w-full px-4 py-3 rounded-2xl border border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-unsoed-blue/30 focus:border-unsoed-blue transition text-sm">
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">
                    Alamat Email <span class="text-red-500">*</span>
                </label>
                <input type="email" name="email" required value="<?= htmlspecialchars($data['user']['email']) ?>" class="w-full px-4 py-3 rounded-2xl border border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-unsoed-blue/30 focus:border-unsoed-blue transition text-sm">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">
                    Peran (Role Akses) <span class="text-red-500">*</span>
                </label>
                <select name="role" required class="w-full px-4 py-3 rounded-2xl border border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-unsoed-blue/30 focus:border-unsoed-blue transition text-sm font-semibold">
                    <option value="customer" <?= $data['user']['role'] == 'customer' ? 'selected' : '' ?>>Customer (Pelanggan / Pembeli)</option>
                    <option value="admin" <?= $data['user']['role'] == 'admin' ? 'selected' : '' ?>>Admin (Pengelola Panel)</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">
                    Nomor Telepon / WhatsApp
                </label>
                <input type="text" name="phone" value="<?= htmlspecialchars($data['user']['phone'] ?? '') ?>" placeholder="081234567890" class="w-full px-4 py-3 rounded-2xl border border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-unsoed-blue/30 focus:border-unsoed-blue transition text-sm">
            </div>
        </div>

        <div class="p-5 bg-yellow-50/70 border border-yellow-200 rounded-2xl">
            <label class="block text-sm font-bold text-gray-800 mb-2">
                <i class="fas fa-key text-yellow-600 mr-1.5"></i> Ganti Kata Sandi (Opsional)
            </label>
            <input type="text" name="password" placeholder="Kosongkan jika tidak ingin mengubah kata sandi" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-white focus:ring-2 focus:ring-unsoed-blue/30 focus:border-unsoed-blue font-mono text-sm transition">
            <p class="text-xs text-gray-500 mt-1.5">* Isi kolom ini hanya jika Anda ingin mereset/mengganti password pengguna tersebut.</p>
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">
                Alamat Lengkap / Instansi
            </label>
            <textarea name="address" rows="3" placeholder="Contoh: Jl. HR Bunyamin No. 708, Purwokerto..." class="w-full px-4 py-3 rounded-2xl border border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-unsoed-blue/30 focus:border-unsoed-blue transition text-sm"><?= htmlspecialchars($data['user']['address'] ?? '') ?></textarea>
        </div>

        <div class="pt-4 border-t border-gray-100 flex items-center justify-end gap-3">
            <a href="<?= BASEURL; ?>/admin/users" class="px-6 py-3 rounded-2xl border border-gray-200 text-gray-600 hover:bg-gray-100 font-bold text-sm transition">
                Batal
            </a>
            <button type="submit" class="btn-primary flex items-center gap-2">
                <i class="fas fa-check"></i> Simpan Perubahan
            </button>
        </div>
    </form>
</div>
