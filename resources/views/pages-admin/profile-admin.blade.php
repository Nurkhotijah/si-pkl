@extends('components.layout-admin')

@section('title', 'Profile Sekolah')

@section('content')
<body class="bg-gray-100 flex items-center justify-center h-screen font-poppins">
  <div class="max-w-4xl mx-auto bg-white shadow-lg rounded-lg overflow-hidden flex flex-col md:flex-row w-full">
    <div class="bg-gray-100 flex items-center justify-center w-full md:w-1/3 p-6">
      <div class="text-center">
        <img alt="Profile picture of the student" class="rounded-full mx-auto mb-2" height="100" src="{{ $profilesekolah->foto_profile ? asset('storage/' . $profilesekolah->foto_profile) : asset('assets/default-profile.png') }}" width="100"/>
        <h2 class="text-xl font-semibold text-gray-800">{{ $profilesekolah->name }}</h2>
        <p class="text-gray-700 text-sm">{{ $profilesekolah->role }}</p>
      </div>
    </div>
    <div class="bg-white w-full md:w-2/3 p-6">
      <h2 class="text-md font-semibold mb-4 text-gray-700">Profile Sekolah</h2>
      <p class="mb-2">
        <span class="font-semibold text-gray-700 text-sm">Nama Sekolah :</span><br/>
        <span class="text-sm text-gray-700">{{ $profilesekolah->name }}</span>
      </p>
      <p class="mb-2">
        <span class="font-semibold text-gray-700 text-sm">Email :</span><br/>
        <span class="text-sm text-gray-700">{{ $profilesekolah->email }}</span>
      </p>
      <p class="mb-2">
        <span class="font-semibold text-gray-700 text-sm">Alamat :</span><br/>
        <span class="text-sm text-gray-700">{{$profilesekolah->alamat }}</span>
      </p>
      <a href="{{ route('profile.edit') }}" class="px-4 py-2 bg-yellow-400 text-white text-sm rounded-lg shadow-lg hover:bg-yellow-500 transition duration-300 ease-in-out transform hover:scale-105">
        Edit
      </a>    
    </div>
  </div>
</body>
@endsection


