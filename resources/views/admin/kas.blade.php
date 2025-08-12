@extends('layouts.main')
@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
                    <h3 class="content-header-title mb-0 d-inline-block">Data Kas</h3>
                    <div class="row breadcrumbs-top d-inline-block">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Home</a>
                                </li>
                                <li class="breadcrumb-item"><a href="#">Tabel</a>
                                </li>
                                <li class="breadcrumb-item active">Data Kas
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
                <div class="content-header-right col-md-6 col-12">
                    <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
                        <button type="button" class="btn btn-info round" data-toggle="modal" data-target="#addDataModal">
                            <i class="ft-plus icon-left"></i> Tambah Data
                        </button>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- Zero configuration table -->
                <section id="configuration">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                            <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                            <li><a data-action="close"><i class="ft-x"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-content collapse show">
                                    <div class="card-body card-dashboard">
                                        <!-- Menampilkan pesan sukses jika ada -->
                                        @if (session('success'))
                                            <div class="alert alert-success">
                                                {{ session('success') }}
                                            </div>
                                        @endif
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered zero-configuration">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Tanggal</th>
                                                        <th>Keterangan</th>
                                                        <th>Sumber Dana</th>
                                                        <th>Jumlah</th>
                                                        @if ($jenis == 'keluar')
                                                            <th>Input</th>
                                                        @endif
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($datakas as $index => $kas)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($kas->tgl)->format('d-m-Y') }}
                                                            </td> <!-- Format tanggal -->
                                                            <td>{{ $kas->keterangan }}</td>
                                                            <td>{{ $kas->bank_sumber }}</td> <!-- Sumber dana (jenis) -->
                                                            <td>
                                                                @if ($kas->jenis == 'masuk')
                                                                    {{ number_format($kas->jumlah, 2) }}
                                                                    <!-- Menampilkan jumlah jika jenis "masuk" -->
                                                                @elseif($kas->jenis == 'keluar')
                                                                    {{ number_format($kas->keluar, 2) }}
                                                                    <!-- Menampilkan keluar jika jenis "keluar" -->
                                                                @endif
                                                            </td>
                                                            @if ($jenis == 'keluar')
                                                                <td>
                                                                    @if ($kas->input === 'Manual')
                                                                        {{ $kas->input }}
                                                                    @else
                                                                        <a
                                                                            href="{{ route('pengajuan.timeline', ['id' => $kas->input]) }}">
                                                                            Pengajuan
                                                                        </a>
                                                                    @endif
                                                                </td>
                                                            @endif

                                                            <!-- Format jumlah -->
                                                            <td>
                                                                <!-- Tombol Edit -->
                                                                <button type="button" class="btn btn-warning btn-sm"
                                                                    onclick="editKas({{ $kas->id_kas }})">Edit</button>

                                                                <!-- Tombol Hapus -->
                                                                <form
                                                                    action="{{ route('admin.hapusKas', ['id' => $kas->id_kas, 'jenis' => $jenis]) }}"
                                                                    method="POST" style="display:inline;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        class="btn btn-danger btn-sm">Hapus</button>
                                                                </form>

                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                {{-- <tfoot>
                                                    <tr>
                                                        <th colspan="4" class="text-right">Total:</th>
                                                        <th></th>
                                                        <th></th>
                                                    </tr>
                                                </tfoot> --}}
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <!-- Modal Edit Kas -->
    <div class="modal fade" id="editKasModal" tabindex="-1" role="dialog" aria-labelledby="editKasModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editKasModalLabel">Edit Kas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form untuk Edit Kas -->
                    <form id="editKasForm" action="{{ route('admin.updateKas', $kas->id_kas) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-row">
                            <div class="form-group col-6">
                                <label for="id">ID</label>
                                <input type="text" class="form-control" id="id" name="id"
                                    value="{{ $kas->id_kas }}" readonly>
                            </div>
                            <div class="form-group col-6">
                                <label for="jenis">Jenis</label>
                                <input type="text" class="form-control" id="jenis" name="jenis"
                                    value="{{ $kas->jenis }}" readonly>
                            </div>
                        </div>

                        <!-- Tanggal dan Waktu -->
                        <div class="form-group">
                            <label for="tanggal">Tanggal</label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal"
                                value="{{ \Carbon\Carbon::parse($kas->tgl)->format('Y-m-d') }}" required>
                            <input type="hidden" class="form-control" id="time" name="waktu"
                                value="<?= date('H:i:s') ?>"> <!-- Waktu saat ini -->
                        </div>

                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea class="form-control" id="keterangan" name="keterangan" required>{{ $kas->keterangan }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="sumber">Sumber Dana</label>
                            <select class="form-control" id="bank_sumber" name="bank_sumber" required>
                                <option value="">Pilih Sumber Dana</option>
                                @foreach ($bankSumber as $bank)
                                    <option value="{{ $bank->id_bank }}"
                                        {{ $kas->bank_sumber == $bank->id_bank ? 'selected' : '' }}>{{ $bank->nama_bank }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Input Jumlah untuk Kas Masuk -->
                        <div class="form-group" id="jumlah-group">
                            <label for="jumlah">Jumlah</label>
                            <input type="number" class="form-control" id="jumlah" name="jumlah"
                                value="{{ $kas->jumlah }}" required>
                        </div>
                        <!-- Input Keluar untuk Kas Keluar -->
                        <div class="form-group" id="keluar-group" style="display:none;">
                            <label for="keluar">Keluar</label>
                            <input type="number" class="form-control" id="keluar" name="keluar"
                                value="{{ $kas->keluar }}" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <!-- Tambah Data -->
    <!-- Modal untuk Menambah Data -->
    <div class="modal fade" id="addDataModal" tabindex="-1" role="dialog" aria-labelledby="addDataModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addDataModalLabel">Tambah Data Kas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addDataForm" method="POST" action="{{ route('admin.kasimpan') }}">
                        @csrf

                        <!-- No Perkiraan -->
                        <div class="form-group">
                            <label for="no_perkiraan"> No Perkiraan</label>
                            <select class="select2 form-control" name="no_perkiraan" required>
                                @foreach ($noperkiraan as $perkiraan)
                                    <option value="{{ $perkiraan->no_perkiraan }}">{{ $perkiraan->keterangan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Keterangan -->
                        <div class="form-group">
                            <label for="tgl">Keterangan Tambahan</label>
                            <textarea class="form-control" name="keterangan" required></textarea>
                        </div>
                        <!-- Jenis Transaksi (Masuk/Keluar) -->
                        <div class="form-group">
                            <label for="jenis">Jenis Transaksi</label>
                            <input type="hidden" name="jenis" value="{{ $jenis }}">
                            <input type="text" class="form-control" value="{{ ucfirst($jenis) }}" readonly>
                        </div>

                        <!-- Tanggal -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tgl">Tanggal</label>
                                    <input type="date" class="form-control" id="tgl" name="tgl" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="timeskr">Waktu</label>
                                    <input type="time" class="form-control" id="timeskr" name="waktuskr"
                                        value="{{ now()->setTimezone('Asia/Jakarta')->format('H:i') }}">
                                </div>
                            </div>
                        </div>


                        <!-- Tanggal Create (otomatis diisi) -->
                        <input type="hidden" id="tgl_create" name="tgl_create" value="{{ now() }}">

                        <!-- Jumlah (tergantung pada jenis) -->
                        <div class="form-group" id="jumlah-group">
                            <label for="jumlah">Jumlah</label>
                            <input type="number" class="form-control" id="jumlah" name="jumlah" required>
                        </div>
                        <!-- Bank Sumber -->
                        <div class="form-group">
                            <label for="bank_sumber">Bank Sumber</label>
                            <select class="form-control" id="bank_sumber" name="bank_sumber" required>
                                <option value="">Pilih Bank Sumber</option>
                                @foreach ($bankSumber as $bank)
                                    <option value="{{ $bank->id_bank }}">{{ $bank->nama_bank }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Tombol Submit -->
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Akhir Tambah-->

    <script>
        function editKas(id) {
            // Mengambil data kas dengan ID yang diberikan menggunakan AJAX
            $.get('{{ url('/kas/edit') }}/' + id, function(data) {
                // Isi form modal dengan data yang diterima
                $('#id').val(data.id_kas);
                $('#jenis').val(data.jenis);
                $('#tanggal').val(data.tgl);
                $('#keterangan').val(data.keterangan);
                $('#bank_sumber').val(data.bank_sumber);
                $('#jumlah').val(data.jumlah);
                $('#keluar').val(data.keluar);
                // Set form action untuk update
                $('#editKasForm').attr('action', '{{ url('/kas/update') }}/' + id);

                // Tampilkan modal
                $('#editKasModal').modal('show');
            });
        }
    </script>

    <script>
        // Mengambil waktu saat ini menggunakan JavaScript dan mengisi input
        var currentTime = new Date().toLocaleTimeString(); // Mengambil waktu sekarang dalam format HH:MM:SS
        document.getElementById('time').value = currentTime; // Menetapkan waktu ke input
    </script>
    <script>
        // Fungsi untuk mengubah tampilan input berdasarkan jenis transaksi
        document.getElementById('jenis').addEventListener('change', function() {
            var jenis = this.value;

            // Menyembunyikan semua input terlebih dahulu
            document.getElementById('jumlah-group').style.display = 'none';
            document.getElementById('keluar-group').style.display = 'none';

            // Tampilkan input berdasarkan jenis yang dipilih
            if (jenis === 'masuk') {
                document.getElementById('jumlah-group').style.display = 'block';
            } else if (jenis === 'keluar') {
                document.getElementById('keluar-group').style.display = 'block';
            }
        });

        // Pastikan pada halaman pertama sudah menampilkan input yang sesuai
        window.onload = function() {
            document.getElementById('jenis').dispatchEvent(new Event('change'));
        }
    </script>
@endsection
