@extends('components.layout-user')

@section('title', 'Jurnal Kegiatan')

@section('content')

<body class="font-poppins">
<main class="p-6 overflow-y-auto h-full">
    <div class="max-w-7xl mx-auto bg-white p-4 sm:p-6 rounded-lg shadow-md">
        <!-- Header Section -->
        <div class="mb-4 flex flex-col sm:flex-row justify-center items-center">
            <h1 class="text-xl sm:text-xl font-semibold mb-2 sm:mb-4">Jurnal</h1>
        </div>        
        <form method="GET" action="{{ route('jurnal-siswa.index') }}" class="flex flex-col sm:flex-row items-center space-y-2 sm:space-y-0 sm:space-x-2 w-full justify-between mb-6">
            <div class="flex flex-col sm:flex-row items-center space-y-2 sm:space-y-0 sm:space-x-2">
                <!-- Tombol Tambah Jurnal -->
                <a href="{{ route('jurnal-siswa.create') }}" class="bg-green-500 text-white text-xs px-3 py-2 rounded shadow hover:bg-green-600 transition duration-300 ease-in-out w-full sm:w-auto text-center">
                    <i class="fas fa-plus mr-2"></i> Tambah Jurnal
                </a>
        
                <!-- Tombol Lihat Penilaian -->
                <a href="{{ route('penilaian.show.user') }}" class="bg-blue-500 text-white text-xs px-3 py-2 rounded shadow hover:bg-blue-600 transition duration-300 ease-in-out w-full sm:w-auto text-center">
                    <i class="fas fa-eye mr-2"></i> Lihat Penilaian
                </a>
            </div>
        
            <!-- Input Tanggal, dengan sm:ml-auto untuk memindahkannya ke kanan pada mode desktop -->
            <div class="flex sm:ml-auto items-center space-x-2 mt-2 sm:mt-0">
                <label for="dateFilter" class="mr-2 text-xs"></label>
                <input type="date" name="tanggal" id="dateFilter" class="border rounded p-1 w-full sm:w-auto text-xs" value="{{ request('tanggal') }}" onchange="this.form.submit()">
            </div>
        </form>        
        
        <!-- Table Section -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border" id="pengajuanTable">
                <thead class="bg-gray-200 text-xs">
                    <tr>
                        <th class="py-2 px-4 font-semibold text-gray-700 border-b text-center">No</th>
                        <th class="py-2 px-4 font-semibold text-gray-700 border-b text-left">Kegiatan</th>
                        <th class="py-2 px-4 font-semibold text-gray-700 border-b text-center">Tanggal</th>
                        <th class="py-2 px-4 font-semibold text-gray-700 border-b text-center">Waktu Mulai</th>
                        <th class="py-2 px-4 font-semibold text-gray-700 border-b text-center">Waktu Selesai</th>
                        <th class="py-2 px-4 font-semibold text-gray-700 border-b text-center">Foto</th>
                        <th class="py-2 px-4 font-semibold text-gray-700 border-b text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody id="jurnalBody" class="font-poppins text-xs ">
                    @foreach($jurnal as $index => $siswa)
                        <tr>
                            <td class="py-2 px-4 border-gray-300 text-gray-700 border-b text-center">{{ $index + 1 }}</td>
                            <td class="py-2 px-4 border-gray-300 text-gray-700 border-b text-left">{{ $siswa->kegiatan }}</td>
                            <td class="py-2 px-4 border-gray-300 text-gray-700 border-b text-center">{{ \Carbon\Carbon::parse($siswa->tanggal)->format('d F Y') }}</td>
                            <td class="py-2 px-4 border-gray-300 text-gray-700 border-b text-center">{{ \Carbon\Carbon::parse($siswa->waktu_mulai)->format('H:i') }}</td>
                            <td class="py-2 px-4 border-gray-300 text-gray-700 border-b text-center">{{ \Carbon\Carbon::parse($siswa->waktu_selesai)->format('H:i') }}</td>
                            <td class="py-2 px-4 border-gray-300 border-b text-center justify-center items-center">
                                <img src="{{ asset('storage/'.$siswa->foto_kegiatan) }}" alt="Foto Kegiatan" class="w-14 h-14 object-cover rounded-full cursor-pointer" onclick="showActivityImage('{{ asset('storage/'.$siswa->foto_kegiatan) }}')">
                            </td>                            
                            <td class="py-2 px-4 border-gray-300 border-b text-center">
                                <div class="flex justify-center space-x-2">
                                    <!-- Tombol Edit -->
                                    <a href="{{ route('jurnal-siswa.edit', ['id' => $siswa->id]) }}" class="inline-block w-auto">
                                        <button class="bg-blue-500 text-white text-xs px-3 py-1 rounded shadow hover:bg-blue-600 transition duration-300 ease-in-out">
                                            <i class="fas fa-edit"></i> 
                                        </button>
                                    </a>
                                    
                                    <!-- Form untuk Hapus -->
                                    <form action="{{ route('jurnal-siswa.destroy', ['id' => $siswa->id]) }}" method="POST" class="inline-block w-auto" onsubmit="return confirm('Apakah Anda yakin ingin menghapus ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 text-white text-xs px-3 py-1 rounded shadow hover:bg-red-600 transition duration-300 ease-in-out">
                                            <i class="fas fa-trash"></i> 
                                        </button>
                                    </form>
                                </div>
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

<!-- Image Modal -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg p-4 relative max-w-md w-full">
        <button onclick="closeModal()" class="absolute top-2 right-2 text-gray-500 font-semibold hover:text-black">
            ✕
        </button>
        <img id="activityImage" src="" alt="Activity Image" class="w-full rounded-md">
    </div>
</div>

<script>
    let currentPage = 1;
    const ITEMS_PER_PAGE = 5;
    let filteredData = [];

    function showActivityImage(imageSrc) {
        const modal = document.getElementById('imageModal');
        const activityImage = document.getElementById('activityImage');
        activityImage.src = imageSrc;
        modal.classList.remove('hidden');
    }

    function closeModal() {
        const modal = document.getElementById('imageModal');
        modal.classList.add('hidden');
    }

    function filterByDate() {
        const selectedDate = document.getElementById('dateFilter').value;
        const rows = Array.from(document.querySelectorAll('#jurnalBody tr'));
        
        filteredData = rows.filter(row => {
            const dateCell = row.querySelector('td:nth-child(3)').textContent;
            return selectedDate ? dateCell === selectedDate : true;
        });

        currentPage = 1;
        updateTableDisplay();
    }

    function updateTableDisplay() {
        const startIndex = (currentPage - 1) * ITEMS_PER_PAGE;
        const endIndex = startIndex + ITEMS_PER_PAGE;

        document.querySelectorAll('#jurnalBody tr').forEach((row, index) => {
            row.style.display = (index >= startIndex && index < endIndex) ? '' : 'none';
        });

        document.getElementById('currentPage').textContent = currentPage;
        document.getElementById('totalPages').textContent = Math.ceil(filteredData.length / ITEMS_PER_PAGE);
    }

    function prevPage() {
        if (currentPage > 1) {
            currentPage--;
            updateTableDisplay();
        }
    }

    function nextPage() {
        const totalPages = Math.ceil(filteredData.length / ITEMS_PER_PAGE);
        if (currentPage < totalPages) {
            currentPage++;
            updateTableDisplay();
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        filteredData = Array.from(document.querySelectorAll('#jurnalBody tr'));
        updateTableDisplay();
    });
</script>
</body>
@endsection
