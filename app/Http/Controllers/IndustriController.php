<?php

namespace App\Http\Controllers;

use App\Models\Jurnal;
use App\Models\Pengajuan;
use App\Models\Kehadiran;
use App\Models\Penilaian;
use App\Models\Pkl;
use App\Models\Profile;
use App\Models\User;
use App\Models\Sekolah; 
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Mail\SekolahAcceptedMail;
use App\Mail\SiswaAccountEmail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class IndustriController extends Controller
{
    public function dashboard()
    {
        $jumlahsiswa = User::where('role', 'siswa')->count(); // Menghitung jumlah pengguna dengan role siswa
        $jumlahsekolah = User::where('role', 'sekolah')->count(); // Menghitung jumlah pengguna dengan role sekolah
        $jumlahjurnal = Jurnal::count();
        $jumlahkehadiran = Kehadiran::count();
    
        return view('pages-industri.dashboard-industri', compact('jumlahjurnal', 'jumlahkehadiran', 'jumlahsiswa', 'jumlahsekolah'));
    }

/* -------------------------------------------------------------------------- */
/*                                  START KEHADIRAN                           */
/* -------------------------------------------------------------------------- */
public function Kehadiran(Request $request)
{
    $search = $request->input('search'); // Ambil input pencarian

    // Query untuk mengambil data kehadiran berdasarkan pencarian
    $kehadiranQuery = Kehadiran::select('user_id')
        ->distinct()
        ->with(['user', 'profile.sekolah']);

    if ($search) {
        $kehadiranQuery->whereHas('user', function ($query) use ($search) {
            $query->where('name', 'like', "%$search%"); // Pencarian berdasarkan nama user
        })
        ->orWhereHas('profile.sekolah', function ($query) use ($search) {
            $query->where('nama', 'like', "%$search%"); // Pencarian berdasarkan nama sekolah
        });
    }

    $kehadiran = $kehadiranQuery->get(); // Ambil data kehadiran yang sudah difilter

    return view('pages-industri.kelola-kehadiran', compact('kehadiran'));
}

    public function detail($userId, Request $request)
    {
        // Ambil tanggal dari parameter request, jika ada
        $tanggal = $request->get('tanggal');
        
        // Query untuk mendapatkan data kehadiran berdasarkan user_id
        $kehadiranQuery = Kehadiran::where('user_id', $userId);
    
        // Jika ada tanggal yang dipilih, filter berdasarkan tanggal
        if ($tanggal) {
            $kehadiranQuery->whereDate('tanggal', $tanggal);
        }
    
        // Ambil data kehadiran, urutkan berdasarkan tanggal terbaru
        $kehadiran = $kehadiranQuery->orderBy('tanggal', 'desc')->get();
    
        // Kirimkan data kehadiran dan tanggal ke view
        return view('pages-industri.detail-kehadiran', compact('kehadiran', 'tanggal', 'userId'));
    }
    
    public function cetakkehadiranuser($userId)
    {
    // Ambil semua data kehadiran untuk user berdasarkan user_id
    $kehadiran = Kehadiran::where('user_id', $userId)->get();

    // Jika tidak ada data kehadiran untuk user ini
    if ($kehadiran->isEmpty()) {
        return abort(404, 'Data kehadiran tidak ditemukan');
    }

    // Ambil data user dan sekolah berdasarkan kehadiran
    $user = $kehadiran->first()->user;

    // Ambil data profile untuk tanggal mulai dan selesai PKL
    $profile = Profile::where('user_id', $userId)->first();
    $tanggalMulai = $profile ? $profile->tanggal_mulai : 'Tanggal Mulai Tidak Tersedia';
    $tanggalSelesai = $profile ? $profile->tanggal_selesai : 'Tanggal Selesai Tidak Tersedia';

    // Hitung jumlah kehadiran untuk status tertentu
    $hadirCount = $kehadiran->where('status', 'hadir')->count();
    $izinCount = $kehadiran->where('status', 'izin')->count();
    $tidakHadirCount = $kehadiran->where('status', 'tidak hadir')->count();
    $total = $kehadiran->count();

    // Siapkan data untuk PDF
    $data = [
        'user' => $user,
        'kehadiran' => $kehadiran,
        'hadirCount' => $hadirCount,
        'izinCount' => $izinCount,
        'tidakHadirCount' => $tidakHadirCount,
        'total' => $total,
        'tanggalMulai' => $tanggalMulai,
        'tanggalSelesai' => $tanggalSelesai,
    ];

    // Muat view dan siapkan PDF
    $pdf = PDF::loadView('template-kehadiran', $data);

    // Kembalikan PDF sebagai download
    return $pdf->download('laporan_kehadiran_' . $user->name . '.pdf');
    }
     public function edit($id)
    {
        $item = Kehadiran::with('user')->find($id);
        $item = Kehadiran::findOrFail($id);
        return view('pages-industri.edit-kehadiran', compact('item'));
    }

    public function update(Request $request, $userId)
{
    // dd($userId);
    // Cari data kehadiran berdasarkan userId
    $kehadiran = Kehadiran::findOrFail($userId);
    $userdataid = $kehadiran->user_id;
    // Validasi permintaan untuk status kehadiran
    $request->validate([
        'status' => 'required|string', // Pastikan status ada dan berupa string
    ]);

    // Perbarui status kehadiran
    $kehadiran->status = $request->status;
    // dd ($request->status);
    // Jika status adalah 'tidak hadir', set kolom tertentu menjadi null
    if ($request->status === 'Tidak Hadir') {
        $kehadiran->foto_masuk = null;
        $kehadiran->foto_keluar = null;
        $kehadiran->waktu_masuk = null;
        $kehadiran->waktu_keluar = null;
    }

    // Simpan perubahan ke database
    $kehadiran->save();

    // Ambil semua data kehadiran untuk ditampilkan di halaman kelola-kehadiran
    $dataKehadiran = Kehadiran::with('user')->get();

    // Redirect kembali ke halaman detail kehadiran dengan pesan sukses
    return redirect()->route('kehadiran.detail', ['userId' => $userdataid ])
        ->with([
            'kehadiran' => $dataKehadiran,
            'success' => 'Status kehadiran berhasil diperbarui',
        ]);
}

/* -------------------------------------------------------------------------- */
/*                                  END KEHADIRAN                             */
/* -------------------------------------------------------------------------- */

/* -------------------------------------------------------------------------- */
/*                                  START PENGAJUAN                           */
/* -------------------------------------------------------------------------- */
     public function dataSekolah()
    {
        
        $listSekolah = User::where('role', 'sekolah')->get();
       

        return view('pages-industri.sekolah.index', compact('listSekolah'));
    }

    public function showpkl(Request $request, string $id)
{
    // Ambil input pencarian
    $search = $request->input('search');

    // Filter data berdasarkan id_sekolah dan input pencarian
    $listSekolah = Pkl::where('id_sekolah', $id)
        ->where(function ($query) use ($search) {
            if ($search) {
                $query->where('tahun', 'like', "%$search%")
                      ->orWhere('judul_pkl', 'like', "%$search%")
                      ->orWhere('pembimbing', 'like', "%$search%");
            }
        })
        ->get();

    return view('pages-industri.sekolah.show', compact('listSekolah'));
}


public function updateStatusSiswa(Request $request)
{
    $validated = $request->validate([
        'id' => 'required',
        'status' => 'required',
    ]);

    $id = $validated['id'];
    $status = $validated['status'];

    // Mendapatkan data pengajuan siswa berdasarkan ID
    $pengajuanSiswa = Pengajuan::with('sekolah.user')->find($id);

    if (!$pengajuanSiswa) {
        \Log::error("Data tidak ditemukan untuk ID: $id");
        return response()->json([
            'success' => false,
            'message' => 'Data siswa tidak ditemukan.',
        ], 404);
    }

    // Update status siswa
    $pengajuanSiswa->status_persetujuan = $status;
    if (!$pengajuanSiswa->save()) {
        \Log::error("Gagal memperbarui status untuk ID: $id, Status: $status");
        return response()->json([
            'success' => false,
            'message' => 'Gagal memperbarui status siswa.',
        ], 500);
    }

    \Log::info("Status berhasil diperbarui untuk ID: $id, Status: $status");

    // Logika tambahan: Hanya buat akun siswa dan kirim email jika status diterima
    if ($status === 'diterima') {
        // Membuat akun siswa
        $this->createSiswaAccount($pengajuanSiswa);

        // Mengirim email ke sekolah
        $sekolahEmail = $pengajuanSiswa->sekolah->user->email ?? null;

        if ($sekolahEmail) {
            try {
                Mail::to($sekolahEmail)->send(new SiswaAccountEmail($pengajuanSiswa));
            } catch (\Exception $e) {
                \Log::error("Gagal mengirim email: " . $e->getMessage());
                return response()->json([
                    'success' => false,
                    'message' => 'Status berhasil diperbarui, tetapi email gagal dikirim.',
                ], 500);
            }
        }
    }

    return response()->json([
        'success' => true,
        'message' => "Status siswa telah diperbarui menjadi {$status}.",
    ]);
}

protected function createSiswaAccount(Pengajuan $pengajuanSiswa)
{
    // Membuat email yang unik
    $email = preg_replace('/\s+/', '-', $pengajuanSiswa->nama) . '@gmail.com';
    
    // Pastikan emailnya unik
    $email = $this->generateUniqueEmail($email, $pengajuanSiswa);

    $user = User::create([
        'name' => $pengajuanSiswa->nama,
        'email' => $email,
        'password' => bcrypt('siswa123'),
        'role' => 'siswa',
        'id_sekolah' => $pengajuanSiswa->id_sekolah,
    ]);

    Profile::create([
        'user_id' => $user->id,
        'id_sekolah' => $pengajuanSiswa->id_sekolah,
        'alamat' => null,
        'jurusan' => $pengajuanSiswa->jurusan,
        'tanggal_mulai' => $pengajuanSiswa->tanggal_mulai,
        'tanggal_selesai' => $pengajuanSiswa->tanggal_selesai,
        'cv_file' => $pengajuanSiswa->cv_file,
    ]);
}


protected function generateUniqueEmail($email, $pengajuanSiswa)
{
    $originalEmail = $email;
    $counter = 1;

    // Cek apakah email sudah ada di database
    while (User::where('email', $email)->exists()) {
        // Jika sudah ada, tambahkan angka atau ID untuk membuat email unik
        $email = preg_replace('/@gmail\.com$/', '-' . $pengajuanSiswa->id . '-' . $counter . '@gmail.com', $originalEmail);
        $counter++;
    }

    return $email;
}

/* -------------------------------------------------------------------------- */
/*                                  END PENGAJUAN                             */
/* -------------------------------------------------------------------------- */

/* -------------------------------------------------------------------------- */
/*                                  START PENILAIAN                           */
/* -------------------------------------------------------------------------- */
    public function indexpenilaian()
    {
        $penilaian = Penilaian::with(['user.profile.sekolah'])
    ->whereHas('user.profile.sekolah')
    ->get();

        return view('pages-industri.penilaian.index', compact('penilaian'));
    }

    public function create()
    {
        $siswa = User::where('role', 'siswa')->get();
        $sekolah = Profile::with('sekolah')->get();
        return view('pages-industri.penilaian.create', compact('siswa', 'sekolah'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'sikap' => 'required|string',
            'microteaching' => 'required|string', 
            'kehadiran' => 'required|string',
            'project' => 'required|string',
        ]);

        Penilaian::create($validated);

        return redirect()->route('penilaian.index')
            ->with('success', 'Penilaian berhasil disimpan!');
    }

    public function show($id)
{
    $penilaian = Penilaian::with(['user.sekolah.profile'])->findOrFail($id);

    // Ambil tanggal mulai dan selesai dari tabel profile
    $tanggalMulai = Carbon::parse($penilaian->user->profile->tanggal_mulai)->translatedFormat('d F Y');
    $tanggalSelesai = Carbon::parse($penilaian->user->profile->tanggal_selesai)->translatedFormat('d F Y');

    return view('pages-industri.penilaian.show', compact('penilaian', 'tanggalMulai', 'tanggalSelesai'));
    }

    public function destroy($id)
    {
    // Cari data penilaian berdasarkan ID
    $penilaian = Penilaian::findOrFail($id);

    // Hapus data penilaian
    $penilaian->delete();

    // Redirect kembali ke halaman index dengan pesan sukses
    return redirect()->route('penilaian.index')
        ->with('success', 'Penilaian berhasil dihapus!');
    }

    public function cetakPdf($id)
    {
        // Ambil data penilaian beserta relasi user dan profile
        $penilaian = Penilaian::with(['user.profile.sekolah'])->findOrFail($id);
    
        // Format tanggal menggunakan Carbon
        $tanggalMulai = Carbon::parse($penilaian->user->profile->tanggal_mulai)->translatedFormat('d-m-Y');
        $tanggalSelesai = Carbon::parse($penilaian->user->profile->tanggal_selesai)->translatedFormat('d-m-Y');
    
        // Generate PDF menggunakan template Blade
        $pdf = Pdf::loadView('template-penilaian', compact('penilaian', 'tanggalMulai', 'tanggalSelesai'))
                  ->setPaper('A4', 'portrait');
    
        // Unduh file PDF
        return $pdf->download('Laporan_Penilaian_PKL_' . $penilaian->user->name . '.pdf');
    }
/* -------------------------------------------------------------------------- */
/*                                  END PENILAIAN                             */
/* -------------------------------------------------------------------------- */

/* -------------------------------------------------------------------------- */
/*                                  START PROFILE                             */
/* -------------------------------------------------------------------------- */
    public function showProfile()
    {
        $user = Auth::user();
        return view('pages-industri.profile-industri', compact('user'));
    }

    public function editProfile()
    {
        $user = Auth::user();
        return view('pages-industri.update-industri', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'foto_profile' => 'nullable|image|max:2048',
        ]);

        $user = Auth::user();

        $user->name = $request->input('name');
        $user->alamat = $request->input('alamat');
        $user->email = $request->input('email');

        if ($request->hasFile('foto_profile')) {
            if ($user->foto_profile) {
                Storage::delete('public/' . $user->foto_profile);
            }

            $path = $request->file('foto_profile')->store('profile_pictures', 'public');
            $user->foto_profile = $path;
        }

        $user->save();

        return redirect()->route('profile-industri')
            ->with('success', 'Profil berhasil diperbarui.');

    }
/* -------------------------------------------------------------------------- */
/*                                  END PROFILE                               */
/* -------------------------------------------------------------------------- */
}
