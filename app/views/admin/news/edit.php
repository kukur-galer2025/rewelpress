<div class="mb-8">
    <a href="<?= BASEURL; ?>/admin/news" class="text-unsoed-blue hover:text-unsoed-darkblue flex items-center gap-2 mb-4 font-medium">
        <i class="fas fa-arrow-left"></i> Kembali ke Daftar Berita
    </a>
    <h1 class="text-3xl font-bold text-gray-800">Edit Berita</h1>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
    <form action="<?= BASEURL; ?>/admin/update_news" method="POST" enctype="multipart/form-data" id="newsForm">
        <input type="hidden" name="id" value="<?= $data['news']['id'] ?>">
        <input type="hidden" name="old_images" value="<?= htmlspecialchars($data['news']['image']) ?>">
        
        <div class="space-y-6">
            <!-- Judul -->
            <div>
                <label for="title" class="block text-sm font-bold text-gray-700 mb-2">Judul Berita <span class="text-red-500">*</span></label>
                <input type="text" name="title" id="title" value="<?= $data['news']['title'] ?>" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-unsoed-blue focus:border-unsoed-blue outline-none transition" required>
            </div>

            <!-- Gambar Berita (Galeri) -->
            <div>
                <label for="images" class="block text-sm font-bold text-gray-700 mb-2">Unggah Gambar Baru (Bisa Lebih Dari Satu)</label>
                
                <?php
                $images = [];
                if(!empty($data['news']['image'])) {
                    $decoded = json_decode($data['news']['image'], true);
                    if(is_array($decoded)) {
                        $images = $decoded;
                    } elseif(is_string($data['news']['image']) && filter_var($data['news']['image'], FILTER_VALIDATE_URL)) {
                        // legacy support for single URL
                        $images[] = $data['news']['image'];
                    }
                }
                ?>
                
                <?php if(!empty($images)): ?>
                    <div class="mb-4">
                        <p class="text-xs text-gray-500 mb-2 font-medium">Gambar Saat Ini (Galeri Lama):</p>
                        <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 gap-4">
                            <?php foreach($images as $img): ?>
                                <div class="aspect-square rounded-lg overflow-hidden border border-gray-200 bg-gray-100">
                                    <img src="<?= $img ?>" alt="Cover" class="w-full h-full object-cover">
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <p class="text-xs text-red-500 mt-2 italic">*Jika Anda mengunggah gambar baru di bawah, seluruh gambar lama ini akan tergantikan.</p>
                    </div>
                <?php endif; ?>

                <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:bg-gray-50 hover:border-unsoed-blue transition-colors relative">
                    <input type="file" name="images[]" id="images" multiple accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" onchange="previewFiles()">
                    <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-3"></i>
                    <p class="text-sm text-gray-600 font-medium">Klik atau seret gambar baru ke sini</p>
                    <p class="text-xs text-gray-400 mt-1">Kosongkan jika tidak ingin mengubah galeri gambar.</p>
                </div>
                
                <!-- Preview Container -->
                <div id="preview-container" class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 gap-4 mt-4 hidden"></div>
                
                <script>
                function previewFiles() {
                    const previewContainer = document.getElementById('preview-container');
                    const files = document.getElementById('images').files;
                    
                    previewContainer.innerHTML = '';
                    if(files.length > 0) {
                        previewContainer.classList.remove('hidden');
                        for(let i=0; i<files.length; i++) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                const div = document.createElement('div');
                                div.className = 'aspect-square rounded-lg overflow-hidden border border-gray-200 bg-gray-100';
                                div.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
                                previewContainer.appendChild(div);
                            }
                            reader.readAsDataURL(files[i]);
                        }
                    } else {
                        previewContainer.classList.add('hidden');
                    }
                }
                </script>
            </div>

            <!-- Konten (Quill Editor) -->
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Isi Berita <span class="text-red-500">*</span></label>
                
                <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
                
                <!-- Initial content passed into the editor container -->
                <div id="editor-container" class="h-64 sm:h-96 rounded-b-lg"><?= $data['news']['content'] ?></div>
                
                <input type="hidden" name="content" id="content" required>
                
                <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
                <script>
                  var toolbarOptions = [
                    ['bold', 'italic', 'underline', 'strike'],
                    ['blockquote', 'code-block'],
                    [{ 'header': 1 }, { 'header': 2 }],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'script': 'sub'}, { 'script': 'super' }],
                    [{ 'indent': '-1'}, { 'indent': '+1' }],
                    [{ 'size': ['small', false, 'large', 'huge'] }],
                    [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                    [{ 'color': [] }, { 'background': [] }],
                    [{ 'font': [] }],
                    [{ 'align': [] }],
                    ['link', 'image', 'video'],
                    ['clean']
                  ];

                  var quill = new Quill('#editor-container', {
                    theme: 'snow',
                    placeholder: 'Tuliskan isi berita di sini...',
                    modules: {
                        toolbar: toolbarOptions
                    }
                  });

                  var form = document.querySelector('#newsForm');
                  form.onsubmit = function() {
                    var contentInput = document.querySelector('input[name=content]');
                    contentInput.value = quill.root.innerHTML;
                  };
                </script>
            </div>
            
            <hr class="border-gray-100">

            <div class="flex justify-end gap-3 pt-2">
                <a href="<?= BASEURL; ?>/admin/news" class="px-6 py-2.5 rounded-lg border border-gray-300 text-gray-700 font-semibold hover:bg-gray-50 transition">
                    Batal
                </a>
                <button type="submit" class="bg-unsoed-blue text-white px-8 py-2.5 rounded-lg font-semibold hover:bg-unsoed-darkblue transition shadow-lg shadow-unsoed-blue/30">
                    Simpan Perubahan
                </button>
            </div>
        </div>
        
    </form>
</div>
