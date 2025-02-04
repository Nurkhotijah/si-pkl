@extends('components.layout-admin')

@section('title', 'Tambah Data PKL Siswa')

@section('content')
<div class="bg-gray-100 flex items-center justify-center font-poppins">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-3xl">
        <h2 class="text-xl font-semibold mb-6 text-center">Tambah Data PKL</h2>

        <main class="p-6 overflow-y-auto h-full">
            @if(session('error'))
                <div class="bg-red-500 text-white p-3 rounded mb-4 text-center">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('pkl.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="judul" class="block text-sm font-medium text-gray-700">Judul PKL</label>
                    <input type="text" name="judul" id="judul" class="w-full p-2 border rounded @error('judul') border-red-500 @enderror" value="{{ old('judul') }}">
                    @error('judul')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="tahun" class="block text-sm font-medium text-gray-700">Tahun</label>
                    <input type="text" name="tahun" id="tahun" class="w-full p-2 border rounded @error('tahun') border-red-500 @enderror" value="{{ old('tahun') }}">
                    @error('tahun')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="pembimbing" class="block text-sm font-medium text-gray-700">Nama Pembimbing</label>
                    <input type="text" name="pembimbing" id="pembimbing" class="w-full p-2 border rounded @error('pembimbing') border-red-500 @enderror" value="{{ old('pembimbing') }}">
                    @error('pembimbing')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="lampiran" class="block text-sm font-medium text-gray-700">Lampiran</label>
                    <input type="file" name="lampiran" id="lampiran" accept=".pdf" class="w-full p-2 border rounded @error('lampiran') border-red-500 @enderror">
                    @error('lampiran')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="text-center text-sm">
                    <button type="submit" class="bg-blue-500 text-white font-medium py-2 px-6 rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Simpan
                    </button>
                </div>
            </form>
        </main>
    </div>
</div>
@endsection
