<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Notification;
use Carbon\Carbon;

class ClearOldNotifications extends Command
{
    protected $signature = 'notification:clear';
    protected $description = 'Hapus notifikasi yang lebih dari 24 jam';

    public function handle()
    {
        Notification::where('created_at', '<', Carbon::now()->subHours(24))->delete();
        $this->info('Notifikasi lama telah dihapus.');
    }
}
