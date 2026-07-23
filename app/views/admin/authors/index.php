<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Kelola Tokoh Penulis</h1>
        <p class="text-gray-500 mt-1">Kelola data tokoh penulis dan akademisi yang ditampilkan di halaman depan.</p>
    </div>
    <a href="<?= BASEURL; ?>/admin/create_author" class="bg-unsoed-blue text-white px-5 py-2.5 rounded-lg font-semibold hover:bg-unsoed-darkblue transition shadow-lg flex items-center gap-2">
        <i class="fas fa-plus"></i> Tambah Penulis
    </a>
</div>

<?php if(isset($_GET['msg'])): ?>
    <div class="mb-6">
        <?php if($_GET['msg'] == 'success_add'): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline font-bold"><i class="fas fa-check-circle mr-2"></i>Tokoh penulis berhasil ditambahkan!</span>
            </div>
        <?php elseif($_GET['msg'] == 'success_edit'): ?>
            <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline font-bold"><i class="fas fa-check-circle mr-2"></i>Data penulis berhasil diperbarui!</span>
            </div>
        <?php elseif($_GET['msg'] == 'success_delete'): ?>
            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline font-bold"><i class="fas fa-trash-alt mr-2"></i>Penulis berhasil dihapus!</span>
            </div>
        <?php elseif($_GET['msg'] == 'error'): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline font-bold"><i class="fas fa-exclamation-triangle mr-2"></i>Terjadi kesalahan saat memproses data.</span>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>

<div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100 text-gray-500 text-xs font-bold uppercase tracking-wider">
                    <th class="p-4 text-center w-16">No</th>
                    <th class="p-4 w-24">Foto</th>
                    <th class="p-4">Nama Penulis & Afiliasi</th>
                    <th class="p-4">Biografi Singkat</th>
                    <th class="p-4 text-center w-36">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                <?php if(empty($data['authors'])): ?>
                <tr>
                    <td colspan="5" class="p-8 text-center text-gray-400 font-medium">
                        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-user-tie text-2xl text-gray-300"></i>
                        </div>
                        Belum ada data tokoh penulis.
                    </td>
                </tr>
                <?php else: ?>
                    <?php $no = 1; foreach($data['authors'] as $author): ?>
                    <tr class="hover:bg-gray-50/80 transition">
                        <td class="p-4 text-center font-medium text-gray-500"><?= $no++ ?></td>
                        <td class="p-4">
                            <div class="w-14 h-14 rounded-2xl overflow-hidden bg-gray-100 border border-gray-200 shadow-sm flex-shrink-0">
                                <?php $photo = !empty($author['photo']) ? $author['photo'] : 'https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp&f=y'; ?>
                                <img src="<?= esc($photo) ?>" alt="<?= htmlspecialchars($author['name']) ?>" class="w-full h-full object-cover">
                            </div>
                        </td>
                        <td class="p-4">
                            <p class="font-bold text-gray-800 text-base mb-0.5"><?= htmlspecialchars($author['name']) ?></p>
                            <?php if(!empty($author['affiliation'])): ?>
                                <span class="inline-block bg-blue-50 text-unsoed-blue text-xs font-semibold px-2.5 py-0.5 rounded-md border border-blue-100">
                                    <?= htmlspecialchars($author['affiliation']) ?>
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="p-4 text-gray-600 max-w-xs">
                            <p class="line-clamp-2 text-xs leading-relaxed"><?= !empty($author['bio']) ? htmlspecialchars($author['bio']) : '<i class="text-gray-400">Belum ada biografi</i>' ?></p>
                        </td>
                        <td class="p-4 text-center">
                            <div class="flex justify-center gap-2">
                                <a href="<?= BASEURL; ?>/admin/edit_author/<?= esc($author['id']) ?>" class="w-9 h-9 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-500 hover:text-white transition" title="Edit Penulis">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="<?= BASEURL; ?>/admin/delete_author/<?= esc($author['id']) ?>" onclick="return confirmAction(this.href, 'Hapus Penulis', 'Apakah Anda yakin ingin menghapus tokoh penulis ini?')" class="w-9 h-9 rounded-lg bg-red-50 text-red-600 flex items-center justify-center hover:bg-red-500 hover:text-white transition" title="Hapus Penulis">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
