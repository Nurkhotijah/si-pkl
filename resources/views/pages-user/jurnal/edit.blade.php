@extends('components.layout-user')

@section('title', 'Edit Jurnal Kegiatan')

@section('content')

<div class="max-w-3xl mx-auto mt-10 p-6 bg-white rounded-lg shadow-md">
    <h1 class="text-xl font-semibold mb-6 text-center">Edit Jurnal</h1>
    
    <form action="{{ route('jurnal-siswa.update', $jurnal->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT') 
        
        <div class="flex flex-col space-y-6 mb-6">
            <!-- Deskripsi Kegiatan -->
            <div class="flex flex-col">
                <label for="kegiatan" class="block text-gray-700 font-semibold mb-2 text-sm">Deskripsi Kegiatan</label>
                <textarea id="kegiatan" name="kegiatan" class="w-full p-3 border rounded-md text-xs @error('kegiatan') border-red-500 @enderror" placeholder="Masukkan deskripsi kegiatan" oninput="removeError('kegiatan')">{{ old('kegiatan', $jurnal->kegiatan) }}</textarea>
                @error('kegiatan')
                    <span id="error-kegiatan" class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>
    
            <!-- Tanggal Laporan -->
            <div class="flex flex-col">
                <label for="tanggal" class="block text-gray-700 font-semibold mb-2 text-sm">Tanggal Laporan</label>
                <input type="date" id="tanggal" name="tanggal" 
                value="{{ old('tanggal', \Carbon\Carbon::parse($jurnal->tanggal)->format('Y-m-d')) }}" 
                class="w-full p-3 border rounded-md text-xs @error('tanggal') border-red-500 @enderror"
                oninput="removeError('tanggal')" 
                max="{{ \Carbon\Carbon::today()->format('Y-m-d') }}">
                         @error('tanggal')
                    <span id="error-tanggal" class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>
    
            <!-- Jam Mulai -->
            <div class="flex flex-col">
                <label for="waktu_mulai" class="block text-gray-700 font-semibold mb-2 text-sm">Jam Mulai</label>
                <input type="time" id="waktu_mulai" name="waktu_mulai" value="{{ old('waktu_mulai', \Carbon\Carbon::parse($jurnal->waktu_mulai)->format('H:i')) }}" class="w-full p-3 border rounded-md text-xs @error('waktu_mulai') border-red-500 @enderror" oninput="removeError('waktu_mulai')">
                @error('waktu_mulai')
                    <span id="error-waktu_mulai" class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>
            
            <!-- Jam Selesai -->
            <div class="flex flex-col">
                <label for="waktu_selesai" class="block text-gray-700 font-semibold mb-2 text-sm">Jam Selesai</label>
                <input type="time" id="waktu_selesai" name="waktu_selesai" value="{{ old('waktu_selesai', \Carbon\Carbon::parse($jurnal->waktu_selesai)->format('H:i')) }}" class="w-full p-3 border rounded-md text-xs @error('waktu_selesai') border-red-500 @enderror" oninput="removeError('waktu_selesai')">
                @error('waktu_selesai')
                    <span id="error-waktu_selesai" class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>
    
            <!-- Foto Kegiatan -->
            <div class="flex flex-col">
                <label for="foto_kegiatan" class="block text-gray-700 font-semibold mb-2 text-sm">Foto Bukti Kegiatan</label>
                <input type="file" id="foto_kegiatan" name="foto_kegiatan" class="w-full p-3 border rounded-md text-xs @error('foto_kegiatan') border-red-500 @enderror" onchange="removeError('foto_kegiatan')">
                @error('foto_kegiatan')
                    <span id="error-foto_kegiatan" class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
                @if($jurnal->foto_kegiatan)
                    <img src="{{ asset('storage/'.$jurnal->foto_kegiatan) }}" alt="Foto Kegiatan" class="mt-2 w-32 h-32 object-cover rounded-md">
                @endif
            </div>
        </div>
    
        <div class="text-center text-sm">
            <button type="submit" class="bg-blue-500 text-white font-medium py-2 px-6 rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
               Simpan
            </button>
        </div>
    </form>    
</div>

<!-- JavaScript -->
<script>
    function removeError(field) {
        let input = document.getElementById(field);
        let errorMsg = document.getElementById("error-" + field);
        
        if (input) {
            input.classList.remove("border-red-500"); // Hapus border merah
        }
        
        if (errorMsg) {
            errorMsg.style.display = "none"; // Sembunyikan pesan error
        }
    }
</script>

@endsection
