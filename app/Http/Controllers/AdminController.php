<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Log;
use App\Models\KasModel;


class AdminController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userLevel = Auth::user()->level;
        $username = Auth::user()->username;

        $baseQuery = function ($status) use ($userLevel, $username) {
            $currentYear = date('Y');
            $query = DB::table('v_riwayat_all')
                ->where('status', $status);
            if (!in_array($userLevel, ['1', '2', '3'])) {
                $query->where('pengaju', $username);
            }
            return $query->get();
        };

        $pengajuanMenunggu = $baseQuery(0); // Menunggu Persetujuan
        $pengajuanRevisi = $baseQuery(1); // Revisi Pengajuan
        $pengajuansudahRev = $baseQuery(2); // Sudah Revisi
        $pengajuanSelesai = $baseQuery(3); // Selesai
        $pengajuanDitolak = $baseQuery(4); // Ditolak
        $pengajuanaccbaku = $baseQuery(5); // Menunggu Pencairan
        $menunggubukti = $baseQuery(8); // Menunggu bukti
        $sudahuploadbukti = $baseQuery(9); // Sudah kirim bukti
        $pengajuanDicek = $baseQuery(11); // Dicek Staff Baku
        $pengajuansudahTrf = $baseQuery(10); // Belum Masuk Kas

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
        $datanoperki = DB::table('noperkiraan')->get();
        return view('admin.noperkiraan', compact('datanoperki'));
    }

    public function tambahnoperki()
    {
        //Ambil Sub kategori
        $kategori = DB::table('sub_kategori')->whereRaw('CHAR_LENGTH(id_subkat) = 3')->get();
        $kampus = DB::table('kampus')->get();
        $fakultas = DB::table('fakultas')->get();
        $prodiname = DB::table('prodi')->get();
        $levels = DB::table('level')->where('id_level', '!=', 1)->get();


        return view('admin.tambahnoperki', compact('kategori', 'kampus', 'fakultas', 'prodiname', 'levels'));
    }

    public function getProdi($id_fakultas)
    {
        $prodi = DB::table('prodi')
            ->where('id_fakultas', $id_fakultas)
            ->get();

        return response()->json($prodi);
    }

    public function getSubKategori1($id_subkat)
    {
        $max = DB::table('noperkiraan')
            ->where('no_perkiraan', 'like', $id_subkat . '.%')
            ->select(DB::raw("MAX(CAST(SUBSTRING(no_perkiraan, 14, 4) AS UNSIGNED)) AS max_sub"))
            ->first();

        $next = str_pad(((int) $max->max_sub + 1), 4, '0', STR_PAD_LEFT);

        return response()->json(['subkategori1' => $next]);
    }

    public function simpannoperkinew(Request $request)
    {
        $request->validate([
            'kategori' => 'required',
            'keterangan' => 'required',
            'subkategori1' => 'required',
            'subkategori2' => 'required',
            'subkategori3' => 'required',
            'kampus' => 'array',
            'fakultas' => 'required',
            'prodi' => 'required',
            'level' => 'required|array',
        ]);

        $kategoriId = $request->kategori;
        $kategori = DB::table('sub_kategori')->where('id_subkat', $kategoriId)->first();
        $namaKategori = $kategori ? $kategori->nm_subkat : '';
        $keteranganFinal = $namaKategori . ' - ' . $request->keterangan;

        $kampus_ids = $request->kampus ?? ['000'];
        $level_str = implode(',', $request->level ?? []);

        $dateNow = now();

        foreach ($kampus_ids as $kampus_id) {
            $kampus_code = str_pad($kampus_id, 3, "0", STR_PAD_LEFT);
            $no_perkiraan = $kategoriId . '.' . $kampus_code . '.' .
                $request->fakultas . $request->prodi . '.' .
                $request->subkategori1 . '.' .
                $request->subkategori2 . '.' .
                $request->subkategori3;

            $kampus = DB::table('kampus')->where('id_kampus', $kampus_id)->first();
            $keteranganKampus = $kampus ? $keteranganFinal . ' - ' . $kampus->kampus : $keteranganFinal;

            DB::table('noperkiraan')->insert([
                'no_perkiraan' => $no_perkiraan,
                'keterangan' => $keteranganKampus,
                'kategori' => 2,
                'level_pemohon' => '1,' . $level_str,
                'jumlah' => 0,
                'status' => 1,
                'user_create' => Auth::user()->username,
                'tgl_create' => $dateNow,
            ]);

            DB::table('log_aktivitas')->insert([
                'aktivitas' => 'Menambahkan data pada nomor perkiraan ' . $keteranganKampus,
                'user_create' => Auth::user()->username,
                'tgl_activitas' => $dateNow,
                'ip' => $request->ip(),
                'agent' => $request->header('User-Agent'),
            ]);
        }

        return redirect()->route('admin.noperkiraan')->with('success', 'Data berhasil disimpan!');
    }

    public function kas($jenis)
    {
        $bankSumber = DB::table('bank_sumber')->get();
        // Validasi jenis yang diterima (kas masuk atau kas keluar)
        if ($jenis == 'masuk') {
            $datakas = DB::table('kas_pusat')
                ->where('jenis', 'masuk')
                ->orderBy('tgl', 'desc')
                ->get();
            // Ambil noperki masuk
            $noperkiraan = DB::table('noperkiraan')->where('kategori', 1)->get();
        } elseif ($jenis == 'keluar') {
            $datakas = DB::table('kas_pusat')
                ->where('jenis', 'keluar')
                ->orderBy('tgl', 'desc')
                ->get();
            //Ambil no perki keluar
            $noperkiraan = DB::table('noperkiraan')->where('kategori', 2)->get();
        } else {
            // Jika jenis tidak valid, tampilkan error atau data kosong
            $datakas = collect();
        }

        // Mengirimkan data ke view
        return view('admin.kas', compact('datakas', 'jenis', 'bankSumber', 'noperkiraan'));
    }


    public function simpankas(Request $request)
    {
        // Validasi data yang masuk
        $request->validate([
            'no_perkiraan' => 'required|exists:noperkiraan,no_perkiraan',
            'keterangan' => 'required',
            'jenis' => 'required|in:masuk,keluar',
            'tgl' => 'required|date',
            'waktuskr' => 'required',
            'jumlah' => 'nullable|numeric',
            'keluar' => 'nullable|numeric',
            'bank_sumber' => 'required|exists:bank_sumber,id_bank',
        ]);

        // Insert data ke tabel kas_pusat
        $kasPusatData = [
            'no_perkiraan' => $request->no_perkiraan,
            'keterangan' => $request->keterangan,
            'jenis' => $request->jenis,
            'tgl' => $request->tgl . ' ' . $request->waktuskr,
            'tgl_create' => now(),
            'jumlah' => $request->jenis === 'masuk' ? $request->jumlah : 0,
            'keluar' => $request->jenis === 'keluar' ? $request->jumlah : 0,
            'bank_sumber' => $request->bank_sumber,
            'user_create' => Auth::user()->username,
            'input' => 'Manual', // Jika inputnya manual
        ];

        // Menyimpan ke kas_pusat
        DB::table('kas_pusat')->insert($kasPusatData);
        // Menyimpan ke kas_pusat_backup
        DB::table('kas_pusat_backup')->insert($kasPusatData);

        // Menyimpan ke log_aktivitas
        DB::table('log_aktivitas')->insert([
            'aktivitas' => "Data kas {$request->jenis} dengan no_perkiraan {$request->no_perkiraan} telah ditambahkan",
            'user_create' => Auth::user()->username,
            'tgl_activitas' => now(),
            'ip' => request()->ip(),
            'agent' => request()->header('User-Agent'),
        ]);

        // Kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Data berhasil ditambahkan');
    }

    public function hapusKas($id, $jenis)
    {
        // Menghapus data berdasarkan ID
        DB::table('kas_pusat')->where('id_kas', $id)->delete();

        // Menyimpan ke log_aktivitas
        DB::table('log_aktivitas')->insert([
            'aktivitas' => "Menghapus data kas $id",
            'user_create' => Auth::user()->username,
            'tgl_activitas' => now(),
            'ip' => request()->ip(),
            'agent' => request()->header('User-Agent'),
        ]);

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
            'tanggal' => 'required',
            'waktu' => 'required',
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
                    'tgl' => $request->tanggal . ' ' . $request->waktu,
                    'jenis' => $request->jenis,
                    'jumlah' => $request->jumlah,  // Kolom untuk Kas Masuk
                    'bank_sumber' => $request->bank_sumber,
                    'tgl_create' => Carbon::now()->format('Y-m-d H:i:s')
                ]);
        } elseif ($request->jenis == 'keluar') {
            // Update kolom keluar untuk Kas Keluardd
            DB::table('kas_pusat')
                ->where('id_kas', $id)
                ->update([
                    'keterangan' => $request->keterangan,
                    'tgl' => $request->tanggal . ' ' . $request->waktu,
                    'jenis' => $request->jenis,
                    'keluar' => $request->keluar,  // Kolom untuk Kas Keluar
                    'bank_sumber' => $request->bank_sumber,
                    'tgl_create' => Carbon::now()->format('Y-m-d H:i:s')
                ]);
        }

        // Menyimpan ke log_aktivitas
        DB::table('log_aktivitas')->insert([
            'aktivitas' => "Mengubah data kas dengan id $id",
            'user_create' => Auth::user()->username,
            'tgl_activitas' => now(),
            'ip' => request()->ip(),
            'agent' => request()->header('User-Agent'),
        ]);

        return redirect()->route('admin.kas', ['jenis' => $request->jenis])->with('success', 'Data berhasil diperbarui');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function kasawaltop()
    {
        $bulannow = Carbon::now()->format('Y-m');
        $sts = 'Belum di Transfer';

        $dataKas = DB::table('noperkiraan')
            ->selectRaw('*, MID(no_perkiraan, 5, 3) AS id_kampus')
            ->whereRaw("LEFT(no_perkiraan, 5) = '100.1'")
            ->whereRaw("LEFT(no_perkiraan, 7) NOT IN (
            SELECT LEFT(no_perkiraan,7) FROM kas_pusat WHERE LEFT(tgl,7) = ?
        )", [$bulannow])
            ->get();

        return view('admin.kasawal', compact('dataKas', 'sts'));
    }

    public function kasproses(Request $request)
    {
        // Ambil username dari user yang sedang login
        $username = Auth::user()->username;

        // Validasi jika checkbox tidak dicentang
        if (!$request->has('chkBox')) {
            return redirect()->back()->with('error', 'Pilih data yang akan diproses.');
        }

        // Ambil data checkbox yang dipilih
        $selectedItems = $request->input('chkBox');

        // Proses data yang dipilih
        foreach ($selectedItems as $item) {
            // Pisahkan data dengan explode
            $itemArray = explode(',', $item);

            // Pastikan ada 3 elemen, jika tidak beri nilai default
            $no_perkiraan = $itemArray[0] ?? null;
            $jumlah = $itemArray[1] ?? null;
            $keterangan = $itemArray[2] ?? null;  // Keterangan berada di elemen ke-3
            $i = $itemArray[3] ?? null; // Jika data ke-4 diperlukan, pastikan item ini ada

            // Cek apakah data yang dibutuhkan ada
            if ($no_perkiraan && $jumlah && $keterangan) {
                // Insert data ke kas_pusat
                $kasData = [
                    'no_perkiraan' => $no_perkiraan,
                    'tgl' => now()->format('Y-m-d H:i:s'), // Tanggal hari ini
                    'jenis' => 'keluar',
                    'keluar' => $jumlah,
                    'tgl_create' => now()->format('Y-m-d H:i:s'),
                    'bank_sumber' => 'KAS',
                    'user_create' => $username,
                    'input' => 'Manual',
                    // tambahkan kolom lainnya sesuai kebutuhan
                ];

                DB::table('kas_pusat')->insert($kasData);
                DB::table('kas_pusat_backup')->insert($kasData);
            }
        }

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Data berhasil diproses.');
    }

    public function updatekasawal(Request $request)
    {
        // Validasi input
        $request->validate([
            'no_perkiraan' => 'required',
            'keterangan' => 'required',
            'jumlah' => 'required|numeric',
        ]);

        // Update data di tabel noperkiraan
        DB::table('noperkiraan')
            ->where('no_perkiraan', $request->no_perkiraan)
            ->update([
                'keterangan' => $request->keterangan,
                'jumlah' => $request->jumlah,
            ]);

        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Data berhasil diubah.');
    }
    /**
     * Store a newly created resource in storage.
     */

    public function datapengajuan(Request $request)
    {
        $encrypted = $request->query('status');
        $status = null;

        if ($encrypted) {
            try {
                $status = Crypt::decrypt($encrypted);
            } catch (DecryptException $e) {
                abort(403, 'Status tidak valid');
            }
        }

        $userLevel = Auth::user()->level;
        $username = Auth::user()->username;

        $currentYear = date('Y');
        $query = DB::table('v_riwayat_all')
            ->when($status == 3, function ($q) use ($currentYear) {
                $q->whereRaw('LEFT(tanggal, 4) = ?', [$currentYear]);
            })
            ->orderBy('tanggal_dip', 'asc');
        $statusLabel = 'Semua';

        if (!in_array($userLevel, ['1', '2', '3'])) {
            $query->where('pengaju', $username);
        }

        if ($status !== null) {
            $query->where('status', $status);
            $statusData = DB::table('sts_aju')->where('kd_status', $status)->first();
            $statusLabel = $statusData->status ?? 'Status Tidak Dikenal';
        }

        $datapengajuan = $query->get();
        $daftarStatus = DB::table('sts_aju')->get();
        $bankSumber = DB::table('bank_sumber')->get();

        // Data Riwayat Pengajuan


        return view('admin.data_pengajuan', compact('datapengajuan', 'statusLabel', 'daftarStatus', 'status', 'bankSumber'));
    }

    public function historiajuan(Request $request)
    {
        $status = $request->query('status'); // dari ?status=1
        $query = DB::table('v_riwayat_all')
            ->where('pengaju', Auth::user()->username)
            ->orderByDesc('tanggal_dip');

        $statusLabel = 'Semua';

        if ($status !== null) {
            $query->where('status', $status);
            $statusData = DB::table('sts_aju')->where('kd_status', $status)->first();
            $statusLabel = $statusData->status ?? 'Status Tidak Dikenal';
        }

        $datapengajuan = $query->get();
        $bankSumber = DB::table('bank_sumber')->get();

        // Ambil semua status untuk dropdown
        $daftarStatus = DB::table('sts_aju')->get();

        return view('admin.data_pengajuan', compact('datapengajuan', 'statusLabel', 'daftarStatus', 'status', 'bankSumber'));
    }

    public function buatpengajuan(Request $request)
    {
        $user = Auth::user()->username;
        $level = Auth::user()->level;
        $kampus = Auth::user()->id_kampus;

        // Ambil semua data rekening dan plat nomor
        $norekening = DB::table('no_rekening')->get();
        $dataplat = DB::table('plat_nomer')->get();
        $bankpemohon = DB::table('bank_pemohon')->get();

        // Query noperkiraan berdasarkan ketentuan level
        $query = DB::table('noperkiraan')->where('status', '1');

        if (in_array($level, ['1', '2', '3'])) {
            // tidak ada tambahan filter
        } elseif (in_array($level, ['4', '5'])) {
            $query->whereNotIn(DB::raw('LEFT(no_perkiraan, 3)'), ['800', '100', '551'])
                ->where('kategori', '2')
                ->where('level_pemohon', 'like', "%$level%");
        } elseif (in_array($level, ['6', '8'])) {
            $query->where('kategori', '2')
                ->where('level_pemohon', 'like', "%$level%");
        } else {
            $query->where(DB::raw('MID(no_perkiraan, 5, 3)'), '=', $kampus)
                ->where('level_pemohon', 'like', '%7%');
        }
        $noperkiraan = $query->get();

        return view('users.buat_pengajuan', compact('norekening', 'noperkiraan', 'dataplat', 'bankpemohon'));
        // return view('layouts.modal', compact('norekening', 'bankpemohon'));
    }

    public function riwayatPengajuan($id_pengajuan)
    {
        // Ambil data pengajuan berdasarkan ID
        $pengajuan = DB::table('riwayat')->where('id_pengajuan', $id_pengajuan)->first();

        // Pastikan jika pengajuan ditemukan, jika tidak bisa mengembalikan response error
        if (!$pengajuan) {
            return response()->json(['error' => 'Pengajuan tidak ditemukan'], 404);
        }

        // Ambil riwayat pengajuan
        $riwayat = DB::table('riwayat')
            ->where('id_pengajuan', $id_pengajuan) // Pastikan filter sesuai
            ->orderBy('tanggal', 'asc') // Mengurutkan berdasarkan tanggal
            ->get();

        // Mengembalikan data dalam format JSON
        return response()->json([
            'pengajuan' => $pengajuan,
            'riwayat' => $riwayat
        ]);
    }

    public function timeline($id)
    {
        // Ambil data pengajuan dari tabel riwayat
        $pengajuan = DB::table('pengajuan')->where('id_pengajuan', $id)->first();

        // Ambil log terkait pengajuan
        $logs = DB::table('riwayat')
            ->leftJoin('users', 'riwayat.eksekutor', '=', 'users.username')
            ->where('riwayat.id_pengajuan', $id)
            ->orderBy('riwayat.tanggal', 'desc')
            ->select('riwayat.*', 'users.nama_lengkap as eksekutor_name')
            ->get();

        return view('admin.timeline', compact('pengajuan', 'logs'));
    }

    public function daftarrekening(Request $request)
    {
        $request->validate([
            'nm_bank' => 'required|string|max:100',
            'no_rekening' => 'required|string|max:100|unique:no_rekening,no_rekening',
            'atas_nama' => 'required|string|max:150',
            'info' => 'nullable|string',
        ]);

        DB::table('no_rekening')->insert([
            'nm_bank' => $request->nm_bank,
            'no_rekening' => $request->no_rekening,
            'atas_nama' => $request->atas_nama,
            'id_kampus' => Auth::user()->id_kampus,
            'info' => $request->info,
            'last_update' => now(),
            'user_create' => Auth::user()->username,
            'status' => 'Aktif',
        ]);

        return redirect()->back()->with('success', 'Nomor rekening berhasil ditambahkan.');
    }
    public function saldoKas($bulan = null, $tahun = null)
    {
        $bulan = $bulan ?? Carbon::now()->format('m');
        $tahun = $tahun ?? Carbon::now()->format('Y');

        // Format 'YYYY-MM'
        $periode = Carbon::create($tahun, $bulan)->format('Y-m');

        // Ambil saldo sebelum bulan ini (sisa saldo bulan sebelumnya)
        $saldoAwal = DB::table('kas_pusat')
            ->where('tgl', '<', $periode . '-01')
            ->whereNotIn('bank_sumber', ['BCA3130']) // sesuai native
            ->selectRaw('SUM(jumlah) - SUM(keluar) as saldo')
            ->value('saldo');

        // Ambil data transaksi bulan ini
        $kasBulanIni = DB::table('kas_pusat')
            ->whereRaw("LEFT(tgl,7) = ?", [$periode])
            ->whereNotIn('bank_sumber', ['BCA3130'])
            ->orderBy('tgl')
            ->orderBy('id_kas')
            ->get();

        return view('admin.kasbaku', compact('saldoAwal', 'kasBulanIni', 'bulan', 'tahun'));
    }

    public function datarekening()
    {
        $datarekening = DB::table('no_rekening')
            ->leftJoin('kampus', 'no_rekening.id_kampus', '=', 'kampus.id_kampus')
            ->select('no_rekening.*', 'kampus.kampus as nama_kampus')
            ->where('no_rekening.status', 'Aktif')
            ->get();

        $bankpemohon = DB::table('bank_pemohon')->get();

        return view('admin.datarekening', compact('datarekening', 'bankpemohon'));
    }

    public function updateRekeningStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'status' => 'required|string|in:Aktif,Tidak Aktif'
        ]);

        DB::table('no_rekening')->where('id', $request->id)->update([
            'status' => $request->status,
            'last_update' => now()
        ]);

        return redirect()->back()->with('success', 'Status rekening berhasil diperbarui.');
    }

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

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
