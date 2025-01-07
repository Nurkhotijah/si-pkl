@extends('components.layout-admin')

@section('title', 'Tambah Pengajuan Siswa')

@section('content')
<div class="bg-gray-100  flex items-center justify-center font-poppins">
    <!-- Tambahkan margin atas untuk menaikkan kotak -->
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-3xl">
        <h2 class="text-xl font-semibold mb-6 text-center">Tambah Data PKL</h2>
        @if ($errors->any())
            <div class="bg-red-500 text-white p-4 mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="">
            <main class="p-6 overflow-y-auto h-full">
                    <form action="{{ route('pkl.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="judul" class="block text-sm font-medium text-gray-700">Judul PKL</label>
                            <input type="text" name="judul" id="judul" class="w-full p-2 border rounded" required>
                        </div>
                        <div class="mb-4">
                            <label for="tahun" class="block text-sm font-medium text-gray-700">Tahun</label>
                            <input type="text" name="tahun" id="tahun" class="w-full p-2 border rounded" required>
                        </div>
                        <div class="mb-4">
                            <label for="pembimbing" class="block text-sm font-medium text-gray-700">Nama Pembimbing</label>
                            <input type="text" name="pembimbing" id="pembimbing" class="w-full p-2 border rounded" required>
                        </div>
                        <div class="mb-4">
                            <label for="lampiran" class="block text-sm font-medium text-gray-700">Lampiran</label>
                            <input type="file" name="lampiran" id="lampiran" accept=".pdf" class="w-full p-2 border rounded" required>
                            <p class="text-xs text-gray-500 mt-1">Upload berupa PDF, maksimum 5MB</p>
                        </div>                        
                        <div class="text-center text-sm">
                            <button type="submit" class="bg-blue-500 text-white font-medium py-2 px-6 rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 ">
                               Simpan
                            </button>
                        </div>                    
                    </form>
                </div>
            </main>
        </div>

@endsection
