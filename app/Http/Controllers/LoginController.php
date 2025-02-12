<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Notification;
use App\Mail\LoginNotificationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Tampilkan form login.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('login'); // Pastikan Anda memiliki file login.blade.php
    }

    // Proses login
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|regex:/^[a-zA-Z0-9@.]+$/',
            'password' => 'required|min:5|regex:/^[a-zA-Z0-9]+$/',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.regex' => 'Email hanya boleh mengandung huruf, angka, titik, dan @.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal 5 karakter.',
            'password.regex' => 'Kata sandi hanya boleh mengandung huruf dan angka, tanpa karakter khusus atau emoticon.',
        ]);
    
        // Jika validasi gagal, kembalikan dengan semua pesan error
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    
        // Cek apakah email terdaftar
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors([
                'email' => 'Email ini belum terdaftar.',
                'password' => 'Silakan periksa kembali kata sandi Anda.', // Pesan tambahan agar muncul error juga di password
            ])->withInput();
        }
    
        // Cek apakah password benar
        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            return back()->withErrors([
                'password' => 'Kata sandi salah.',
            ])->withInput();
        }
    
        // Logout semua guard sebelum login
        Auth::guard('industri')->logout();
        Auth::guard('sekolah')->logout();
        Auth::logout();
    
        // Cek role user dan arahkan ke halaman dashboard sesuai role
        if ($user->role === 'industri') {
            if (Auth::guard('industri')->attempt($request->only('email', 'password'))){
                $request->session()->regenerate();
                Mail::to($user->email)->send(new LoginNotificationMail($user));
                return redirect()->route('industri.dashboard')->with('success', 'Login successful!');
            } 
        } elseif ($user->role === 'sekolah') {
            if (Auth::guard('sekolah')->attempt($request->only('email', 'password'))){
                $request->session()->regenerate();
                Mail::to($user->email)->send(new LoginNotificationMail($user));

                // Simpan log login
        Notification::create([
            'user_id' => $user->id,
            'message' => $user->name . ' telah login.',
        ]);
                return redirect()->route('admin.dashboard')->with('success', 'Login successful!');
            }
        } elseif ($user->role === 'siswa') {
            if (Auth::attempt($request->only('email', 'password'))){
                $request->session()->regenerate();
                Mail::to($user->email)->send(new LoginNotificationMail($user));
                return redirect()->route('user.dashboard')->with('success', 'Login successful!');
            }
        }
    
        return back()->withErrors(['email' => 'Invalid email or password.']);
    }
    
        public function logout(Request $request)
        {
            Auth::logout();
            $request->session()->invalidate();
     
            $request->session()->regenerateToken();
    
            return redirect('/login')->with('success', 'Anda berhasil logout.');       
        }
        public function logoutsekolah(Request $request)
        {
            $user = Auth::guard('sekolah')->user();            
            if ($user) {
                // Simpan log logout
                Notification::create([
                    'user_id' => $user->id,
                    'message' => $user->name . ' telah logout.',
                ]);
            }
        
            Auth::guard('sekolah')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
    
            return redirect('/login')->with('success', 'Anda berhasil logout.');       
        }
        public function logoutindustri(Request $request)
        {
            Auth::guard('industri')->logout();
            $request->session()->invalidate();
            
     
            $request->session()->regenerateToken();
    
            return redirect('/login')->with('success', 'Anda berhasil logout.');       
        }
    }
