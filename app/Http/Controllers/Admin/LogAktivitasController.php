<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;

class LogAktivitasController extends Controller
{
public function index(Request $request)
{
    // Eager load relasi user
    $query = LogAktivitas::with('user')->orderBy('waktu', 'desc');

    // Filter berdasarkan role (Mencari di tabel users lewat relasi)
    if ($request->filled('role')) {
        $query->whereHas('user', function($q) use ($request) {
            $q->where('role', $request->role);
        });
    }

    // Filter berdasarkan tanggal
    if ($request->filled('tanggal')) {
        $query->whereDate('waktu', $request->tanggal);
    }

    $logs = $query->get(); // Gunakan ->get() jika ingin DataTables client-side bekerja penuh

    return view('admin.log_aktivitas.index', compact('logs'));
}
}
