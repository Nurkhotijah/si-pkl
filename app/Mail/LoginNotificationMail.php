<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LoginNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    /**
     * Create a new message instance.
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Notifikasi Login Berhasil')
                    ->view('emails.login-notification')
                    ->with([
                        'userName' => $this->user->name,
                        'loginTime' => now()->format('d M Y, H:i:s'),
                    ]);
    }
}
