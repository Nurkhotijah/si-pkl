@extends('components.layout-admin')

@section('title', 'Pengajuan Siswa')

@section('content')
<div class="bg-gray-100 font-poppins">
    <main class="p-6 overflow-y-auto h-full">
        <div class="max-w-7xl mx-auto bg-white p-4 sm:p-6 rounded-lg shadow-md">
            <!-- Header Section -->
            <div class="mb-4">
                <h1 class="text-xl sm:text-xl font-semibold text-center mb-2 sm:mb-4">Pengajuan Siswa</h1>
                <div class="flex flex-col sm:flex-row items-center justify-between space-y-4 sm:space-y-0 sm:space-x-4 text-xs">
                    <div class="relative w-full sm:w-auto">
                        <input class="border rounded p-2 pl-10 w-full sm:w-64" id="search" placeholder="Cari Nama Siswa" type="text" oninput="searchTable()">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                    <!-- Add Student Button -->
                    <div class="mt-4 sm:mt-0 w-full sm:w-auto text-center">
                        <a href="{{ route('pengajuan.create', $id_pkl) }}" class="bg-green-500 text-white text-xs px-4 py-2 rounded shadow hover:bg-green-600 transition duration-300 ease-in-out mx-auto sm:mx-0 block sm:inline-block">
                            <i class="fas fa-user-plus mr-2"></i>Tambah Siswa
                        </a>                        
                    </div>
                </div>
            </div>                   

            <!-- Table Section -->
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border-collapse" id="studentTable">
                    <thead class="bg-gray-200 font-semibold text-gray-700 border-b border-gray-300 text-xs">
                        <tr>
                            <th class="py-2 px-4 text-center">No</th>
                            <th class="py-2 px-4 text-left">Nama Siswa</th>
                            <th class="py-2 px-4 text-left">Jurusan</th>
                            <th class="py-2 px-4 text-center">Tanggal Mulai</th>
                            <th class="py-2 px-4 text-center">Tanggal Selesai</th>
                            <th class="py-2 px-4 text-center">CV</th>
                            <th class="py-2 px-4 text-center">Status Persetujuan</th>
                            <th class="py-2 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 font-poppins text-xs">
                        @foreach($pengajuan as $item)
                        <tr class="bg-white hover:bg-gray-50 transition duration-200 ease-in-out">
                            <td class="py-2 px-4  border-b border-gray-300 text-center">{{ $loop->iteration }}</td>
                            <td class="py-2 px-4  border-b border-gray-300">{{ $item->nama }}</td>
                            <td class="py-2 px-4  border-b border-gray-300">{{ $item->jurusan }}</td>
                            <td class="py-2 px-4  border-b border-gray-300 text-center">{{ \Carbon\Carbon::parse($item->tanggal_mulai)->locale('id')->translatedFormat('d F Y') }}</td>
                            <td class="py-2 px-4  border-b border-gray-300 text-center">{{ \Carbon\Carbon::parse($item->tanggal_selesai)->locale('id')->translatedFormat('d F Y') }}</td>
                            <td class="py-2 px-4  border-b border-gray-300 text-center">
                                <a href="{{ asset('storage/' . $item->cv_file) }}" class="bg-blue-500 text-white text-xs px-2 py-1 rounded hover:bg-blue-600 transition duration-300">
                                    <i class="fas fa-file-pdf"></i>
                                </a>
                            </td>
                            <td class="border-b border-gray-300 text-center">
                                @if ($item->status_persetujuan == 'pending')
                                <span id="status-{{ $item->id }}" class="bg-yellow-200 text-yellow-800 text-xs px-2 py-1 rounded-full">{{ $item->status_persetujuan }}</span>
                            @elseif ($item->status_persetujuan == 'diterima')
                                <span id="status-{{ $item->id }}" class="bg-green-200 text-green-800 text-xs px-2 py-1 rounded-full">{{ $item->status_persetujuan }}</span>
                            @elseif ($item->status_persetujuan == 'ditolak')
                                <span id="status-{{ $item->id }}" class="bg-red-200 text-red-800 text-xs px-2 py-1 rounded-full">{{ $item->status_persetujuan }}</span>
                            @endif                            
                            </td>
                             <td class="py-2 px-3 border-b border-gray-300 text-center">
                                <div class="flex justify-center space-x-2">
                                    {{-- <!-- Edit Button -->
                                    <a href="{{ route('pengajuan.edit', $item->id) }}" class="bg-yellow-500 text-white text-xs px-2 py-1 rounded shadow hover:bg-yellow-600 transition duration-300 ease-in-out">
                                        <i class="fas fa-edit"></i>
                                    </a> --}}
                                    <!-- Delete Button -->
                                    <form action="{{ route('pengajuan.delete', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus siswa ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 text-white text-xs px-2 py-1 rounded shadow hover:bg-red-600 transition duration-300 ease-in-out">
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
</div>

<script>
    function searchTable() {
        const input = document.getElementById('search');
        const filter = input.value.toLowerCase();
        const table = document.getElementById('studentTable');
        const rows = table.getElementsByTagName('tr');

        for (let i = 1; i < rows.length; i++) {
            const nameCell = rows[i].getElementsByTagName('td')[1]; // Index 1 adalah kolom nama siswa
            if (nameCell) {
                const nameText = nameCell.textContent || nameCell.innerText;
                if (nameText.toLowerCase().indexOf(filter) > -1) {
                    rows[i].style.display = '';
                } else {
                    rows[i].style.display = 'none';
                }
            }
        }
        function deleteStudent(studentId) {
        if (confirm("Apakah Anda yakin ingin menghapus data siswa ini?")) {
            // Implementasikan logika penghapusan data di sini
            console.log(`Data siswa dengan ID ${studentId} dihapus.`);
        }
    }
    }
</script>

@endsection
