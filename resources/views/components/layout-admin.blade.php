<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'default title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('assets/logo.png') }}" type="image/x-icon" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/boxicons/2.1.1/css/boxicons.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div id="sidebar"
     class="fixed inset-0 w-56 md:w-1/7 bg-gray-800 text-white flex flex-col shadow-lg z-30 transition-transform transform md:relative md:block md:translate-x-0 -translate-x-full">
    <button id="closeSidebarBtn" class="absolute top-3 right-3 text-white text-lg focus:outline-none md:hidden">
        <i class="fas fa-times"></i>
    </button>
    <div class="flex items-center justify-center p-3 text-lg font-bold border-b border-gray-700">
        <img alt="profile" class="rounded-full w-12 h-12 mr-4" src="{{ asset('assets/SI-PKL.png') }}">
        <span>SI-PKL</span>
    </div>
    <div class="mt-4 flex-grow">
        <ul>
            <li class="p-3 {{ request()->is('pages-admin/dashboard-admin') ?  'bg-green-600' : 'hover:bg-gray-700 hover:shadow-lg transition-all duration-200 cursor-pointer' }}">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-2 w-full h-full">
                    <!-- Home Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 hover:text-green-400">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12L11.204 3.045c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                    <span class="text-sm">Dashboard</span>
                </a>
            </li>
            
            <li class="p-3 {{ request()->is('kehadiran-siswapkl') ?  'bg-green-600' : 'hover:bg-gray-700 hover:shadow-lg transition-all duration-200 cursor-pointer' }}">
                <a href="{{ route('kehadiran-siswapkl') }}" class="flex items-center space-x-2 w-full h-full">
                    <!-- Home Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 hover:text-green-400">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                    </svg>
                    <span class="text-sm">Kehadiran Siswa</span>
                </a>
            </li>
            
            <li class="p-3 {{ request()->is('pkl') ?  'bg-green-600' : 'hover:bg-gray-700 hover:shadow-lg transition-all duration-200 cursor-pointer' }}">
                <a href="{{ route('pkl.index') }}" class="flex items-center space-x-2 w-full h-full">
                    <!-- Home Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 hover:text-green-400">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 3.75H6.912a2.25 2.25 0 0 0-2.15 1.588L2.35 13.177a2.25 2.25 0 0 0-.1.661V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18v-4.162c0-.224-.034-.447-.1-.661L19.24 5.338a2.25 2.25 0 0 0-2.15-1.588H15M2.25 13.5h3.86a2.25 2.25 0 0 1 2.012 1.244l.256.512a2.25 2.25 0 0 0 2.013 1.244h3.218a2.25 2.25 0 0 0 2.013-1.244l.256-.512a2.25 2.25 0 0 1 2.013-1.244h3.859M12 3v8.25m0 0-3-3m3 3 3-3" />
                    </svg>
                    <span class="text-sm">Pengajuan PKL</span>
                </a>
            </li>
            
            <li class="p-3 {{ request()->is('data-siswa') ?  'bg-green-600' : 'hover:bg-gray-700 hover:shadow-lg transition-all duration-200 cursor-pointer' }}">
                <a href="{{ route('data-siswa') }}" class="flex items-center space-x-2 w-full h-full">
                    <!-- Home Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 hover:text-green-400">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                    </svg>
                    <span class="text-sm">Data Siswa</span>
                </a>
            </li>
            
            <!-- Jurnal Kegiatan Harian -->
            <li class="p-3 {{ request()->is('jurnal-admin') ? 'bg-green-600' : 'hover:bg-gray-700 hover:shadow-lg transition-all duration-200 cursor-pointer' }}">
                <a href="{{ route('jurnal-admin.index') }}" class="flex items-center space-x-2 w-full h-full">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 hover:text-green-400">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                    </svg>
                    <span class="text-sm">Jurnal Siswa</span>
                </a>
            </li>
        </ul>
    </div>
    
</div>

        <div class="flex-1 flex flex-col overflow-auto">
            <nav
                class="bg-white p-4 text-white flex items-center justify-between border-b border-white shadow-lg sticky top-0 z-10 w-full">
                <div class="flex items-center space-x-4">
                    <!-- Mobile Sidebar Toggle -->
                    <button id="openSidebarBtn" class="md:hidden text-gray-800">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
                <div class="flex items-center space-x-6 ml-auto">
                    <!-- Profile Dropdown -->
                    <div class="relative">
                        <button id="profileButton" class="focus:outline-none flex items-center space-x-2">
                            <img src="{{ Auth::check() && Auth::user()->foto_profile ? asset('storage/' . Auth::user()->foto_profile) : asset('assets/default-profile.png') }}" alt="profile" class="w-auto h-8" />
                        </button>

                        <!-- Profile Dropdown -->
                        <div id="profileDropdown"
                            class="absolute right-0 mt-2 w-40 bg-white shadow-lg rounded-lg hidden transition-all ease-in-out duration-150">
                            <ul class="py-1 text-gray-700">
                                <li class="block px-6 py-2 hover:bg-gray-100 cursor-pointer transition">
                                    <a class="flex items-center space-x-2" href="{{ route('profile-admin') }}">
                                        <img alt="test-account" src="https://img.icons8.com/fluency-systems-filled/50/000000/test-account.png"
                                        class="w-5 h-5" />
                                        <span>Profile</span>
                                    </a>
                                </li>
                                <li class="block px-6 py-2 hover:bg-gray-100 cursor-pointer transition">
                                    <form method="POST" action="{{ route('logout-sekolah') }}">
                                        @csrf
                                        <button type="submit" class="flex items-center space-x-2 w-full text-left">
                                            <img alt="logout-rounded-left" src="https://img.icons8.com/ios-filled/50/000000/logout-rounded-left.png"
                                            class="w-5 h-5" />
                                        <span>Logout</span>
                                        </button>
                                    </form>
                                </li>   
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>

            <div class="flex-1 p-6 overflow-auto bg-gray-100" id="contentArea">
                @yield('content')
               </div>
             </div>
   
   <script>
       // Menambahkan event listener untuk klik di area konten
   document.getElementById('contentArea').addEventListener('click', function() {
       // Menutup sidebar jika sedang terbuka pada mode mobile
       if (document.getElementById('sidebar').classList.contains('-translate-x-full') === false) {
           document.getElementById('sidebar').classList.add('-translate-x-full');
       }
       // Menutup dropdown profile jika sedang terbuka
       if (!profileDropdown.classList.contains('hidden')) {
           profileDropdown.classList.add('hidden');
       }
   });
   
   
    
        // Menampilkan dan menyembunyikan dropdown
        const profileButton = document.getElementById('profileButton');
        const profileDropdown = document.getElementById('profileDropdown');

        profileButton.addEventListener('click', () => {
            profileDropdown.classList.toggle('hidden');
        });

        // Sidebar toggle untuk mobile
        document.getElementById('openSidebarBtn').addEventListener('click', function () {
            document.getElementById('sidebar').classList.remove('-translate-x-full');
        });

        document.getElementById('closeSidebarBtn').addEventListener('click', function () {
            document.getElementById('sidebar').classList.add('-translate-x-full');
        });
    </script>
</body>

</html>
