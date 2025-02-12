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
        'name' => ['required', 'string', 'max:255', 'regex:/^[A-Za-z0-9\s]+$/'],
        'email' => 'required|string|email|max:255|unique:users|regex:/^.+@.+\..+$/',
        'alamat' => ['required', 'string', 'max:255', 'regex:/^[A-Za-z0-9\s]+$/'],
        'password' => 'required|string|min:5',
        'agreement' => 'accepted',
    ], [
        'name.required' => 'Nama Sekolah wajib diisi.',
        'name.regex' => 'Nama Sekolah hanya boleh mengandung huruf dan angka, tanpa simbol atau emoji.',
        'email.required' => 'Email wajib diisi.',
        'email.email' => 'Format email tidak valid.',
        'email.unique' => 'Email sudah terdaftar, silakan gunakan email lain.',
        'email.regex' => 'Email harus mengandung tanda @ dan format yang benar.',
        'alamat.required' => 'Alamat wajib diisi.',
        'alamat.regex' => 'Alamat hanya boleh mengandung huruf dan angka, tanpa simbol atau emoji.',
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