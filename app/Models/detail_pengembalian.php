<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Detail_Pengembalian extends Model
{
    protected $table = 'detail_pengembalian';
    protected $primaryKey = 'id_detail_pengembalian';

    protected $fillable = [
        'id_pengembalian',
        'id_alat',
        'jumlah',
        'kondisi',
        'denda'
    ];

    public function alat()
    {
        return $this->belongsTo(Alat::class, 'id_alat');
    }
}
