@extends('components.layout-admin')

@section('title', 'Tambah Pengajuan Siswa')

@section('content')
<div class="bg-gray-100 flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-2xl">
        <h2 class="text-xl font-bold mb-6 text-center text-gray-800">Tambah Siswa</h2>

        <main class="p-6">
            <form action="{{ route('pengajuan.store', $id_pkl) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Dynamic Nama dan CV -->
                <div id="siswa-container">
                    <div class="siswa-row mb-4">
                        <label class="block text-sm font-medium text-gray-700">Nama Siswa</label>
                        <input type="text" name="nama[]" class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                        
                        <label class="block text-sm font-medium text-gray-700">Jurusan</label>
                        <input type="text" name="jurusan[]" class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                        
                        <label class="block text-sm font-medium text-gray-700 mt-2">CV</label>
                        <input type="file" name="cv[]" accept=".pdf" class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">

                    </div>
                </div>
                <div class="mb-4">
                    <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" id="tanggal_mulai"
                    class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 @error('tanggal_mulai') border-red-500 @enderror"
                    value="{{ old('tanggal_mulai') }}" min="{{ now()->toDateString() }}">
                    @error('tanggal_mulai')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="tanggal_selesai" class="block text-sm font-medium text-gray-700">Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 @error('tanggal_selesai') border-red-500 @enderror" value="{{ old('tanggal_selesai') }}">
                    @error('tanggal_selesai')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tombol Tambah Siswa -->
                <button type="button" id="add-siswa" class="bg-green-500 text-white px-4 py-2 rounded mt-3">Tambah Siswa</button>

                <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600 transition duration-300 mt-4">Simpan</button>
            </form>
        </main>
    </div>
</div>

<script>
    document.getElementById('add-siswa').addEventListener('click', function() {
        let container = document.getElementById('siswa-container');
        let newRow = document.createElement('div');
        newRow.classList.add('siswa-row', 'mb-4');
        newRow.innerHTML = `
            <label class="block text-sm font-medium text-gray-700">Nama Siswa</label>
            <input type="text" name="nama[]" class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">

            <label class="block text-sm font-medium text-gray-700">Jurusan</label>
            <input type="text" name="jurusan[]" class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            
            <label class="block text-sm font-medium text-gray-700 mt-2">CV</label>
            <input type="file" name="cv[]" accept=".pdf" class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">

        `;
        container.appendChild(newRow);
    });
</script>

@endsection
