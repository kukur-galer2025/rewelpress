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

                <!-- Order Summary -->
                <div class="lg:w-1/3">
                    <div class="glass rounded-3xl p-6 shadow-xl border border-white sticky top-24">
                        <h3 class="font-bold text-lg text-gray-800 border-b border-gray-200 pb-4 mb-6">Ringkasan Belanja</h3>
                        
                        <div class="space-y-4 mb-6">
                            <div class="flex justify-between text-gray-600">
                                <span>Total Harga (<?= count($data['cart_items']) ?> Barang)</span>
                                <span>Rp <?= number_format($data['total_price'], 0, ',', '.') ?></span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Diskon</span>
                                <span class="text-red-500">- Rp 0</span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Biaya Pengiriman</span>
                                <span class="text-green-600 font-medium">Gratis</span>
                            </div>
                        </div>

                        <div class="border-t border-gray-200 pt-4 mb-8">
                            <div class="flex justify-between items-center">
                                <span class="font-bold text-gray-800">Total Belanja</span>
                                <span class="font-extrabold text-2xl text-unsoed-blue">Rp <?= number_format($data['total_price'], 0, ',', '.') ?></span>
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
