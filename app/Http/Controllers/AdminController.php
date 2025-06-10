<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pengajuanMenunggu = DB::table('v_riwayat_all')->where('status', 0)->get(); // Menunggu Persetujuan
        $pengajuanRevisi = DB::table('v_riwayat_all')->where('status', 1)->get(); // Revisi Pengajuan
        $pengajuansudahRev = DB::table('v_riwayat_all')->where('status', 2)->get(); // Sudah Revisi
        $pengajuanSelesai = DB::table('v_riwayat_all')->where('status', 3)->get(); // Selesai
        $pengajuanDitolak = DB::table('v_riwayat_all')->where('status', 4)->get(); // Ditolak
        $pengajuanaccbaku = DB::table('v_riwayat_all')->where('status', 5)->get(); // Menunggu Pencairan
        $menunggubukti = DB::table('v_riwayat_all')->where('status', 8)->get(); // Menunggu Pencairan
        $sudahuploadbukti = DB::table('v_riwayat_all')->where('status', 9)->get(); // Menunggu Pencairan
        $pengajuanDicek = DB::table('v_riwayat_all')->where('status', 11)->get(); // Dicek Staff Baku
        $pengajuansudahTrf = DB::table('v_riwayat_all')->where('status', 10)->get(); // Belum Masuk Kas

        // Mengirimkan data ke view
        return view('admin.dashboard', compact(
            'pengajuanMenunggu',
            'pengajuanRevisi',
            'pengajuansudahRev',
            'pengajuanSelesai',
            'pengajuanSelesai',
            'pengajuanDitolak',
            'pengajuanaccbaku',
            'menunggubukti',
            'sudahuploadbukti',
            'pengajuanDicek',
            'pengajuansudahTrf'
        ));
    }
    public function noperki()
    {
        $datanoperki = DB::table('noperkiraan')->limit(1000)->get();
        return view('admin.noperkiraan', compact('datanoperki'));
    }

    public function kas($jenis)
    {
        $bankSumber = DB::table('bank_sumber')->get();
        // Validasi jenis yang diterima (kas masuk atau kas keluar)
        if ($jenis == 'masuk') {
            $datakas = DB::table('kas_pusat')
                ->where('jenis', 'masuk')
                ->limit(1000)
                ->get();
        } elseif ($jenis == 'keluar') {
            $datakas = DB::table('kas_pusat')
                ->where('jenis', 'keluar')
                ->limit(1000)
                ->get();
        } else {
            // Jika jenis tidak valid, tampilkan error atau data kosong
            $datakas = collect();
        }

        // Mengirimkan data ke view
        return view('admin.kas', compact('datakas', 'jenis', 'bankSumber'));
    }

    public function hapusKas($id, $jenis)
    {
        // Menghapus data berdasarkan ID
        DB::table('kas_pusat')->where('id_kas', $id)->delete();

        // Redirect ke halaman yang sesuai setelah penghapusan
        return redirect()->route('admin.kas', ['jenis' => $jenis])->with('success', 'Data berhasil dihapus');
    }

    public function editKas($id)
    {
        $kas = DB::table('kas_pusat')->where('id_kas', $id)->first();
        $kas->tgl = \Carbon\Carbon::parse($kas->tgl)->format('Y-m-d');
        return response()->json($kas);  // Mengembalikan data kas dalam format JSON
    }

    public function updateKas(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'jenis' => 'required',
            'keterangan' => 'required',
            'jumlah' => 'nullable',  // Hanya diperlukan jika Kas Masuk
            'keluar' => 'nullable',  // Hanya diperlukan jika Kas Keluar
            'bank_sumber' => 'required',
        ]);

        // Menyimpan data berdasarkan jenis transaksi
        if ($request->jenis == 'masuk') {
            // Update kolom jumlah untuk Kas Masuk
            DB::table('kas_pusat')
                ->where('id_kas', $id)
                ->update([
                    'keterangan' => $request->keterangan,
                    'jenis' => $request->jenis,
                    'jumlah' => $request->jumlah,  // Kolom untuk Kas Masuk
                    'bank_sumber' => $request->bank_sumber,
                    'tgl' => Carbon::now()->format('Y-m-d H:i:s')
                ]);
        } elseif ($request->jenis == 'keluar') {
            // Update kolom keluar untuk Kas Keluar
            DB::table('kas_pusat')
                ->where('id_kas', $id)
                ->update([
                    'keterangan' => $request->keterangan,
                    'jenis' => $request->jenis,
                    'keluar' => $request->keluar,  // Kolom untuk Kas Keluar
                    'bank_sumber' => $request->bank_sumber,
                    'tgl' => Carbon::now()->format('Y-m-d H:i:s')
                ]);
        }

        return redirect()->route('admin.kas', ['jenis' => $request->jenis])->with('success', 'Data berhasil diperbarui');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
