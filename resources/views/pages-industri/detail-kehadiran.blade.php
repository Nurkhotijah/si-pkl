@extends('components.layout-industri')

@section('title', 'Detail Kehadiran Siswa')

@section('content')

<main class="bg-gray-100 font-poppins">
    <div class="p-6 overflow-y-auto h-full">
        <div class="max-w-7xl mx-auto bg-white p-4 sm:p-6 rounded-lg shadow-md">
            <!-- Header Section -->
            <div class="mb-4">
                <h1 class="text-xl sm:text-xl font-semibold text-center mb-2 sm:mb-4">Detail Kehadiran</h1>
                <div class="flex flex-col sm:flex-row items-center justify-between space-y-2 sm:space-y-0 sm:space-x-4">
                    <div class="flex items-center w-full sm:w-auto sm:ml-auto text-xs">
                        <form method="GET" action="{{ route('kehadiran.detail', $userId) }}" id="dateForm">
                            <label class="mr-2" for="date"></label>
                            <input type="date" class="border rounded p-2 w-full sm:w-auto" id="date" name="tanggal" 
                            value="{{ request('tanggal') }}"  max="{{ now()->toDateString() }}" 
                                onchange="this.form.submit()" 
                            />
                        </form>                                                                               
                    </div>               
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border" id="attendanceTable">
                    <thead class="bg-gray-200 font-semibold text-gray-700 border-b border-gray-300 text-xs">
                        <tr>
                            <th class="py-2 px-4 text-center">No</th>
                            <th class="py-2 px-4 text-center">Tanggal</th>
                            <th class="py-2 px-4 text-center">Waktu Masuk</th>
                            <th class="py-2 px-4 text-center">Waktu Keluar</th> 
                            <th class="py-2 px-4 text-center">Foto Masuk</th> 
                            <th class="py-2 px-4 text-center">Foto Keluar</th> 
                            <th class="py-2 px-4 text-center">Foto Izin</th>
                            <th class="py-2 px-4 text-center">Status</th> 
                            <th class="py-2 px-4 text-center">Aksi</th> 
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 font-poppins text-xs">
                        @foreach ($kehadiran as $item)
                            <tr class="kehadiran-row bg-white hover:bg-gray-50 transition duration-200 ease-in-out">
                                <td class="py-2 px-4 border-b text-center">{{ $loop->iteration }}</td>
                                <td class="py-2 px-4 border-b text-center">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}</td>
                                <td class="py-2 px-4 border-b text-center">{{ $item->waktu_masuk ? \Carbon\Carbon::parse($item->waktu_masuk)->format('H:i:s') : '-' }}</td>
                                <td class="py-2 px-4 border-b text-center">{{ $item->waktu_keluar ? \Carbon\Carbon::parse($item->waktu_keluar)->format('H:i:s') : '-' }}</td>
                                <td class="py-2 px-4 text-center border-b border-gray-300">
                                    @if($item->foto_masuk)
                                        <img src="{{ asset('storage/' . $item->foto_masuk) }}" alt="Foto Masuk" class="w-10 h-10 object-cover rounded-full mx-auto hover:opacity-75 transition duration-300"> 
                                    @else
                                        <span class="text-gray-400">Tidak ada foto</span>
                                    @endif
                                </td>
                                <td class="py-2 px-4 text-center border-b border-gray-300">
                                    @if($item->foto_keluar)
                                        <img src="{{ asset('storage/' . $item->foto_keluar) }}" alt="Foto Keluar" class="w-10 h-10 object-cover rounded-full mx-auto hover:opacity-75 transition duration-300"> 
                                    @else
                                        <span class="text-gray-400">Tidak ada foto</span>
                                    @endif
                                </td>
                                <td class="py-2 px-4 text-center border-b border-gray-300">
                                    @if($item->foto_izin)
                                        <img src="{{ asset('storage/' . $item->foto_izin) }}" alt="Foto Izin" class="w-10 h-10 object-cover rounded-full mx-auto hover:opacity-75 transition duration-300"> 
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="py-4 px-4 border-b border-gray-300 text-center text-gray-600">{{ $item->status }}</td>
                                <td class="py-4 px-4 border-b border-gray-300 text-center">
                                    <!-- Tombol Edit -->
                                    <a href="{{ route('kehadiran.edit', $item->id) }}" class="text-white bg-blue-500 hover:bg-blue-700 p-2 rounded transition duration-200">Edit</a>
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
    {{-- <!-- Modal -->
    <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden" id="modal" onclick="closeModal()">
        <div class="bg-white rounded-lg shadow-lg p-6 w-96" onclick="event.stopPropagation();">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold"></h2>
                <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div id="modalImage">
                <img alt="Foto Absensi" class="w-full h-auto rounded-lg shadow-md transition duration-300 transform hover:scale-105"/>
            </div>
        </div>
    </div> --}}


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
    rows = Array.from(document.querySelectorAll('.kehadiran-row'));  // Ambil semua baris dengan class kehadiran-row
    updateTableDisplay();  // Memperbarui tampilan tabel
});


function openModal(imageUrl) {
    const modal = document.getElementById("modal");
    const modalImage = document.getElementById("modalImage").querySelector("img");
    modalImage.src = imageUrl;
    modal.classList.remove("hidden");
}

function closeModal() {
    const modal = document.getElementById("modal");
    modal.classList.add("hidden");
}

document.addEventListener('DOMContentLoaded', initializeTable);
</script>

@endsection
