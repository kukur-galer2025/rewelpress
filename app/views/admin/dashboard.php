<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800">Dashboard</h1>
    <p class="text-gray-500 mt-1">Selamat datang kembali, <?= $_SESSION['user_name'] ?>!</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Stats Cards -->
    <a href="<?= BASEURL; ?>/admin/books" class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center gap-5 hover:border-blue-300 hover:shadow-md transition group">
        <div class="w-14 h-14 rounded-full bg-blue-50 text-blue-500 flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">
            <i class="fas fa-book"></i>
        </div>
        <div>
            <p class="text-gray-500 text-sm font-semibold">Total Buku</p>
            <h3 class="text-2xl font-bold text-gray-800"><?= $data['total_books'] ?? 0 ?></h3>
        </div>
    </a>
    <a href="<?= BASEURL; ?>/admin/orders" class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center gap-5 hover:border-green-300 hover:shadow-md transition group">
        <div class="w-14 h-14 rounded-full bg-green-50 text-green-500 flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">
            <i class="fas fa-shopping-cart"></i>
        </div>
        <div>
            <p class="text-gray-500 text-sm font-semibold">Pesanan Masuk</p>
            <h3 class="text-2xl font-bold text-gray-800"><?= $data['total_orders'] ?? 0 ?></h3>
        </div>
    </a>
    <a href="<?= BASEURL; ?>/admin/users" class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center gap-5 hover:border-purple-300 hover:shadow-md transition group">
        <div class="w-14 h-14 rounded-full bg-purple-50 text-purple-500 flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">
            <i class="fas fa-users"></i>
        </div>
        <div>
            <p class="text-gray-500 text-sm font-semibold">Total Pengguna</p>
            <h3 class="text-2xl font-bold text-gray-800"><?= $data['total_users'] ?? 0 ?></h3>
        </div>
    </a>
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center gap-5">
        <div class="w-14 h-14 rounded-full bg-unsoed-yellow/10 text-unsoed-yellow flex items-center justify-center text-2xl">
            <i class="fas fa-wallet"></i>
        </div>
        <div>
            <p class="text-gray-500 text-sm font-semibold">Aktifitas Sistem</p>
            <h3 class="text-2xl font-bold text-gray-800">Normal</h3>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2 bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
        <h3 class="text-lg font-bold text-gray-800 mb-6">Grafik Penjualan</h3>
        <div class="h-64 flex items-end gap-2 justify-between">
            <div class="w-1/12 bg-blue-100 rounded-t-md relative group"><div class="absolute bottom-0 w-full bg-unsoed-blue rounded-t-md h-[40%] transition-all group-hover:bg-unsoed-yellow"></div></div>
            <div class="w-1/12 bg-blue-100 rounded-t-md relative group"><div class="absolute bottom-0 w-full bg-unsoed-blue rounded-t-md h-[60%] transition-all group-hover:bg-unsoed-yellow"></div></div>
            <div class="w-1/12 bg-blue-100 rounded-t-md relative group"><div class="absolute bottom-0 w-full bg-unsoed-blue rounded-t-md h-[30%] transition-all group-hover:bg-unsoed-yellow"></div></div>
            <div class="w-1/12 bg-blue-100 rounded-t-md relative group"><div class="absolute bottom-0 w-full bg-unsoed-blue rounded-t-md h-[80%] transition-all group-hover:bg-unsoed-yellow"></div></div>
            <div class="w-1/12 bg-blue-100 rounded-t-md relative group"><div class="absolute bottom-0 w-full bg-unsoed-blue rounded-t-md h-[50%] transition-all group-hover:bg-unsoed-yellow"></div></div>
            <div class="w-1/12 bg-blue-100 rounded-t-md relative group"><div class="absolute bottom-0 w-full bg-unsoed-blue rounded-t-md h-[90%] transition-all group-hover:bg-unsoed-yellow"></div></div>
        </div>
        <div class="flex justify-between mt-4 text-xs text-gray-400 font-bold uppercase">
            <span>Jan</span><span>Feb</span><span>Mar</span><span>Apr</span><span>Mei</span><span>Jun</span>
        </div>
    </div>
    
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
        <h3 class="text-lg font-bold text-gray-800 mb-6">Aktivitas Terakhir</h3>
        <div class="space-y-6">
            <div class="flex gap-4">
                <div class="w-2 h-2 mt-2 rounded-full bg-green-500"></div>
                <div>
                    <p class="text-sm text-gray-800 font-semibold">Pesanan #10023 Berhasil</p>
                    <p class="text-xs text-gray-400">2 menit yang lalu</p>
                </div>
            </div>
            <div class="flex gap-4">
                <div class="w-2 h-2 mt-2 rounded-full bg-blue-500"></div>
                <div>
                    <p class="text-sm text-gray-800 font-semibold">Buku Baru Ditambahkan</p>
                    <p class="text-xs text-gray-400">1 jam yang lalu</p>
                </div>
            </div>
            <div class="flex gap-4">
                <div class="w-2 h-2 mt-2 rounded-full bg-unsoed-yellow"></div>
                <div>
                    <p class="text-sm text-gray-800 font-semibold">User Mendaftar</p>
                    <p class="text-xs text-gray-400">3 jam yang lalu</p>
                </div>
            </div>
        </div>
    </div>
</div>
