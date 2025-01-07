<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'default title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('assets/logo absensipkl.png') }}" type="image/x-icon" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.14.305/pdf.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
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
            class="fixed inset-0 w-64 md:w-1/6 bg-gray-800 text-white flex flex-col shadow-lg z-30 transition-transform transform md:relative md:block md:translate-x-0 -translate-x-full">
            <button id="closeSidebarBtn" class="absolute top-3 right-3 text-white text-lg focus:outline-none md:hidden">
                <i class="fas fa-times"></i>
            </button>
            <div class="flex items-center justify-center p-3 text-lg font-bold border-b border-gray-700">
                <img alt="profile" class="rounded-full w-12 h-12 mr-4" src="{{ asset('assets/SI-PKL.png') }}">
                <span>SI-PKL</span>
            </div>
            <div class="mt-4 flex-grow">
              <ul>
                <li class="p-3 {{ request()->is('pages-industri/dashboard-industri') ?  'bg-green-600' : 'hover:bg-gray-700 hover:shadow-lg transition-all duration-200 cursor-pointer' }}">
                    <a href="{{ route('industri.dashboard') }}" class="flex items-center space-x-2 w-full h-full">
                        <!-- Home Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 hover:text-green-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12L11.204 3.045c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                        </svg>
                        <span class="text-sm">Dashboard</span>
                    </a>
                </li>
                <li class="p-3 {{ request()->is('kelola-kehadiran') ?  'bg-green-600' : 'hover:bg-gray-700 hover:shadow-lg transition-all duration-200 cursor-pointer' }}">
                    <a href="{{ route('kelola-kehadiran') }}" class="flex items-center space-x-2 w-full h-full">
                        <!-- Home Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 hover:text-green-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                        </svg>
                        <span class="text-sm">Kelola Kehadiran</span>
                    </a>
                </li>
                <li class="p-3 {{ request()->is('jurnal-industri') ?  'bg-green-600' : 'hover:bg-gray-700 hover:shadow-lg transition-all duration-200 cursor-pointer' }}">
                    <a href="{{ route('jurnal-industri.index') }}" class="flex items-center space-x-2 w-full h-full">
                        <!-- Home Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 hover:text-green-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                        </svg>
                        <span class="text-sm">Jurnal Siswa</span>
                    </a>
                </li>
                <li class="p-3 {{ request()->routeIs('penilaian.index') ? 'bg-green-600' : 'hover:bg-gray-700 hover:shadow-lg transition-all duration-200 cursor-pointer' }}">
                    <a href="{{ route('penilaian.index') }}" class="flex items-center space-x-2 w-full h-full">
                        <!-- Penilaian Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 hover:text-green-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0 1 18 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3 1.5 1.5 3-3.75" />
                        </svg>                                                  
                        <span class="text-sm">Penilaian Siswa</span>
                    </a>
                </li>                
                <li class="p-3 {{ request()->is('sekolah') ?  'bg-green-600' : 'hover:bg-gray-700 hover:shadow-lg transition-all duration-200 cursor-pointer' }}">
                    <a href="{{ route('sekolah.index') }}" class="flex items-center space-x-2 w-full h-full">
                        <!-- Home Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 hover:text-green-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                        </svg>                          
                        <span class="text-sm">Data Sekolah</span>
                    </a>
                </li>
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
                                <li class="block px-4 py-2 hover:bg-gray-100 cursor-pointer transition">
                                    <a class="flex items-center space-x-2" href="{{ route('profile-industri') }}">
                                        <img alt="test-account" src="https://img.icons8.com/fluency-systems-filled/50/000000/test-account.png"
                                        class="w-5 h-5" />
                                        <span>Profile</span>
                                    </a>
                                </li>
                                <li class="block px-4 py-2 hover:bg-gray-100 cursor-pointer transition">
                                    <form method="POST" action="{{ route('logout-industri') }}">
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