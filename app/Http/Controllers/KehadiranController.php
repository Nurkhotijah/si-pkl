<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Kehadiran;
use App\Models\Profile;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class KehadiranController extends Controller
{
    
    public function index(Request $request)
{
    $query = Kehadiran::where('user_id', Auth::id());

    // Filter berdasarkan tanggal jika tersedia
    if ($request->has('tanggal') && $request->tanggal) {
        $query->whereDate('tanggal', $request->tanggal);
    }

    // Ambil semua data kehadiran
    $kehadiran = $query->orderBy('tanggal', 'desc')->get();

    // Cek apakah user sudah absen atau izin hari ini
    $todayRecord = Kehadiran::where('user_id', Auth::id())
        ->whereDate('tanggal', now()->toDateString())
        ->first();
    
    $sudahAbsen = $todayRecord && $todayRecord->foto_masuk;
    $sudahIzin = $todayRecord && $todayRecord->foto_izin;

    // Ambil data profile untuk mengecek tanggal selesai PKL
    $profile = Profile::where('user_id', Auth::id())->first();

    // Cek apakah PKL sudah selesai
    $isPklSelesai = $profile ? Carbon::parse($profile->tanggal_selesai)->isPast() : false;

    return view('pages-user.riwayat-absensi', compact('kehadiran', 'isPklSelesai'));
    }

    public function store(Request $request)
{
    // Cek apakah user sudah absen atau izin hari ini
    $todayRecord = Kehadiran::where('user_id', Auth::id())
        ->whereDate('tanggal', now()->toDateString())
        ->first();

    if ($todayRecord) {
        if ($todayRecord->foto_masuk && $request->hasFile('foto_izin')) {
            return response()->json(['message' => 'Anda sudah absen hari ini, tidak bisa mengajukan izin!'], 403);
        }
        if ($todayRecord->foto_izin && $request->hasFile('foto_masuk')) {
            return response()->json(['message' => 'Anda sudah mengajukan izin hari ini, tidak bisa absen!'], 403);
        }
    }

    // Validasi input
    $request->validate([
        'foto_keluar' => 'nullable|image|mimes:jpeg,png,jpg|max:5000', 
        'foto_masuk' => 'nullable|image|mimes:jpeg,png,jpg|max:5000', 
        'foto_izin' => 'nullable|image|mimes:jpeg,png,jpg|max:5000', 
    ]);

    // Menyimpan foto masuk jika ada
    if ($request->hasFile('foto_masuk')) {
        $fotoMasuk = $request->file('foto_masuk')->store('kehadiran/masuk', 'public');
    } else {
        $fotoMasuk = null;
    }

    // Menyimpan foto izin jika ada
    if ($request->hasFile('foto_izin')) {
        $fotoIzin = $request->file('foto_izin')->store('kehadiran/izin', 'public');
    } else {
        $fotoIzin = null;
    }

    // Menentukan status kehadiran
    $status = $fotoIzin ? 'Izin' : 'Hadir';

    if ($request->id) {
        // Update data kehadiran
        Kehadiran::find($request->id)?->update([
            'waktu_keluar' => $status === 'Hadir' ? now()->toTimeString() : null,
            'foto_keluar' => $fotoMasuk,
        ]);
    } else {
        // Menyimpan data kehadiran
        Kehadiran::create([
            'user_id' => Auth::id(),
            'sekolah_id' => Auth::user()->profile->id_sekolah,
            'tanggal' => now(),
            'waktu_masuk' => $status === 'Hadir' ? now()->toTimeString() : null,
            'status' => $status,
            'foto_masuk' => $fotoMasuk,
            'foto_izin' => $fotoIzin,
        ]);
    }

    return response()->json(['message' => 'Kehadiran berhasil disimpan!']);
    }

    public function rekapkehadiran()
    {
        $user = Auth::user();
        
        // Ambil data profile untuk mendapatkan nama, sekolah, tanggal mulai dan selesai PKL
        $profile = Profile::where('user_id', $user->id)->first();
        if (!$profile) {
            return redirect()->back()->withErrors('Data profil tidak ditemukan.');
        }
    
        // Ambil tanggal mulai dan selesai PKL dari profil
        $tanggalMulai = Carbon::parse($profile->tanggal_mulai)->startOfDay();
        $tanggalSelesai = Carbon::parse($profile->tanggal_selesai)->endOfDay();
    
        // Hitung jumlah kehadiran berdasarkan status 'Hadir'
        $hadirCount = Kehadiran::where('user_id', $user->id)
            ->where('status', 'hadir')
            ->count();
    
        // Hitung jumlah izin berdasarkan status 'Izin'
        $izinCount = Kehadiran::where('user_id', $user->id)
            ->where('status', 'izin')
            ->count();
    
        // Hitung jumlah tidak hadir berdasarkan status 'Tidak Hadir'
        $tidakHadirCount = Kehadiran::where('user_id', $user->id)
            ->where('status', 'tidak hadir')
            ->count();
    
        // Total kehadiran berdasarkan status
        $total = $hadirCount + $izinCount + $tidakHadirCount;
    
        // Menyusun data untuk PDF
        $data = [
            'user' => $user,
            'profile' => $profile,
            'hadirCount' => $hadirCount,
            'izinCount' => $izinCount,
            'tidakHadirCount' => $tidakHadirCount,
            'total' => $total,
            'tanggalMulai' => $tanggalMulai->format('Y-m-d'),
            'tanggalSelesai' => $tanggalSelesai->format('Y-m-d'),
        ];
    
        // Membuat PDF menggunakan template
        $pdf = PDF::loadView('template-kehadiran', $data);
    
        // Mengunduh PDF
        return $pdf->download('rekap-kehadiran-' . $user->name . '.pdf');
    }
    
}    