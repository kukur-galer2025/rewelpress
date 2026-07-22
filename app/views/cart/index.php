<!-- Page Header -->
<div class="bg-unsoed-darkblue py-10 relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-r from-unsoed-darkblue to-unsoed-blue"></div>
    <div class="container mx-auto px-4 relative z-10">
        <h1 class="text-3xl font-serif font-bold text-white mb-2">Keranjang Belanja</h1>
        <p class="text-gray-300 text-sm">Tinjau kembali buku pilihan Anda sebelum melakukan pembayaran.</p>
    </div>
</div>

<section class="py-12 bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4">
        
        <?php if(empty($data['cart_items'])): ?>
            <div class="glass rounded-3xl p-12 text-center shadow-xl border border-white max-w-2xl mx-auto">
                <div class="w-32 h-32 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <img src="https://cdn-icons-png.flaticon.com/512/11329/11329060.png" alt="Empty Cart" class="w-16 h-16 opacity-50">
                </div>
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Keranjang Anda Masih Kosong</h2>
                <p class="text-gray-500 mb-8">Wah, sepertinya Anda belum menambahkan buku apapun ke keranjang. Mari temukan buku-buku menarik di katalog kami!</p>
                <a href="<?= BASEURL; ?>" class="btn-primary inline-block"><i class="fas fa-shopping-bag mr-2"></i> Mulai Belanja</a>
            </div>
        <?php else: ?>
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Cart Items List -->
                <div class="lg:w-2/3">
                    <form action="<?= BASEURL; ?>/cart/update" method="POST" id="cartForm">
                        <div class="glass rounded-3xl p-6 shadow-xl border border-white mb-6">
                            <div class="flex justify-between items-center border-b border-gray-200 pb-4 mb-6">
                                <h3 class="font-bold text-lg text-gray-800">Daftar Produk (<?= count($data['cart_items']) ?>)</h3>
                                <a href="<?= BASEURL; ?>/cart/clear" class="text-sm text-red-500 hover:text-red-700 font-medium transition" onclick="return confirm('Apakah Anda yakin ingin mengosongkan keranjang?')">
                                    <i class="fas fa-trash-alt mr-1"></i> Kosongkan
                                </a>
                            </div>

                            <div class="space-y-6">
                                <?php foreach($data['cart_items'] as $item): ?>
                                <div class="flex flex-col sm:flex-row items-center gap-6 pb-6 border-b border-gray-100 last:border-0 last:pb-0">
                                    
                                    <!-- Book Image -->
                                    <a href="<?= BASEURL; ?>/book/detail/<?= $item['id'] ?>" class="w-24 shrink-0 rounded-xl overflow-hidden shadow-md">
                                        <?php $img_src = !empty($item['image']) ? $item['image'] : 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?auto=format&fit=crop&q=80&w=400'; ?>
                                        <img src="<?= $img_src ?>" alt="<?= $item['title'] ?>" class="w-full h-auto object-cover aspect-[3/4] hover:scale-110 transition duration-500">
                                    </a>

                                    <!-- Book Info -->
                                    <div class="flex-grow w-full">
                                        <a href="<?= BASEURL; ?>/book/detail/<?= $item['id'] ?>" class="text-lg font-bold text-gray-800 hover:text-unsoed-blue transition line-clamp-2 mb-1"><?= $item['title'] ?></a>
                                        <p class="text-sm text-gray-500 mb-3"><?= $item['author'] ?></p>
                                        <h4 class="text-unsoed-blue font-extrabold text-lg">Rp <?= number_format($item['price'], 0, ',', '.') ?></h4>
                                    </div>

                                    <!-- Qty & Action -->
                                    <div class="flex flex-col sm:items-end gap-3 w-full sm:w-auto">
                                        <div class="flex items-center border border-gray-300 rounded-lg bg-gray-50 px-2 py-1">
                                            <button type="button" class="w-8 h-8 flex items-center justify-center text-gray-500 hover:text-unsoed-blue transition" onclick="document.getElementById('qty_<?= $item['id'] ?>').value = Math.max(1, parseInt(document.getElementById('qty_<?= $item['id'] ?>').value) - 1)">
                                                <i class="fas fa-minus text-xs"></i>
                                            </button>
                                            <input type="number" name="qty[<?= $item['id'] ?>]" id="qty_<?= $item['id'] ?>" value="<?= $item['qty'] ?>" min="1" class="w-12 text-center font-bold text-gray-800 bg-transparent outline-none appearance-none">
                                            <button type="button" class="w-8 h-8 flex items-center justify-center text-gray-500 hover:text-unsoed-blue transition" onclick="document.getElementById('qty_<?= $item['id'] ?>').value = parseInt(document.getElementById('qty_<?= $item['id'] ?>').value) + 1">
                                                <i class="fas fa-plus text-xs"></i>
                                            </button>
                                        </div>
                                        <div class="flex justify-between items-center w-full mt-2 sm:mt-0">
                                            <span class="text-sm font-bold text-gray-700 sm:hidden">Subtotal: Rp <?= number_format($item['subtotal'], 0, ',', '.') ?></span>
                                            <a href="<?= BASEURL; ?>/cart/remove/<?= $item['id'] ?>" class="text-sm text-red-400 hover:text-red-600 transition flex items-center gap-1 bg-red-50 px-3 py-1 rounded-full">
                                                <i class="fas fa-times"></i> Hapus
                                            </a>
                                        </div>
                                    </div>
                                    
                                </div>
                                <?php endforeach; ?>
                            </div>

                            <div class="mt-8 flex justify-end">
                                <button type="submit" class="px-6 py-2 bg-gray-800 text-white font-medium rounded-lg hover:bg-gray-700 transition shadow-md flex items-center gap-2">
                                    <i class="fas fa-sync-alt"></i> Perbarui Keranjang
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Order Summary & Voucher -->
                <div class="lg:w-1/3 space-y-6">
                    
                    <!-- Kotak Input & Widget Voucher -->
                    <div class="glass rounded-3xl p-6 shadow-xl border border-white">
                        <h3 class="font-bold text-base text-gray-800 flex items-center gap-2 mb-4">
                            <i class="fas fa-ticket-alt text-amber-500 text-lg"></i> Kode Voucher & Promo
                        </h3>

                        <?php if(isset($_GET['voucher_err']) || isset($data['voucher_error'])): ?>
                            <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-600 rounded-2xl text-xs flex items-center justify-between">
                                <span><i class="fas fa-exclamation-circle mr-1"></i> <?= htmlspecialchars($_GET['voucher_err'] ?? $data['voucher_error']) ?></span>
                            </div>
                        <?php endif; ?>

                        <?php if(!empty($data['applied_voucher'])): ?>
                            <!-- Voucher Terpasang -->
                            <div class="p-4 bg-green-50 border-2 border-green-300 rounded-2xl flex items-center justify-between gap-2">
                                <div>
                                    <span class="text-[10px] font-extrabold text-green-600 uppercase tracking-wider block">Voucher Digunakan:</span>
                                    <span class="font-mono font-bold text-sm text-green-900"><?= htmlspecialchars($data['applied_voucher']['code']) ?></span>
                                    <p class="text-xs text-green-700 font-semibold mt-0.5">Hemat Rp <?= number_format($data['applied_voucher']['discount_amount'], 0, ',', '.') ?></p>
                                </div>
                                <a href="<?= BASEURL; ?>/cart/remove_voucher" class="p-2 text-red-500 hover:bg-red-100 rounded-xl transition font-bold text-xs" title="Hapus Voucher">
                                    <i class="fas fa-times text-base"></i>
                                </a>
                            </div>
                        <?php else: ?>
                            <!-- Form Input Voucher -->
                            <form action="<?= BASEURL; ?>/cart/apply_voucher" method="POST" class="flex gap-2 mb-4">
                                <input type="text" name="voucher_code" placeholder="Ketik kode promo..." uppercase
                                       class="flex-1 px-3.5 py-2.5 rounded-xl border border-gray-300 focus:border-unsoed-blue text-xs font-mono font-bold uppercase text-gray-800">
                                <button type="submit" class="bg-unsoed-blue hover:bg-blue-800 text-white px-4 py-2.5 rounded-xl font-bold text-xs shadow transition">
                                    Pakai
                                </button>
                            </form>

                            <!-- Daftar Voucher Aktif -->
                            <?php if(!empty($data['active_vouchers'])): ?>
                                <div class="space-y-2 mt-4 pt-4 border-t border-gray-100">
                                    <p class="text-[11px] font-extrabold text-gray-400 uppercase tracking-wider">Pilih Promo Tersedia:</p>
                                    <div class="max-h-48 overflow-y-auto pr-1 space-y-2">
                                        <?php foreach($data['active_vouchers'] as $av): ?>
                                            <div class="p-3 bg-amber-50/60 border border-amber-200/80 rounded-2xl flex items-center justify-between gap-2 hover:bg-amber-50 transition">
                                                <div class="min-w-0">
                                                    <span class="font-mono font-bold text-xs text-amber-900 bg-amber-100 px-2 py-0.5 rounded"><?= htmlspecialchars($av['code']) ?></span>
                                                    <p class="text-[11px] font-bold text-gray-800 truncate mt-1"><?= htmlspecialchars($av['title']) ?></p>
                                                    <p class="text-[10px] text-gray-500">Min. Belanja: Rp <?= number_format($av['min_purchase'], 0, ',', '.') ?></p>
                                                </div>
                                                <form action="<?= BASEURL; ?>/cart/apply_voucher" method="POST">
                                                    <input type="hidden" name="voucher_code" value="<?= htmlspecialchars($av['code']) ?>">
                                                    <button type="submit" class="px-2.5 py-1.5 bg-amber-500 hover:bg-amber-600 text-white text-[10px] font-extrabold rounded-lg shadow-sm transition whitespace-nowrap">
                                                        Klaim
                                                    </button>
                                                </form>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>

                    <!-- Order Summary -->
                    <div class="glass rounded-3xl p-6 shadow-xl border border-white sticky top-24">
                        <h3 class="font-bold text-lg text-gray-800 border-b border-gray-200 pb-4 mb-6">Ringkasan Belanja</h3>
                        
                        <?php 
                        $discount = !empty($data['applied_voucher']) ? floatval($data['applied_voucher']['discount_amount']) : 0;
                        $final_price = max(0, $data['total_price'] - $discount);
                        ?>

                        <div class="space-y-4 mb-6 text-sm">
                            <div class="flex justify-between text-gray-600">
                                <span>Total Harga (<?= count($data['cart_items']) ?> Barang)</span>
                                <span class="font-semibold">Rp <?= number_format($data['total_price'], 0, ',', '.') ?></span>
                            </div>
                            <?php if($discount > 0): ?>
                            <div class="flex justify-between text-green-600 font-bold">
                                <span>Diskon (<?= htmlspecialchars($data['applied_voucher']['code']) ?>)</span>
                                <span>- Rp <?= number_format($discount, 0, ',', '.') ?></span>
                            </div>
                            <?php endif; ?>
                            <div class="flex justify-between text-gray-600">
                                <span>Biaya Pengiriman</span>
                                <span class="text-green-600 font-bold">Gratis</span>
                            </div>
                        </div>

                        <div class="border-t border-gray-200 pt-4 mb-8">
                            <div class="flex justify-between items-center">
                                <span class="font-bold text-gray-800">Total Belanja</span>
                                <span class="font-extrabold text-2xl text-unsoed-blue">Rp <?= number_format($final_price, 0, ',', '.') ?></span>
                            </div>
                        </div>

                        <a href="<?= BASEURL; ?>/order/checkout" class="btn-primary w-full text-center block text-lg py-4">
                            Lanjut ke Pembayaran <i class="fas fa-chevron-right ml-2 text-sm"></i>
                        </a>
                        
                        <div class="mt-6 flex items-center justify-center gap-2 text-xs text-gray-400">
                            <i class="fas fa-lock"></i> Transaksi dijamin 100% aman
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

    </div>
</section>
