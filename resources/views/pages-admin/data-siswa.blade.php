@extends('components.layout-admin')

@section('title', 'Data Siswa')

@section('content')
<div class="bg-gray-100">
    <main class="p-6 overflow-y-auto h-full">
        <div class="max-w-7xl mx-auto bg-white p-4 sm:p-6 rounded-lg shadow-md">
            <!-- Header Section -->
            <div class="mb-4 text-center">
                <h1 class="text-xl sm:text-xl font-semibold mb-2 sm:mb-4">Data Siswa</h1>
                <div class="bg-blue-100 px-4 py-2 ml-0 my-2 rounded-md text-xs flex items-center max-w-md shadow-sm w-full sm:w-2/3">
                    <svg viewBox="0 0 24 24" class="text-blue-600 w-4 h-4 mr-2">
                        <path fill="currentColor"
                            d="M12,0A12,12,0,1,0,24,12,12.013,12.013,0,0,0,12,0Zm.25,5a1.5,1.5,0,1,1-1.5,1.5A1.5,1.5,0,0,1,12.25,5ZM14.5,18.5h-4a1,1,0,0,1,0-2h.75a.25.25,0,0,0,.25-.25v-4.5a.25.25,0,0,0-.25-.25H10.5a1,1,0,0,1,0-2h1a2,2,0,0,1,2,2v4.75a.25.25,0,0,0,.25.25h.75a1,1,0,1,1,0,2Z">
                        </path>
                    </svg>
                    <span class="text-blue-800">Tombol hanya dapat diklik jika siswa telah menyelesaikan PKL.</span>
                </div>
                
                <div class="flex flex-col text-xs sm:flex-row items-center justify-between space-y-2 sm:space-y-0 sm:space-x-4">
                    <div class="relative w-full sm:w-auto">
                        <input class="border rounded p-2 pl-10 w-full sm:w-64" id="search" placeholder="Cari Nama atau Jurusan" type="text" oninput="searchTable()">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                </div>
            </div>
            @if(session('error'))
            <div id="flash-message" class="alert alert-danger">
                {{ session('error') }}
            </div>
         @endif


            <!-- Table Section -->
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border-collapse" id="studentTable">
                    <thead class="bg-gray-200 font-semibold text-gray-700 border-b border-gray-300 text-xs">
                        <tr>
                            <th class="py-2 px-4 text-center">No</th>
                            <th class="py-2 px-4 text-left">Nama Siswa</th>
                            <th class="py-2 px-4 text-left">Jurusan</th>
                            <th class="py-2 px-4 text-center">Nilai</th>
                            <th class="py-2 px-4 text-center">Kehadiran</th>
                            <th class="py-2 px-4 text-center">Sertifikat</th>
                            <th class="py-2 px-4 text-center">Laporan</th> 
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 font-poppins text-xs">
                        @foreach ($siswa as $item)
                            <tr class="student-row">
                                <td class="py-2 px-4 border-b border-gray-300 text-center">{{ $loop->iteration }}</td>
                                <td class="py-2 px-4 border-b border-gray-300 text-left">{{ $item->name }}</td>
                                <td class="py-2 px-4 border-b border-gray-300 text-left">{{ $item->profile->jurusan }}</td>
                                <td class="py-2 px-3 border-b border-gray-300 text-center">
                                    @if ($item->profile && $item->profile->tanggal_selesai && $item->profile->tanggal_selesai <= now() && $item->penilaian) 
                                        <a href="{{ route('penilaiansiswa.unduh', $item->id) }}" class="inline-flex items-center justify-center px-2 py-1 bg-blue-500 text-white rounded-lg shadow-md hover:bg-blue-600 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-300 transition duration-300">
                                            <i class="fas fa-eye mr-2"></i> Lihat
                                        </a>
                                    @else
                                        <span class="inline-flex items-center justify-center px-2 py-1 bg-gray-300 text-gray-700 rounded-lg shadow-md cursor-not-allowed opacity-50">
                                            <i class="fas fa-eye mr-2"></i> Lihat
                                        </span>
                                    @endif
                                </td>
                                <td class="py-2 px-3 border-b border-gray-300 text-center">
                                    @if ($item->profile && $item->profile->tanggal_selesai && $item->profile->tanggal_selesai <= now())
                                        <a href="{{ route('kehadiransiswa.unduh', ['userId' => $item->id]) }}"  class="inline-flex items-center justify-center px-2 py-1 bg-blue-500 text-white rounded-lg shadow-md hover:bg-blue-600 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-300 transition duration-300">
                                            <i class="fas fa-eye mr-2"></i> Lihat
                                        </a>
                                    @else
                                        <span class="inline-flex items-center justify-center px-2 py-1 bg-gray-300 text-gray-700 rounded-lg shadow-md cursor-not-allowed opacity-50">
                                            <i class="fas fa-eye mr-2"></i> Lihat
                                        </span>
                                    @endif
                                </td>
                                <td class="py-2 px-3 border-b border-gray-300 text-center">
                                    @if ($item->profile && $item->profile->tanggal_selesai && $item->profile->tanggal_selesai <= now())
                                        <a href="{{ route('cetak-sertifikat-siswa', $item->id) }}"  class="inline-flex items-center justify-center px-2 py-1 bg-blue-500 text-white rounded-lg shadow-md hover:bg-blue-600 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-300 transition duration-300">
                                            <i class="fas fa-eye mr-2"></i> Lihat
                                        </a>
                                    @else
                                        <span class="inline-flex items-center justify-center px-2 py-1 bg-gray-300 text-gray-700 rounded-lg shadow-md cursor-not-allowed opacity-50">
                                            <i class="fas fa-eye mr-2"></i> Lihat
                                        </span>
                                    @endif
                                </td>                                
                                <td class="py-2 px-4 border-b border-gray-300 text-center">
                                    @if ($item->laporan)
                                    <a href="{{ asset('storage/' . $item->laporan->file_path) }}"  class="inline-flex items-center justify-center px-2 py-1 bg-blue-500 text-white rounded-lg shadow-md hover:bg-blue-600 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-300 transition duration-300">
                                        <i class="fas fa-eye mr-2"></i> Lihat
                                    </a>
                                    @else
                                        <p>Tidak ada laporan</p>
                                    @endif
                                </td>                                                                                                                         
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
// Flash message timeout
window.onload = function () {
    const flashMessage = document.getElementById("flash-message");
    if (flashMessage) {
        setTimeout(function () {
            flashMessage.classList.add("hidden");
        }, 3000); // Hide after 3 seconds
    }
};

// Search function
function searchTable() {
    const input = document.getElementById('search');
    const filter = input.value.toLowerCase();
    const table = document.getElementById('studentTable');
    const rows = table.getElementsByTagName('tr');

    for (let i = 1; i < rows.length; i++) {
        const nameCell = rows[i].getElementsByTagName('td')[1];
        const majorCell = rows[i].getElementsByTagName('td')[2];
        if (nameCell || majorCell) {
            const nameValue = nameCell.textContent || nameCell.innerText;
            const majorValue = majorCell.textContent || majorCell.innerText;
            if (nameValue.toLowerCase().indexOf(filter) > -1 || majorValue.toLowerCase().indexOf(filter) > -1) {
                rows[i].style.display = "";
            } else {
                rows[i].style.display = "none";
            }
        }       
    }
}

// Initialize pagination
window.onload = function() {
    showPage(1);
};

function deleteStudent(studentId) {
    // Tampilkan dialog konfirmasi
    const confirmDelete = confirm("Apakah Anda yakin ingin menghapus data siswa ini?");
    if (confirmDelete) {
        // Hapus baris siswa berdasarkan ID
        const studentRow = document.querySelector(`.student-row[data-id="${studentId}"]`);
        if (studentRow) {
            studentRow.remove();
        } else {
            alert("Data siswa tidak ditemukan!");
        }
    }
}

let currentPage = 1;
const ITEMS_PER_PAGE = 5; // Set jumlah item per halaman
let filteredData = [];  // Menyimpan data yang akan dipaginasikan

// Fungsi untuk memperbarui tampilan berdasarkan halaman
function updateTableDisplay() {
    const rows = Array.from(document.querySelectorAll('.student-row'));
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
    const totalPages = Math.ceil(filteredData.length / ITEMS_PER_PAGE);
    if (currentPage < totalPages) {
        currentPage++;
        updateTableDisplay();
    }
}

// Menampilkan halaman pertama setelah data dimuat
document.addEventListener('DOMContentLoaded', () => {
    filteredData = Array.from(document.querySelectorAll('.student-row'));  // Targetkan rows dengan class student-row
    updateTableDisplay();  // Memperbarui tampilan tabel
});

</script>

@endsection