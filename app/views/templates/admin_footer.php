            </div>
            
            <footer class="bg-white border-t border-gray-200 py-4 px-6 text-center text-sm text-gray-500 mt-auto">
                &copy; <?= date('Y') ?> Admin Panel Unsoed Press. Didesain dengan Native PHP & Tailwind CSS.
            </footer>
        </main>
    </div>
<!-- jQuery and Select2 JS -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2-multiple').select2({
            placeholder: "-- Pilih Penulis --",
            allowClear: true,
            width: '100%'
        });
    });
</script>
<?php include __DIR__ . '/admin_modal.php'; ?>

<?php if(isset($_GET['msg'])): ?>
<script>
    let msgCode = '<?= htmlspecialchars($_GET['msg']) ?>';
    let type = msgCode.includes('error') || msgCode.includes('failed') ? 'error' : (msgCode.includes('success') ? 'success' : 'info');
    let messageStr = '';

    switch(msgCode) {
        case 'success_add': messageStr = 'Data berhasil ditambahkan!'; break;
        case 'success_edit': messageStr = 'Data berhasil diperbarui!'; break;
        case 'success_delete': messageStr = 'Data berhasil dihapus!'; break;
        case 'error_has_books': messageStr = 'Gagal dihapus: Kategori ini masih menampung Buku/E-Book!'; break;
        case 'error_delete': messageStr = 'Gagal menghapus data. Data sedang digunakan atau tidak ditemukan.'; break;
        case 'error': messageStr = 'Terjadi kesalahan pada sistem.'; break;
        case 'success': messageStr = 'Berhasil disimpan!'; break;
        default: messageStr = msgCode.replace(/_/g, ' '); break;
    }

    if (typeof showAlert === 'function') {
        showAlert(messageStr, type);
    }
</script>
<?php endif; ?>
</body>
</html>
