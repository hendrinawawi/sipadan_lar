<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\KasModel;

class LaporanController extends Controller
{
    public function kasperiode(Request $request)
    {
        $dataKas = collect();
        $saldoSebelumnya = 0;

        if ($request->filled('tgl_awal') && $request->filled('tgl_akhir')) {
            $request->validate([
                'tgl_awal' => 'required|date',
                'tgl_akhir' => 'required|date',
            ]);

            // Saldo sebelumnya = (total masuk) - (total keluar) sebelum tanggal awal
            $totalMasuk = KasModel::where('jenis', 'masuk')
                ->where('tgl', '<', $request->tgl_awal)
                ->sum('jumlah');

            $totalKeluar = KasModel::where('jenis', 'keluar')
                ->where('tgl', '<', $request->tgl_awal)
                ->sum('keluar');

            $saldoSebelumnya = $totalMasuk - $totalKeluar;

            // Data transaksi sesuai filter
            $dataKas = KasModel::whereBetween('tgl', [
                $request->tgl_awal,
                $request->tgl_akhir
            ])
                ->orderBy('tgl', 'asc')
                ->get();
        }

        return view('admin.kasperiode', compact('dataKas', 'saldoSebelumnya'));
    }


    public function kascabangbaku()
    {
        $datakampus = DB::table('kampus')->get();
        return view('admin.kascabangbaku', compact('datakampus'));
    }

    public function kaskampuscek(Request $request, $id_kampus)
    {
        $selectedBulan = $request->input('bulan', now()->month);
        $selectedTahun = $request->input('tahun', now()->year);

        $carbonBulanLalu = \Carbon\Carbon::create($selectedTahun, $selectedBulan, 1)->subMonth();

        $saldoAkhirBulanSebelumnya = DB::table('kascabang')
            ->where('id_kampus', $id_kampus)
            ->whereDate('tgl', '<=', $carbonBulanLalu->endOfMonth()->toDateString())
            ->select(
                DB::raw('COALESCE(SUM(masuk),0) as total_masuk'),
                DB::raw('COALESCE(SUM(keluar),0) as total_keluar')
            )
            ->first();

        $saldoAwal = ($saldoAkhirBulanSebelumnya->total_masuk ?? 0) - ($saldoAkhirBulanSebelumnya->total_keluar ?? 0);

        $kasBulanIni = DB::table('kascabang')
            ->where('id_kampus', $id_kampus)
            ->whereMonth('tgl', $selectedBulan)
            ->whereYear('tgl', $selectedTahun)
            ->orderBy('tgl', 'asc')
            ->get();

        $kampus = DB::table('kampus')->where('id_kampus', $id_kampus)->first();

        $saldoAkhirBulanIni = DB::table('kascabang')
            ->where('id_kampus', $id_kampus)
            ->whereMonth('tgl', $selectedBulan)
            ->whereYear('tgl', $selectedTahun)
            ->select(
                DB::raw('COALESCE(SUM(masuk),0) as total_masuk'),
                DB::raw('COALESCE(SUM(keluar),0) as total_keluar')
            )
            ->first();

        $saldoAkhir = $saldoAwal +
            ($saldoAkhirBulanIni->total_masuk ?? 0) -
            ($saldoAkhirBulanIni->total_keluar ?? 0);


        return view('admin.kascabangcekbaku', [
            'kasBulanIni' => $kasBulanIni,
            'saldoAwal' => $saldoAwal,
            'saldoAkhir' => $saldoAkhir,
            'carbonBulanLalu' => $carbonBulanLalu,
            'selectedBulan' => $selectedBulan,
            'selectedTahun' => $selectedTahun,
            'kampus' => $kampus
        ]);
    }
}
