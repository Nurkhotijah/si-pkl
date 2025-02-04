@extends('components.layout-admin')

@section('title', 'Jurnal Siswa')

@section('content')
<main class="p-6 overflow-y-auto h-full">
    <div class="max-w-7xl mx-auto bg-white p-4 sm:p-6 rounded-lg shadow-md">
        <!-- Header Section -->
        <div class="mb-4">
            <h1 class="text-xl sm:text-xl font-semibold text-center mb-2 sm:mb-4">Jurnal Siswa</h1>
            <div class="flex flex-col sm:flex-row items-center justify-between space-y-2 sm:space-y-0 sm:space-x-4">
                <div class="relative w-full sm:w-auto text-xs">
                    <input class="border rounded-l p-2 pl-10 w-full sm:w-64" id="searchInput" placeholder="Cari Nama" type="text">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border" id="pengajuanTable">
                <thead class="bg-gray-200 font-semibold text-gray-700 border-b border-gray-300 text-xs">
                    <tr>
                        <th class="py-2 px-4 text-center">No</th>
                        <th class="py-2 px-4 text-left">Nama</th>
                        <th class="py-2 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Contoh data statis -->
                    @foreach ($siswa as $item)
                        <tr class="jurnal-row font-poppins text-xs">
                            <td class="py-2 px-4 border-b text-center">{{ $loop->iteration }}</td>
                            <td class="py-2 px-4 border-b text-left">{{ $item->name }}</td>
                            <td class="py-2 px-4 border-b text-center">
                                <div class="flex justify-center space-x-2">
                                    <a href="{{ route('jurnal-admin.detail', $item->id) }}" 
                                    class="bg-blue-500 text-white text-xs px-2 py-1 rounded shadow hover:bg-blue-600 transition duration-300 ease-in-out">
                                        <i class="fas fa-eye mr-1"></i> Lihat
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
</main>
{{-- 
<!-- Modal untuk menampilkan laporan PKL -->
<div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden" id="modal-laporan" onclick="closeLaporanModal()">
    <div class="bg-white rounded-lg shadow-lg p-6 w-full sm:w-3/4 lg:w-1/2" onclick="event.stopPropagation();">
        <h2 class="text-xl font-bold mb-4 flex justify-between items-center">
            Laporan PKL Siswa
            <span class="cursor-pointer text-black" onclick="closeLaporanModal()">×</span>
        </h2>
        <iframe id="laporanContent" src="" class="w-full h-96 rounded-lg border"></iframe>
    </div>
</div> --}}

<script>
    // function openLaporanModal(fileUrl) {
    //     const modal = document.getElementById('modal-laporan');
    //     const iframe = document.getElementById('laporanContent');
    //     iframe.src = fileUrl;
    //     modal.classList.remove('hidden');
    // }

    // function closeLaporanModal() {
    //     const modal = document.getElementById('modal-laporan');
    //     const iframe = document.getElementById('laporanContent');
    //     iframe.src = ""; // Reset iframe untuk menghindari masalah caching
    //     modal.classList.add('hidden');
    // }

    // Search function
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let searchValue = this.value.toLowerCase();
        let table = document.getElementById('pengajuanTable');
        let rows = table.getElementsByTagName('tr');

        // Start from index 1 to skip the header row
        for (let i = 1; i < rows.length; i++) {
            let nameCell = rows[i].getElementsByTagName('td')[1]; // Index 1 is the name column
            if (nameCell) {
                let name = nameCell.textContent || nameCell.innerText;
                if (name.toLowerCase().indexOf(searchValue) > -1) {
                    rows[i].style.display = '';
                } else {
                    rows[i].style.display = 'none';
                }
            }
        }
    });

    
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
    rows = Array.from(document.querySelectorAll('.jurnal-row'));  // Ambil semua baris dengan class kehadiran-row
    updateTableDisplay();  // Memperbarui tampilan tabel
});
</script>
@endsection
