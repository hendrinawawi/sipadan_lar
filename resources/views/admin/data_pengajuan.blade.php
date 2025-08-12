@extends('layouts.main')
@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
                    <h3 class="content-header-title mb-0 d-inline-block">Data Pengajuan</h3>
                    <div class="row breadcrumbs-top d-inline-block">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                                <li class="breadcrumb-item"><a href="#">Tabel</a></li>
                                <li class="breadcrumb-item active">Data Pengajuan</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <section id="mobile-support">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Data Pengajuan <b> {{ $statusLabel }} </b></h4>
                                </div>
                                @if (session('success'))
                                    <script>
                                        Swal.fire({
                                            title: 'Berhasil!',
                                            text: '{{ session('success') }}',
                                            icon: 'success',
                                            confirmButtonText: 'OK'
                                        });
                                    </script>
                                @endif

                                <div class="card-content collapse show">
                                    <div class="card-body card-dashboard">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered zero-configuration">
                                                <thead>
                                                    @php
                                                        $userLevel = Auth::user()->level;
                                                    @endphp
                                                    <tr>
                                                        <th>No.</th>
                                                        @if (in_array($userLevel, [1, 2]) && isset($status) && $status == 11)
                                                            <th>
                                                                <button type="button" class="btn btn-primary btn-sm"
                                                                    id="btn-prootorisasi">Multi <br> Otorisasi</button> <br>
                                                                <input type="checkbox" id="checkAll">
                                                            </th>
                                                        @endif
                                                        <th>Tgl Pengajuan</th>
                                                        <th>Tgl Diperlukan</th>
                                                        <th>Keterangan</th>
                                                        <th>Type</th>
                                                        <th>Lampiran</th>
                                                        <th>Jumlah</th>
                                                        <th>Pemohon</th>
                                                        <th>Tujuan Transfer</th>
                                                        <th>Note BAKU</th>
                                                        <th>Status</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $userLevel = Auth::user()->level;
                                                    @endphp
                                                    @foreach ($datapengajuan as $pengajuan)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>

                                                            {{-- Checkbox hanya untuk level 1 atau 2 --}}
                                                            @if (in_array($userLevel, [1, 2]) && isset($status) && $status == 11)
                                                                <td>
                                                                    <input type="checkbox" name="selected[]"
                                                                        value="{{ $pengajuan->id_pengajuan }}">
                                                                </td>
                                                            @endif

                                                            <td>{{ \Carbon\Carbon::parse($pengajuan->tanggal)->format('d M Y') }}
                                                            </td>
                                                            <td>{{ \Carbon\Carbon::parse($pengajuan->tanggal_dip)->format('d M Y') }}
                                                            </td>
                                                            <td>
                                                                {{ \Illuminate\Support\Str::limit($pengajuan->keterangan, 50) }}
                                                                <button type="button"
                                                                    class="btn btn-link btn-sm btn-detail"
                                                                    data-keterangan="{{ $pengajuan->keterangan }}">
                                                                    Detail
                                                                </button>
                                                            </td>
                                                            <td>{{ $pengajuan->pemakaian == 0 ? 'Baru' : 'Reimburse' }}</td>
                                                            <td>
                                                                @if ($pengajuan->bukti)
                                                                    <a href="{{ asset('dok_pengajuan/' . $pengajuan->bukti) }}"
                                                                        target="_blank">Lihat</a>
                                                                @else
                                                                    -
                                                                @endif
                                                            </td>
                                                            <td>Rp {{ number_format($pengajuan->jumlah, 0, ',', '.') }}
                                                            </td>
                                                            <td>{{ $pengajuan->nama_lengkap }}</td>
                                                            <td>{{ $pengajuan->rek_tujuan . ' - ' . $pengajuan->atas_nama }}
                                                            </td>
                                                            <td>{{ $pengajuan->cat_staf_baku ?? '-' }}</td>
                                                            <td>
                                                                <span
                                                                    class="btn btn-info round btn-sm">{{ $pengajuan->nama_status }}</span>
                                                                <br> <br>
                                                                <button type="button"
                                                                    class="btn btn-dark round btn-sm btn-detail-pengajuan"
                                                                    data-id="{{ $pengajuan->id_pengajuan }}">
                                                                    Cek Riwayat
                                                                </button>
                                                            </td>

                                                            <!-- Button Aksi Dimuat disini -->
                                                            <td>
                                                                @switch($pengajuan->status)
                                                                    {{-- STATUS 0: Menunggu Persetujuan --}}
                                                                    @case(0)
                                                                        @if (in_array($userLevel, [1, 2]))
                                                                            {{-- Otorisasi hanya untuk level 1 dan 2 --}}
                                                                            <a href="#" class="btn btn-primary btn-sm btn-acc"
                                                                                data-id="{{ $pengajuan->id_pengajuan }}">
                                                                                Otorisasi
                                                                            </a>
                                                                        @endif

                                                                        @if (in_array($userLevel, [1, 2, 3]))
                                                                            {{-- Tombol lainnya untuk level 1, 2, 3 --}}
                                                                            <a href="#"
                                                                                class="btn btn-danger btn-sm btn-tolak"
                                                                                data-id="{{ $pengajuan->id_pengajuan }}">
                                                                                Tolak
                                                                            </a>
                                                                            <a href="#"
                                                                                class="btn btn-warning btn-sm btn-revisi"
                                                                                data-id="{{ $pengajuan->id_pengajuan }}"
                                                                                data-jumlah="{{ $pengajuan->jumlah }}">
                                                                                Revisi
                                                                            </a>
                                                                            <a href="#"
                                                                                class="btn btn-info btn-sm btn-ajukan-kabaku"
                                                                                data-toggle="modal" data-target="#modalAjukanKaBaku"
                                                                                data-id="{{ $pengajuan->id_pengajuan }}">
                                                                                Ajukan ke Ka. BAKU
                                                                            </a>
                                                                            <a href="#"
                                                                                class="btn btn-secondary btn-sm btn-catatan"
                                                                                data-id="{{ $pengajuan->id_pengajuan }}">
                                                                                Buat Catatan
                                                                            </a>
                                                                        @endif
                                                                    @break

                                                                    {{-- STATUS 1: Menunggu Revisi --}}
                                                                    @case(1)
                                                                        @if (in_array($userLevel, [1, 2, 3]))
                                                                            <a href="#"
                                                                                class="btn btn-primary btn-sm">Menunggu
                                                                                Revisi</a>
                                                                        @else
                                                                            <a href="#" class="btn btn-warning btn-sm">Ajukan
                                                                                Revisi</a>
                                                                        @endif
                                                                    @break

                                                                    {{-- STATUS 2: Sudah Revisi --}}
                                                                    @case(2)
                                                                        @if (in_array($userLevel, [1, 2, 3]))
                                                                            <a href="#"
                                                                                class="btn btn-danger btn-sm btn-tolak">Tolak</a>
                                                                            <a href="#"
                                                                                class="btn btn-warning btn-sm btn-revisi"
                                                                                data-id="{{ $pengajuan->id_pengajuan }}"
                                                                                data-jumlah="{{ $pengajuan->jumlah }}">
                                                                                Revisi
                                                                            </a>
                                                                            <a href="#"
                                                                                class="btn btn-info btn-sm btn-ajukan-kabaku">Ajukan
                                                                                ke
                                                                                Ka. BAKU</a>
                                                                            <a href="#" class="btn btn-success btn-sm">Acc
                                                                                Pengajuan</a>
                                                                        @else
                                                                            <a href="#" class="btn btn-secondary btn-sm">Sudah
                                                                                Revisi</a>
                                                                        @endif
                                                                    @break

                                                                    {{-- STATUS 3: Selesai --}}
                                                                    @case(3)
                                                                        <a href="#" class="btn btn-primary btn-sm">Selesai</a>
                                                                    @break

                                                                    {{-- STATUS 4: Ditolak --}}
                                                                    @case(4)
                                                                        <a href="#" class="btn btn-danger btn-sm">Ditolak</a>
                                                                    @break

                                                                    {{-- STATUS 5: Disetujui Ka BAKU --}}
                                                                    @case(5)
                                                                        @if (in_array($userLevel, [1, 2, 3]))
                                                                            <a href="#" class="btn btn-primary btn-sm"
                                                                                data-toggle="modal"
                                                                                data-target="#modalKonfirmasiTransfer"
                                                                                data-id="{{ $pengajuan->id_pengajuan }}"
                                                                                data-no_perkiraan="{{ $pengajuan->no_perkiraan }}">
                                                                                Konfirmasi Transfer
                                                                            </a>
                                                                        @else
                                                                            <a href="#"
                                                                                class="btn btn-secondary btn-sm">Menunggu
                                                                                Pencairan</a>
                                                                        @endif
                                                                    @break

                                                                    {{-- STATUS 8: Menunggu Bukti --}}
                                                                    @case(8)
                                                                        @if (in_array($userLevel, [1, 2, 3]))
                                                                            <a href="#"
                                                                                class="btn btn-warning btn-sm">Menunggu
                                                                                Bukti</a>
                                                                        @else
                                                                            <a href="#" class="btn btn-info btn-sm">Upload
                                                                                Bukti</a>
                                                                        @endif
                                                                    @break

                                                                    {{-- STATUS 9: Sudah Kirim Bukti --}}
                                                                    @case(9)
                                                                        @if (in_array($userLevel, [1, 2, 3]))
                                                                            <a href="#" class="btn btn-primary btn-sm">Cek
                                                                                Bukti</a>
                                                                        @else
                                                                            <a href="#" class="btn btn-info btn-sm">Upload
                                                                                Bukti</a>
                                                                        @endif
                                                                    @break

                                                                    {{-- STATUS 10: Sudah Transfer --}}
                                                                    @case(10)
                                                                        @if (in_array($userLevel, [1, 3]))
                                                                            <a href="#" class="btn btn-success btn-sm"
                                                                                data-toggle="modal" data-target="#modalInputKas"
                                                                                data-id="{{ $pengajuan->id_pengajuan }}"
                                                                                data-noperkiraan="{{ $pengajuan->no_perkiraan }}"
                                                                                data-keterangan="{{ $pengajuan->keterangan }}"
                                                                                data-jumlah="{{ $pengajuan->jumlah }}">
                                                                                Input ke Kas
                                                                            </a>
                                                                        @else
                                                                            <a href="#"
                                                                                class="btn btn-secondary btn-sm">Sudah
                                                                                Transfer</a>
                                                                        @endif
                                                                    @break

                                                                    {{-- STATUS 11: Sudah Cek Staf BAKU --}}
                                                                    @case(11)
                                                                        @if (in_array($userLevel, [1, 2]))
                                                                            <a href="#"
                                                                                class="btn btn-primary btn-sm btn-acc"
                                                                                data-id="{{ $pengajuan->id_pengajuan }}">
                                                                                Otorisasi
                                                                            </a>
                                                                            <a href="#"
                                                                                class="btn btn-danger btn-sm btn-tolak"
                                                                                data-id="{{ $pengajuan->id_pengajuan }}">
                                                                                Tolak
                                                                            </a>
                                                                            <a href="#"
                                                                                class="btn btn-warning btn-sm btn-revisi"
                                                                                data-id="{{ $pengajuan->id_pengajuan }}"
                                                                                data-jumlah="{{ $pengajuan->jumlah }}">
                                                                                Revisi
                                                                            </a>
                                                                        @else
                                                                            <a href="#"
                                                                                class="btn btn-secondary btn-sm">Dicek
                                                                                BAKU</a>
                                                                        @endif
                                                                    @break

                                                                    {{-- DEFAULT --}}

                                                                    @default
                                                                        <span class="badge badge-secondary">Status Tidak
                                                                            Dikenal</span>
                                                                @endswitch
                                                            </td>
                                                            <!-- Akhir Aksi -->
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </section>
            </div>
        </div>
    </div>

    <!-- Modal Detail Keterangan -->
    <div class="modal fade" id="modalDetailKeterangan" tabindex="-1" aria-labelledby="modalDetailKeteranganLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-secondary white">
                    <h5 class="modal-title text-white" id="modalDetailKeteranganLabel">Detail Pengajuan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-white">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="keterangan-lengkap" style="white-space: normal;"></div>
                    <!-- Keterangan akan ditampilkan di sini -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Riwayat History Pengajuan -->
    <div class="modal fade text-left" id="modalDetail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1"
        aria-hidden="true">
        <div class="modal-dialog modal-lg"> <!-- Tambahkan kelas modal-lg di sini -->
            <div class="modal-content">
                <div class="modal-header bg-secondary white">
                    <h5 class="modal-title text-white" id="modalDetailLabel">Detail Pengajuan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Menampilkan detail pengajuan -->
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead class="bg-yellow bg-lighten-4">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Deskripsi</th>
                                    <th>Jumlah</th>
                                    <th>Eksekutor</th>
                                </tr>
                            </thead>
                            <tbody id="riwayat-table">
                                <!-- Riwayat data akan dimuat disini -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Konfirmasi Transfer -->
    <div class="modal fade" id="modalKonfirmasiTransfer" tabindex="-1" aria-labelledby="modalKonfirmasiTransferLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ url('/konfirmasi-transfer') }}" enctype="multipart/form-data"
                id="formKonfirmasiTransfer">
                @csrf
                <input type="hidden" name="id_pengajuan" id="id_pengajuan">
                <input type="hidden" name="no_perkiraan" id="no_perkiraan">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalKonfirmasiTransferLabel">Konfirmasi Transfer</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="nominal_transfer">Nominal Transfer:</label>
                            <input name="nominal" id="nominal_transfer" class="form-control" type="number"
                                min="1" required>
                        </div>
                        <div id="bukti_transfer_section" class="form-group">
                            <label for="bukti_file">Upload Bukti Transfer: (Opsional)</label>
                            <input type="file" name="bukti" id="bukti_file" class="form-control"
                                accept="image/*, .pdf">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Konfirmasi Transfer</button>
                    </div>
                </div>
            </form>
        </div>
    </div>



    <!-- Modal Revisi -->
    <div class="modal fade" id="modalRevisi" tabindex="-1" aria-labelledby="modalRevisiLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalRevisiLabel">Masukkan Alasan Revisi dan Jumlah Baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <label for="catatan-revisi">Masukkan Alasan Revisi:</label>
                    <textarea id="catatan-revisi" class="form-control" rows="4" placeholder="Masukkan alasan revisi..."></textarea>

                    <label for="jumlah-revisi">Jumlah Baru: (Opsional)</label>
                    <input id="jumlah-revisi" class="form-control" type="number" placeholder="Jumlah baru (opsional)">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="submitRevisi">Simpan Revisi</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Input ke Kas -->
    <div class="modal fade" id="modalInputKas" tabindex="-1" role="dialog" aria-labelledby="modalInputKasLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="POST" action="{{ route('input.kas') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalInputKasLabel">Form Konfirmasi Transfer Dana</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        {{-- Id Pengajuan --}}
                        <input type="hidden" name="id_pengajuan" id="inputIdPengajuan">

                        {{-- No Perkiraan --}}
                        <input type="hidden" name="no_perkiraan" id="inputNoPerkiraan">

                        {{-- Keterangan --}}
                        <div class="form-group">
                            <label for="inputKeterangan">Keterangan</label>
                            <textarea name="keterangan" id="inputKeterangan" class="form-control" rows="3" readonly></textarea>
                        </div>

                        {{-- Tanggal Laporan BAKU --}}
                        <div class="form-group">
                            <label for="inputTglLaporan">Tanggal di Laporan Kas BAKU</label>
                            <input type="date" name="tgl_laporan" id="inputTglLaporan" class="form-control"
                                value="{{ date('Y-m-d') }}">
                        </div>

                        {{-- Jumlah --}}
                        <div class="form-group">
                            <label for="inputJumlah">Jumlah Transfer</label>
                            <input type="number" name="jumlah" id="inputJumlah" class="form-control" min="1"
                                required readonly>
                        </div>

                        {{-- Catatan Laporan --}}
                        <div class="form-group">
                            <label for="inputCatatan">Catatan Di Laporan Kas BAKU</label>
                            <textarea name="catatan" id="inputCatatan" class="form-control" rows="2"
                                placeholder="Pembayaran Dana Untuk Kegiatan"></textarea>
                        </div>

                        {{-- Upload Bukti --}}
                        <div class="form-group">
                            <label>Perlu Bukti Transaksi dari Pemohon?</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="upload_bukti" id="upload_bukti_yes"
                                    value="yes">
                                <label class="form-check-label" for="upload_bukti_yes">Ya</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="upload_bukti" id="upload_bukti_no"
                                    value="no" checked>
                                <label class="form-check-label" for="upload_bukti_no">Tidak</label>
                            </div>
                        </div>

                        {{-- Bank Sumber --}}
                        <div class="form-group">
                            <label for="inputBankSumber">Sumber Dana</label>
                            <select name="bank_sumber" id="inputBankSumber" class="form-control" required>
                                <option value="">-- Pilih Sumber Dana --</option>
                                @foreach ($bankSumber as $bank)
                                    <option value="{{ $bank->nama_bank }}">{{ $bank->nama_bank }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Input di Kas</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            // Pilih semua checkbox
            $('#checkAll').on('click', function() {
                var checked = $(this).prop('checked');
                $('input[name="selected[]"]').prop('checked', checked);
            });

            // Otorisasi pengajuan yang dipilih
            $('#btn-prootorisasi').on('click', function() {
                var selectedIds = [];
                $('input[name="selected[]"]:checked').each(function() {
                    selectedIds.push($(this)
                        .val()); // Ambil id_pengajuan dari checkbox yang dipilih
                });

                if (selectedIds.length === 0) {
                    Swal.fire('Peringatan', 'Pilih pengajuan yang ingin diotorisasi', 'warning');
                    return;
                }

                // Kirim request untuk mengubah status pengajuan menjadi Disetujui Ka. BAKU (status 5)
                $.ajax({
                    url: '/otorisasi-pengajuan', // Ganti dengan rute yang sesuai
                    method: 'POST',
                    data: {
                        ids: selectedIds, // ID pengajuan yang dipilih
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('Sukses', 'Pengajuan berhasil diotorisasi', 'success');
                            location.reload(); // Reload halaman untuk melihat perubahan
                        } else {
                            Swal.fire('Gagal', 'Gagal mengotorisasi pengajuan', 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire('Terjadi Kesalahan', 'Silakan coba lagi', 'error');
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Ketika tombol Detail diklik
            $('.btn-detail').on('click', function() {
                var keterangan = $(this).data('keterangan'); // Ambil data-keterangan

                // Format teks keterangan sesuai dengan format yang diinginkan
                var formatted = keterangan
                    .replace(/(?:\r\n|\r|\n)/g, '<br>') // Mengganti line breaks dengan <br>
                    .replace(/(?:^|\<br\>)[\-\*]\s?(.*?)(?=\<br\>|$)/g, function(match, p1) {
                        // Ganti - atau * dengan <li> untuk bullet points
                        return '<li>' + p1 + '</li>';
                    });

                // Jika ada <li>, bungkus dengan <ul>
                if (formatted.includes('<li>')) {
                    formatted = '<ul style="padding-left: 1.2em">' + formatted.replace(/<br>/g, '') +
                        '</ul>';
                }

                // Untuk menangani titik dua dan elemen lain, kita tetap tampilkan teks secara apa adanya
                formatted = formatted.replace(/:(.*)/g, function(match, p1) {
                    return ':' + p1; // Menjaga titik dua di dalam teks tetap ada
                });

                // Tampilkan keterangan yang sudah diformat di modal
                $('#keterangan-lengkap').html(formatted);
                $('#modalDetailKeterangan').modal('show'); // Tampilkan modal
            });
        });
    </script>
    <!-- Modal Riwayat History Pengajuan -->
    <script>
        $(document).ready(function() {
            $('.btn-detail-pengajuan').on('click', function() {
                var id_pengajuan = $(this).data('id');

                // Ajax request untuk mengambil data pengajuan dan riwayat
                $.ajax({
                    url: '{{ route('riwayat.pengajuan', ':id') }}'.replace(':id', id_pengajuan),
                    type: 'GET',
                    success: function(response) {
                        // Cek dan log respons
                        console.log(response); // Untuk memeriksa format respons

                        if (response.riwayat && response.riwayat.length > 0) {
                            // Isi data pengajuan pada modal
                            $('#pengajuan-id').text(response.pengajuan.id_pengajuan);
                            $('#pengajuan-tanggal').text(response.pengajuan.tanggal);
                            $('#pengajuan-eksekutor').text(response.pengajuan.eksekutor);
                            $('#pengajuan-jumlah').text(response.pengajuan.jumlah);

                            // Bersihkan dan isi riwayat pengajuan
                            $('#riwayat-table').empty(); // Kosongkan tabel riwayat
                            response.riwayat.forEach(function(item) {
                                // Format jumlah ke dalam format angka dengan pemisah ribuan
                                var jumlahFormatted = new Intl.NumberFormat('id-ID')
                                    .format(item.jumlah);

                                $('#riwayat-table').append(
                                    '<tr><td>' + item.tanggal + '</td><td>' + item
                                    .catatan + '</td><td>' + jumlahFormatted +
                                    '</td><td>' + item.eksekutor + '</td></tr>'
                                );
                            });

                            // Tampilkan modal
                            $('#modalDetail').modal('show');
                        } else {
                            console.log("Data riwayat tidak ditemukan");
                            // Tampilkan pesan bahwa riwayat tidak ditemukan jika tidak ada data riwayat
                            $('#riwayat-table').append(
                                '<tr><td colspan="2">Riwayat tidak ditemukan.</td></tr>');
                            $('#modalDetail').modal('show');
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Gagal memuat data riwayat pengajuan.');
                    }
                });
            });
        });
    </script>

    <!-- Proses Bisnis -->
    <script>
        // Proses Tolak Pengajuan
        $(document).on('click', '.btn-tolak', function() {
            var id_pengajuan = $(this).data('id'); // Ambil ID Pengajuan

            // Menampilkan SweetAlert2 untuk meminta alasan penolakan
            Swal.fire({
                title: 'Masukkan Alasan Penolakan',
                input: 'textarea',
                inputPlaceholder: 'Masukkan alasan...',
                showCancelButton: true,
                confirmButtonText: 'Tolak Pengajuan',
                cancelButtonText: 'Batal',
                inputValidator: (value) => {
                    if (!value) {
                        return 'Alasan penolakan harus diisi';
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    var alasan = result.value; // Dapatkan alasan dari SweetAlert2

                    // Ajax request untuk menolak pengajuan
                    $.ajax({
                        url: '/tolak-pengajuan',
                        method: 'POST',
                        data: {
                            id_pengajuan: id_pengajuan,
                            alasan: alasan,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire('Pengajuan Ditolak', 'Pengajuan berhasil ditolak',
                                    'success');
                                location.reload(); // Refresh halaman
                            } else {
                                Swal.fire('Gagal', 'Gagal menolak pengajuan', 'error');
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire('Terjadi Kesalahan', 'Silakan coba lagi', 'error');
                        }
                    });
                }
            });
        });


        // Proses Revisi Pengajuan
        $(document).on('click', '.btn-revisi', function() {
            var id_pengajuan = $(this).data('id'); // Ambil ID Pengajuan
            var jumlahLama = $(this).data('jumlah'); // Ambil jumlah dari data-jumlah

            // Isi form modal dengan data yang ada
            $('#jumlah-revisi').val(jumlahLama); // Isi jumlah lama
            $('#catatan-revisi').val(''); // Kosongkan catatan revisi

            // Tampilkan modal revisi
            $('#modalRevisi').modal('show');

            // Ketika tombol "Simpan Revisi" di modal diklik
            $('#submitRevisi').on('click', function() {
                var catatanRevisi = $('#catatan-revisi').val(); // Ambil catatan dari textarea
                var jumlahRevisi = $('#jumlah-revisi').val(); // Ambil jumlah dari input number

                if (catatanRevisi.trim() === '') {
                    alert('Alasan revisi harus diisi.');
                    return;
                }

                // AJAX request untuk memperbarui status menjadi Revisi (status 1)
                $.ajax({
                    url: '/revisi-pengajuan', // Ganti dengan URL yang sesuai
                    method: 'POST',
                    data: {
                        id_pengajuan: id_pengajuan,
                        catatan: catatanRevisi,
                        jumlah: jumlahRevisi,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            alert('Pengajuan berhasil direvisi');
                            $('#modalRevisi').modal('hide'); // Tutup modal setelah berhasil
                            location.reload(); // Reload halaman untuk melihat perubahan
                        } else {
                            alert('Gagal revisi pengajuan');
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Terjadi kesalahan. Silakan coba lagi.');
                    }
                });
            });
        });
        //Sudah cek staf Baku
        $(document).on('click', '.btn-ajukan-kabaku', function() {
            var id_pengajuan = $(this).data('id');

            // Menampilkan SweetAlert2 untuk konfirmasi
            Swal.fire({
                title: 'Ajukan ke Ka. BAKU?',
                text: 'Pengajuan akan diajukan ke Ka. BAKU untuk di Otorisasi.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ajukan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Ajax request untuk mengubah status menjadi 11 (Sudah Cek Staf BAKU)
                    $.ajax({
                        url: '/ajukan-ka-baku',
                        method: 'POST',
                        data: {
                            id_pengajuan: id_pengajuan,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire('Diajukan ke Ka. BAKU',
                                'Pengajuan berhasil diajukan ke Ka. BAKU', 'success');
                            location.reload(); // Refresh halaman
                        },
                        error: function(xhr, status, error) {
                            Swal.fire('Terjadi Kesalahan', 'Silakan coba lagi', 'error');
                        }
                    });
                }
            });
        });


        // Proses Acc Pengajuan
        $(document).on('click', '.btn-acc', function() {
            var id_pengajuan = $(this).data('id');

            // Menampilkan konfirmasi dengan SweetAlert2
            Swal.fire({
                title: 'Anda yakin ingin menyetujui pengajuan ini?',
                text: 'Pengajuan Disetuji Ka. BAKU.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Setujui',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Ajax request untuk mengubah status menjadi Disetujui Ka BAKU (status 5)
                    $.ajax({
                        url: '/acc-pengajuan',
                        method: 'POST',
                        data: {
                            id_pengajuan: id_pengajuan,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire('Disetujui', 'Pengajuan berhasil disetujui', 'success');
                            location.reload(); // Refresh halaman
                        },
                        error: function(xhr, status, error) {
                            Swal.fire('Terjadi Kesalahan', 'Silakan coba lagi', 'error');
                        }
                    });
                }
            });
        });

        // Buat Catatan Pengajuan
        $(document).on('click', '.btn-catatan', function() {
            var id_pengajuan = $(this).data('id'); // Ambil ID Pengajuan

            // Menampilkan SweetAlert2 untuk meminta catatan
            Swal.fire({
                title: 'Catatan Pengajuan',
                input: 'textarea',
                inputPlaceholder: 'Masukkan Catatan...',
                showCancelButton: true,
                confirmButtonText: 'Simpan Catatan',
                cancelButtonText: 'Batal',
                inputValidator: (value) => {
                    if (!value) {
                        return 'Catatan harus diisi';
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    var catatan = result.value; // Dapatkan catatan dari SweetAlert2

                    // Ajax request untuk menolak pengajuan
                    $.ajax({
                        url: '/simpan-catatan',
                        method: 'POST',
                        data: {
                            id_pengajuan: id_pengajuan,
                            catatan: catatan,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            console.log(response); // Periksa respons
                            if (response.success) {
                                Swal.fire('Catatan berhasil disimpan', '', 'success');
                                location.reload(); // Refresh halaman
                            } else {
                                Swal.fire('Terjadi kesalahan', '', 'error');
                                location.reload(); // Refresh halaman
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire('Terjadi kesalahan', 'Silakan coba lagi', 'error');
                        }
                    });
                }
            });
        });
    </script>
    <!-- Script untuk otomatis mengisi nominal transfer dari tabel -->
    <script>
        // Jika ingin auto-set id_pengajuan dan no_perkiraan dari tombol tabel ke form modal
        $(document).on('click', '[data-target="#modalKonfirmasiTransfer"]', function() {
            var id_pengajuan = $(this).data('id');
            var no_perkiraan = $(this).data('no_perkiraan');
            var nominal = $(this).closest('tr').find('td:eq(7)').text().replace(/[^\d]/g, '');

            $('#formKonfirmasiTransfer #id_pengajuan').val(id_pengajuan);
            $('#formKonfirmasiTransfer #no_perkiraan').val(no_perkiraan);
            $('#formKonfirmasiTransfer #nominal_transfer').val(nominal);
        });

        // Input Ke Kas
        $('#modalInputKas').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            $('#inputIdPengajuan').val(button.data('id'));
            $('#inputNoPerkiraan').val(button.data('noperkiraan'));
            $('#inputKeterangan').val(button.data('keterangan'));
            $('#inputJumlah').val(button.data('jumlah'));
        });
    </script>
@endsection
