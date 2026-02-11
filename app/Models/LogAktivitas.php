<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogAktivitas extends Model
{
    use HasFactory;

    protected $table = 'log_aktivitas';
    protected $primaryKey = 'id_log';
    public $timestamps = false; 

    protected $fillable = [
        'id_user',
        'aktivitas',
        'waktu'
    ];

    // relasi ke user (petugas / peminjam)
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
