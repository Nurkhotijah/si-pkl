@extends('components.layout-industri')

@section('title', 'Dashboard Industri')

@section('content')
<body class="flex-1 p-6 bg-gray-100 font-poppins">
    <!-- Kotak Hai -->
    <div class="bg-white p-6 rounded-lg shadow-md mb-6 border-b-4 border-gray-300">
        <h1 class="text-xl font-bold mb-2">Hai {{ Auth::user()->name }}!</h1>
        <p class="text-base text-gray-900">
          Selamat datang di si-pkl. Silakan pantau data kehadiran siswa PKL dan informasi sekolah dengan lebih mudah di sini.
        </p>
      </div>
  
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
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
    
        <!-- Jumlah sekolah -->
        <div class="bg-white rounded-lg shadow-lg p-6 text-center border border-transparent hover:border-gradient-to-r hover:from-red-400 hover:to-red-600 transition">
          <div class="flex flex-col items-center">
            <svg xmlns="http://www.w3.org/2000/svg"  class="h-10 w-10 text-blue-500 mb-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
            </svg>        
            <p class="text-black font-semibold text-base mb-2">Jumlah sekolah</p>
            <p class="text-base font-semibold text-gray-800">{{ $jumlahsekolah }}</p>
          </div>
        </div>

        <div class="bg-white rounded-lg shadow-lg p-6 text-center mt-4" style="width: 100%; max-width: 400px; margin: auto;">
          <canvas id="kehadiranChart" style="width: 100%; height: auto;"></canvas>
      </div>
      </div>
    </body>
    
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>    
<script>
  document.addEventListener("DOMContentLoaded", function () {
        const ctx = document.getElementById("kehadiranChart").getContext("2d");
        
        new Chart(ctx, {
            type: "pie",
            data: {
                labels: ["Hadir", "Izin", "Tidak Hadir"],
                datasets: [{
                    label: "Jumlah Kehadiran",
                    data: @json([$jumlahHadir, $jumlahIzin, $jumlahTidakHadir]),
                    backgroundColor: ["#4CAF50", "#FFC107", "#F44336"],
                    hoverOffset: 4,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: "bottom"
                    }
                }
            }
        });
    });

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

