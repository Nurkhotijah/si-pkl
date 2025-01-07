@extends('components.layout-industri')

@section('title', 'Edit Kehadiran Siswa')

@section('content')

<main class="p-6 overflow-y-auto h-full">
    <div class="max-w-3xl mx-auto bg-white p-4 sm:p-6 rounded-lg shadow-md">
        <h1 class="text-xl sm:text-xl font-semibold text-center mb-2 sm:mb-4">Edit Kehadiran</h1>

        <form action="{{ route('kehadiran.update', $item->id) }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                <input type="text" id="name" name="name" class="border rounded p-2 w-full mt-1 text-xs" readonly value="{{ $item->user->name }}">
            </div>
        
            <div class="mb-4">
                <label for="school" class="block text-sm font-medium text-gray-700 ">Sekolah</label>
                <input type="text" id="sekolah" name="sekolah" class="border rounded p-2 w-full mt-1 text-xs" readonly value="{{ $item->user->profile->sekolah->nama }}">
            </div>
        
            <div class="mb-4">
                <label for="date" class="block text-sm font-medium text-gray-700">Tanggal</label>
                <input type="date" id="tanggal" name="tanggal" value="{{ old('tanggal', \Carbon\Carbon::parse($item->tanggal)->format('Y-m-d')) }}" class="border rounded p-2 w-full mt-1 text-xs" readonly>
            </div>
        
            <div class="mb-4">
                <label for="checkInTime" class="block text-sm font-medium text-gray-700">Waktu Masuk</label>
                <input type="time" id="waktu_masuk" name="waktu_masuk" class="border rounded p-2 w-full mt-1 text-xs" readonly value="{{ $item->waktu_masuk }}">
            </div>
        
            <div class="mb-4">
                <label for="checkOutTime" class="block text-sm font-medium text-gray-700">Waktu Keluar</label>
                <input type="time" id="waktu_keluar" name="waktu_keluar" class="border rounded p-2 w-full mt-1 text-xs" readonly value="{{ $item->waktu_keluar }}">
            </div>
        
            <div class="mb-4">
                <label for="status" class="block text-sm font-medium text-gray-700">Status Kehadiran</label>
                <select id="status" name="status" class="border rounded p-2 w-full mt-1 text-xs" required>
                    <option value="Hadir" {{ old('status', $item->status) == 'Hadir' ? 'selected' : '' }}>Hadir</option>
                    <option value="Izin" {{ old('status', $item->status) == 'Izin' ? 'selected' : '' }}>Izin</option>
                    <option value="Tidak Hadir" {{ old('status', $item->status) == 'Tidak Hadir' ? 'selected' : '' }}>Tidak Hadir</option>
                </select>
            </div>
        
            <div class="col-span-1 sm:col-span-2 flex justify-end mt-4">
                <a href="#">
                    <button type="cancel" class="bg-gray-400 text-white text-xs px-3 py-2 rounded shadow hover:bg-gray-500 transition duration-300 ease-in-out mr-2">Batal</button>
                </a>
                <button type="submit" class="bg-blue-400 text-white text-xs px-3 py-2 rounded shadow hover:bg-blue-500 transition duration-300 ease-in-out">Simpan</button>
            </div>            
        </form>
    </div>
</main>


@endsection