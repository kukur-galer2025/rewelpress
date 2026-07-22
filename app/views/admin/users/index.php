<div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Manajemen Pengguna</h1>
        <p class="text-gray-500 mt-1">Kelola data akun admin dan pelanggan (*customer*) yang terdaftar di sistem.</p>
    </div>
    <a href="<?= BASEURL; ?>/admin/create_user" class="btn-primary flex items-center justify-center gap-2 shadow-md w-full md:w-auto">
        <i class="fas fa-user-plus"></i> Tambah Pengguna Baru
    </a>
</div>

<?php if(isset($_GET['msg'])): ?>
    <div class="mb-6">
        <?php if($_GET['msg'] == 'success_add'): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-2xl shadow-sm font-bold flex items-center gap-2.5" role="alert">
                <i class="fas fa-check-circle text-lg"></i> Pengguna baru berhasil ditambahkan ke dalam sistem!
            </div>
        <?php elseif($_GET['msg'] == 'success_update'): ?>
            <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded-2xl shadow-sm font-bold flex items-center gap-2.5" role="alert">
                <i class="fas fa-info-circle text-lg"></i> Data pengguna berhasil diperbarui!
            </div>
        <?php elseif($_GET['msg'] == 'success_delete'): ?>
            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded-2xl shadow-sm font-bold flex items-center gap-2.5" role="alert">
                <i class="fas fa-trash-alt text-lg"></i> Akun pengguna berhasil dihapus dari sistem!
            </div>
        <?php elseif($_GET['msg'] == 'email_exists'): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-2xl shadow-sm font-bold flex items-center gap-2.5" role="alert">
                <i class="fas fa-exclamation-circle text-lg"></i> Gagal menambahkan! Alamat email tersebut sudah terdaftar.
            </div>
        <?php elseif($_GET['msg'] == 'error_delete'): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-2xl shadow-sm font-bold flex items-center gap-2.5" role="alert">
                <i class="fas fa-exclamation-triangle text-lg"></i> Gagal menghapus pengguna (Anda tidak dapat menghapus akun Anda sendiri yang sedang aktif).
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>

<div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-gray-50/50">
        <div class="flex items-center gap-2 font-bold text-gray-700">
            <i class="fas fa-users text-unsoed-blue"></i>
            <span>Daftar Pengguna Terdaftar</span>
            <span class="ml-2 bg-unsoed-blue/10 text-unsoed-blue text-xs px-3 py-1 rounded-full"><?= count($data['users']) ?> Akun</span>
        </div>
        <div class="flex items-center gap-2 text-xs text-gray-500">
            <span class="inline-block w-3 h-3 rounded-full bg-purple-500"></span> Admin
            <span class="inline-block w-3 h-3 rounded-full bg-blue-500 ml-2"></span> Customer
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100 text-xs uppercase text-gray-500 font-bold tracking-wider">
                    <th class="p-4 pl-6">ID</th>
                    <th class="p-4">Pengguna</th>
                    <th class="p-4">Peran (Role)</th>
                    <th class="p-4">Telepon / WhatsApp</th>
                    <th class="p-4">Tanggal Daftar</th>
                    <th class="p-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php if(empty($data['users'])): ?>
                <tr>
                    <td colspan="6" class="p-12 text-center text-gray-400">
                        <i class="fas fa-user-slash text-4xl mb-3 block text-gray-200"></i>
                        Belum ada data pengguna di database.
                    </td>
                </tr>
                <?php else: foreach($data['users'] as $user): ?>
                <tr class="hover:bg-gray-50/80 transition-colors">
                    <td class="p-4 pl-6 font-bold text-gray-500 text-sm">
                        #<?= $user['id'] ?>
                    </td>
                    <td class="p-4">
                        <div class="flex items-center gap-3.5">
                            <div class="w-10 h-10 rounded-2xl <?= $user['role'] == 'admin' ? 'bg-purple-600 text-white shadow-md shadow-purple-500/20' : 'bg-unsoed-blue text-white shadow-md shadow-unsoed-blue/20' ?> flex items-center justify-center font-bold text-base flex-shrink-0">
                                <?= strtoupper(substr($user['name'], 0, 1)) ?>
                            </div>
                            <div>
                                <p class="font-bold text-gray-900 text-sm flex items-center gap-1.5">
                                    <?= htmlspecialchars($user['name']) ?>
                                    <?php if(isset($_SESSION['user_id']) && $_SESSION['user_id'] == $user['id']): ?>
                                        <span class="bg-green-100 text-green-700 text-[10px] px-2 py-0.5 rounded-full font-bold">Anda</span>
                                    <?php endif; ?>
                                </p>
                                <p class="text-xs text-gray-500 flex items-center gap-1 mt-0.5">
                                    <i class="fas fa-envelope text-[10px] text-gray-400"></i>
                                    <?= htmlspecialchars($user['email']) ?>
                                </p>
                            </div>
                        </div>
                    </td>
                    <td class="p-4">
                        <?php if($user['role'] == 'admin'): ?>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-purple-50 text-purple-700 border border-purple-200 rounded-full text-xs font-extrabold uppercase tracking-wider">
                                <i class="fas fa-shield-alt text-purple-600"></i> Admin
                            </span>
                        <?php else: ?>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-blue-50 text-blue-700 border border-blue-200 rounded-full text-xs font-bold uppercase tracking-wider">
                                <i class="fas fa-user"></i> Customer
                            </span>
                        <?php endif; ?>
                    </td>
                    <td class="p-4 text-sm text-gray-600 font-medium">
                        <?php if(!empty($user['phone'])): ?>
                            <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $user['phone']) ?>" target="_blank" class="text-green-600 hover:underline flex items-center gap-1.5">
                                <i class="fab fa-whatsapp"></i> <?= htmlspecialchars($user['phone']) ?>
                            </a>
                        <?php else: ?>
                            <span class="text-gray-300 italic text-xs">- Belum diisi -</span>
                        <?php endif; ?>
                    </td>
                    <td class="p-4 text-xs text-gray-500 font-medium">
                        <?= date('d M Y, H:i', strtotime($user['created_at'])) ?>
                    </td>
                    <td class="p-4 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <a href="<?= BASEURL; ?>/admin/edit_user/<?= $user['id'] ?>" class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition flex items-center justify-center shadow-sm" title="Edit Data Pengguna">
                                <i class="fas fa-edit text-sm"></i>
                            </a>
                            <?php if(isset($_SESSION['user_id']) && $_SESSION['user_id'] != $user['id']): ?>
                            <a href="<?= BASEURL; ?>/admin/delete_user/<?= $user['id'] ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus akun pengguna <?= htmlspecialchars(addslashes($user['name'])) ?> secara permanen?')" class="w-9 h-9 rounded-xl bg-red-50 text-red-600 hover:bg-red-600 hover:text-white transition flex items-center justify-center shadow-sm" title="Hapus Pengguna">
                                <i class="fas fa-trash-alt text-sm"></i>
                            </a>
                            <?php else: ?>
                            <span class="w-9 h-9 rounded-xl bg-gray-100 text-gray-300 flex items-center justify-center cursor-not-allowed" title="Akun Anda Sendiri Tidak Dapat Dihapus">
                                <i class="fas fa-lock text-sm"></i>
                            </span>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; endif; ?>
            </tbody>
        </table>
    </div>
</div>
