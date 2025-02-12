@extends('components.layout-industri')

@section('title', 'Tambah Penilaian Siswa')

@section('content')

<div class="max-w-2xl mx-auto mt-10 p-6 bg-white rounded-lg shadow-md font-poppins">
    <h1 class="text-xl font-semibold mb-6 text-center">Tambah Penilaian</h1>
    <form action="{{ route('penilaian.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 gap-6">
            <div>
                <select name="user_id" id="user_id" class="w-full p-3 border @error('user_id') border-red-500 @else border-gray-300 @enderror rounded-md" onchange="clearError('user_id')">
                    <option value="" disabled selected>Pilih Siswa</option>
                    @foreach ($siswa as $item)
                        <option value="{{ $item->id }}" {{ old('user_id') == $item->id ? 'selected' : '' }}>
                            {{ $item->name }} - {{ $item->profile->sekolah->nama }}
                        </option>
                    @endforeach
                </select>                
                @error('user_id')
                    <p id="error-user_id" class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>
    
            <div>
                <select name="sikap" id="sikap" class="w-full p-3 border @error('sikap') border-red-500 @else border-gray-300 @enderror rounded-md" onchange="clearError('sikap')">
                    <option value="" disabled selected>Pilih Penilaian Sikap</option>
                    <option value="baik" {{ old('sikap') == 'baik' ? 'selected' : '' }}>Baik</option>
                    <option value="cukup baik" {{ old('sikap') == 'cukup baik' ? 'selected' : '' }}>Cukup Baik</option>
                    <option value="sangat baik" {{ old('sikap') == 'sangat baik' ? 'selected' : '' }}>Sangat Baik</option>
                </select>
                @error('sikap')
                    <p id="error-sikap" class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>
    
            <div>
                <select name="microteaching" id="microteaching" class="w-full p-3 border @error('microteaching') border-red-500 @else border-gray-300 @enderror rounded-md" onchange="clearError('microteaching')">
                    <option value="" disabled selected>Pilih Penilaian Microteaching</option>
                    <option value="baik" {{ old('microteaching') == 'baik' ? 'selected' : '' }}>Baik</option>
                    <option value="cukup baik" {{ old('microteaching') == 'cukup baik' ? 'selected' : '' }}>Cukup Baik</option>
                    <option value="sangat baik" {{ old('microteaching') == 'sangat baik' ? 'selected' : '' }}>Sangat Baik</option>
                </select>
                @error('microteaching')
                    <p id="error-microteaching" class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>
    
            <div>
                <select name="kehadiran" id="kehadiran" class="w-full p-3 border @error('kehadiran') border-red-500 @else border-gray-300 @enderror rounded-md" onchange="clearError('kehadiran')">
                    <option value="" disabled selected>Pilih Penilaian Kehadiran</option>
                    <option value="baik" {{ old('kehadiran') == 'baik' ? 'selected' : '' }}>Baik</option>
                    <option value="cukup baik" {{ old('kehadiran') == 'cukup baik' ? 'selected' : '' }}>Cukup Baik</option>
                    <option value="sangat baik" {{ old('kehadiran') == 'sangat baik' ? 'selected' : '' }}>Sangat Baik</option>
                </select>
                @error('kehadiran')
                    <p id="error-kehadiran" class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>
    
            <div>
                <select name="project" id="project" class="w-full p-3 border @error('project') border-red-500 @else border-gray-300 @enderror rounded-md" onchange="clearError('project')">
                    <option value="" disabled selected>Pilih Penilaian Project</option>
                    <option value="baik" {{ old('project') == 'baik' ? 'selected' : '' }}>Baik</option>
                    <option value="cukup baik" {{ old('project') == 'cukup baik' ? 'selected' : '' }}>Cukup Baik</option>
                    <option value="sangat baik" {{ old('project') == 'sangat baik' ? 'selected' : '' }}>Sangat Baik</option>
                </select>
                @error('project')
                    <p id="error-project" class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>
        </div>
    
        <div class="text-center mt-6">
            <button type="submit" class="bg-blue-500 text-white font-semibold text-sm py-3 px-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                Simpan
            </button>
        </div>
    </form>    
</div>

<script>
    function clearError(field) {
        // Hapus pesan error
        let errorText = document.getElementById("error-" + field);
        if (errorText) {
            errorText.style.display = "none";
        }

        // Hapus border merah
        let inputField = document.getElementById(field);
        if (inputField) {
            inputField.classList.remove("border-red-500");
            inputField.classList.add("border-gray-300");
        }
    }
</script>


@endsection
