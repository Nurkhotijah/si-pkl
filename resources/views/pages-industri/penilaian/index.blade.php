@extends('components.layout-industri')

@section('title', 'Penilaian Siswa')

@section('content')
<main class="bg-gray-100">
    <div class="p-6 overflow-y-auto h-full ml-4">
        @if(session('success'))
        <div id="flash-message" class="bg-green-100 px-4 py-2 my-2 rounded-md text-xs flex items-center max-w-md w-full sm:w-2/3">
            <svg viewBox="0 0 24 24" class="text-green-600 w-4 h-4 mr-2">
                <path fill="currentColor" d="M12,0A12,12,0,1,0,24,12A12.013,12.013,0,0,0,12,0Zm.25,5a1.5,1.5,0,1,1-1.5,1.5A1.5,1.5,0,0,1,12.25,5ZM14.5,18.5h-4a1,1,0,0,1,0-2h.75a.25.25,0,0,0,.25-.25v-4.5a.25.25,0,0,0-.25-.25H10.5a1,1,0,0,1,0-2h1a2,2,0,0,1,2,2v4.75a.25.25,0,0,0,.25.25h.75a1,1,0,1,1,0,2Z"></path>
            </svg>
            <span class="text-green-800">{{ session('success') }}</span>
        </div>
        
        @endif
        <div class="max-w-7xl mx-auto bg-white p-4 sm:p-6 rounded-lg shadow-md">
            <div class="flex flex-col sm:flex-row justify-center items-start sm:items-center mb-4">
                <h1 class="text-xl sm:text-xl font-semibold mb-2 sm:mb-4">Penilaian Siswa</h1>
            </div>

            <!-- Tombol Tambah Jurnal -->
            <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4 mb-6 items-center">
                <a href="{{ route('penilaian.create') }}" class="bg-green-500 text-white text-xs px-3 py-2 rounded shadow hover:bg-green-600 transition duration-300 ease-in-out w-full sm:w-auto text-center">
                    <i class="fas fa-plus mr-2"></i> Tambah 
                </a>
            </div>

            <!-- Tabel Penilaian -->
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border text-sm sm:text-base">
                    <thead class="bg-gray-200 text-gray-700 border-b text-xs">
                        <tr>
                            <th class="py-2 px-4 text-center">No</th>
                            <th class="py-2 px-4 text-left">Nama Lengkap</th>
                            <th class="py-2 px-4 text-left">Sekolah</th>
                            <th class="py-2 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="border-gray-300 text-gray-700 border-b text-xs">
                        @foreach($penilaian as $item)
                        <tr>
                            <td class="py-2 px-4 border-b text-center">{{ $loop->iteration }}</td>
                            <td class="py-2 px-4 border-b text-left">{{ $item->user->name }}</td>
                            <td class="py-2 px-4 border-b text-left">{{ $item->user->profile->sekolah->nama }}</td>
                            <td class="py-2 px-4 border-b text-center">
                                <div class="flex justify-center space-x-2">
                                    <a href="{{ route('penilaian.show', $item->id) }}" class="inline">
                                        <button class="bg-blue-500 text-white text-xs px-3 py-1 rounded shadow hover:bg-blue-600 transition duration-300 ease-in-out">
                                            <i class="fas fa-eye"></i> 
                                        </button>
                                    </a>                                                                        
                                    <form action="{{ route('penilaian.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 text-white text-xs px-3 py-1 rounded shadow hover:bg-red-600 transition duration-300 ease-in-out">
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
    </div>
</main>

<script>
    setTimeout(() => {
        document.getElementById('flash-message').style.display = 'none';
    }, 3000);
</script>
@endsection
