@extends('components.layout-user')

@section('title', 'Riwayat Kehadiran')

@section('content')
<!-- Main Content -->
<body class="bg-gray-100 font-poppins">
    <div class="container mx-auto p-4">
        <div class="bg-white rounded-lg shadow p-6">
            <h1 class="text-xl font-semibold mb-4 text-center">Riwayat Kehadiran</h1>
            <div class="flex flex-col sm:flex-row items-center space-y-2 sm:space-y-0 sm:space-x-2 w-full justify-between mb-6">
                <!-- Form for Upload Foto Izin -->
                <form action="{{ route('kehadiran.store') }}" method="POST" enctype="multipart/form-data" id="formIzin">
                    @csrf
                    <input type="hidden" name="jenis_absen" value="masuk">
                    <div class="flex flex-col md:flex-row md:space-x-4 mb-4 md:mb-0 w-full">
                        <div class="flex space-x-2 mb-4 md:mb-0 w-full md:w-auto">
                            @php $disableIzin = $disableIzin ?? false; @endphp
                            @if(!$disableIzin)
                                <label for="uploadIzin" class="bg-blue-500 text-white text-xs px-4 py-2 rounded shadow hover:bg-blue-600 transition duration-300 ease-in-out cursor-pointer flex items-center w-full">
                                    <i class="fas fa-upload mr-2"></i> Upload Foto Izin
                                </label>
                                <input type="file" id="uploadIzin" name="foto_izin" class="hidden" accept="image/jpeg, image/png" onchange="submitForm()">
                            @else
                                <p class="text-gray-500 text-xs italic">Anda sudah absen hari ini, tidak bisa mengupload izin.</p>
                            @endif
                        </div>
                
            
                        <!-- Tombol Unduh Rekap Kehadiran -->
                    <div class="w-full md:w-auto">
                        <a class="bg-green-500 text-white text-xs px-4 py-2 rounded hover:bg-green-600 transition duration-300 ease-in-out flex items-center space-x-2 w-full justify-center md:justify-start 
                            {{ !$isPklSelesai ? 'cursor-not-allowed opacity-50' : '' }}" href="{{ route('rekap.kehadiran') }}" {{ !$isPklSelesai ? 'disabled' : '' }}>
                            <i class="fas fa-download"></i><span>Rekap Kehadiran</span>
                        </a>
                    </div>
                    </div>
                </form>
            
                <!-- Filter Tanggal -->
                <div class="mt-4 md:mt-0">
                    <form action="{{ route('riwayat-absensi') }}" method="GET">
                        <input type="date" name="tanggal" class="border rounded p-2 w-full md:w-auto text-xs" value="{{ request()->tanggal }}" max="{{ now()->toDateString() }}" 
                        onchange="this.form.submit() ">
                    </form>                    
                </div>
            </div>
                        
            <div class="overflow-x-auto ">
                <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
                    <thead class="bg-gray-200">
                        <tr class="text-gray-600 text-xs">
                            <th class="py-3 px-4 text-center  font-semibold text-gray-700 border-b border-gray-300">No</th>
                            {{-- <th class="py-3 px-4 text-center  font-semibold text-gray-700 border-b border-gray-300">Nama Lengkap</th> --}}
                            <th class="py-3 px-4 text-center  font-semibold text-gray-700 border-b border-gray-300">Tanggal</th>
                            <th class="py-3 px-4 text-center  font-semibold text-gray-700 border-b border-gray-300">Waktu Masuk</th>
                            <th class="py-3 px-4 text-center  font-semibold text-gray-700 border-b border-gray-300">Waktu Keluar</th>
                            <th class="py-3 px-4 text-center  font-semibold text-gray-700 border-b border-gray-300">Foto Masuk</th>
                            <th class="py-3 px-4 text-center  font-semibold text-gray-700 border-b border-gray-300">Foto Keluar</th>
                            <th class="py-3 px-4 text-center  font-semibold text-gray-700 border-b border-gray-300">Foto Izin</th>
                            <th class="py-3 px-4 text-center  font-semibold text-gray-700 border-b border-gray-300">Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 font-poppins text-xs">
                        @foreach($kehadiran as $absensi)
                        <tr class="kehadiran-row">
                            <!-- No -->
                            <td class="py-2 px-4 border-b border-gray-300 text-center">{{ $loop->iteration }}</td>
                            
                            <!-- Nama Lengkap -->
                            {{-- <td class="py-2 px-4 border-b border-gray-300">{{ Auth::user()->name }}</td> --}}
                            
                            <!-- Tanggal -->
                            <td class="py-2 px-4 border-b border-gray-300 text-center">{{ \Carbon\Carbon::parse($absensi->tanggal)->translatedFormat('d F Y') }}</td>
                            
                            <!-- Waktu Masuk -->
                            <td class="py-2 px-4 border-b border-gray-300 text-center">{{ $absensi->waktu_masuk ? \Carbon\Carbon::parse($absensi->waktu_masuk)->format('H:i:s') : '-' }}</td>
                            
                            <!-- Waktu Keluar -->
                            <td class="py-2 px-4 border-b border-gray-300 text-center">{{ $absensi->waktu_keluar ? \Carbon\Carbon::parse($absensi->waktu_keluar)->format('H:i:s') : '-' }}</td>
                            
                            <!-- Foto Masuk -->
                            <td class="py-2 px-4 border-b border-gray-300 text-center">
                                @if($absensi->foto_masuk)
                                <a href="{{ asset('storage/' . $absensi->foto_masuk) }}" target="_blank">
                                    <img class="w-10 h-10 object-cover rounded-full mx-auto hover:opacity-75 transition duration-300"
                                         src="{{ asset('storage/' . $absensi->foto_masuk) }}" 
                                         alt="Foto Masuk" 
                                         title="Klik untuk memperbesar">
                                </a>
                                @else
                                <span class="text-gray-500">-</span>
                                @endif
                            </td>
                            
                            <!-- Foto Keluar -->
                            <td class="py-2 px-4 border-b border-gray-300 text-center">
                                @if($absensi->foto_keluar)
                                <a href="{{ asset('storage/' . $absensi->foto_keluar) }}" target="_blank">
                                    <img class="w-10 h-10 object-cover rounded-full mx-auto hover:opacity-75 transition duration-300"
                                         src="{{ asset('storage/' . $absensi->foto_keluar) }}" 
                                         alt="Foto Keluar" 
                                         title="Klik untuk memperbesar">
                                </a>
                                @else
                                <span class="text-gray-500">-</span>
                                @endif
                            </td>
                            
                            <!-- Foto Izin -->
                            <td class="py-2 px-4 border-b border-gray-300 text-center">
                                @if($absensi->foto_izin)
                                <a href="{{ asset('storage/' . $absensi->foto_izin) }}" target="_blank">
                                    <img class="w-10 h-10 object-cover rounded-full mx-auto hover:opacity-75 transition duration-300"
                                         src="{{ asset('storage/' . $absensi->foto_izin) }}" 
                                         alt="Foto Izin" 
                                         title="Klik untuk memperbesar">
                                </a>
                                @else
                                <span class="text-gray-500">-</span>
                                @endif
                            </td>
                            
                            <!-- Status -->
                            <td class="py-2 px-4 border-b border-gray-300 text-center">
                                {{ $absensi->foto_izin ? 'Izin' : $absensi->status }}
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
</body>
<script>
function submitForm() {
    const form = document.getElementById('formIzin');
    const fileInput = document.getElementById('uploadIzin');

    if (!form) {
        alert("Form tidak ditemukan!");
        return;
    }

    if (fileInput.files.length > 0) {
        const formData = new FormData(form);
        
        fetch("{{ route('kehadiran.store') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.message) {
                alert('Foto izin berhasil diupload');
                window.location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat mengupload foto izin');
        });
    } else {
        alert("Silakan pilih file foto izin sebelum mengupload.");
    }
}

let currentPage = 1;
const ITEMS_PER_PAGE = 10; // Set jumlah item per halaman
let filteredData = [];  // Menyimpan data yang akan dipaginasikan

// Fungsi untuk memperbarui tampilan berdasarkan halaman
function updateTableDisplay() {
    const rows = Array.from(document.querySelectorAll('.kehadiran-row'));
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
    filteredData = Array.from(document.querySelectorAll('.kehadiran-row'));  // Targetkan rows dengan class kehadiran-row
    updateTableDisplay();  // Memperbarui tampilan tabel
});

document.querySelector('input[name="tanggal"]').addEventListener('change', function() {
    if (!this.value) {
        // Ketika input tanggal kosong, hapus parameter 'tanggal' dari URL
        window.location.href = "{{ route('riwayat-absensi') }}";
    } else {
        // Kirimkan form jika ada tanggal yang dipilih
        this.form.submit();
    }
});

</script>
@endsection
