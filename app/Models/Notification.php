<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notification'; // Gunakan nama tabel yang benar

    protected $fillable = ['user_id', 'message', 'created_at'];
}