@extends('components.layout-user')

@section('title', 'Profile Siswa')

@section('content')
<body class="bg-gray-100 flex items-center justify-center h-screen font-poppins">
  <div class="max-w-4xl mx-auto bg-white shadow-lg rounded-lg overflow-hidden flex flex-col md:flex-row w-full">
    <div class="bg-gray-100 flex items-center justify-center w-full md:w-1/3 p-6">
      <div class="text-center">
        <img alt="Profile picture of the student" class="rounded-full mx-auto mb-2" height="100" src="{{ asset(Auth::user()->foto_profile ?? 'assets/default-profile.png') }}" width="100"/>
        <h2 class="text-xl font-semibold text-gray-800">{{ Auth::user()->name }}</h2>
        <p class="text-gray-700 text-sm">{{ $profilesiswa->role }}</p>
      </div>
    </div>
    <div class="bg-white w-full md:w-2/3 p-6">
      <h2 class="text-md font-semibold mb-4 text-gray-700">Informasi Siswa</h2>
      <p class="mb-2">
        <span class="font-semibold text-gray-700 text-sm">Nama Sekolah :</span><br/>
        <span class="text-sm text-gray-700">{{ $profilesiswa->profile->sekolah->nama }}</span>
      <p class="mb-2">
        <span class="font-semibold text-gray-700 text-sm">Jurusan :</span><br/>
        <span class="text-sm text-gray-700">{{ $profilesiswa->profile->jurusan }}</span>
      </p>
      <p class="mb-2">
        <span class="font-semibold text-gray-700 text-sm">Tanggal Mulai PKL :</span><br/>
        <span class="text-sm text-gray-700">{{ \Carbon\Carbon::parse($profilesiswa->profile->tanggal_mulai)->translatedFormat('d F Y') }}</span>
      </p>
      <p class="mb-2">
        <span class="font-semibold text-gray-700 text-sm">Tanggal Selesai PKL :</span><br/>
        <span class="text-sm text-gray-700">{{ \Carbon\Carbon::parse($profilesiswa->profile->tanggal_selesai)->translatedFormat('d F Y') }}</span>
      </p>
    </div>
  </div>
</body>
@endsection