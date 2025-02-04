<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Sekolah;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
{
    // Validasi input
    $validated = $request->validate([
        'name' => 'required|string|max:255', // Nama Sekolah atau Username wajib diisi
        'email' => 'required|string|email|max:255|unique:users', // Email harus unik
        'alamat' => 'required|string|max:255', // Alamat wajib diisi
        'password' => 'required|string|min:5', // Password minimal 5 karakter
        'agreement' => 'accepted', // Validasi checkbox persetujuan
    ], [
        'name.required' => 'Nama Sekolah wajib diisi.',
        'email.required' => 'Email wajib diisi.',
        'email.email' => 'Format email tidak valid.',
        'email.unique' => 'Email sudah terdaftar, silakan gunakan email lain.',
        'alamat.required' => 'Alamat wajib diisi.',
        'password.required' => 'Kata sandi wajib diisi.',
        'password.min' => 'Kata sandi harus minimal 5 karakter.',
        'agreement.accepted' => 'Anda harus menyetujui kebijakan dan ketentuan penggunaan.',
    ]);

    // Simpan data user ke database
    $user = User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'alamat' => $validated['alamat'],
        'password' => Hash::make($validated['password']),
        'role' => 'sekolah',
    ]);

    // Tambahkan role sekolah
    $user->assignRole('sekolah');

    Profile::create([
        'user_id' => $user->id,
        'alamat' => $validated['alamat']
    ]);

    Sekolah::create([
        'user_id' => $user->id,
        'nama' => $validated['name'],
        'alamat' => $validated['alamat']
    ]);

    return redirect()->route('login')->with('success', 'Registrasi berhasil. Silakan login.');
}

}