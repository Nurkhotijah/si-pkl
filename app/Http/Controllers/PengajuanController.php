<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class PengajuanController extends Controller
{
    public function index($id_pkl)
    {
        $pengajuan = Pengajuan::where('id_pkl', $id_pkl)->get();

        return view('pages-admin.pkl.pengajuan.index', compact('pengajuan', 'id_pkl'));
    }

    public function create($id_pkl) 
    {
        return view('pages-admin.pkl.pengajuan.create', compact('id_pkl')); // Pastikan view yang dimaksud sesuai
    }
    public function store(Request $request, $id_pkl)
    {
        $request->validate([
            'nama.*' => 'required|string|max:255', // Validasi array nama
            'jurusan.*' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'cv.*' => 'required|mimes:pdf|max:5000', // Validasi array CV
        ], [
            'nama.*.required' => 'Nama siswa wajib diisi.',
            'jurusan.*.required' => 'Jurusan wajib diisi.',
            'tanggal_mulai.required' => 'Tanggal mulai wajib diisi.',
            'tanggal_selesai.required' => 'Tanggal selesai wajib diisi.',
            'tanggal_selesai.after' => 'Tanggal selesai harus lebih dari tanggal mulai.',
            'cv.*.required' => 'CV wajib diunggah.',
            'cv.*.mimes' => 'File CV harus berupa PDF.',
            'cv.*.max' => 'File CV maksimal 5MB.',
        ]);
    
        $users = Auth::user(); // Mendapatkan data pengguna yang login
    
        // Loop untuk menyimpan setiap siswa yang diinput
        foreach ($request->nama as $index => $nama) {
            // Simpan file CV dengan indeks yang sesuai
            if ($request->hasFile('cv') && isset($request->cv[$index])) {
                $filePath = $request->cv[$index]->store('cv_siswa', 'public');
            } else {
                $filePath = null;
            }
    
            // Simpan data siswa ke dalam database
            Pengajuan::create([
                'nama' => $nama,
                'jurusan' => $request->jurusan[$index],
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'cv_file' => $filePath,
                'status_persetujuan' => 'pending',
                'id_pkl' => $id_pkl, // ID PKL
                'id_sekolah' => $users->sekolah->id, // ID Sekolah yang login
            ]);
        }
    
        return redirect()->route('pengajuan.index', $id_pkl)
        ->with('success', 'Pengajuan siswa berhasil diajukan.');
    }

    public function edit($id)
    {
    $pengajuan = Pengajuan::findOrFail($id);
    return view('pages-admin.pkl.pengajuan.edit', compact('pengajuan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jurusan' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'cv' => 'nullable|mimes:pdf|max:5000', // CV tidak wajib diubah
        ], [
            'nama.required' => 'Nama siswa wajib diisi.',
            'jurusan.required' => 'Jurusan wajib diisi.',
            'tanggal_mulai.required' => 'Tanggal mulai wajib diisi.',
            'tanggal_selesai.required' => 'Tanggal selesai wajib diisi.',
            'tanggal_selesai.after' => 'Tanggal selesai harus lebih dari tanggal mulai.',
            'cv.mimes' => 'File CV harus berupa PDF.',
            'cv.max' => 'File CV maksimal 5MB.',
        ]);

        $pengajuan = Pengajuan::findOrFail($id);
        
        // Jika ada file baru yang diunggah
        if ($request->hasFile('cv')) {
            // Hapus file lama jika ada
            if ($pengajuan->cv_file) {
                Storage::disk('public')->delete($pengajuan->cv_file);
            }

            // Simpan file CV baru
            $filePath = $request->file('cv')->store('cv_siswa', 'public');
            $pengajuan->cv_file = $filePath;
        }

        // Update data
        $pengajuan->update([
            'nama' => $request->nama,
            'jurusan' => $request->jurusan,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
        ]);


        return redirect()->route('pengajuan.index', ['id_pkl' => $pengajuan->id_pkl])
        ->with('success', 'Pengajuan siswa berhasil diperbarui.');;
    }
    
    public function destroy($id)
    {
        // Cari pengajuan siswa berdasarkan ID
        $pengajuan = Pengajuan::find($id);

        // Periksa apakah data pengajuan ditemukan
        if (!$pengajuan) {
            return response()->json([
                'status' => 'error',
                'message' => 'Pengajuan siswa tidak ditemukan'
            ], 404);
        }

        // Hapus file CV jika ada
        if ($pengajuan->cv_file && Storage::exists('public/' . $pengajuan->cv_file)) {
            Storage::delete('public/' . $pengajuan->cv_file);
        }

        // Hapus data pengajuan siswa dari database
        $pengajuan->delete();

        // Kembali ke halaman yang sama dengan pesan sukses
        return redirect()->back()->with('success', 'Pengajuan siswa berhasil dihapus.');
    }

}
