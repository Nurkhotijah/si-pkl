@extends('components.layout-admin')

@section('title', 'Kehadiran Siswa')

@section('content')

<body class="font-poppins">
<main class="p-6 overflow-y-auto h-full">
    <div class="max-w-7xl mx-auto bg-white p-4 sm:p-6 rounded-lg shadow-md">
        <div class="flex flex-col sm:flex-row justify-center items-center mb-4">
            <h1 class="text-xl sm:text-xl font-bold mb-2 sm:mb-0">Kelola Kehadiran</h1>
        </div>          
        <div class="flex flex-col sm:flex-row justify-between items-center mb-4 space-y-4 sm:space-y-0 sm:space-x-4">
            <div class="relative w-full sm:w-auto text-xs">
                <input class="border rounded p-2 pl-10 w-full sm:w-64" id="searchInput" placeholder="Cari Nama" type="text">
                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
            </div>
            <div class="mt-4 md:mt-0">
              <label class="mr-2" for="date"></label>
              <input class="border rounded p-2 text-xs" id="dateInput" type="date" />
          </div>
        </div>
        <div class="overflow-x-auto">
            <table id="attendanceTable" class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
                <thead class="bg-gray-200">
                    <tr class="font-semibold text-gray-700 border-b border-gray-300 text-xs">
                        <th class="py-3 px-4 text-left">No</th>
                        <th class="py-3 px-4 text-left">Nama Lengkap</th>
                        <th class="py-3 px-4 text-left">Tanggal</th>
                        <th class="py-3 px-4 text-center">Waktu Masuk</th>
                        <th class="py-3 px-4 text-center">Waktu Keluar</th>
                        <th class="py-3 px-4 text-center">Foto Masuk</th>
                        <th class="py-3 px-4 text-center">Foto Keluar</th>
                        <th class="py-3 px-4 text-center">Foto Izin</th>
                        <th class="py-3 px-4 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 font-poppins text-xs">
                    @foreach ($kehadiran as $index => $data)
                        <tr class="kehadiran-row bg-white hover:bg-gray-50 transition duration-200 ease-in-out">
                            <td class="py-4 px-4 border-b border-gray-300">{{ $loop->iteration }}</td>
                            <td class="py-4 px-4 border-b border-gray-300">{{ $data->user->name }}</td>
                            <td class="py-4 px-4 border-b border-gray-300">{{ \Carbon\Carbon::parse($data->tanggal)->format('d F Y') }}</td>
                            <td class="py-4 px-4 text-center border-b border-gray-300">{{ $data->waktu_masuk ? \Carbon\Carbon::parse($data->waktu_masuk)->format('H:i:s') : '-' }}</td>
                            <td class="py-4 px-4 text-center border-b border-gray-300">{{ $data->waktu_keluar ? \Carbon\Carbon::parse($data->waktu_keluar)->format('H:i:s') : '-' }}</td>
                            <td class="py-2 px-4 text-center border-b border-gray-300">
                                @if ($data->foto_masuk)
                                    <img src="{{ asset('storage/' . $data->foto_masuk) }}" alt="Foto Masuk" class="w-10 h-10 object-cover rounded-full mx-auto hover:opacity-75 transition duration-300" onclick="bukaModal('{{ asset('storage/' . $data->foto_masuk) }}')">
                                @else
                                    - 
                                @endif
                            </td>
                            <td class="py-2 px-4 border-b border-gray-300 text-center ">
                                @if ($data->foto_keluar)
                                    <img src="{{ asset('storage/' . $data->foto_keluar) }}" alt="Foto Keluar" class="w-10 h-10 object-cover rounded-full mx-auto hover:opacity-75 transition duration-300" onclick="bukaModal('{{ asset('storage/' . $data->foto_keluar) }}')">
                                @else
                                    - 
                                @endif
                            </td>
                            <td class="py-2 px-4 border-b border-gray-300 text-center">
                                @if ($data->foto_izin)
                                    <img src="{{ asset('storage/' . $data->foto_izin) }}" alt="Foto Izin" class="w-10 h-10 object-cover rounded-full mx-auto hover:opacity-75 transition duration-300" onclick="bukaModal('{{ asset('storage/' . $data->foto_izin) }}')">
                                @else
                                    - 
                                @endif
                            </td>
                            <td class="py-4 px-4 border-b border-gray-300 text-center">{{ $data->status }}</td>
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

<script>
// Fungsi pencarian berdasarkan nama
document.getElementById('searchInput').addEventListener('keyup', function() {
    filterTable();
});

// Fungsi pencarian berdasarkan tanggal
document.getElementById('dateInput').addEventListener('change', function() {
    filterTable(); 
});

function filterTable() {
    let searchValue = document.getElementById('searchInput').value.toLowerCase();
    let dateValue = document.getElementById('dateInput').value;
    let table = document.getElementById('attendanceTable');
    let rows = table.getElementsByTagName('tr');

    // Start from index 1 to skip the header row
    for (let i = 1; i < rows.length; i++) {
        let row = rows[i];
        let nameCell = row.getElementsByTagName('td')[1]; // Index 1 is the name column
        let dateCell = row.getElementsByTagName('td')[2]; // Index 2 is the date column
        
        if (nameCell && dateCell) {
            let name = nameCell.textContent || nameCell.innerText;
            let date = dateCell.textContent || dateCell.innerText;
            
            let nameMatch = name.toLowerCase().indexOf(searchValue) > -1;
            let dateMatch = !dateValue || date.includes(dateValue);

            if (nameMatch && dateMatch) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        }
    }
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
    rows = Array.from(document.querySelectorAll('.kehadiran-row'));  // Ambil semua baris dengan class kehadiran-row
    updateTableDisplay();  // Memperbarui tampilan tabel
});

</script>
</body>
@endsection
