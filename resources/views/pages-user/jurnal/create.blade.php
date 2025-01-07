@extends('components.layout-user')

@section('title', 'Tambah Jurnal')

@section('content')
    <body class="font-poppins">
        <div class="max-w-3xl mx-auto mt-10 p-6 bg-white rounded-lg shadow-md">
            <h1 class="text-xl font-semibold mb-6 text-center">Tambah Jurnal</h1>
            
            @if ($errors->any())
                <div class="bg-red-500 text-white p-4 mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('jurnal-siswa.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="space-y-6 mb-6">
                    <!-- Deskripsi Kegiatan -->
                    <div class="flex flex-col">
                        <label for="deskripsi" class="block text-gray-700 font-medium mb-2 text-sm">Deskripsi Kegiatan</label>
                        <textarea id="kegiatan" name="kegiatan" class="w-full p-3 border border-gray-300 rounded-md text-xs" placeholder="Masukkan deskripsi kegiatan"></textarea>
                    </div>
            
                    <!-- Tanggal Laporan -->
                    <div class="flex flex-col">
                        <label for="tanggal" class="block text-gray-700 font-medium mb-2 text-sm">Tanggal Laporan</label>
                        <div class="relative">
                            <input type="date" id="tanggal" name="tanggal" class="w-full p-3 border border-gray-300 rounded-md text-sm" placeholder="dd/mm/yyyy">
                        </div>
                    </div>
            
                    <!-- Jam Mulai -->
                    <div class="flex flex-col">
                        <label for="jam-mulai" class="block text-gray-700 font-medium mb-2 text-sm">Jam Mulai</label>
                        <div class="relative">
                            <input type="time" id="waktu_mulai" name="waktu_mulai" class="w-full p-3 border border-gray-300 rounded-md text-sm" placeholder="--:--">
                        </div>
                    </div>
            
                    <!-- Jam Selesai -->
                    <div class="flex flex-col">
                        <label for="jam-selesai" class="block text-gray-700 font-medium mb-2 text-sm">Jam Selesai</label>
                        <div class="relative">
                            <input type="time" id="waktu_selesai" name="waktu_selesai" class="w-full p-3 border border-gray-300 rounded-md text-sm" placeholder="--:--">
                        </div>
                    </div>
            
                    <!-- Foto Kegiatan -->
                    <div class="flex flex-col">
                        <label for="foto_kegiatan" class="block text-gray-700 font-medium mb-2 text-sm">Foto Kegiatan</label>
                        <input type="file" id="foto_kegiatan" name="foto_kegiatan" class="w-full p-3 border border-gray-300 rounded-md text-sm">
                        <p class="mt-1 text-xs text-gray-500">Format yang diunggah harus berupa: jpeg, png, atau jpg. Ukuran maksimum: 3MB.</p>
                    </div>
                </div>
            
                <div class="text-center text-sm">
                    <button type="submit" class="bg-blue-500 text-white font-medium py-2 px-6 rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 ">
                       Simpan
                    </button>
                </div>
            </form>
              
        </div>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </body>
@endsection
