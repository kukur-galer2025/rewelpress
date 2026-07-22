<?php
$monthly = $data['monthly_sales'] ?? [];
$maxRevenue = 1;
foreach ($monthly as $m) {
    if ($m['revenue'] > $maxRevenue) $maxRevenue = $m['revenue'];
}
?>
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800">Dashboard</h1>
    <p class="text-gray-500 mt-1">Selamat datang kembali, <?= esc($_SESSION['user_name']) ?>!</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Buku -->
    <a href="<?= BASEURL; ?>/admin/books" class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center gap-5 hover:border-blue-300 hover:shadow-md transition group">
        <div class="w-14 h-14 rounded-full bg-blue-50 text-blue-500 flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">
            <i class="fas fa-book"></i>
        </div>
        <div>
            <p class="text-gray-500 text-sm font-semibold">Total Buku</p>
            <h3 class="text-2xl font-bold text-gray-800"><?= $data['total_books'] ?? 0 ?></h3>
        </div>
    </a>
    <!-- Total E-Book -->
    <a href="<?= BASEURL; ?>/admin/ebooks" class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center gap-5 hover:border-indigo-300 hover:shadow-md transition group">
        <div class="w-14 h-14 rounded-full bg-indigo-50 text-indigo-500 flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">
            <i class="fas fa-tablet-alt"></i>
        </div>
        <div>
            <p class="text-gray-500 text-sm font-semibold">Total E-Book</p>
            <h3 class="text-2xl font-bold text-gray-800"><?= $data['total_ebooks'] ?? 0 ?></h3>
        </div>
    </a>
    <!-- Pesanan Pending -->
    <a href="<?= BASEURL; ?>/admin/orders" class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center gap-5 hover:border-yellow-300 hover:shadow-md transition group relative">
        <div class="w-14 h-14 rounded-full bg-yellow-50 text-yellow-500 flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">
            <i class="fas fa-clock"></i>
        </div>
        <div>
            <p class="text-gray-500 text-sm font-semibold">Menunggu Konfirmasi</p>
            <h3 class="text-2xl font-bold text-gray-800"><?= $data['pending_orders'] ?? 0 ?></h3>
        </div>
        <?php if(($data['pending_orders'] ?? 0) > 0): ?>
        <span class="absolute top-3 right-3 w-3 h-3 bg-red-500 rounded-full animate-ping"></span>
        <span class="absolute top-3 right-3 w-3 h-3 bg-red-500 rounded-full"></span>
        <?php endif; ?>
    </a>
    <!-- Total Revenue -->
    <div class="bg-gradient-to-br from-unsoed-blue to-unsoed-darkblue rounded-2xl p-6 shadow-sm flex items-center gap-5 text-white">
        <div class="w-14 h-14 rounded-full bg-white/10 flex items-center justify-center text-2xl">
            <i class="fas fa-wallet"></i>
        </div>
        <div>
            <p class="text-blue-100 text-sm font-semibold">Total Pendapatan</p>
            <h3 class="text-2xl font-bold">Rp<?= number_format($data['total_revenue'] ?? 0, 0, ',', '.') ?></h3>
        </div>
    </div>
</div>

<!-- Secondary Stats -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <a href="<?= BASEURL; ?>/admin/orders" class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 flex items-center gap-4 hover:shadow-md transition group">
        <div class="w-12 h-12 rounded-full bg-green-50 text-green-500 flex items-center justify-center text-xl group-hover:scale-110 transition-transform">
            <i class="fas fa-shopping-cart"></i>
        </div>
        <div>
            <p class="text-gray-500 text-xs font-semibold">Total Pesanan</p>
            <h3 class="text-xl font-bold text-gray-800"><?= $data['total_orders'] ?? 0 ?></h3>
        </div>
    </a>
    <a href="<?= BASEURL; ?>/admin/users" class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 flex items-center gap-4 hover:shadow-md transition group">
        <div class="w-12 h-12 rounded-full bg-purple-50 text-purple-500 flex items-center justify-center text-xl group-hover:scale-110 transition-transform">
            <i class="fas fa-users"></i>
        </div>
        <div>
            <p class="text-gray-500 text-xs font-semibold">Total Pengguna</p>
            <h3 class="text-xl font-bold text-gray-800"><?= $data['total_users'] ?? 0 ?></h3>
        </div>
    </a>
    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 flex items-center gap-4">
        <div class="w-12 h-12 rounded-full bg-unsoed-yellow/10 text-unsoed-yellow flex items-center justify-center text-xl">
            <i class="fas fa-check-circle"></i>
        </div>
        <div>
            <p class="text-gray-500 text-xs font-semibold">Status Sistem</p>
            <h3 class="text-xl font-bold text-green-600">Online</h3>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Grafik Penjualan Bulanan -->
    <div class="lg:col-span-2 bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
        <h3 class="text-lg font-bold text-gray-800 mb-6">Grafik Penjualan (12 Bulan Terakhir)</h3>
        <?php if(empty($monthly)): ?>
            <div class="h-64 flex items-center justify-center text-gray-400 text-sm italic">
                <i class="fas fa-chart-bar text-4xl text-gray-200 mr-3"></i> Belum ada data penjualan.
            </div>
        <?php else: ?>
            <div class="h-64 flex items-end gap-2 justify-between">
                <?php foreach($monthly as $m): ?>
                    <?php $pct = ($m['revenue'] / $maxRevenue) * 100; ?>
                    <div class="flex-1 bg-blue-50 rounded-t-lg relative group cursor-pointer min-w-0" style="height: 100%;">
                        <div class="absolute bottom-0 w-full bg-unsoed-blue rounded-t-lg transition-all group-hover:bg-unsoed-yellow" style="height: <?= max($pct, 5) ?>%"></div>
                        <div class="absolute -top-10 left-1/2 -translate-x-1/2 bg-gray-900 text-white text-[10px] font-bold px-2 py-1 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap z-10">
                            Rp<?= number_format($m['revenue'], 0, ',', '.') ?> (<?= esc($m['order_count']) ?> order)
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="flex justify-between mt-4 text-xs text-gray-400 font-bold uppercase">
                <?php foreach($monthly as $m): ?>
                    <span class="flex-1 text-center"><?= esc($m['month_name']) ?></span>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- Pesanan Terakhir -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
        <h3 class="text-lg font-bold text-gray-800 mb-6">Pesanan Terakhir</h3>
        <div class="space-y-5">
            <?php 
            $latestOrders = $data['latest_orders'] ?? [];
            if(empty($latestOrders)): ?>
                <div class="text-center text-gray-400 text-sm italic py-8">Belum ada pesanan.</div>
            <?php else: ?>
                <?php foreach($latestOrders as $order): ?>
                    <a href="<?= BASEURL ?>/admin/order_detail/<?= esc($order['id']) ?>" class="flex gap-4 items-start hover:bg-gray-50 -mx-2 px-2 py-2 rounded-xl transition">
                        <?php
                        $statusColor = 'bg-gray-400';
                        $statusLabel = $order['status'];
                        if ($order['status'] == 'pending') { $statusColor = 'bg-yellow-400'; $statusLabel = 'Belum Bayar'; }
                        elseif ($order['status'] == 'paid') { $statusColor = 'bg-blue-500'; $statusLabel = 'Menunggu Verif'; }
                        elseif ($order['status'] == 'confirmed') { $statusColor = 'bg-green-500'; $statusLabel = 'Selesai'; }
                        elseif ($order['status'] == 'rejected') { $statusColor = 'bg-red-500'; $statusLabel = 'Ditolak'; }
                        ?>
                        <div class="w-2 h-2 mt-2 rounded-full <?= esc($statusColor) ?> flex-shrink-0"></div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm text-gray-800 font-semibold truncate">#INV-<?= esc($order['id']) ?> — <?= htmlspecialchars($order['user_name']) ?></p>
                            <p class="text-xs text-gray-400 flex items-center justify-between">
                                <span>Rp<?= number_format($order['total_amount'], 0, ',', '.') ?></span>
                                <span class="text-[10px] font-bold uppercase <?= str_replace('bg-', 'text-', $statusColor) ?>"><?= esc($statusLabel) ?></span>
                            </p>
                            <p class="text-[10px] text-gray-400 mt-0.5"><?= date('d M Y, H:i', strtotime($order['created_at'])) ?></p>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
