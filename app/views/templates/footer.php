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
                    <a href="#" class="flex items-center gap-3">
                        <i class="fas fa-book-reader text-4xl text-unsoed-yellow"></i>
                        <div class="font-serif text-3xl font-bold tracking-tight text-white">
                            UNSOED<span class="text-unsoed-yellow">PRESS</span>
                        </div>
                    </a>
                    <p class="text-sm leading-relaxed">
                        Badan Penerbit dan Publikasi Universitas Jenderal Soedirman. Menghadirkan karya-karya akademis berkualitas untuk memajukan pendidikan dan penelitian di Indonesia.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-unsoed-yellow hover:text-white transition-all"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-unsoed-yellow hover:text-white transition-all"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-unsoed-yellow hover:text-white transition-all"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>

                <!-- Links -->
                <div>
                    <h4 class="text-white font-semibold text-lg mb-6 relative inline-block">
                        Pintasan
                        <span class="absolute -bottom-2 left-0 w-1/2 h-1 bg-unsoed-yellow rounded-full"></span>
                    </h4>
                    <ul class="space-y-3 text-sm">
                        <li><a href="#" class="hover:text-unsoed-yellow hover:translate-x-2 transition-all block">Beranda</a></li>
                        <li><a href="#" class="hover:text-unsoed-yellow hover:translate-x-2 transition-all block">Tentang Kami</a></li>
                        <li><a href="#" class="hover:text-unsoed-yellow hover:translate-x-2 transition-all block">Katalog Buku</a></li>
                        <li><a href="#" class="hover:text-unsoed-yellow hover:translate-x-2 transition-all block">Cara Pembelian</a></li>
                        <li><a href="#" class="hover:text-unsoed-yellow hover:translate-x-2 transition-all block">Syarat & Ketentuan</a></li>
                    </ul>
                </div>

                <!-- Categories -->
                <div>
                    <h4 class="text-white font-semibold text-lg mb-6 relative inline-block">
                        Kategori Populer
                        <span class="absolute -bottom-2 left-0 w-1/2 h-1 bg-unsoed-yellow rounded-full"></span>
                    </h4>
                    <ul class="space-y-3 text-sm">
                        <li><a href="#" class="hover:text-unsoed-yellow hover:translate-x-2 transition-all block">Pertanian & Kehutanan</a></li>
                        <li><a href="#" class="hover:text-unsoed-yellow hover:translate-x-2 transition-all block">Hukum & Politik</a></li>
                        <li><a href="#" class="hover:text-unsoed-yellow hover:translate-x-2 transition-all block">Ekonomi & Bisnis</a></li>
                        <li><a href="#" class="hover:text-unsoed-yellow hover:translate-x-2 transition-all block">Biologi & Sains</a></li>
                        <li><a href="#" class="hover:text-unsoed-yellow hover:translate-x-2 transition-all block">Kedokteran & Kesehatan</a></li>
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
                            <span>Gedung Rektorat Lt. 1<br>Jl. Profesor DR. HR Boenyamin No.708, Purwokerto Utara, Banyumas 53122</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fas fa-phone-alt text-unsoed-yellow"></i>
                            <span>(0281) 635292</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fas fa-envelope text-unsoed-yellow"></i>
                            <span>unsoedpress@unsoed.ac.id</span>
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
</body>
</html>
