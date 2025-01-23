<?php

namespace App\Http\Controllers;

use App\Models\Penilaian;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;


class PenilaianController extends Controller
{
    public function showuser()
    {
        // Ambil penilaian berdasarkan user ID yang sedang login
        $penilaian = Penilaian::with('user')
            ->where('user_id', auth()->user()->id)
            ->first();
    
        // Jika penilaian tidak ditemukan, tampilkan alert
        if (!$penilaian) {
            return redirect()->action([JurnalSiswaController::class, 'index'])
                ->with('alert', 'Data penilaian Anda belum tersedia.');
        }
    
        // Tentukan tanggal mulai dan selesai
        $tanggalMulai = $penilaian->tanggal_mulai;
        $tanggalSelesai = $penilaian->tanggal_selesai;
    
        // Jika penilaian ditemukan, buat PDF dan download
        $pdf = Pdf::loadView('template-penilaian', compact('penilaian', 'tanggalMulai', 'tanggalSelesai'));
        $pdf->setPaper('A4', 'portrait');
        return $pdf->download('Laporan_Penilaian_PKL.pdf');
    }
    
}
