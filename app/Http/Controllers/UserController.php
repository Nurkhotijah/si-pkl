<?php

namespace App\Http\Controllers;
use App\Models\Jurnal;
use App\Models\Profile;
use App\Models\Kehadiran;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class UserController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $today = Carbon::now()->toDateString();
    
        // Ambil data kehadiran hari ini
        $absenHariIni = Kehadiran::where('user_id', $user->id)
            ->whereDate('tanggal', $today)
            ->first();
    
        // Tentukan teks tombol "Ayo Absen"
        $buttonText = "Ayo Absen";
        if ($absenHariIni) {
            if ($absenHariIni->foto_masuk && !$absenHariIni->foto_keluar) {
                $buttonText = "Ayo Pulang";
            } elseif ($absenHariIni->foto_masuk && $absenHariIni->foto_keluar) {
                $buttonText = "Selesai";
            }
        }
    
    $jumlahHadir = Kehadiran::where('user_id', $user->id)->where('status', 'hadir')->count();
    $jumlahIzin = Kehadiran::where('user_id', $user->id)->where('status', 'izin')->count();
    $jumlahTidakHadir = Kehadiran::where('user_id', $user->id)->where('status', 'tidak hadir')->count();

    
        // Hitung jumlah jurnal
        $jumlahJurnal = Jurnal::where('user_id', $user->id)->count();
    
        return view('pages-user.Dashboard-user', compact('jumlahJurnal', 'jumlahHadir', 'jumlahIzin', 'jumlahTidakHadir', 'buttonText', 'absenHariIni'));
    }
    
    public function cetakSertifikat($id)
    {
        $siswa = User::with('profile.sekolah.user')->findOrFail($id);
    
        // Mengecek apakah siswa sudah selesai PKL
        $selesaiPKL = $siswa->profile && $siswa->profile->tanggal_selesai ? true : false;
    
        // Jika belum selesai PKL, arahkan atau beri pesan
        if (!$selesaiPKL) {
            return back()->with('error', 'Anda belum selesai PKL, sertifikat tidak bisa dicetak.');
        }
    
        // Load view dan generate PDF
        $pdf = Pdf::loadView('pages-user.pdf.sertifikatuser', compact('siswa'));
        $pdf->setPaper('A4', 'landscape');
    
        // Return PDF untuk di-download
        return $pdf->download($siswa->name . '-sertifikat.pdf');
    }
    public function showprofilsiswa()
    {
        $profilesiswa = User::with(['sekolah', 'profile', 'pengajuan.sekolah', 'pengajuan.pkl'])->findOrFail(Auth::user()->id);

        return view('pages-user.profile', compact('profilesiswa'));
    }
    public function laporanpkl()
    {
    return view('pages-user.laporan-pkl'); 
    }
}
