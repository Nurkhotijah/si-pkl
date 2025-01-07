@extends('components.layout-admin')

@section('title', 'Dashboard Sekolah')

@section('content')

<body class="flex-1 p-6 bg-gray-100 font-poppins">
  <!-- Kotak utama untuk konten -->
  <div class="bg-white p-4 rounded-lg shadow-md mb-6">
    <h1 class="text-xl font-bold mb-2">
      Hai {{ Auth::user()->name }}
      <span class="ml-2">
        <i class="fas fa-star text-yellow-500"></i>
      </span>
    </h1>
    <p class="mb-4 text-base font-semibold">Selamat Datang Di SI-PKL</p>
    <p class="text-gray-600 mb-4"></p>
  </div>

  <div class="grid grid-cols-1  lg:grid-cols-3 gap-4">
    <!-- Waktu Saat Ini -->
    <div class="bg-white rounded-lg shadow-lg p-6 text-center border border-transparent hover:border-gradient-to-r hover:from-blue-400 hover:to-blue-600 transition">
      <div class="flex flex-col items-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-blue-500 mb-2" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
        </svg>
        <p class="text-black font-semibold text-base mb-2">Waktu Saat Ini</p>
        <p class="text-base font-semibold text-gray-800" id="current-time">--:--:-- WIB</p>
      </div>
    </div>

    <!-- Jumlah Jurnal Siswa -->
    <div class="bg-white rounded-lg shadow-lg p-6 text-center border border-transparent hover:border-gradient-to-r hover:from-green-400 hover:to-green-600 transition">
      <div class="flex flex-col items-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-green-500 mb-2" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
      </svg>
        <p class="text-black font-semibold text-base mb-2">Jumlah Jurnal Siswa</p>
        <p class="text-base font-semibold text-gray-800">{{ $jumlahjurnal }}</p>
      </div>
    </div>

    <!-- Kotak tambahan -->
    <div class="bg-white rounded-lg shadow-lg p-6 text-center border border-transparent hover:border-gradient-to-r hover:from-red-400 hover:to-red-600 transition">
      <div class="flex flex-col items-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-red-500 mb-2" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none">
          <path stroke-linecap="round" stroke-linejoin="round" d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0 1 18 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3 1.5 1.5 3-3.75" />
      </svg>
        <p class="text-black font-semibold text-base mb-2">Jumlah Kehadiran Siswa</p>
        <p class="text-base font-semibold text-gray-800">{{ $jumlahkehadiran }}</p>
      </div>
    </div>

    <!-- Jumlah Siswa -->
    <div class="bg-white rounded-lg shadow-lg p-6 text-center border border-transparent hover:border-gradient-to-r hover:from-red-400 hover:to-red-600 transition">
      <div class="flex flex-col items-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-blue-500 mb-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
          <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
        </svg>        
        <p class="text-black font-semibold text-base mb-2">Jumlah siswa</p>
        <p class="text-base font-semibold text-gray-800">{{ $jumlahsiswa }}</p>
      </div>
    </div>
  </div>
</body>


<script>
  // Fungsi untuk memperbarui waktu setiap detik
  function updateTime() {
    const currentTimeElement = document.getElementById("current-time");
    const currentDate = new Date();

    // Format waktu dalam HH:mm:ss
    const hours = currentDate.getHours().toString().padStart(2, '0');
    const minutes = currentDate.getMinutes().toString().padStart(2, '0');
    const seconds = currentDate.getSeconds().toString().padStart(2, '0');

    const timeString = `${hours}:${minutes}:${seconds} WIB`;

    // Memperbarui elemen dengan ID 'current-time'
    currentTimeElement.textContent = timeString;
  }

  // Panggil fungsi updateTime setiap detik
  setInterval(updateTime, 1000);
</script>
 @endsection