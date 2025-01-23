<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SI-PKL</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="icon" href="{{ asset('assets/logo.png') }}" type="image/x-icon" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
    body   {
        font-family: 'Poppins', sans-serif;
      }
      html {
        scroll-behavior: smooth;
      }
      #mobile-menu {
        transition: transform 0.3s ease-in-out;
        transform: translateX(100%);
        z-index: 60; /* Ensure mobile menu is above the header */
      }
      #mobile-menu.open {
        transform: translateX(0);
      }
      .gradient-text {
        background: linear-gradient(to right, #38b2ac, #4299e1);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
      }
      .sticky-header {
        position: sticky;
        top: 0;
        z-index: 50; /* Ensure header is below the mobile menu */
      }
    </style>
</head>
<body class="font-roboto">

  <header class="bg-white p-4 flex justify-between items-center sticky-header shadow-md">
    <div class="flex items-center mx-10">
        <img src="{{ asset('assets/logo.png') }}" alt="SI-PKL logo" class="h-12 w-12 rounded-full">
        <span class="text-white text-xl font-bold ml-2"></span>
    </div>
    <nav class="hidden md:flex space-x-4">
        <a href="#beranda" class="text-black hover:text-blue-500">Beranda</a>
        <a href="#tentang" class="text-black hover:text-blue-500">Tentang</a>
        <a href="#fitur" class="text-black hover:text-blue-500">Fitur</a>
        <a href="#kontak" class="text-black hover:text-blue-500">Kontak</a>

    </nav>
    <div class="hidden md:flex space-x-2">
        <a href="{{ route('register') }}"  class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">Pengajuan</a>
        <a href="{{ route('login') }}" class="bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 rounded">Masuk</a>
    </div>
    <div class="md:hidden">
        <button id="menu-toggle" class="text-indigo-700 focus:outline-none">
            <i class="fas fa-bars text-2xl"></i>
        </button>
    </div>
  </header>

  <!-- Mobile Menu -->
  <div id="mobile-menu" class="fixed top-0 right-0 h-full w-64 bg-white p-4 shadow-md hidden flex flex-col space-y-4">
    <button id="menu-close" class="text-black self-end focus:outline-none">
        <i class="fas fa-times text-2xl"></i>
    </button>
    <nav class="flex flex-col space-y-4">
        <a href="#beranda" class="gradient-text text-lg font-semibold menu-link">Beranda</a>
        <a href="#tentang" class="gradient-text text-lg font-semibold menu-link">Tentang</a>
        <a href="#fitur" class="gradient-text text-lg font-semibold menu-link">Fitur</a>
        <a href="#kontak" class="gradient-text text-lg font-semibold menu-link">Kontak</a>
        <a href="{{ route('register') }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">Pengajuan</a>
        <a href="{{ route('login') }}" class="bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 rounded">Masuk</a>
    </nav>
  </div>

  <main class="pt-18">
    <!-- Beranda Section -->
    <section id="beranda" class="py-10 md:py-20 bg-white">
        <div class="container mx-auto flex flex-col md:flex-row items-center justify-center px-4 md:px-8 lg:px-16">
            <!-- Left Content (Text) -->
            <div class="text-center md:text-left md:w-1/2">
                <h2 class="text-2xl md:text-2xl lg:text-4xl font-bold text-indigo-700 mb-4">
                    Selamat Datang di SI-PKL
                </h2>
                <p class="text-base md:text-lg lg:text-xl text-gray-800 mb-6">
                    Platform untuk memudahkan proses administrasi PKL siswa, memberikan pengalaman yang lebih baik dan efisien.
                </p>
                <!-- Button -->
                <a href="#tentang" class="bg-gradient-to-r from-teal-500 to-blue-600 text-white px-6 md:px-8 py-3 md:py-4 rounded-full text-base md:text-lg font-semibold shadow-lg hover:scale-105 transition-all duration-300">
                    Pelajari Lebih Lanjut
                </a>
            </div>
            <!-- Right Content (Image/Animated Icon) -->
            <div class="md:w-1/2 flex justify-center md:justify-end mt-8 md:mt-0">
                <div class="relative">
                    <img src="{{ asset('assets/1.png') }}" alt="Gambar Beranda" class="w-64 md:w-80 lg:w-[400px] h-auto">
                </div>
            </div>
        </div>
    </section>
  
    <section id="tentang" class="py-20 bg-gray-100">
        <div class="container mx-auto flex flex-col md:flex-row items-center justify-center py-12 px-4 md:px-6 lg:px-8">
            <!-- Left Content (Image/Icon) -->
            <div class="w-full md:w-1/2 flex justify-center order-2 md:order-1 mt-8 md:mt-0" data-aos="zoom-in" data-aos-duration="1000">
                <img src="{{ asset('assets/2.png') }}" alt="" class="max-w-full h-auto" height="200" width="400">
            </div>
            
            <!-- Right Content (Text) -->
            <div class="w-full md:w-1/2 md:pl-12 order-1 md:order-2">
                <h1 class="text-3xl font-bold text-blue-600 mb-4">Tentang SI-PKL</h1>
                <p class="text-gray-600 mb-6">SI-PKL ini membantu mengelola kegiatan PKL siswa dengan lebih efisien, mulai dari absensi hingga laporan kegiatan.</p>
                
                <!-- New Content with Icons -->
                <ul class="space-y-4">
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-teal-500 text-xl mr-3"></i>
                        <span class="text-gray-700"><strong>Pengajuan Siswa</strong> untuk PKL yang mudah dan cepat.</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-teal-500 text-xl mr-3"></i>
                        <span class="text-gray-700"><strong>Absensi Online</strong> tanpa kertas, praktis dan efisien.</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-teal-500 text-xl mr-3"></i>
                        <span class="text-gray-700"><strong>Laporan Kegiatan</strong> yang terstruktur dan mudah dibuat.</span>
                    </li>
                </ul>
            </div>
        </div>
    </section>

    <section id="fitur" class="py-20 ">
        <div class="container mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-2xl font-bold text-indigo-700">Fitur Unggulan</h2>
                <p class="text-lg text-gray-700 mt-4">Beragam fitur untuk mendukung kegiatan PKL siswa dengan lebih efisien.</p>
            </div>
            <!-- Fitur Items -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Fitur 1 -->
                <div class="bg-white shadow-lg rounded-lg p-6 flex flex-col items-center mx-4">
                    <div class="text-center mb-4">
                        <h3 class="text-xl font-semibold text-indigo-700 mb-4">Absensi Kamera</h3>
                        <p class="text-sm text-gray-700">Siswa dapat melakukan absensi dengan menggunakan kamera secara mudah dan praktis.</p>
                    </div>
                    <div class="flex justify-center" data-aos="zoom-in" data-aos-duration="1000">
                        <img alt="Absensi Kamera" class="w-36 h-36 md:w-48 md:h-48" src="{{ asset('assets/4.png') }}" />
                    </div>
                </div>
                <!-- Fitur 2 -->
                <div class="bg-white shadow-lg rounded-lg p-6 flex flex-col items-center mx-4">
                    <div class="text-center mb-4">
                        <h3 class="text-xl font-semibold text-indigo-700 mb-4">Laporan Kegiatan</h3>
                        <p class="text-sm text-gray-700">Membantu siswa membuat laporan kegiatan PKL yang terstruktur dan mudah dipahami.</p>
                    </div>
                    <div class="flex justify-center" data-aos="zoom-in" data-aos-duration="1000">
                        <img alt="Laporan Kegiatan" class="w-36 h-36 md:w-48 md:h-48" src="{{ asset('assets/3.png') }}" />
                    </div>
                </div>
                <!-- Fitur 3 -->
                <div class="bg-white shadow-lg rounded-lg p-6 flex flex-col items-center mx-4">
                    <div class="text-center mb-4">
                        <h3 class="text-xl font-semibold text-indigo-700 mb-4">Pengajuan Izin</h3>
                        <p class="text-sm text-gray-700">Memudahkan siswa untuk mengajukan izin jika tidak dapat hadir ke lokasi PKL.</p>
                    </div>
                    <div class="flex justify-center" data-aos="zoom-in" data-aos-duration="1000">
                        <img alt="Pengajuan Izin" class="w-36 h-36 md:w-48 md:h-48" src="{{ asset('assets/6.png') }}" />
                    </div>
                </div>
                <!-- Fitur 4 -->
                <div class="bg-white shadow-lg rounded-lg p-6 flex flex-col items-center mx-4">
                    <div class="text-center mb-4">
                        <h3 class="text-xl font-semibold text-indigo-700 mb-4">Monitoring</h3>
                        <p class="text-sm text-gray-700">Pantau kegiatan siswa secara real-time untuk memastikan kehadiran dan aktivitas mereka.</p>
                    </div>
                    <div class="flex justify-center" data-aos="zoom-in" data-aos-duration="1000">
                        <img alt="Monitoring" class="w-36 h-36 md:w-48 md:h-48" src="{{ asset('assets/5.png') }}" />
                    </div>
                </div>
            </div>
        </div>
    </section>  

    <section id="kontak" class="bg-gray-100 scroll-mt-16">
        <div class="max-w-4xl mx-auto py-16 px-4">
            <h1 class="text-3xl font-bold text-center text-blue-800 mb-4 font-serif">Kontak Kami</h1>
            <p class="text-center text-gray-600 mb-12">
                Jangan ragu untuk menghubungi kami terkait layanan atau informasi tambahan. Kami menjaga kerahasiaan data pribadi Anda.
            </p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <!-- Peta Lokasi -->
                <div class="flex items-center justify-center">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3963.612413793621!2d106.74005677410136!3d-6.570503664228493!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69dc9b2bd7bc0f%3A0x3fff29cf02995e70!2sPT%20Qelopak%20Teknologi%20Indonesia!5e0!3m2!1sid!2sid!4v1737171545370!5m2!1sid!2sid"
                        width="100%"
                        height="300"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        class="rounded-lg shadow-md"
                    ></iframe>
                </div>
    
                <!-- Informasi Kontak -->
                <div>
                    <div class="flex items-start mb-8">
                        <img src="{{ asset('assets/location.png') }}" alt="alamat" class="w-8 h-8 mr-4">
                        <div>
                            <h2 class="text-xl font-semibold mb-2">Alamat</h2>
                            <p class="text-gray-700">
                                Ruko Pakuan Regency, Jl. Amparan Jati Blok A2 No 11, RT.01/RW.07, Margajaya, Kec. Bogor Bar., Kota Bogor, Jawa Barat 16116
                            </p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <img src="{{ asset('assets/email.png') }}" alt="email" class="w-8 h-8 mr-4">
                        <div>
                            <h2 class="text-xl font-semibold mb-2">Email</h2>
                            <p class="text-gray-700">si.pklteam@gmail.com</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>    

    <footer class="bg-white text-black py-2 mt-10 shadow-t-md">
        <div class="container mx-auto text-center">
            <p>&copy; 2024 SI-PKL. All Rights Reserved.</p>
        </div>
    </footer>    
    
  </main>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
  <script>
    AOS.init();
    document.getElementById('menu-toggle').addEventListener('click', function() {
        var menu = document.getElementById('mobile-menu');
        menu.classList.toggle('hidden');
        menu.classList.toggle('open');
    });

    document.getElementById('menu-close').addEventListener('click', function() {
        var menu = document.getElementById('mobile-menu');
        menu.classList.toggle('hidden');
        menu.classList.toggle('open');
    });

    document.querySelectorAll('.menu-link').forEach(link => {
        link.addEventListener('click', function() {
            var menu = document.getElementById('mobile-menu');
            menu.classList.add('hidden');
            menu.classList.remove('open');
        });
    });

    document.addEventListener('click', function(event) {
        var menu = document.getElementById('mobile-menu');
        var menuToggle = document.getElementById('menu-toggle');
        var menuClose = document.getElementById('menu-close');

        if (!menu.contains(event.target) && !menuToggle.contains(event.target) && !menuClose.contains(event.target)) {
            menu.classList.add('hidden');
            menu.classList.remove('open');
        }
    });
  </script>

</body>
</html>