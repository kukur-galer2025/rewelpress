<div class="max-w-4xl mx-auto">
    <div class="flex items-center gap-4 mb-8">
        <a href="<?= BASEURL; ?>/admin/authors" class="w-10 h-10 rounded-xl bg-white border border-gray-200 flex items-center justify-center text-gray-600 hover:bg-gray-50 transition shadow-sm">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Tambah Tokoh Penulis</h1>
            <p class="text-gray-500 mt-1">Lengkapi informasi penulis dan akademisi untuk ditampilkan di web.</p>
        </div>
    </div>

    <form action="<?= BASEURL; ?>/admin/create_author" method="POST" enctype="multipart/form-data" class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
<?= csrf_field() ?><div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Upload Foto Col -->
            <div class="md:col-span-1">
                <label class="block text-sm font-bold text-gray-700 mb-2">Foto Profil Penulis</label>
                <div class="border-2 border-dashed border-gray-300 rounded-2xl p-4 text-center hover:border-unsoed-blue transition cursor-pointer relative bg-gray-50 aspect-square flex flex-col items-center justify-center group" onclick="document.getElementById('photo').click()">
                    <div id="upload_placeholder">
                        <i class="fas fa-user-circle text-6xl text-gray-300 mb-3 group-hover:text-unsoed-blue transition-colors"></i>
                        <p class="text-sm text-gray-600 font-medium">Klik untuk upload foto</p>
                        <p class="text-xs text-gray-400 mt-1">Format: JPG, PNG (Maks 3MB)</p>
                    </div>
                    <img id="photo_preview" src="" class="hidden absolute inset-0 w-full h-full object-cover rounded-2xl">
                    <input type="file" name="photo" id="photo" class="hidden" accept="image/*" onchange="previewPhoto(this)">
                </div>

                <div class="mt-4">
                    <label for="photo_url" class="block text-xs font-bold text-gray-600 mb-1">Atau Gunakan URL Gambar Eksternal:</label>
                    <input type="url" name="photo_url" id="photo_url" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-xs focus:ring-2 focus:ring-unsoed-blue focus:border-unsoed-blue outline-none transition" placeholder="https://images.unsplash.com/..." oninput="previewPhotoUrl(this.value)">
                </div>
            </div>

            <!-- Detail Form Col -->
            <div class="md:col-span-2 space-y-6">
                <div>
                    <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap & Gelar <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-unsoed-blue focus:border-unsoed-blue outline-none transition" placeholder="Contoh: Prof. Dr. Ir. Suwarto, M.S." required>
                </div>

                <div>
                    <label for="affiliation" class="block text-sm font-bold text-gray-700 mb-2">Afiliasi / Jabatan</label>
                    <input type="text" name="affiliation" id="affiliation" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-unsoed-blue focus:border-unsoed-blue outline-none transition" placeholder="Contoh: Guru Besar Ilmu Pertanian Tropis UNSOED">
                </div>

                <div>
                    <label for="bio" class="block text-sm font-bold text-gray-700 mb-2">Biografi / Keahlian Singkat</label>
                    <textarea name="bio" id="bio" rows="5" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-unsoed-blue focus:border-unsoed-blue outline-none transition" placeholder="Tuliskan biografi singkat, bidang keahlian, dan karya utama penulis..."></textarea>
                </div>

                <div class="pt-4 border-t border-gray-100 flex justify-end gap-3">
                    <a href="<?= BASEURL; ?>/admin/authors" class="px-6 py-2.5 bg-gray-100 text-gray-700 rounded-lg font-semibold hover:bg-gray-200 transition">Batal</a>
                    <button type="submit" class="px-6 py-2.5 bg-unsoed-blue text-white rounded-lg font-semibold hover:bg-unsoed-darkblue transition shadow-lg flex items-center gap-2">
                        <i class="fas fa-save"></i> Simpan Penulis
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
function previewPhoto(input) {
    const preview = document.getElementById('photo_preview');
    const placeholder = document.getElementById('upload_placeholder');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            placeholder.classList.add('hidden');
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function previewPhotoUrl(url) {
    const preview = document.getElementById('photo_preview');
    const placeholder = document.getElementById('upload_placeholder');
    if (url && url.startsWith('http')) {
        preview.src = url;
        preview.classList.remove('hidden');
        placeholder.classList.add('hidden');
    } else {
        preview.classList.add('hidden');
        placeholder.classList.remove('hidden');
    }
}
</script>
<?= csrf_field() ?>
