@extends('components.layout-industri')

@section('title', 'Data Sekolah')

@section('content')

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="bg-gray-100 font-poppins">
    <main class="p-6 overflow-y-auto h-full">
        <div class="max-w-7xl mx-auto bg-white p-4 sm:p-6 rounded-lg shadow-md">
            <!-- Header Section -->
            <div class="mb-4">
                <h1 class="text-xl sm:text-xl font-semibold text-center mb-2 sm:mb-4">Data Sekolah</h1>
                <div class="flex flex-col sm:flex-row items-center justify-between space-y-2 sm:space-y-0 sm:space-x-4">
                    <div class="relative w-full sm:w-auto">
                        <input class="border rounded p-2 pl-10 w-full sm:w-64 text-xs" id="search" placeholder="Cari Nama Sekolah" type="text" oninput="searchTable()">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>                
                </div>
            </div>

            <!-- Table Section -->
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border" id="schoolTable">
                    <thead class="bg-gray-200 font-semibold text-gray-700 border-b border-gray-300 text-xs">
                        @if (session('success'))
                    <div class="bg-green-500 text-white px-4 py-3 rounded shadow-md mb-4">
                        <p>{{ session('success') }}</p>
                    </div>
                @endif

                @if (session('error'))
                    <div class="bg-red-500 text-white px-4 py-3 rounded shadow-md mb-4">
                        <p>{{ session('error') }}</p>
                    </div>
                @endif
                        <tr>
                            <th class="py-2 px-4 text-center">No</th>
                            <th class="py-2 px-4 text-left">Nama Sekolah</th>
                            <th class="py-2 px-4 text-left">Email</th>
                            <th class="py-2 px-4 text-left">Alamat</th>
                            <th class="py-2 px-4 text-center">Status</th>
                            <th class="py-2 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Example rows for schools -->
                        @foreach ($listSekolah as $item)
                            <tr class="school-row bg-white hover:bg-gray-50 transition duration-200 ease-in-out text-xs">
                                <td class="py-2 px-4 border-b text-center">{{ $loop->iteration }}</td>
                                <td class="py-2 px-4 border-b text-left">{{ $item->name }}</td>
                                <td class="py-2 px-4 border-b text-left">{{ $item->email }}</td>
                                <td class="py-2 px-4 border-b text-left">{{ $item->sekolah->alamat }}</td>
                                <td class="py-2 px-4 border-b text-center">
                                    <form action="/sekolah/{{ $item->sekolah->id }}/update-status" method="POST">
                                        @csrf
                                        <button type="submit" 
                                            class="text-xs px-2 py-1 rounded shadow transition duration-300 ease-in-out
                                                @if ($item->sekolah->status === 'pending')
                                                    bg-yellow-200 text-yellow-800 text-xs px-2 py-1 rounded-full
                                                @elseif ($item->sekolah->status === 'diterima')
                                                    bg-green-200 text-green-800 text-xs px-2 py-1 rounded-full
                                                @endif">
                                            {{ $item->sekolah->status }}
                                        </button>
                                    </form>
                                    
                                </td>                                
                                <td class="py-2 px-4 border-b text-center">
                                    <div class="flex justify-center space-x-2">
                                        <button onclick="window.location.href='{{ route('sekolah.show', $item->sekolah->id) }}'" class="bg-blue-500 text-white text-xs px-2 py-1 rounded shadow hover:bg-blue-600 transition duration-300 ease-in-out">
                                            <i class="fas fa-eye"></i> 
                                        </button>                                                                         
                                        <button onclick="deleteSchool({{ $item->sekolah->id }})" class="bg-red-500 text-white text-xs px-2 py-1 rounded shadow hover:bg-red-600 transition duration-300 ease-in-out">
                                            <i class="fas fa-trash"></i> 
                                        </button>
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
    rows = Array.from(document.querySelectorAll('.school-row'));  // Ambil semua baris dengan class kehadiran-row
    updateTableDisplay();  // Memperbarui tampilan tabel
});

    // Function to handle searching in the table
    function searchTable() {
        const searchInput = document.getElementById('search').value.toLowerCase();
        const rows = document.querySelectorAll('.school-row');
        rows.forEach(row => {
            const schoolName = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
            if (schoolName.includes(searchInput)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

   
    // Function to view students for a selected school
    function viewStudents(school) {
        alert(`Menampilkan siswa untuk sekolah: ${school}`);
        // Here you would redirect to another page or load student data dynamically
    }

    // Function to handle deletion of school data
    function deleteSchool(schoolId) {
        if (confirm('Apakah Anda yakin ingin menghapus data sekolah ini?')) {
            const url = `{{ route('sekolah.delete', ':schoolId') }}`.replace(':schoolId', schoolId);

            fetch(url, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // If using Laravel CSRF protection
                }
            })
            .then(response => {
                if (response.ok) {
                    alert(`Data sekolah berhasil dihapus.`);
                    location.reload();
                } else {
                    alert('Terjadi kesalahan saat menghapus data sekolah.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Gagal menghapus data sekolah. Coba lagi nanti.');
            });
        }
    }

   
</script>
  
        </div>
    </main>
</div>

@endsection