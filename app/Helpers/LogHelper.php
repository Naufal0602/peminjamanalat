<?php

namespace App\Helpers;

use App\Models\LogAktivitas;
use Illuminate\Support\Facades\Auth;

class LogHelper
{
    public static function simpan($aktivitas)
    {
        LogAktivitas::create([
            'id_user' => Auth::id(),
            'aktivitas' => $aktivitas,
        ]);
    }
}
