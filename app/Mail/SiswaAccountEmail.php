<?php

namespace App\Mail;

use App\Models\Pengajuan;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SiswaAccountEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $pengajuanSiswa;

    /**
     * Create a new message instance.
     *
     * @param Pengajuan $pengajuanSiswa
     * @return void
     */
    public function __construct(Pengajuan $pengajuanSiswa)
    {
        $this->pengajuanSiswa = $pengajuanSiswa;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Selamat Siswa Anda Telah Diterima')
                    ->view('emails.siswa_account')
                    ->with([
                        'name' => $this->pengajuanSiswa->nama,
                        'email' => preg_replace('/\s+/', '-', $this->pengajuanSiswa->nama) . '@gmail.com',
                        'password' => 'siswa123',
                    ]);
    }
}
