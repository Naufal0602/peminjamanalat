<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Alat;
use App\Models\Peminjaman;

class Detail_Peminjaman extends Model
{
    protected $table = 'detail_peminjaman';
    protected $primaryKey = 'id_detail';

    protected $fillable = [
        'id_peminjaman',
        'id_alat',
        'jumlah'
    ];

    public function alat()
    {
        return $this->belongsTo(Alat::class, 'id_alat');
    }

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'id_peminjaman');
    }
}
