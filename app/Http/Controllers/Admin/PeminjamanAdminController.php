<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Detail_Peminjaman;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Alat;
use App\Models\Kategori;
use Barryvdh\DomPDF\Facade\Pdf; // Tambahkan ini untuk PDF
use Carbon\Carbon;

class PeminjamanAdminController extends Controller
{
    // READ (index) - Update dengan statistik
    public function index()
    {
        $peminjaman = Peminjaman::with([
            'peminjam',
            'petugas',
            'detailPeminjaman.alat'
        ])->orderBy('created_at', 'desc')->get();
        
        // Hitung statistik
        $totalPeminjaman = Peminjaman::count();
        $statusCounts = Peminjaman::selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        return view('admin.peminjaman.index', compact('peminjaman', 'totalPeminjaman', 'statusCounts'));
    }

    // CREATE (form) - sudah ada sebelumnya
    public function create()
    {
        $alat = Alat::with('kategori');
        
        if (request()->has('search') && request('search') != '') {
            $search = request('search');
            $alat->where('nama_alat', 'LIKE', "%{$search}%");
        }
        
        if (request()->has('kategori') && request('kategori') != '') {
            $alat->whereHas('kategori', function($query) {
                $query->where('id_kategori', request('kategori'));
            });
        }
        
        if (request()->has('stok_tersedia')) {
            $alat->where('stok', '>', 0);
        }
        
        if (request()->has('kondisi') && request('kondisi') != '') {
            $alat->where('kondisi', request('kondisi'));
        }
        
        if (request()->has('status') && request('status') != '') {
            $alat->where('status', request('status'));
        }
        
        return view('admin.peminjaman.create', [
            'peminjam' => User::where('role','peminjam')->get(),
            'alat' => $alat->get(),
            'kategori_list' => Kategori::all(),
            'kondisi_list' => ['baik', 'rusak_ringan', 'rusak_berat'],
            'status_list' => ['tersedia', 'dipinjam', 'perbaikan']
        ]);
    }

    // STORE - sudah ada sebelumnya
    public function store(Request $request)
    {
        $request->validate([
            'id_peminjam' => 'required',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali_rencana' => 'required|date|after_or_equal:tanggal_pinjam'
        ]);

        $peminjaman = Peminjaman::create([
            'id_peminjam' => $request->id_peminjam,
            'id_petugas' => Auth::id(),
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali_rencana' => $request->tanggal_kembali_rencana,
            'status' => 'disetujui'
        ]);

        if ($request->has('alat')) {
            foreach ($request->alat as $a) {
                if (isset($a['id_alat']) && isset($a['jumlah']) && $a['jumlah'] > 0) {
                    Detail_Peminjaman::create([
                        'id_peminjaman' => $peminjaman->id_peminjaman,
                        'id_alat' => $a['id_alat'],
                        'jumlah' => $a['jumlah']
                    ]);
                    
                    $alat = Alat::find($a['id_alat']);
                    if ($alat) {
                        $alat->stok -= $a['jumlah'];
                        $alat->status = $alat->stok > 0 ? 'tersedia' : 'habis';
                        $alat->save();
                    }
                }
            }
        }

        return redirect()->route('admin.peminjaman.index')
            ->with('success','Data peminjaman berhasil ditambahkan');
    }

    // EDIT
    public function edit($id)
    {
        $peminjaman = Peminjaman::with(['detailPeminjaman.alat', 'peminjam'])->findOrFail($id);
        
        return view('admin.peminjaman.edit', [
            'peminjaman' => $peminjaman,
            'alat' => Alat::with('kategori')->get(),
            'peminjam_list' => User::where('role','peminjam')->get(),
            'kategori_list' => Kategori::all()
        ]);
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        
        $request->validate([
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali_rencana' => 'required|date|after_or_equal:tanggal_pinjam',
            'status' => 'required|in:disetujui,dipinjam,dikembalikan,ditolak,pending'
        ]);

        $peminjaman->update([
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali_rencana' => $request->tanggal_kembali_rencana,
            'status' => $request->status
        ]);

        // Jika ada update detail peminjaman
        if ($request->has('alat')) {
            // Hapus detail lama
            Detail_Peminjaman::where('id_peminjaman', $id)->delete();
            
            // Tambah detail baru
            foreach ($request->alat as $a) {
                if (isset($a['id_alat']) && isset($a['jumlah']) && $a['jumlah'] > 0) {
                    Detail_Peminjaman::create([
                        'id_peminjaman' => $id,
                        'id_alat' => $a['id_alat'],
                        'jumlah' => $a['jumlah']
                    ]);
                }
            }
        }

        return redirect()->route('admin.peminjaman.index')
            ->with('success','Data peminjaman berhasil diperbarui');
    }

    // DELETE
    public function destroy($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        
        // Kembalikan stok alat
        foreach ($peminjaman->detailPeminjaman as $detail) {
            $alat = Alat::find($detail->id_alat);
            if ($alat) {
                $alat->stok += $detail->jumlah;
                $alat->save();
            }
        }
        
        $peminjaman->delete();

        return back()->with('success','Data peminjaman berhasil dihapus');
    }

    // CETAK PDF untuk single peminjaman
    public function cetak($id)
    {
        $peminjaman = Peminjaman::with([
            'peminjam',
            'petugas',
            'detailPeminjaman.alat.kategori'
        ])->findOrFail($id);
        
        $data = [
            'title' => 'Surat Peminjaman Alat',
            'peminjaman' => $peminjaman,
            'tanggal_cetak' => Carbon::now()->format('d/m/Y H:i:s')
        ];
        
        $pdf = Pdf::loadView('admin.peminjaman.pdf.single', $data);
        return $pdf->download('peminjaman-'.$peminjaman->id_peminjaman.'-'.Carbon::now()->format('Ymd').'.pdf');
    }
    
    // CETAK PDF untuk laporan semua peminjaman
    public function cetakLaporan(Request $request)
    {
        $query = Peminjaman::with(['peminjam', 'detailPeminjaman.alat']);
        
        // Filter berdasarkan tanggal
        if ($request->has('tanggal_awal') && $request->has('tanggal_akhir')) {
            $query->whereBetween('tanggal_pinjam', [$request->tanggal_awal, $request->tanggal_akhir]);
        }
        
        // Filter berdasarkan status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        
        $peminjaman = $query->orderBy('tanggal_pinjam', 'desc')->get();
        
        $data = [
            'title' => 'Laporan Data Peminjaman',
            'peminjaman' => $peminjaman,
            'tanggal_awal' => $request->tanggal_awal ?? '',
            'tanggal_akhir' => $request->tanggal_akhir ?? '',
            'status' => $request->status ?? 'Semua',
            'tanggal_cetak' => Carbon::now()->format('d/m/Y H:i:s')
        ];
        
        $pdf = Pdf::loadView('admin.peminjaman.pdf.laporan', $data);
        return $pdf->download('laporan-peminjaman-'.Carbon::now()->format('YmdHis').'.pdf');
    }
    
    
}