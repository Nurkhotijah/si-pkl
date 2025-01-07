@extends('components.layout-industri')

@section('title', 'Tambah Penilaian User')

@section('content')

<div class="max-w-4xl mx-auto mt-10 p-6 bg-white rounded-lg shadow-md font-poppins">
    <h1 class="text-xl font-semibold mb-6 text-center">Form Penilaian</h1>
    @if ($errors->any())
    <div class="bg-red-500 text-white p-4 mb-4">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('penilaian.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <select name="user_id" class="w-full p-3 border border-gray-300 rounded-md">
                    <option value="" disabled selected>Pilih Nama Lengkap</option>
                    @foreach ($siswa as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <select name="sikap" class="w-full p-3 border border-gray-300 rounded-md">
                    <option value="" disabled selected>Pilih Penilaian Sikap</option>
                    <option value="baik">Baik</option>
                    <option value="cukup baik">Cukup Baik</option>
                    <option value="sangat baik">Sangat Baik</option>
                </select>
            </div>

            <div>
                <select name="microteaching" class="w-full p-3 border border-gray-300 rounded-md">
                    <option value="" disabled selected>Pilih Penilaian Microteaching</option>
                    <option value="baik">Baik</option>
                    <option value="cukup baik">Cukup Baik</option>
                    <option value="sangat baik">Sangat Baik</option>
                </select>
            </div>

            <div>
                <select name="kehadiran" class="w-full p-3 border border-gray-300 rounded-md">
                    <option value="" disabled selected>Pilih Penilaian Kehadiran</option>
                    <option value="baik">Baik</option>
                    <option value="cukup baik">Cukup Baik</option>
                    <option value="sangat baik">Sangat Baik</option>
                </select>
            </div>

            <div>
                <select name="project" class="w-full p-3 border border-gray-300 rounded-md">
                    <option value="" disabled selected>Pilih Penilaian Project</option>
                    <option value="baik">Baik</option>
                    <option value="cukup baik">Cukup Baik</option>
                    <option value="sangat baik">Sangat Baik</option>
                </select>
            </div>
        </div>

        <div class="text-center mt-6">
            <button type="submit" class="bg-blue-500 text-white font-semibold text-sm py-3 px-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                Simpan
            </button>
        </div>
    </form>
</div>

@endsection
