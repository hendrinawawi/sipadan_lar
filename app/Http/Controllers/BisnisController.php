<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BisnisController extends Controller
{
    public function pengajuankirim(Request $request)
    {
        // Validasi awal
        $request->validate([
            'rekening_id' => 'required|string',
            'noperkiraan' => 'required|string',
            'keterangantambahan' => 'nullable|string',
            'tgl_ajuan' => 'required|date',
            'tgl_dip' => 'required|date|after_or_equal:' . now()->addDays(3)->format('Y-m-d'),
            'jumlah' => 'required|numeric',
            'type' => 'required|in:0,1',
            'nip' => 'nullable|string',
            'plat_nomor' => 'nullable|string',
            'lampiran' => 'nullable|file|mimes:pdf|max:2048',  // Lampiran opsional, validasi nanti
            // Lampiran validasi nanti di bawah
        ]);

        // Validasi lampiran, sesuai jenis pengajuan
        if ($request->input('type') == '1') {
            // Reimburse: wajib upload
            $request->validate([
                'lampiran' => 'required|file|mimes:pdf|max:2048',
            ]);
        } else {
            // Pengajuan baru: opsional upload
            $request->validate([
                'lampiran' => 'nullable|file|max:2048',
            ]);
        }

        // Split data noperkiraan
        [$noPerkiraan, $keteranganDb] = explode('|', $request->noperkiraan);

        // Tambahkan nip atau plat_nomor jika ada
        if ($request->nip) {
            $noPerkiraan .= '.' . $request->nip;
        } elseif ($request->plat_nomor) {
            $noPerkiraan .= '.' . $request->plat_nomor;
        }

        // Gabungan keterangan
        $keteranganGabungan = $keteranganDb . ' - ' . $request->keterangantambahan;

        // Buat kode pengajuan unik
        $kodePengajuan = Auth::user()->username . now()->format('Ymd') . rand(1000, 9999);

        // Proses upload lampiran
        $lampiranPath = '-'; // Default jika tidak ada lampiran
        if ($request->hasFile('lampiran') && $request->file('lampiran')->isValid()) {
            $lampiran = $request->file('lampiran');
            $lampiranName = Auth::user()->username . '_PengajuanBaru_' . $kodePengajuan . '.' . $lampiran->getClientOriginalExtension();
            $lampiran->move(public_path('dok_pengajuan'), $lampiranName);
            $lampiranPath = $lampiranName;
        }

        // Simpan ke tabel pengajuan
        DB::table('pengajuan')->insert([
            'id_pengajuan'   => $kodePengajuan,
            'rek_tujuan'     => $request->rekening_id,
            'no_perkiraan'   => $noPerkiraan,
            'keterangan'     => $keteranganGabungan,
            'tanggal'        => $request->tgl_ajuan,
            'tanggal_dip'    => $request->tgl_dip,
            'jumlah'         => $request->jumlah,
            'pemakaian'      => $request->type,
            'pengaju'        => Auth::user()->username,
            'tujuan'        => 'BAKU',
            'bukti'          => $lampiranPath,
            'id_kampus'      => Auth::user()->id_kampus,
            'user_create'    => Auth::user()->username,
            'status'         => '0',
        ]);

        // Simpan juga ke tabel riwayat
        DB::table('riwayat')->insert([
            'id_pengajuan' => $kodePengajuan,
            'tanggal'      => now(),
            'catatan'      => 'Pengajuan baru',
            'pengaju'      => Auth::user()->username,
            'jumlah'       => $request->jumlah,
            'tujuan'       => $request->rekening_id,
            'eksekutor'    => Auth::user()->username,
        ]);

        // Redirect dengan notifikasi SweetAlert (opsional, jika ingin trigger js SweetAlert di view)
        return redirect()->back()->with('success', 'Pengajuan berhasil dikirim.');
    }

    public function tolakPengajuan(Request $request)
    {
        $id_pengajuan = $request->input('id_pengajuan');
        $alasan = $request->input('alasan');
        $user = Auth::user(); // Mendapatkan user yang sedang login
        $jumlah = DB::table('pengajuan')->where('id_pengajuan', $id_pengajuan)->value('jumlah');
        $pengaju = DB::table('pengajuan')->where('id_pengajuan', $id_pengajuan)->value('pengaju');
        $tujuan = DB::table('pengajuan')->where('id_pengajuan', $id_pengajuan)->value('tujuan');

        // Update status pengajuan menjadi Ditolak (status 4)
        DB::table('pengajuan')->where('id_pengajuan', $id_pengajuan)->update(['status' => 4, 'catatan' => 'Ditolak - ' . $alasan]);

        // Tambahkan catatan ke tabel riwayat
        DB::table('riwayat')->insert([
            'id_pengajuan' => $id_pengajuan,
            'tanggal' => now(),
            'catatan' => 'Ditolak - ' . $alasan,
            'pengaju' => $pengaju,
            'jumlah' => $jumlah,
            'tujuan' => $tujuan,
            'eksekutor' => $user->username, // Eksekutor adalah user yang menolak
        ]);

        return response()->json(['success' => true]);
    }
    public function revisiPengajuan(Request $request)
    {
        $id_pengajuan = $request->input('id_pengajuan');
        $catatan = $request->input('catatan');
        $jumlah = $request->input('jumlah'); // Jumlah revisi
        $user = Auth::user(); // Pengguna yang sedang login
        $pengaju = DB::table('pengajuan')->where('id_pengajuan', $id_pengajuan)->value('pengaju');
        $tujuan = DB::table('pengajuan')->where('id_pengajuan', $id_pengajuan)->value('tujuan');

        // Update status pengajuan menjadi Revisi (status 1)
        DB::table('pengajuan')->where('id_pengajuan', $id_pengajuan)->update([
            'status' => 1,
            'catatan' => $catatan,
            'jumlah' => $jumlah // update jumlah juga saat revisi
        ]);

        // Tambahkan riwayat revisi
        DB::table('riwayat')->insert([
            'id_pengajuan' => $id_pengajuan,
            'tanggal' => now(),
            'catatan' => 'Revisi - ' . $catatan,
            'pengaju' => $pengaju,
            'jumlah' => $jumlah,
            'tujuan' => $tujuan,
            'eksekutor' => $user->username,
        ]);

        return response()->json(['success' => true]);
    }

    public function ajukanKeKaBaku(Request $request)
    {
        $id_pengajuan = $request->input('id_pengajuan');

        $jumlah = DB::table('pengajuan')->where('id_pengajuan', $id_pengajuan)->value('jumlah');
        $user = Auth::user(); // Pengguna yang sedang login
        $pengaju = DB::table('pengajuan')->where('id_pengajuan', $id_pengajuan)->value('pengaju');
        $tujuan = DB::table('pengajuan')->where('id_pengajuan', $id_pengajuan)->value('tujuan');
        DB::table('pengajuan')->where('id_pengajuan', $id_pengajuan)->update(['status' => 11]);
        // Tambahkan riwayat ajukan ke Ka BAKU
        DB::table('riwayat')->insert([
            'id_pengajuan' => $id_pengajuan,
            'tanggal' => now(),
            'catatan' => 'Pengajuan Diteruskan ke Ka. BAKU Untuk Diotorisasi',
            'pengaju' => $pengaju,
            'jumlah' => $jumlah,
            'tujuan' => $tujuan,
            'eksekutor' => $user->username,
        ]);

        return response()->json(['success' => true]);
    }

    public function accPengajuan(Request $request)
    {
        $id_pengajuan = $request->input('id_pengajuan');

        $jumlah = DB::table('pengajuan')->where('id_pengajuan', $id_pengajuan)->value('jumlah');
        $user = Auth::user(); // Pengguna yang sedang login
        $pengaju = DB::table('pengajuan')->where('id_pengajuan', $id_pengajuan)->value('pengaju');
        $tujuan = DB::table('pengajuan')->where('id_pengajuan', $id_pengajuan)->value('tujuan');
        DB::table('pengajuan')->where('id_pengajuan', $id_pengajuan)->update([
            'status' => 5,
            'tanggal_acc' => now()
        ]);
        // Tambahkan riwayat ajukan ke Ka BAKU
        DB::table('riwayat')->insert([
            'id_pengajuan' => $id_pengajuan,
            'tanggal' => now(),
            'catatan' => 'Pengajuan Disetujui Ka BAKU',
            'pengaju' => $pengaju,
            'jumlah' => $jumlah,
            'tujuan' => $tujuan,
            'eksekutor' => $user->username,
        ]);

        return response()->json(['success' => true]);
    }

    public function simpanCatatan(Request $request)
    {
        // Validasi input
        $id_pengajuan = $request->input('id_pengajuan');
        $catatan = $request->input('catatan');

        DB::table('pengajuan')->where('id_pengajuan', $id_pengajuan)->update(['cat_staf_baku' => $catatan]);

        return response()->json(['success' => true]);
    }

    public function otorisasiPengajuan(Request $request)
    {
        $ids = $request->input('ids'); // ID pengajuan yang dipilih

        // Pastikan ada ID pengajuan yang dipilih
        if (empty($ids)) {
            return response()->json(['success' => false, 'message' => 'Tidak ada pengajuan yang dipilih']);
        }

        $user = Auth::user(); // User yang sedang login

        // Update status pengajuan menjadi Disetujui Ka. BAKU (status 5)
        DB::table('pengajuan')
            ->whereIn('id_pengajuan', $ids)
            ->update([
                'status' => 5,
                'tanggal_acc' => now()
            ]);

        // Menambahkan riwayat untuk setiap pengajuan yang diotorisasi
        foreach ($ids as $id_pengajuan) {
            DB::table('riwayat')->insert([
                'id_pengajuan' => $id_pengajuan,
                'tanggal' => now(),
                'catatan' => 'Disetujui Ka. BAKU',
                'pengaju' => DB::table('pengajuan')->where('id_pengajuan', $id_pengajuan)->value('pengaju'),
                'jumlah' => DB::table('pengajuan')->where('id_pengajuan', $id_pengajuan)->value('jumlah'),
                'tujuan' => DB::table('pengajuan')->where('id_pengajuan', $id_pengajuan)->value('tujuan'),
                'eksekutor' => $user->username, // Eksekutor adalah user yang mengotorisasi
            ]);
        }

        return response()->json(['success' => true]);
    }

    public function konfirmasiTransfer(Request $request)
    {
        $request->validate([
            'id_pengajuan' => 'required',
            'no_perkiraan' => 'required',
            'nominal' => 'required|numeric|min:1',
            'bukti' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048'
        ]);

        $id_pengajuan = $request->id_pengajuan;
        $no_perkiraan = $request->no_perkiraan;
        $nominal = $request->nominal;
        $status = 10;
        $catatan = 'Dana Sudah Di Transfer';

        // Update pengajuan
        DB::table('pengajuan')->where('id_pengajuan', $id_pengajuan)->update([
            'status' => $status,
            'jumlah' => $nominal
        ]);

        // Simpan riwayat
        $pengaju = DB::table('pengajuan')->where('id_pengajuan', $id_pengajuan)->value('pengaju');
        $tujuan = DB::table('pengajuan')->where('id_pengajuan', $id_pengajuan)->value('tujuan');
        DB::table('riwayat')->insert([
            'id_pengajuan' => $id_pengajuan,
            'tanggal' => now(),
            'catatan' => $catatan,
            'pengaju' => $pengaju,
            'jumlah' => $nominal,
            'tujuan' => $tujuan,
            'eksekutor' => Auth::user()->username,
        ]);

        // Simpan file bukti jika ada
        if ($request->hasFile('bukti')) {
            $bukti = $request->file('bukti');
            $buktiName = Auth::user()->username . '_BuktiTrf_' . $id_pengajuan . '.' . $bukti->getClientOriginalExtension();
            $bukti->move(public_path('bukti_trf_baku'), $buktiName);
            DB::table('pengajuan')->where('id_pengajuan', $id_pengajuan)->update(['bukti_trf_dana' => $buktiName]);
        }

        // Jika tiga digit awal no_perkiraan = '100', insert ke tabel kascabang
        if (substr($no_perkiraan, 0, 3) === '100') {
            DB::table('kascabang')->insert([
                'no_perkiraan' => $no_perkiraan,
                'keterangan' => 'Penambahan Dana dari Baku',
                'jumlah' => $nominal,
                'tgl' => now(),
                'id_kampus' => DB::table('pengajuan')->where('id_pengajuan', $id_pengajuan)->value('id_kampus'),
                'user_create' => Auth::user()->username,
            ]);
        }

        return redirect()->back()->with('success', 'Transfer berhasil dikonfirmasi!');
    }

    public function inputKeKas(Request $request)
    {
        $request->validate([
            'id_pengajuan' => 'required',
            'no_perkiraan' => 'required',
            'catatan'      => 'required',
            'jumlah'       => 'required|numeric|min:1',
            'bank_sumber'  => 'required',
            'upload_bukti' => 'required|in:yes,no',
        ]);

        $user = Auth::user();

        // Simpan ke tabel kas
        $dataKas = [
            'no_perkiraan' => $request->no_perkiraan,
            'keterangan'   => $request->catatan,
            'tgl'          => now(),
            'jumlah'       => 0,
            'keluar'       => $request->jumlah,
            'jenis'        => 'keluar',
            'tgl_create'   => now(),
            'user_create'  => $user->username,
            'input'        => $request->id_pengajuan,
            'bank_sumber'  => $request->bank_sumber,
        ];

        DB::table('kas_pusat')->insert($dataKas);
        DB::table('kas_pusat_backup')->insert($dataKas);

        // Logic update status & riwayat
        if ($request->upload_bukti === 'no') {
            // Tidak perlu upload bukti, status selesai
            DB::table('pengajuan')->where('id_pengajuan', $request->id_pengajuan)->update([
                'status' => 3, // Status selesai
            ]);
            DB::table('riwayat')->insert([
                'id_pengajuan' => $request->id_pengajuan,
                'tanggal' => now(),
                'catatan' => 'Pengajuan Selesai',
                'pengaju' => $user->username,
                'jumlah' => $request->jumlah,
                'tujuan' => 'BAKU',
                'eksekutor' => $user->username,
            ]);
        } else {
            // Perlu upload bukti
            DB::table('pengajuan')->where('id_pengajuan', $request->id_pengajuan)->update([
                'status' => 8
            ]);
            DB::table('riwayat')->insert([
                'id_pengajuan' => $request->id_pengajuan,
                'tanggal' => now(),
                'catatan' => 'Dana Sudah di Transfer dan harus melampirkan Bukti dari pemohon',
                'pengaju' => $user->username,
                'jumlah' => $request->jumlah,
                'eksekutor' => $user->username,
            ]);
        }

        return redirect()->back()->with('success', 'Data kas keluar berhasil diinput!');
    }

    public function multi(Request $request)
    {        // Ambil kode kampus dari session
        $idkampus = Auth::user()->id_kampus;
        $levelUser = Auth::user()->level;

        // Inisialisasi query
        $query = DB::table('noperkiraan');

        // Filter khusus jika level user = 7
        if ($levelUser == 7 && $idkampus) {
            $query->where(DB::raw('SUBSTRING(no_perkiraan, 5, 3)'), $idkampus);
        }
        // Ambil data noperkiraan
        $noperkiraan = $query->get();

        // Ambil data karyawan dari tabel karyawan
        $karyawan = DB::table('karyawanbs1')->get();

        // Ambil data no rekening dari tabel no_rekening
        $noRekening = DB::table('no_rekening')->get();
        $bankpemohon = DB::table('bank_pemohon')->get();

        // Kirim ke view
        return view('admin.multi', compact('karyawan', 'noRekening', 'bankpemohon', 'noperkiraan'));
        // return view('layouts.modal', compact('karyawan', 'noRekening'));
    }

    public function storeMulti(Request $request)
    {
        try {
            $request->validate([
                'lampiran' => 'required|file|mimes:pdf|max:2048',
                'noperkiraan' => 'required|string',
                'keterangantambahan' => 'nullable|string',
                'tgl_ajuan' => 'required|date',
                'tgl_dip' => 'required|date',
                'personil' => 'required|array|min:1',
                'personil.*.nip' => 'required|string',
                'personil.*.rekening_id' => 'required|string',
                'personil.*.jumlah' => 'required|numeric',
                'personil.*.type' => 'required|in:0,1',
            ]);

            [$noPerkiraan, $keteranganDb] = explode('|', $request->noperkiraan);

            // Proses upload lampiran sekali saja
            $lampiranName = Auth::user()->username . '_MultiPengajuan_' . now()->format('YmdHis') . '.' . $request->lampiran->getClientOriginalExtension();
            $request->lampiran->move(public_path('dok_pengajuan'), $lampiranName);

            foreach ($request->personil as $item) {
                [$nip, $nama] = explode('|', $item['nip']);
                // Kode pengajuan UNIK untuk setiap personil
                $kodePengajuan = Auth::user()->username . now()->format('Ym') . $nip . rand(100, 999);

                $keteranganGabungan = $keteranganDb . ' - ' . ($request->keterangantambahan ?? '') . ' - ' . $nama;

                DB::table('pengajuan')->insert([
                    'id_pengajuan'   => $kodePengajuan,
                    'rek_tujuan'     => $item['rekening_id'],
                    'no_perkiraan'   => $noPerkiraan . '.' . $nip,
                    'keterangan'     => $keteranganGabungan,
                    'tanggal'        => $request->tgl_ajuan,
                    'tanggal_dip'    => $request->tgl_dip,
                    'jumlah'         => $item['jumlah'],
                    'pemakaian'      => '0',
                    'pengaju'        => Auth::user()->username,
                    'tujuan'         => 'BAKU',
                    'bukti'          => $lampiranName,
                    'id_kampus'      => Auth::user()->id_kampus,
                    'user_create'    => Auth::user()->username,
                    'status'         => '0',
                ]);

                DB::table('riwayat')->insert([
                    'id_pengajuan' => $kodePengajuan,
                    'tanggal'      => now(),
                    'catatan'      => 'Pengajuan multi baru',
                    'pengaju'      => Auth::user()->username,
                    'jumlah'       => $item['jumlah'],
                    'tujuan'       => 'BAKU',
                    'eksekutor'    => Auth::user()->username,
                ]);
            }

            return response()->json(['message' => 'Pengajuan multi berhasil disimpan.']);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Error: ' . $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ], 500);
        }
    }
}
