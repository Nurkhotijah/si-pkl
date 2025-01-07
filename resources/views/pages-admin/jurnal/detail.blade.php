@extends('components.layout-admin')

@section('title', ' Detail Jurnal Siswa')

@section('content')

<main class="p-6 overflow-y-auto h-full">
    <div class="max-w-7xl mx-auto bg-white p-4 sm:p-6 rounded-lg shadow-md">
        <!-- Header Section -->
        <div class="mb-4">
            <h1 class="text-xl sm:text-xl font-semibold text-center mb-2 sm:mb-4">Detail Jurnal Siswa</h1>
            <div class="flex items-center">
                <label class="mr-2" for="dateFilter"></label>
                <input class="border rounded p-2 text-xs" id="dateFilter" type="date" onchange="filterByDate()" />
            </div>
        </div>

        <!-- Table Section -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border" id="pengajuanTable">
                <thead class="bg-gray-200 font-semibold text-gray-700 border-b border-gray-300 text-xs">
                    <tr>
                        <th class="py-2 px-4 text-center">No</th>
                        <th class="py-2 px-4 text-left">Kegiatan</th>
                        <th class="py-2 px-4 text-center">Tanggal</th>
                        <th class="py-2 px-4 text-center">Waktu Mulai</th>
                        <th class="py-2 px-4 text-center">Waktu Selesai</th>
                        <th class="py-2 px-4 text-center">Foto</th>
                    </tr>
                </thead>
                <tbody id="jurnalBody">
                    @foreach ($jurnal as $item)
                        <tr class="jurnal-row bg-white hover:bg-gray-50 transition duration-200 ease-in-out text-xs">
                            <td class="py-2 px-4 border-b text-center">{{ $loop->iteration }}</td>
                            <td class="py-2 px-4 border-b text-left">{{ $item->kegiatan }}</td>
                            <td class="py-2 px-4 border-b text-center">{{ \Carbon\Carbon::parse($item->tanggal)->format('Y-m-d') }}</td>
                            <td class="py-2 px-4 border-b text-center">{{ $item->waktu_mulai }}</td>
                            <td class="py-2 px-4 border-b text-center">{{ $item->waktu_selesai }}</td>
                            <td class="py-2 px-4 border-b text-center">
                                <img src="{{ asset('storage/'.$item->foto_kegiatan) }}" alt="Foto Kegiatan 1" class="w-16 h-16 object-cover rounded-full cursor-pointer" onclick="showActivityImage('{{ asset('storage/'.$item->foto_kegiatan) }}')">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Modal untuk menampilkan gambar besar -->
        <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
            <div class="bg-white rounded-lg p-4 relative max-w-md w-full">
                <button onclick="closeModal()" class="absolute top-2 right-2 text-gray-500 hover:text-black">
                    ✕
                </button>
                <img id="activityImage" src="" alt="Activity Image" class="w-full rounded-md">
            </div>
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

<script>
    // Fungsi untuk menampilkan gambar besar di modal
    function showActivityImage(imageSrc) {
        const modal = document.getElementById('imageModal');
        const image = document.getElementById('activityImage');
        image.src = imageSrc;
        modal.classList.remove('hidden');
    }

    // Fungsi untuk menutup modal
    function closeModal() {
        const modal = document.getElementById('imageModal');
        modal.classList.add('hidden');
    }

    // Filter by date function
    function filterByDate() {
        const filterDate = document.getElementById('dateFilter').value;
        const rows = document.querySelectorAll('#jurnalBody tr');

        rows.forEach(row => {
            const rowDate = row.getAttribute('data-tanggal');
            if (filterDate === '' || rowDate === filterDate) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
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
    rows = Array.from(document.querySelectorAll('.jurnal-row'));  // Ambil semua baris dengan class kehadiran-row
    updateTableDisplay();  // Memperbarui tampilan tabel
});
</script>
@endsection