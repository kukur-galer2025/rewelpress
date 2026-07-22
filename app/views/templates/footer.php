    <!-- Footer -->
    <footer class="bg-unsoed-darkblue text-white/70 pt-20 pb-10 border-t-4 border-unsoed-yellow mt-20 relative overflow-hidden">
        <!-- Decorative bg -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none">
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-unsoed-blue/50 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-unsoed-yellow/10 rounded-full blur-3xl"></div>
        </div>

        <div class="container mx-auto px-4 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
                
                <!-- Brand -->
                <div class="space-y-6">
                    <a href="<?= BASEURL; ?>" class="flex items-center gap-3">
                        <i class="fas fa-book-reader text-4xl text-unsoed-yellow"></i>
                        <div class="font-serif text-3xl font-bold tracking-tight text-white">
                            UNSOED<span class="text-unsoed-yellow">PRESS</span>
                        </div>
                    </a>
                    <p class="text-sm leading-relaxed">
                        Badan Penerbit dan Publikasi Universitas Jenderal Soedirman. Menghadirkan karya-karya akademis berkualitas untuk memajukan pendidikan dan penelitian di Indonesia.
                    </p>
                    <div class="flex space-x-4">
                        <a href="https://facebook.com/unsoedpress" target="_blank" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-unsoed-yellow hover:text-white transition-all"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://twitter.com/unsoedpress" target="_blank" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-unsoed-yellow hover:text-white transition-all"><i class="fab fa-twitter"></i></a>
                        <a href="https://instagram.com/unsoedpress" target="_blank" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-unsoed-yellow hover:text-white transition-all"><i class="fab fa-instagram"></i></a>
                        <a href="https://youtube.com/@unsoedpress" target="_blank" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-unsoed-yellow hover:text-white transition-all"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>

                <!-- Links -->
                <div>
                    <h4 class="text-white font-semibold text-lg mb-6 relative inline-block">
                        Pintasan
                        <span class="absolute -bottom-2 left-0 w-1/2 h-1 bg-unsoed-yellow rounded-full"></span>
                    </h4>
                    <ul class="space-y-3 text-sm">
                        <li><a href="<?= BASEURL; ?>" class="hover:text-unsoed-yellow hover:translate-x-2 transition-all block">Beranda</a></li>
                        <li><a href="<?= BASEURL; ?>/news" class="hover:text-unsoed-yellow hover:translate-x-2 transition-all block">Berita Unsoed Press</a></li>
                        <li><a href="<?= BASEURL; ?>/book" class="hover:text-unsoed-yellow hover:translate-x-2 transition-all block">Katalog Buku</a></li>
                        <li><a href="<?= BASEURL; ?>/ebook" class="hover:text-unsoed-yellow hover:translate-x-2 transition-all block">E-Book</a></li>
                    </ul>
                </div>

                <!-- Categories -->
                <div>
                    <h4 class="text-white font-semibold text-lg mb-6 relative inline-block">
                        Kategori Populer
                        <span class="absolute -bottom-2 left-0 w-1/2 h-1 bg-unsoed-yellow rounded-full"></span>
                    </h4>
                    <ul class="space-y-3 text-sm">
                        <?php 
                        $dbFooter = new Database();
                        $dbFooter->query('SELECT categories.id, categories.name, categories.slug, COUNT(books.id) as total_books FROM categories LEFT JOIN books ON categories.id = books.category_id WHERE categories.parent_id IS NULL GROUP BY categories.id ORDER BY total_books DESC LIMIT 5');
                        $popCats = $dbFooter->resultSet();
                        foreach($popCats as $pcat):
                        ?>
                        <li><a href="<?= BASEURL; ?>/book/category/<?= esc($pcat['slug']) ?>" class="hover:text-unsoed-yellow hover:translate-x-2 transition-all block"><?= esc($pcat['name']) ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h4 class="text-white font-semibold text-lg mb-6 relative inline-block">
                        Hubungi Kami
                        <span class="absolute -bottom-2 left-0 w-1/2 h-1 bg-unsoed-yellow rounded-full"></span>
                    </h4>
                    <ul class="space-y-4 text-sm">
                        <li class="flex items-start gap-3">
                            <i class="fas fa-map-marker-alt text-unsoed-yellow mt-1"></i>
                            <span>Dukuhbandong, Grendeng, Kec. Purwokerto Utara, Kabupaten Banyumas, Jawa Tengah 53125</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fas fa-phone-alt text-unsoed-yellow"></i>
                            <span>(0281) 626070</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fas fa-envelope text-unsoed-yellow"></i>
                            <span>unsoedpress@gmail.com</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="mt-16 pt-8 border-t border-white/10 text-center text-sm">
                <p>&copy; <?= date('Y') ?> UNSOED PRESS - Universitas Jenderal Soedirman. Didesain dengan Native PHP & Tailwind CSS.</p>
            </div>
        </div>
    </footer>

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    
    <!-- Custom Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Navbar Glassmorphism Effect on Scroll
            const navbar = document.querySelector('nav');
            window.addEventListener('scroll', () => {
                if (window.scrollY > 20) {
                    navbar.classList.add('shadow-xl', 'bg-white/90');
                    navbar.classList.remove('bg-white/80');
                } else {
                    navbar.classList.remove('shadow-xl', 'bg-white/90');
                    navbar.classList.add('bg-white/80');
                }
            });

            // Toggle Mobile Menu Drawer
            const mobileMenuBtn = document.getElementById('mobile-menu-btn');
            const mobileMenuPanel = document.getElementById('mobile-menu-panel');
            if (mobileMenuBtn && mobileMenuPanel) {
                mobileMenuBtn.addEventListener('click', () => {
                    mobileMenuPanel.classList.toggle('hidden');
                });
            }

            // Initialize Swiper for Hero Slider
            if(document.querySelector('.hero-swiper')) {
                new Swiper('.hero-swiper', {
                    loop: true,
                    effect: 'fade',
                    autoplay: {
                        delay: 6000,
                        disableOnInteraction: false,
                    },
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                    },
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    },
                });
            }

            // Initialize Swiper for Testimonial Carousel
            if(document.querySelector('.testimoni-swiper')) {
                new Swiper('.testimoni-swiper', {
                    slidesPerView: 1,
                    spaceBetween: 20,
                    loop: true,
                    autoplay: {
                        delay: 4000,
                        disableOnInteraction: false,
                    },
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                    },
                    breakpoints: {
                        640: {
                            slidesPerView: 2,
                            spaceBetween: 20,
                        },
                        1024: {
                            slidesPerView: 3,
                            spaceBetween: 30,
                        },
                    }
                });
            }

            // Initialize Swiper for Product Carousel
            if(document.querySelector('.product-swiper')) {
                const productSwipers = document.querySelectorAll('.product-swiper');
                
                productSwipers.forEach(element => {
                    new Swiper(element, {
                        slidesPerView: 1,
                        spaceBetween: 24,
                        loop: true,
                        autoplay: {
                            delay: 4000,
                            disableOnInteraction: false,
                        },
                        breakpoints: {
                            576: { slidesPerView: 2 },
                            768: { slidesPerView: 3 },
                            1024: { slidesPerView: 4 },
                            1280: { slidesPerView: 5 }
                        },
                        navigation: {
                            nextEl: element.parentElement.querySelector('.swiper-button-next'),
                            prevEl: element.parentElement.querySelector('.swiper-button-prev'),
                        },
                    });
                });
            }
        });
    </script>

    <!-- Global Floating Voucher Widget (Melayang di Atas WhatsApp) -->
    <div class="fixed right-6 bottom-28 md:bottom-32 z-[100] flex items-center group">
        <!-- Tooltip geser saat hover -->
        <span class="mr-3 bg-gradient-to-r from-amber-600 to-orange-600 text-white text-xs font-extrabold px-3.5 py-2 rounded-xl shadow-xl whitespace-nowrap opacity-0 group-hover:opacity-100 transition-all duration-300 translate-x-2 group-hover:translate-x-0 pointer-events-none border border-amber-400/40">
            <i class="fas fa-gift text-yellow-300 mr-1 text-sm animate-bounce"></i> Klaim Voucher Diskon & Promo Spesial!
        </span>

        <!-- Tombol Melayang Voucher Diskon dengan ring gelombang emas -->
        <a href="<?= BASEURL; ?>/promo" class="relative w-16 h-16 bg-gradient-to-tr from-amber-500 via-orange-500 to-yellow-400 hover:from-amber-600 hover:to-orange-600 text-white rounded-full flex items-center justify-center shadow-2xl text-3xl border-2 border-white transition-all duration-300 transform group-hover:scale-110 group-hover:-rotate-12" title="Lihat Daftar Promo & Klaim Voucher Diskon">
            <!-- Animasi gelombang berdenyut (Pulse Ring Emas) -->
            <span class="absolute inset-0 rounded-full bg-amber-400 opacity-60 animate-ping -z-10"></span>
            
            <i class="fas fa-ticket-alt"></i>
        </a>
    </div>

    <!-- Global Floating WhatsApp Widget (Muncul di Semua Halaman Pengunjung / Non-Admin) -->
    <div class="fixed right-6 bottom-8 md:bottom-10 z-[100] flex items-center group">
        <!-- Tooltip geser saat hover -->
        <span class="mr-3 bg-gray-900 text-white text-xs font-bold px-3.5 py-2 rounded-xl shadow-xl whitespace-nowrap opacity-0 group-hover:opacity-100 transition-all duration-300 translate-x-2 group-hover:translate-x-0 pointer-events-none">
            <i class="fab fa-whatsapp text-green-400 mr-1 text-sm"></i> Hubungi WhatsApp Redaksi
        </span>

        <!-- Tombol WhatsApp dengan ring pemanis -->
        <a href="https://wa.me/6285600110828" target="_blank" class="relative w-16 h-16 bg-[#25d366] hover:bg-[#20bd5a] text-white rounded-full flex items-center justify-center shadow-2xl text-4xl border-2 border-white transition-all duration-300 transform group-hover:scale-110 group-hover:rotate-12" title="Hubungi Kami via WhatsApp (085600110828)">
            <!-- Animasi gelombang berdenyut (Pulse Ring) -->
            <span class="absolute inset-0 rounded-full bg-[#25d366] opacity-75 animate-ping -z-10"></span>
            
            <i class="fab fa-whatsapp"></i>
        </a>
    </div>

    <!-- Global Cinema Pop-Up Video Modal -->
    <div id="videoModal" class="fixed inset-0 z-[110] bg-black/90 hidden flex items-center justify-center p-4 md:p-8 backdrop-blur-md transition-opacity duration-300" onclick="closeVideoModal()">
        <div class="relative w-full max-w-5xl bg-gray-950 rounded-2xl overflow-hidden shadow-2xl border border-gray-800 flex flex-col transform transition-all duration-300" onclick="event.stopPropagation()">
            
            <!-- Header Modal -->
            <div class="h-14 px-6 bg-gray-900 border-b border-gray-800 flex items-center justify-between text-white">
                <div class="flex items-center gap-3 overflow-hidden pr-4">
                    <span class="w-2 h-6 bg-red-600 rounded-full flex-shrink-0"></span>
                    <h3 id="modalVideoTitle" class="font-bold text-base md:text-lg truncate tracking-wide text-gray-100"></h3>
                </div>
                <button onclick="closeVideoModal()" class="w-9 h-9 rounded-full bg-gray-800 hover:bg-red-600 text-gray-300 hover:text-white transition flex items-center justify-center text-lg flex-shrink-0 shadow" title="Tutup Video">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Cinema Video Player Container (16:9 Aspect Ratio) -->
            <div class="aspect-video w-full bg-black relative flex items-center justify-center">
                <iframe id="modalVideoFrame" src="" title="Video Player" class="w-full h-full border-0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>

            <!-- Footer Modal -->
            <div class="px-6 py-3 bg-gray-900 border-t border-gray-800 flex items-center justify-between text-xs text-gray-400">
                <span><i class="fab fa-youtube text-red-600 mr-1.5 text-sm"></i> UNSOED PRESS YouTube Gallery</span>
                <button onclick="closeVideoModal()" class="text-gray-300 hover:text-white underline font-semibold transition">
                    Tutup Jendela [ESC]
                </button>
            </div>

        </div>
    </div>

    <script>
    function openVideoModal(url, title) {
        if (!url || url === '#' || url === '') return;
        let playUrl = url;
        if (playUrl.indexOf('?') !== -1) {
            playUrl += '&autoplay=1';
        } else {
            playUrl += '?autoplay=1';
        }
        
        document.getElementById('modalVideoTitle').textContent = title || 'Video Gallery';
        document.getElementById('modalVideoFrame').src = playUrl;
        document.getElementById('videoModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeVideoModal() {
        const modalFrame = document.getElementById('modalVideoFrame');
        if (modalFrame) modalFrame.src = '';
        const modal = document.getElementById('videoModal');
        if (modal) modal.classList.add('hidden');
        document.body.style.overflow = '';
    }

    document.addEventListener('keydown', function(event) {
        if (event.key === "Escape") {
            closeVideoModal();
        }
    });
    </script>
    <!-- AOS JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true,
            offset: 100,
        });
    </script>
</body>
</html>
