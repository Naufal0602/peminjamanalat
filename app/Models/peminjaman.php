<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Detail_Peminjaman;
use App\Models\User;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';
    protected $primaryKey = 'id_peminjaman';

    protected $fillable = [
        'id_peminjam',
        'id_petugas',
        'tanggal_pinjam',
        'tanggal_kembali_rencana',
        'status'
    ];

     public function detailPeminjaman()
    {
        return $this->hasMany(Detail_Peminjaman::class, 'id_peminjaman');
    }

    public function pengembalian()
    {
        return $this->hasOne(\App\Models\Pengembalian::class, 'id_peminjaman');
    }


    public function peminjam()
    {
        return $this->belongsTo(User::class, 'id_peminjam');
    }
}

