@extends('components.layout-industri')

@section('title', 'Data PKL Sekolah')

@section('content')
<div class="bg-gray-100 font-poppins">
    <main class="p-6 overflow-y-auto h-full">
        <div class="max-w-7xl mx-auto bg-white p-4 sm:p-6 rounded-lg shadow-md">
            <!-- Header Section -->
            <div class="mb-4">
                <h1 class="text-xl sm:text-xl font-semibold text-center mb-2 sm:mb-4">Data PKL</h1>
                <div class="flex flex-col sm:flex-row items-center justify-between space-y-2 sm:space-y-0 sm:space-x-4">
                    <div class="relative w-full sm:w-auto text-xs">
                        <form method="GET" action="{{ url()->current() }}">
                            <input 
                                type="text" 
                                name="search" 
                                id="search" 
                                class="border rounded p-2 pl-10 w-full sm:w-64" 
                                placeholder="Cari Tahun Ajaran, Judul, atau Pembimbing" 
                                value="{{ request('search') }}"
                            >
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                        </form>
                    </div>                              
                </div>
            </div>

            <!-- Table Section -->
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border" id="schoolTable">
                    <thead class="bg-gray-200 font-semibold text-gray-700 border-b border-gray-300 text-xs">
                        <tr>
                            <th class="py-2 px-4 text-center">No</th>
                            <th class="py-2 px-4 text-left">Judul PKL</th>
                            <th class="py-2 px-4 text-center">Tahun Ajaran</th>
                            <th class="py-2 px-4 text-left">Nama Pembimbing</th>
                            <th class="py-2 px-4 text-center">Lampiran</th>
                            <th class="py-2 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($listSekolah as $item)
                            <tr class="school-row bg-white hover:bg-gray-50 transition duration-200 ease-in-out text-xs">
                                <td class="py-2 px-4 border-b text-center">{{ $loop->iteration }}</td>
                                <td class="py-2 px-4 border-b text-left">{{ $item->judul_pkl }}</td>
                                <td class="py-2 px-4 border-b text-center">{{ $item->tahun }}</td>
                                <td class="py-2 px-4 border-b text-left">{{ $item->pembimbing }}</td>
                                <td class="py-2 px-4 border-b text-center">
                                    <a href="{{ asset('storage/' . $item->lampiran) }}" class="bg-blue-500 text-white text-xs px-2 py-1 rounded hover:bg-blue-600">
                                        <i class="fas fa-file-pdf"></i>
                                    </a>
                                </td>
                                <td class="py-2 px-4 border-b text-center">
                                    <div class="flex justify-center space-x-2">
                                        <a href="{{ route('sekolah.detail-siswa', $item->id) }}" class="bg-blue-500 text-white text-xs px-2 py-1 rounded hover:bg-blue-600">
                                            <i class="fas fa-eye"></i>
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
</div>

<script>
    // Function to handle searching in the table
    function searchTable() {
        const searchInput = document.getElementById('search').value.toLowerCase();
        const rows = document.querySelectorAll('.school-row');
        let visibleRows = 0;
        
        rows.forEach(row => {
            const tahunAjaran = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
            if (tahunAjaran.includes(searchInput)) {
                row.classList.remove('hidden-row');
                visibleRows++;
            } else {
                row.classList.add('hidden-row');
            }
        });
        
        currentPage = 1;
        updatePagination();
    }

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
    rows = Array.from(document.querySelectorAll('.school-row'));  // Ambil semua baris dengan class kehadiran-row
    updateTableDisplay();  // Memperbarui tampilan tabel
});

</script>

@endsection