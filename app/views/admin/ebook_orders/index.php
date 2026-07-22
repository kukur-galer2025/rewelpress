<div class="mb-8 flex items-center justify-between">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Pesanan E-Book Masuk</h1>
        <p class="text-gray-500 mt-1">Verifikasi pembayaran dan buka akses unduh e-book untuk pembeli.</p>
    </div>
</div>

<?php if(isset($_GET['msg'])): ?>
    <div class="mb-6 px-4 py-3 rounded-2xl shadow-sm font-bold flex items-center gap-2.5 <?= $_GET['msg'] == 'confirmed' ? 'bg-green-100 border border-green-400 text-green-700' : 'bg-yellow-100 border border-yellow-400 text-yellow-700' ?>">
        <i class="fas <?= $_GET['msg'] == 'confirmed' ? 'fa-check-circle' : 'fa-times-circle' ?> text-lg"></i>
        <?= $_GET['msg'] == 'confirmed' ? 'Pembayaran berhasil dikonfirmasi! User sudah bisa mengunduh e-book.' : 'Pesanan berhasil ditolak. Notifikasi telah dikirim ke user.' ?>
    </div>
<?php endif; ?>

<?php
$statusGroups = ['paid' => [], 'pending' => [], 'confirmed' => [], 'rejected' => []];
foreach ($data['orders'] as $o) {
    $statusGroups[$o['status']][] = $o;
}
$waitingVerif = count($statusGroups['paid']);
$waitingPayment = count($statusGroups['pending']);
$totalConfirmed = count($statusGroups['confirmed']);
?>

<!-- Stats -->
<div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
        <p class="text-xs font-semibold text-gray-400 uppercase">Perlu Verifikasi</p>
        <h4 class="text-2xl font-extrabold text-yellow-600 mt-1"><?= esc($waitingVerif) ?></h4>
    </div>
    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
        <p class="text-xs font-semibold text-gray-400 uppercase">Menunggu Bayar</p>
        <h4 class="text-2xl font-extrabold text-blue-600 mt-1"><?= esc($waitingPayment) ?></h4>
    </div>
    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
        <p class="text-xs font-semibold text-gray-400 uppercase">Sudah Dikonfirmasi</p>
        <h4 class="text-2xl font-extrabold text-green-600 mt-1"><?= esc($totalConfirmed) ?></h4>
    </div>
    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
        <p class="text-xs font-semibold text-gray-400 uppercase">Total Pesanan</p>
        <h4 class="text-2xl font-extrabold text-gray-800 mt-1"><?= count($data['orders']) ?></h4>
    </div>
</div>

<div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-5 border-b border-gray-100 flex items-center gap-2 text-gray-700 font-bold bg-gray-50/50">
        <i class="fas fa-tablet-alt text-unsoed-blue"></i> Daftar Semua Pesanan E-Book
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100 text-xs uppercase text-gray-500 font-bold tracking-wider">
                    <th class="p-4 pl-6">ID</th>
                    <th class="p-4">Pembeli</th>
                    <th class="p-4">E-Book</th>
                    <th class="p-4">Nominal</th>
                    <th class="p-4">Bukti Bayar</th>
                    <th class="p-4">Status</th>
                    <th class="p-4">Tanggal</th>
                    <th class="p-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php if(empty($data['orders'])): ?>
                <tr>
                    <td colspan="8" class="p-12 text-center text-gray-400">
                        <i class="fas fa-inbox text-4xl mb-3 block text-gray-200"></i>
                        Belum ada pesanan e-book masuk.
                    </td>
                </tr>
                <?php else: foreach($data['orders'] as $ord): ?>
                <tr class="hover:bg-gray-50/80 transition-colors <?= $ord['status'] == 'paid' ? 'bg-yellow-50/30' : '' ?>">
                    <td class="p-4 pl-6 font-bold text-gray-500 text-sm">#EBO-<?= esc($ord['id']) ?></td>
                    <td class="p-4">
                        <p class="font-bold text-gray-900 text-sm"><?= htmlspecialchars($ord['user_name']) ?></p>
                        <p class="text-xs text-gray-400"><?= htmlspecialchars($ord['user_email']) ?></p>
                    </td>
                    <td class="p-4 max-w-[200px]">
                        <p class="font-semibold text-gray-800 text-sm line-clamp-2"><?= htmlspecialchars($ord['ebook_title']) ?></p>
                    </td>
                    <td class="p-4 font-extrabold text-unsoed-blue text-sm">
                        Rp <?= number_format($ord['amount'], 0, ',', '.') ?>
                    </td>
                    <td class="p-4">
                        <?php if(!empty($ord['payment_receipt'])): ?>
                            <a href="<?= htmlspecialchars($ord['payment_receipt']) ?>" target="_blank"
                               class="inline-flex items-center gap-1.5 text-xs bg-blue-50 text-blue-700 border border-blue-200 px-3 py-1.5 rounded-xl font-bold hover:bg-blue-100 transition">
                                <i class="fas fa-eye"></i> Lihat Bukti
                            </a>
                        <?php else: ?>
                            <span class="text-xs text-gray-400 italic">Belum ada</span>
                        <?php endif; ?>
                    </td>
                    <td class="p-4">
                        <?php
                        $statusUI = [
                            'pending'   => ['bg-blue-50 text-blue-700 border-blue-200',    'Menunggu Bayar'],
                            'paid'      => ['bg-yellow-50 text-yellow-700 border-yellow-300', 'Perlu Verifikasi'],
                            'confirmed' => ['bg-green-50 text-green-700 border-green-200',  'Dikonfirmasi'],
                            'rejected'  => ['bg-red-50 text-red-600 border-red-200',        'Ditolak'],
                        ];
                        [$sCls, $sLabel] = $statusUI[$ord['status']] ?? $statusUI['pending'];
                        ?>
                        <span class="inline-flex items-center px-3 py-1 rounded-full border text-xs font-bold uppercase tracking-wider <?= esc($sCls) ?>">
                            <?php if($ord['status'] == 'paid'): ?>
                                <span class="w-1.5 h-1.5 rounded-full bg-yellow-500 animate-pulse mr-1.5"></span>
                            <?php endif; ?>
                            <?= esc($sLabel) ?>
                        </span>
                    </td>
                    <td class="p-4 text-xs text-gray-500">
                        <?= date('d M Y H:i', strtotime($ord['created_at'])) ?>
                    </td>
                    <td class="p-4 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <?php if($ord['status'] === 'paid'): ?>
                                <!-- KONFIRMASI -->
                                <a href="<?= BASEURL ?>/admin/confirm_ebook_order/<?= esc($ord['id']) ?>"
                                   onclick="return confirmAction(this.href, 'Konfirmasi Pembayaran', 'Konfirmasi pembayaran #EBO-<?= esc($ord['id']) ?>? User akan mendapat akses unduh e-book.', 'warning')"
                                   class="inline-flex items-center gap-1 px-3 py-2 bg-green-600 hover:bg-green-700 text-white rounded-xl text-xs font-bold transition shadow-sm">
                                    <i class="fas fa-check"></i> Konfirmasi
                                </a>
                                <!-- TOLAK -->
                                <button onclick="openRejectModal(<?= esc($ord['id']) ?>)"
                                        class="inline-flex items-center gap-1 px-3 py-2 bg-red-500 hover:bg-red-600 text-white rounded-xl text-xs font-bold transition shadow-sm">
                                    <i class="fas fa-times"></i> Tolak
                                </button>
                            <?php elseif($ord['status'] === 'confirmed'): ?>
                                <span class="text-xs text-green-600 font-bold flex items-center gap-1">
                                    <i class="fas fa-check-circle"></i> Terverifikasi
                                </span>
                            <?php else: ?>
                                <span class="text-xs text-gray-400 italic">–</span>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tolak -->
<div id="rejectModal" class="fixed inset-0 bg-black/60 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-3xl p-8 max-w-md w-full mx-4 shadow-2xl">
        <h3 class="text-xl font-bold text-gray-800 mb-2">Tolak Pesanan E-Book</h3>
        <p class="text-sm text-gray-500 mb-5">Masukkan alasan penolakan. Pesan ini akan dikirim ke user sebagai notifikasi.</p>
        <form id="rejectForm" action="" method="POST">
<?= csrf_field() ?>
<?= csrf_field() ?>
<?= csrf_field() ?><textarea name="note" rows="3" placeholder="Contoh: Bukti transfer tidak terbaca, nominal tidak sesuai, dll."
                      class="w-full px-4 py-3 rounded-2xl border border-gray-200 bg-gray-50 focus:ring-2 focus:ring-red-400/30 focus:border-red-400 text-sm transition mb-4" required></textarea>
            <div class="flex gap-3">
                <button type="button" onclick="closeRejectModal()"
                        class="flex-1 py-2.5 rounded-xl border border-gray-200 text-gray-600 font-bold text-sm hover:bg-gray-50 transition">
                    Batal
                </button>
                <button type="submit"
                        class="flex-1 py-2.5 rounded-xl bg-red-500 hover:bg-red-600 text-white font-bold text-sm transition">
                    <i class="fas fa-times mr-1"></i> Tolak Pesanan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openRejectModal(orderId) {
    document.getElementById('rejectForm').action = '<?= BASEURL ?>/admin/reject_ebook_order/' + orderId;
    document.getElementById('rejectModal').classList.remove('hidden');
}
function closeRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
}
</script>
<?= csrf_field() ?>
<?= csrf_field() ?>
