@extends('components.layout-admin')

@section('title', 'Edit Pengajuan Siswa')

@section('content')
<div class="bg-gray-100 flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-2xl">
        <h2 class="text-xl font-bold mb-6 text-center text-gray-800">Edit Pengajuan Siswa</h2>
        
        <main class="p-6">
            <form action="{{ route('pengajuan.update', $pengajuan->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
            
                <div class="mb-4">
                    <label for="nama" class="block text-sm font-medium text-gray-700">Nama Siswa</label>
                    <input type="text" name="nama" id="nama" class="w-full p-3 border border-gray-300 rounded @error('nama') border-red-500 @enderror" value="{{ old('nama', $pengajuan->nama) }}">
                    @error('nama')
                        <p class="text-red-500 text-xs mt-1" id="error-nama">{{ $message }}</p>
                    @enderror
                </div>
            
                <div class="mb-4">
                    <label for="jurusan" class="block text-sm font-medium text-gray-700">Jurusan</label>
                    <input type="text" name="jurusan" id="jurusan" class="w-full p-3 border border-gray-300 rounded @error('jurusan') border-red-500 @enderror" value="{{ old('jurusan', $pengajuan->jurusan) }}">
                    @error('jurusan')
                        <p class="text-red-500 text-xs mt-1" id="error-jurusan">{{ $message }}</p>
                    @enderror
                </div>
            
                <div class="mb-4">
                    <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="w-full p-3 border border-gray-300 rounded @error('tanggal_mulai') border-red-500 @enderror" value="{{ old('tanggal_mulai', $pengajuan->tanggal_mulai) }}">
                    @error('tanggal_mulai')
                        <p class="text-red-500 text-xs mt-1" id="error-tanggal_mulai">{{ $message }}</p>
                    @enderror
                </div>
            
                <div class="mb-4">
                    <label for="tanggal_selesai" class="block text-sm font-medium text-gray-700">Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="w-full p-3 border border-gray-300 rounded @error('tanggal_selesai') border-red-500 @enderror" value="{{ old('tanggal_selesai', $pengajuan->tanggal_selesai) }}">
                    @error('tanggal_selesai')
                        <p class="text-red-500 text-xs mt-1" id="error-tanggal_selesai">{{ $message }}</p>
                    @enderror
                </div>
            
                <div class="mb-4">
                    <label for="cv" class="block text-sm font-medium text-gray-700">CV</label>
                    <input type="file" name="cv" id="cv" class="w-full p-3 border border-gray-300 rounded @error('cv') border-red-500 @enderror">
                    <p class="text-sm text-gray-500">Biarkan kosong jika tidak ingin mengubah.</p>
                    @if ($pengajuan->cv_file)
                        <p class="text-sm mt-2">File saat ini: <a href="{{ asset('storage/' . $pengajuan->cv_file) }}" target="_blank" class="text-blue-500 underline">Lihat CV</a></p>
                    @endif
                    @error('cv')
                        <p class="text-red-500 text-xs mt-1" id="error-cv">{{ $message }}</p>
                    @enderror
                </div>
            
                <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600 transition duration-300">Update</button>
            </form>
        </main>
    </div>
</div>

<script>
    const inputs = document.querySelectorAll('input');

    inputs.forEach(input => {
        input.addEventListener('focus', () => {
            // Remove the error border and message when the input is focused
            input.classList.remove('border-red-500');
            const errorMessage = document.getElementById('error-' + input.id);
            if (errorMessage) {
                errorMessage.style.display = 'none';
            }
        });
    });
</script>

@endsection
