<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Pesan Kontak Masuk</h1>
        <p class="text-gray-500 mt-1">Pantau, kelola, dan balas langsung pertanyaan atau masukan dari pengunjung website.</p>
    </div>
    
    <div class="flex items-center gap-3 flex-wrap">
        <?php 
            $unreadCount = 0;
            foreach ($data['messages'] as $m) {
                if ($m['is_read'] == 0) $unreadCount++;
            }
        ?>
        <button onclick="filterMessages('all')" id="btn-filter-all" class="filter-btn px-4 py-2 rounded-2xl border border-unsoed-blue bg-unsoed-blue text-white shadow-sm font-bold text-xs flex items-center gap-2 transition">
            <i class="fas fa-inbox"></i> Semua (<?= count($data['messages']) ?>)
        </button>
        <button onclick="filterMessages('unread')" id="btn-filter-unread" class="filter-btn px-4 py-2 rounded-2xl border border-gray-200 bg-white hover:bg-gray-50 text-gray-700 shadow-sm font-bold text-xs flex items-center gap-2 transition">
            <span class="w-2 h-2 rounded-full bg-red-500 <?= $unreadCount > 0 ? 'animate-ping' : '' ?>"></span> Belum Dibaca (<?= esc($unreadCount) ?>)
        </button>
        <button onclick="filterMessages('read')" id="btn-filter-read" class="filter-btn px-4 py-2 rounded-2xl border border-gray-200 bg-white hover:bg-gray-50 text-gray-700 shadow-sm font-bold text-xs flex items-center gap-2 transition">
            <i class="fas fa-check-circle text-green-500"></i> Sudah Dibaca (<?= count($data['messages']) - $unreadCount ?>)
        </button>
    </div>
</div>

<?php if(isset($_GET['msg'])): ?>
    <div class="mb-6">
        <?php if($_GET['msg'] == 'success_delete'): ?>
            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded-2xl shadow-sm font-bold flex items-center gap-2.5 animate-fadeIn" role="alert">
                <i class="fas fa-trash-alt text-lg"></i> Pesan berhasil dihapus secara permanen dari sistem!
            </div>
        <?php elseif($_GET['msg'] == 'error'): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-2xl shadow-sm font-bold flex items-center gap-2.5 animate-fadeIn" role="alert">
                <i class="fas fa-exclamation-triangle text-lg"></i> Terjadi kesalahan saat memproses data pesan.
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>

<?php if(empty($data['messages'])): ?>
    <div class="bg-white rounded-3xl p-16 text-center border border-gray-100 shadow-sm text-gray-400">
        <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-300">
            <i class="fas fa-envelope-open text-4xl"></i>
        </div>
        <h4 class="text-lg font-bold text-gray-600 mb-1">Belum Ada Pesan Masuk</h4>
        <p class="text-sm text-gray-400">Saat ini belum ada pesan dari pengunjung melalui formulir kontak.</p>
    </div>
<?php else: ?>
    <div class="space-y-6" id="messages-container">
        <?php foreach($data['messages'] as $msg): ?>
            <div class="message-card bg-white rounded-3xl p-6 md:p-7 shadow-sm border transition-all duration-300 hover:shadow-md <?= $msg['is_read'] == 0 ? 'border-l-8 border-l-red-500 border-gray-200 bg-gradient-to-r from-red-50/30 to-white' : 'border-gray-200' ?>" data-status="<?= $msg['is_read'] == 0 ? 'unread' : 'read' ?>">
                
                <!-- Header Card: Sender & Status -->
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-5 pb-4 border-b border-gray-100">
                    <div class="flex items-start md:items-center gap-3.5">
                        <div class="w-12 h-12 rounded-2xl <?= $msg['is_read'] == 0 ? 'bg-red-500 text-white shadow-md shadow-red-500/20' : 'bg-gray-100 text-gray-600' ?> flex items-center justify-center font-extrabold text-lg flex-shrink-0">
                            <?= strtoupper(substr($msg['full_name'], 0, 1)) ?>
                        </div>
                        <div>
                            <div class="flex items-center gap-2.5 flex-wrap">
                                <h3 class="font-bold text-gray-900 text-base md:text-lg"><?= htmlspecialchars($msg['full_name']) ?></h3>
                                <?php if($msg['is_read'] == 0): ?>
                                    <span class="bg-red-100 text-red-600 border border-red-200 text-[10px] font-extrabold px-2.5 py-0.5 rounded-full uppercase tracking-wider flex items-center gap-1 animate-pulse">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-600"></span> Pesan Baru
                                    </span>
                                <?php else: ?>
                                    <span class="bg-green-100 text-green-700 border border-green-200 text-[10px] font-bold px-2.5 py-0.5 rounded-full flex items-center gap-1">
                                        <i class="fas fa-check"></i> Sudah Dibaca
                                    </span>
                                <?php endif; ?>
                            </div>
                            <div class="flex items-center gap-3 mt-1 flex-wrap">
                                <a href="mailto:<?= htmlspecialchars($msg['email']) ?>" class="text-xs font-semibold text-unsoed-blue hover:underline flex items-center gap-1" title="Kirim Email Langsung">
                                    <i class="fas fa-envelope text-[11px] opacity-75"></i> <?= htmlspecialchars($msg['email']) ?>
                                </a>
                                <button onclick="copyToClipboard('<?= htmlspecialchars(addslashes($msg['email'])) ?>')" class="text-[11px] text-gray-400 hover:text-gray-600 flex items-center gap-1 bg-gray-50 px-2 py-0.5 rounded border border-gray-100 transition" title="Salin Email">
                                    <i class="far fa-copy"></i> Salin
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 self-start md:self-auto text-xs font-medium text-gray-400 bg-gray-50/80 px-3 py-1.5 rounded-xl border border-gray-100">
                        <i class="far fa-clock text-unsoed-yellow"></i> <?= date('d M Y, H:i', strtotime($msg['created_at'])) ?> WIB
                    </div>
                </div>

                <!-- Subject & Message Body -->
                <div class="space-y-3 mb-5">
                    <div class="flex items-center gap-2 flex-wrap">
                        <span class="text-[10px] font-extrabold uppercase tracking-wider text-gray-400 bg-gray-100 px-2.5 py-1 rounded-lg">Subjek</span>
                        <h4 class="font-bold text-gray-900 text-base"><?= htmlspecialchars($msg['subject']) ?></h4>
                    </div>
                    
                    <div class="bg-gray-50/90 rounded-2xl p-4 md:p-5 border border-gray-100/80 text-gray-700 text-sm leading-relaxed whitespace-pre-line font-normal shadow-inner">
<?= htmlspecialchars($msg['message']) ?>
                    </div>
                </div>

                <!-- Action Bar / Footer Card -->
                <div class="pt-4 border-t border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div class="flex items-center gap-2.5 flex-wrap">
                        <!-- Tombol Balas via Modal -->
                        <button onclick="openReplyModal(<?= esc($msg['id']) ?>, '<?= htmlspecialchars(addslashes($msg['full_name'])) ?>', '<?= htmlspecialchars(addslashes($msg['email'])) ?>', '<?= htmlspecialchars(addslashes($msg['subject'])) ?>', '<?= htmlspecialchars(addslashes($msg['message'])) ?>')" class="px-4 py-2 bg-gradient-to-r from-unsoed-blue to-blue-700 hover:from-blue-800 hover:to-blue-900 text-white rounded-xl text-xs font-bold transition shadow-sm flex items-center gap-2 group">
                            <i class="fas fa-reply group-hover:-translate-x-0.5 transition-transform"></i> Balas Pesan (Email)
                        </button>

                        <!-- Tombol Direct Mailto -->
                        <a href="mailto:<?= htmlspecialchars($msg['email']) ?>?subject=Re: <?= urlencode($msg['subject']) ?>&body=<?= urlencode("Halo " . $msg['full_name'] . ",\n\nTerima kasih telah menghubungi Unsoed Press.\nMenanggapi pesan Anda:\n\"" . $msg['message'] . "\"\n\n[Tulis balasan di sini]\n\nSalam hormat,\nTim Unsoed Press") ?>" target="_blank" class="px-3.5 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl text-xs font-bold transition flex items-center gap-1.5" title="Buka Aplikasi Email Anda (Gmail / Outlook)">
                            <i class="fas fa-external-link-alt text-[10px] text-gray-500"></i> Buka Mail Client
                        </a>
                    </div>

                    <div class="flex items-center gap-2 self-end sm:self-auto">
                        <?php if($msg['is_read'] == 0): ?>
                            <a href="<?= BASEURL; ?>/admin/read_message/<?= esc($msg['id']) ?>" class="px-3.5 py-2 bg-green-50 text-green-700 hover:bg-green-600 hover:text-white rounded-xl text-xs font-bold transition flex items-center gap-1.5 border border-green-200 hover:border-transparent" title="Tandai Sudah Dibaca">
                                <i class="fas fa-check"></i> Tandai Dibaca
                            </a>
                        <?php endif; ?>

                        <a href="<?= BASEURL; ?>/admin/delete_message/<?= esc($msg['id']) ?>" onclick="return confirmAction(this.href, 'Hapus Pesan', 'Apakah Anda yakin ingin menghapus pesan dari <?= htmlspecialchars(addslashes($msg['full_name'])) ?> ini secara permanen?')" class="w-9 h-9 rounded-xl bg-red-50 text-red-600 hover:bg-red-600 hover:text-white transition flex items-center justify-center flex-shrink-0 border border-red-100 hover:border-transparent shadow-sm" title="Hapus Pesan">
                            <i class="fas fa-trash-alt text-xs"></i>
                        </a>
                    </div>
                </div>

            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<!-- MODAL BALAS PESAN INTERAKTIF -->
<div id="replyModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-2xl w-full shadow-2xl border border-gray-100 overflow-hidden transform transition-all scale-95 opacity-0 duration-300" id="replyModalBox">
        
        <!-- Header Modal -->
        <div class="bg-unsoed-darkblue text-white p-6 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-unsoed-yellow text-white flex items-center justify-center text-lg font-bold">
                    <i class="fas fa-paper-plane"></i>
                </div>
                <div>
                    <h3 class="font-bold text-lg leading-tight">Balas Pesan Kontak</h3>
                    <p class="text-xs text-gray-300 mt-0.5" id="replyModalSubtitle">Kirim email balasan ke pengunjung</p>
                </div>
            </div>
            <button onclick="closeReplyModal()" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Body Modal -->
        <div class="p-6 md:p-8 space-y-5">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="bg-gray-50 p-3.5 rounded-2xl border border-gray-100">
                    <span class="text-[11px] font-bold text-gray-400 block mb-1 uppercase tracking-wider">Penerima (To):</span>
                    <p class="font-bold text-gray-800 text-sm flex items-center gap-1.5 truncate">
                        <i class="fas fa-user-circle text-unsoed-blue"></i>
                        <span id="replyToName">-</span>
                    </p>
                    <p class="text-xs text-unsoed-blue font-mono mt-0.5 truncate" id="replyToEmail">-</p>
                </div>

                <div class="bg-gray-50 p-3.5 rounded-2xl border border-gray-100">
                    <span class="text-[11px] font-bold text-gray-400 block mb-1 uppercase tracking-wider">Subjek Pesan Asli:</span>
                    <p class="font-bold text-gray-800 text-sm truncate" id="replyOriginalSubject">-</p>
                    <span class="text-[10px] text-green-600 font-bold block mt-0.5">Otomatis ditambah "Re:"</span>
                </div>
            </div>

            <!-- Pesan Pengunjung Asli (Kutipan) -->
            <div class="bg-blue-50/50 p-3.5 rounded-2xl border border-blue-100/80 text-xs text-gray-600">
                <span class="font-bold text-unsoed-blue block mb-1"><i class="fas fa-quote-left mr-1"></i> Pesan dari pengunjung:</span>
                <p class="italic line-clamp-3 text-gray-600 leading-relaxed" id="replyOriginalMessage">-</p>
            </div>

            <!-- Pilihan Template Cepat -->
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Pilih Template Balasan Cepat (Opsional):</label>
                <div class="flex flex-wrap gap-2">
                    <button type="button" onclick="useTemplate('terimakasih')" class="px-3 py-1.5 rounded-xl bg-gray-100 hover:bg-unsoed-blue hover:text-white text-gray-700 text-xs font-semibold transition border border-gray-200 hover:border-transparent">
                        💡 Konfirmasi Penerimaan & Terima Kasih
                    </button>
                    <button type="button" onclick="useTemplate('penerbitan')" class="px-3 py-1.5 rounded-xl bg-gray-100 hover:bg-unsoed-blue hover:text-white text-gray-700 text-xs font-semibold transition border border-gray-200 hover:border-transparent">
                        📚 Prosedur Penerbitan Buku
                    </button>
                    <button type="button" onclick="useTemplate('kontak_wa')" class="px-3 py-1.5 rounded-xl bg-gray-100 hover:bg-unsoed-blue hover:text-white text-gray-700 text-xs font-semibold transition border border-gray-200 hover:border-transparent">
                        📱 Arahkan ke WhatsApp Resmi
                    </button>
                </div>
            </div>

            <!-- Form Isi Balasan -->
            <div>
                <label class="block text-sm font-bold text-gray-800 mb-2">Isi Email Balasan <span class="text-red-500">*</span></label>
                <textarea id="replyMessageBody" rows="6" class="w-full px-4 py-3 rounded-2xl border border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-unsoed-blue/30 focus:border-unsoed-blue transition text-sm text-gray-800 leading-relaxed font-normal" placeholder="Tulis pesan balasan Anda di sini..."></textarea>
            </div>
        </div>

        <!-- Footer Modal -->
        <div class="p-5 bg-gray-50 border-t border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div class="flex items-center gap-2 text-xs text-gray-500 font-medium">
                <i class="fas fa-info-circle text-unsoed-blue"></i>
                <span>Email dikirim melalui klien email default Anda.</span>
            </div>
            
            <div class="flex items-center gap-3">
                <button type="button" onclick="closeReplyModal()" class="px-5 py-2.5 rounded-xl border border-gray-200 text-gray-600 hover:bg-gray-100 font-bold text-xs transition">
                    Batal
                </button>
                <button type="button" onclick="sendReplyViaEmail()" class="px-6 py-2.5 bg-gradient-to-r from-unsoed-blue to-blue-700 hover:from-blue-800 hover:to-blue-900 text-white rounded-xl text-xs font-bold transition shadow-md flex items-center gap-2">
                    <i class="fas fa-paper-plane"></i> Buka di Email Client & Kirim
                </button>
            </div>
        </div>

    </div>
</div>

<script>
// Filter Pesan Tab
function filterMessages(type) {
    const cards = document.querySelectorAll('.message-card');
    const btns = document.querySelectorAll('.filter-btn');
    
    // Reset buttons
    btns.forEach(b => {
        b.classList.remove('bg-unsoed-blue', 'text-white', 'border-unsoed-blue');
        b.classList.add('bg-white', 'text-gray-700', 'border-gray-200');
    });
    
    // Active button
    const activeBtn = document.getElementById('btn-filter-' + type);
    if(activeBtn) {
        activeBtn.classList.remove('bg-white', 'text-gray-700', 'border-gray-200');
        activeBtn.classList.add('bg-unsoed-blue', 'text-white', 'border-unsoed-blue');
    }

    // Filter logic
    cards.forEach(card => {
        const status = card.getAttribute('data-status');
        if(type === 'all') {
            card.style.display = 'block';
        } else if(type === 'unread' && status === 'unread') {
            card.style.display = 'block';
        } else if(type === 'read' && status === 'read') {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
}

// Salin ke Clipboard
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        showAlert('Alamat email (' + text + ') berhasil disalin ke clipboard!', 'success');
    }).catch(err => {
        prompt('Salin alamat email di bawah ini:', text);
    });
}

// Data Modal Balas
let currentMsgId = null;
let currentSenderName = '';
let currentSenderEmail = '';
let currentSubject = '';
let currentOriginalMsg = '';

function openReplyModal(id, name, email, subject, message) {
    currentMsgId = id;
    currentSenderName = name;
    currentSenderEmail = email;
    currentSubject = subject;
    currentOriginalMsg = message;

    document.getElementById('replyToName').innerText = name;
    document.getElementById('replyToEmail').innerText = email;
    document.getElementById('replyOriginalSubject').innerText = subject;
    document.getElementById('replyOriginalMessage').innerText = message;

    // Set Default Body
    document.getElementById('replyMessageBody').value = `Halo ${name},\n\nTerima kasih telah menghubungi Unsoed Press.\nMenanggapi pesan Anda mengenai "${subject}":\n\n\n\nSalam hormat,\nTim Layanan Unsoed Press`;

    const modal = document.getElementById('replyModal');
    const box = document.getElementById('replyModalBox');
    
    modal.classList.remove('hidden');
    setTimeout(() => {
        box.classList.remove('scale-95', 'opacity-0');
        box.classList.add('scale-100', 'opacity-100');
    }, 10);
}

function closeReplyModal() {
    const modal = document.getElementById('replyModal');
    const box = document.getElementById('replyModalBox');
    
    box.classList.remove('scale-100', 'opacity-100');
    box.classList.add('scale-95', 'opacity-0');
    setTimeout(() => {
        modal.classList.add('hidden');
    }, 200);
}

function useTemplate(templateType) {
    const bodyField = document.getElementById('replyMessageBody');
    if(templateType === 'terimakasih') {
        bodyField.value = `Halo ${currentSenderName},\n\nTerima kasih telah menghubungi Unsoed Press. Pesan Anda mengenai "${currentSubject}" telah kami terima dengan baik.\n\nKami telah mencatat masukan/pertanyaan Anda dan akan segera menindaklanjutinya. Jika ada informasi tambahan yang diperlukan, kami akan kembali menghubungi Anda melalui email ini.\n\nSalam hormat,\nTim Layanan Unsoed Press`;
    } else if(templateType === 'penerbitan') {
        bodyField.value = `Halo ${currentSenderName},\n\nTerima kasih atas ketertarikan Anda untuk menerbitkan naskah di Unsoed Press.\n\nUntuk prosedur pengajuan naskah baru, Anda dapat mengirimkan draf naskah beserta sinopsis dan biodata penulis ke email resmi atau menghubungi nomor layanan WhatsApp kami (0856-0011-0828) untuk panduan teknis formatting dan estimasi biaya.\n\nSalam hormat,\nTim Redaksi Unsoed Press`;
    } else if(templateType === 'kontak_wa') {
        bodyField.value = `Halo ${currentSenderName},\n\nTerima kasih telah menghubungi Unsoed Press.\nUntuk respons yang lebih cepat mengenai "${currentSubject}", Anda juga dapat langsung berkonsultasi dengan tim admin kami melalui layanan WhatsApp di nomor: 0856-0011-0828 pada jam kerja (Senin - Jumat, 08:00 - 16:00 WIB).\n\nSalam hormat,\nTim Unsoed Press`;
    }
}

function sendReplyViaEmail() {
    const replyBody = document.getElementById('replyMessageBody').value;
    const mailtoUrl = `mailto:${encodeURIComponent(currentSenderEmail)}?subject=${encodeURIComponent('Re: ' + currentSubject)}&body=${encodeURIComponent(replyBody)}`;
    
    // Open email client
    window.open(mailtoUrl, '_blank');
    
    // Automatically mark as read if it was unread
    setTimeout(() => {
        if(currentMsgId) {
            window.location.href = `<?= BASEURL; ?>/admin/read_message/${currentMsgId}`;
        }
    }, 1000);
}
</script>
