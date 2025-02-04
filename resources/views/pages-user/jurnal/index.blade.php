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
            
            <!-- Alert and Table Section -->
            <div class="flex flex-col sm:flex-row items-center sm:items-start space-y-2 sm:space-y-0 sm:space-x-4 mb-6">
                @if (session('alert'))
            <div id="alert-message" class="fixed top-4 left-1/2 transform -translate-x-1/2 bg-red-500 text-white px-4 py-2 rounded-md shadow-md flex items-center max-w-sm z-50">
                <svg viewBox="0 0 24 24" class="w-5 h-5 mr-2">
                    <path fill="currentColor" d="M12,0A12,12,0,1,0,24,12,12.013,12.013,0,0,0,12,0Zm1,17H11V15h2Zm0-4H11V7h2Z" />
                </svg>
                <span>{{ session('alert') }}</span>
            </div>
            @endif
            </div>
    
            <!-- Form and Buttons -->
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
            
                <!-- Input Tanggal -->
                <div class="flex sm:ml-auto items-center space-x-2 mt-2 sm:mt-0">
                    <label for="dateFilter" class="mr-2 text-xs"></label>
                    <input type="date" name="tanggal" id="dateFilter" class="border rounded p-1 w-full sm:w-auto text-xs" value="{{ request('tanggal') }}" max="{{ now()->toDateString() }}" onchange="this.form.submit()">
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
                    <tbody id="jurnalBody" class="font-poppins text-xs">
                        @foreach($jurnal as $index => $siswa)
                            <tr>
                                <td class="py-2 px-4 border-gray-300 text-gray-700 border-b text-center">{{ $index + 1 }}</td>
                                <td class="py-2 px-4 border-gray-300 text-gray-700 border-b text-left">{{ $siswa->kegiatan }}</td>
                                <td class="py-2 px-4 border-gray-300 text-gray-700 border-b text-center">{{ \Carbon\Carbon::parse($siswa->tanggal)->translatedFormat('d F Y') }}</td>
                                <td class="py-2 px-4 border-gray-300 text-gray-700 border-b text-center">{{ \Carbon\Carbon::parse($siswa->waktu_mulai)->format('H:i') }}</td>
                                <td class="py-2 px-4 border-gray-300 text-gray-700 border-b text-center">{{ \Carbon\Carbon::parse($siswa->waktu_selesai)->format('H:i') }}</td>
                                <td class="py-2 px-4 border-gray-300 border-b text-center">
                                    <img src="{{ asset('storage/'.$siswa->foto_kegiatan) }}" alt="Foto Kegiatan" class="w-14 h-14 object-cover rounded-full cursor-pointer">
                                </td>
                                <td class="py-2 px-4 border-gray-300 border-b text-center">
                                    <div class="flex justify-center space-x-2">
                                        <a href="{{ route('jurnal-siswa.edit', ['id' => $siswa->id]) }}" class="bg-blue-500 text-white text-xs px-3 py-1 rounded shadow hover:bg-blue-600">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('jurnal-siswa.destroy', ['id' => $siswa->id]) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 text-white text-xs px-3 py-1 rounded shadow hover:bg-red-600">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>                
                </table>
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
    document.addEventListener('DOMContentLoaded', function() {
    const alertMessage = document.getElementById('alert-message');
    if (alertMessage) {
        setTimeout(() => {
            alertMessage.style.transition = 'opacity 0.5s';
            alertMessage.style.opacity = '0';
            setTimeout(() => alertMessage.remove(), 500); // Hapus elemen setelah transisi selesai
        }, 3000); // 3000 ms = 3 detik
    }
});

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
