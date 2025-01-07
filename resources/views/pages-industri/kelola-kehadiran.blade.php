@extends('components.layout-industri')

@section('title', 'Kehadiran Siswa')

@section('content')

<main class="bg-gray-100 font-poppins">
    <div class="p-6 overflow-y-auto h-full">
        <div class="max-w-7xl mx-auto bg-white p-4 sm:p-6 rounded-lg shadow-md">
            <!-- Header Section -->
            <div class="mb-4">
                <h1 class="text-xl sm:text-xl font-semibold text-center mb-2 sm:mb-4">Kelola Kehadiran</h1>
                <div class="flex flex-col sm:flex-row items-center justify-between space-y-2 sm:space-y-0 sm:space-x-4">
                    <form method="GET" action="{{ route('kelola-kehadiran') }}" class="relative">
                        <input class="border rounded p-2 pl-10 w-full sm:w-64 text-xs" id="search" placeholder="Cari Nama atau sekolah" type="text" 
                        name="search"value="{{ request('search') }}"oninput="this.form.submit()">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </form>                    
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border" id="attendanceTable">
                    <thead class="bg-gray-200 font-semibold text-gray-700 border-b border-gray-300 text-xs">
                        <tr>
                            <th class="py-2 px-4 text-center">No</th>
                            <th class="py-2 px-4 text-left">Nama Lengkap</th>
                            <th class="py-2 px-4 text-left">Sekolah</th>
                            <th class="py-2 px-4 text-center">Aksi</th> 
                        </tr>
                    </thead>
                    <tbody id="attendanceTableBody">
                        @foreach ($kehadiran as $index => $item)
                            <tr class="school-row font-poppins text-xs">
                                <td class="py-2 px-4 border-b text-center">{{ $index + 1 }}</td>
                                <td class="py-2 px-4 border-b text-left">{{ $item->user->name }}</td>
                                <td class="py-2 px-4 border-b text-left">{{ $item->user->profile->sekolah->nama }}</td>
                                <td class="py-2 px-4 border-b text-center">
                                    <div class="flex justify-center space-x-2 ">
                                        <a href="{{ route('kehadiran.detail', $item->user_id) }}" class="bg-blue-500 text-white text-xs px-2 py-1 rounded shadow hover:bg-blue-600 transition duration-300 ease-in-out">
                                            <i class="fas fa-eye mr-1"></i> Lihat
                                        </a>
                                        <a href="{{ route('kehadiran.pdf', $item->user_id) }}" class="bg-green-500 text-white text-xs px-2 py-1 rounded shadow hover:bg-green-600 transition duration-300 ease-in-out">
                                            <i class="fas fa-eye mr-1"></i> Cetak
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
 
        <!-- Pagination Section -->
        <div class="flex justify-end items-center mt-4 w-full text-xs">
            <button class="bg-gray-300 text-gray-700 p-2 rounded mr-2" onclick="prevPage()">
                <i class="fas fa-chevron-left"></i>
            </button>
            
            <span class="mr-4 text-center text-gray-700" id="pageNumber">
                Halaman <span id="currentPage">1</span> dari <span id="totalPages">1</span>
            </span>
            
            <button class="bg-gray-300 text-gray-700 p-2 rounded" onclick="nextPage()">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>  
        </div>
</div>
</main>

<script>

let currentPage = 1;
const ITEMS_PER_PAGE = 5; // Set jumlah item per halaman
let rows = []; // Menyimpan semua baris kehadiran

// Fungsi untuk memperbarui tampilan berdasarkan halaman
function updateTableDisplay() {
    const startIndex = (currentPage - 1) * ITEMS_PER_PAGE;
    const endIndex = startIndex + ITEMS_PER_PAGE;

    // Menyembunyikan atau menampilkan baris berdasarkan halaman
    rows.forEach((row, index) => {
        row.style.display = (index >= startIndex && index < endIndex) ? '' : 'none';
    });

    // Mengupdate informasi halaman
    const totalPages = Math.ceil(rows.length / ITEMS_PER_PAGE);
    document.getElementById('currentPage').textContent = currentPage;
    document.getElementById('totalPages').textContent = totalPages;
}

// Fungsi untuk menampilkan halaman sebelumnya
function prevPage() {
    if (currentPage > 1) {
        currentPage--;
        updateTableDisplay();
    }
}

// Fungsi untuk menampilkan halaman berikutnya
function nextPage() {
    const totalPages = Math.ceil(rows.length / ITEMS_PER_PAGE);
    if (currentPage < totalPages) {
        currentPage++;
        updateTableDisplay();
    }
}

// Menampilkan halaman pertama setelah data dimuat
document.addEventListener('DOMContentLoaded', () => {
    rows = Array.from(document.querySelectorAll('.school-row'));  // Ambil semua baris dengan class school-row
    updateTableDisplay();  // Memperbarui tampilan tabel
});

</script>

@endsection
