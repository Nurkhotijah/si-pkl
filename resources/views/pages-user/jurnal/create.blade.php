@extends('components.layout-user')

@section('title', 'Tambah Jurnal')

@section('content')
    <body class="font-poppins">
        <div class="max-w-3xl mx-auto mt-10 p-6 bg-white rounded-lg shadow-md">
            <h1 class="text-xl font-semibold mb-6 text-center">Tambah Jurnal</h1>

            <form action="{{ route('jurnal-siswa.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="space-y-6 mb-6">
                    <!-- Deskripsi Kegiatan -->
                    <div class="flex flex-col">
                        <label for="kegiatan" class="block text-gray-700 font-medium mb-2 text-sm">Deskripsi Kegiatan</label>
                        <textarea id="kegiatan" name="kegiatan" 
                            class="w-full p-3 border rounded-md text-xs @error('kegiatan') border-red-500 @else border-gray-300 @enderror"
                            placeholder="Masukkan deskripsi kegiatan">{{ old('kegiatan') }}</textarea>
                        @error('kegiatan')
                            <span class="text-red-500 text-xs error-message">{{ $message }}</span>
                        @enderror
                    </div>
            
                    <!-- Tanggal Laporan -->
                    <div class="flex flex-col">
                        <label for="tanggal" class="block text-gray-700 font-medium mb-2 text-sm">Tanggal Laporan</label>
                        <input type="date" id="tanggal" name="tanggal" max="{{ now()->toDateString() }}" value="{{ old('tanggal') }}" 
                            class="w-full p-3 border rounded-md text-sm @error('tanggal') border-red-500 @else border-gray-300 @enderror">
                        @error('tanggal')
                            <span class="text-red-500 text-xs error-message">{{ $message }}</span>
                        @enderror
                    </div>
            
                    <!-- Jam Mulai -->
                    <div class="flex flex-col">
                        <label for="waktu_mulai" class="block text-gray-700 font-medium mb-2 text-sm">Jam Mulai</label>
                        <input type="time" id="waktu_mulai" name="waktu_mulai" value="{{ old('waktu_mulai') }}" 
                            class="w-full p-3 border rounded-md text-sm @error('waktu_mulai') border-red-500 @else border-gray-300 @enderror">
                        @error('waktu_mulai')
                            <span class="text-red-500 text-xs error-message">{{ $message }}</span>
                        @enderror
                    </div>
            
                    <!-- Jam Selesai -->
                    <div class="flex flex-col">
                        <label for="waktu_selesai" class="block text-gray-700 font-medium mb-2 text-sm">Jam Selesai</label>
                        <input type="time" id="waktu_selesai" name="waktu_selesai" value="{{ old('waktu_selesai') }}" 
                            class="w-full p-3 border rounded-md text-sm @error('waktu_selesai') border-red-500 @else border-gray-300 @enderror">
                        @error('waktu_selesai')
                            <span class="text-red-500 text-xs error-message">{{ $message }}</span>
                        @enderror
                    </div>
            
                    <!-- Foto Kegiatan -->
                    <div class="flex flex-col">
                        <label for="foto_kegiatan" class="block text-gray-700 font-medium mb-2 text-sm">Foto Kegiatan</label>
                        <input type="file" id="foto_kegiatan" name="foto_kegiatan" 
                            class="w-full p-3 border rounded-md text-sm @error('foto_kegiatan') border-red-500 @else border-gray-300 @enderror">
                        @error('foto_kegiatan')
                            <span class="text-red-500 text-xs error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            
                <div class="text-center text-sm">
                    <button type="submit" class="bg-blue-500 text-white font-medium py-2 px-6 rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Simpan
                    </button>
                </div>
            </form>

        </div>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- JavaScript untuk menghilangkan error saat mengetik -->
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const inputs = document.querySelectorAll("input, textarea");
        
                inputs.forEach(input => {
                    input.addEventListener("input", function() {
                        this.classList.remove("border-red-500");
                        this.classList.add("border-gray-300");
        
                        let errorMessage = this.parentNode.querySelector(".error-message");
                        if (errorMessage) {
                            errorMessage.style.display = "none";
                        }
                    });
                });
            });
        </script>
    </body>
@endsection
