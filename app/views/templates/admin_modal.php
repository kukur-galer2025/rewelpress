<!-- Custom Confirmation Modal -->
<div id="customModal" class="fixed inset-0 z-[9999] hidden">
    <!-- Backdrop -->
    <div id="modalBackdrop" class="absolute inset-0 bg-black/50 backdrop-blur-sm transition-opacity duration-300 opacity-0"></div>
    <!-- Modal Box -->
    <div class="absolute inset-0 flex items-center justify-center p-4">
        <div id="modalBox" class="bg-white rounded-3xl shadow-2xl border border-gray-100 w-full max-w-md transform transition-all duration-300 scale-95 opacity-0 overflow-hidden">
            <!-- Header -->
            <div id="modalHeader" class="p-6 pb-2 flex items-start gap-4">
                <div id="modalIconWrap" class="w-12 h-12 rounded-2xl flex items-center justify-center flex-shrink-0 bg-red-50">
                    <i id="modalIcon" class="fas fa-exclamation-triangle text-xl text-red-500"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <h3 id="modalTitle" class="text-lg font-bold text-gray-900"></h3>
                    <p id="modalMessage" class="text-sm text-gray-500 mt-1 leading-relaxed"></p>
                </div>
                <button onclick="closeModal()" class="w-8 h-8 rounded-xl bg-gray-100 hover:bg-gray-200 flex items-center justify-center text-gray-400 hover:text-gray-600 transition flex-shrink-0 -mt-1 -mr-1">
                    <i class="fas fa-times text-sm"></i>
                </button>
            </div>
            <!-- Actions -->
            <div id="modalActions" class="p-6 pt-4 flex items-center justify-end gap-3">
                <button onclick="closeModal()" class="px-5 py-2.5 rounded-xl border border-gray-200 text-gray-600 hover:bg-gray-50 font-semibold text-sm transition">
                    Batal
                </button>
                <a id="modalConfirmBtn" href="#" class="px-5 py-2.5 rounded-xl bg-red-500 text-white font-bold text-sm hover:bg-red-600 transition shadow-lg shadow-red-500/20 flex items-center gap-2">
                    <i class="fas fa-check"></i> Ya, Lanjutkan
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Custom Alert Toast -->
<div id="alertToast" class="fixed top-6 right-6 z-[9998] hidden">
    <div id="alertToastBox" class="bg-white rounded-2xl shadow-2xl border border-gray-100 p-4 flex items-center gap-3 max-w-sm transform transition-all duration-300 translate-x-full opacity-0">
        <div id="alertToastIcon" class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0 bg-green-50">
            <i id="alertToastIconI" class="fas fa-check-circle text-green-500 text-lg"></i>
        </div>
        <div class="flex-1 min-w-0">
            <p id="alertToastMsg" class="text-sm font-semibold text-gray-800"></p>
        </div>
        <button onclick="closeAlert()" class="text-gray-400 hover:text-gray-600 transition flex-shrink-0">
            <i class="fas fa-times text-sm"></i>
        </button>
    </div>
</div>

<script>
let modalResolve = null;

function confirmAction(url, title, message, type = 'danger') {
    const modal = document.getElementById('customModal');
    const backdrop = document.getElementById('modalBackdrop');
    const box = document.getElementById('modalBox');
    const iconWrap = document.getElementById('modalIconWrap');
    const icon = document.getElementById('modalIcon');
    const confirmBtn = document.getElementById('modalConfirmBtn');

    document.getElementById('modalTitle').textContent = title || 'Konfirmasi';
    document.getElementById('modalMessage').textContent = message || 'Apakah Anda yakin ingin melanjutkan?';

    if (type === 'danger') {
        iconWrap.className = 'w-12 h-12 rounded-2xl flex items-center justify-center flex-shrink-0 bg-red-50';
        icon.className = 'fas fa-exclamation-triangle text-xl text-red-500';
        confirmBtn.className = 'px-5 py-2.5 rounded-xl bg-red-500 text-white font-bold text-sm hover:bg-red-600 transition shadow-lg shadow-red-500/20 flex items-center gap-2';
    } else if (type === 'warning') {
        iconWrap.className = 'w-12 h-12 rounded-2xl flex items-center justify-center flex-shrink-0 bg-yellow-50';
        icon.className = 'fas fa-question-circle text-xl text-yellow-500';
        confirmBtn.className = 'px-5 py-2.5 rounded-xl bg-yellow-500 text-white font-bold text-sm hover:bg-yellow-600 transition shadow-lg shadow-yellow-500/20 flex items-center gap-2';
    } else {
        iconWrap.className = 'w-12 h-12 rounded-2xl flex items-center justify-center flex-shrink-0 bg-blue-50';
        icon.className = 'fas fa-info-circle text-xl text-blue-500';
        confirmBtn.className = 'px-5 py-2.5 rounded-xl bg-blue-500 text-white font-bold text-sm hover:bg-blue-600 transition shadow-lg shadow-blue-500/20 flex items-center gap-2';
    }

    confirmBtn.href = url;

    modal.classList.remove('hidden');
    requestAnimationFrame(() => {
        backdrop.classList.remove('opacity-0');
        box.classList.remove('scale-95', 'opacity-0');
        box.classList.add('scale-100', 'opacity-100');
    });

    return false; // prevent default link behavior
}

function closeModal() {
    const modal = document.getElementById('customModal');
    const backdrop = document.getElementById('modalBackdrop');
    const box = document.getElementById('modalBox');

    backdrop.classList.add('opacity-0');
    box.classList.add('scale-95', 'opacity-0');
    box.classList.remove('scale-100', 'opacity-100');

    setTimeout(() => {
        modal.classList.add('hidden');
    }, 300);
}

function showAlert(message, type = 'success') {
    const toast = document.getElementById('alertToast');
    const box = document.getElementById('alertToastBox');
    const iconWrap = document.getElementById('alertToastIcon');
    const icon = document.getElementById('alertToastIconI');
    document.getElementById('alertToastMsg').textContent = message;

    if (type === 'success') {
        iconWrap.className = 'w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0 bg-green-50';
        icon.className = 'fas fa-check-circle text-green-500 text-lg';
    } else if (type === 'error') {
        iconWrap.className = 'w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0 bg-red-50';
        icon.className = 'fas fa-exclamation-circle text-red-500 text-lg';
    } else {
        iconWrap.className = 'w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0 bg-blue-50';
        icon.className = 'fas fa-info-circle text-blue-500 text-lg';
    }

    toast.classList.remove('hidden');
    requestAnimationFrame(() => {
        box.classList.remove('translate-x-full', 'opacity-0');
        box.classList.add('translate-x-0', 'opacity-100');
    });

    setTimeout(() => closeAlert(), 4000);
}

function closeAlert() {
    const toast = document.getElementById('alertToast');
    const box = document.getElementById('alertToastBox');
    box.classList.add('translate-x-full', 'opacity-0');
    box.classList.remove('translate-x-0', 'opacity-100');
    setTimeout(() => toast.classList.add('hidden'), 300);
}

// For forms that use onsubmit confirm
function confirmForm(form, title, message, type = 'danger') {
    const modal = document.getElementById('customModal');
    const backdrop = document.getElementById('modalBackdrop');
    const box = document.getElementById('modalBox');
    const iconWrap = document.getElementById('modalIconWrap');
    const icon = document.getElementById('modalIcon');
    const confirmBtn = document.getElementById('modalConfirmBtn');

    document.getElementById('modalTitle').textContent = title || 'Konfirmasi';
    document.getElementById('modalMessage').textContent = message || 'Apakah Anda yakin ingin melanjutkan?';

    if (type === 'danger') {
        iconWrap.className = 'w-12 h-12 rounded-2xl flex items-center justify-center flex-shrink-0 bg-red-50';
        icon.className = 'fas fa-exclamation-triangle text-xl text-red-500';
        confirmBtn.className = 'px-5 py-2.5 rounded-xl bg-red-500 text-white font-bold text-sm hover:bg-red-600 transition shadow-lg shadow-red-500/20 flex items-center gap-2';
    } else {
        iconWrap.className = 'w-12 h-12 rounded-2xl flex items-center justify-center flex-shrink-0 bg-yellow-50';
        icon.className = 'fas fa-question-circle text-xl text-yellow-500';
        confirmBtn.className = 'px-5 py-2.5 rounded-xl bg-yellow-500 text-white font-bold text-sm hover:bg-yellow-600 transition shadow-lg shadow-yellow-500/20 flex items-center gap-2';
    }

    // Change confirm button to submit the form instead of navigating
    confirmBtn.href = '#';
    confirmBtn.onclick = function(e) {
        e.preventDefault();
        closeModal();
        form.submit();
    };

    modal.classList.remove('hidden');
    requestAnimationFrame(() => {
        backdrop.classList.remove('opacity-0');
        box.classList.remove('scale-95', 'opacity-0');
        box.classList.add('scale-100', 'opacity-100');
    });

    return false;
}
</script>
