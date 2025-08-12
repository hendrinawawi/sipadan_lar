@extends('layouts.main')
@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
                    <h3 class="content-header-title mb-0 d-inline-block">Buat Pengajuan</h3>
                    <div class="row breadcrumbs-top d-inline-block">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Home</a>
                                </li>
                                <li class="breadcrumb-item"><a href="#">Form</a>
                                </li>
                                <li class="breadcrumb-item active">Buat Pengajuan
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- Basic form layout section start -->
                <section id="basic-form-layouts">
                    <div class="row match-height">
                        <div class="col-md-10">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title" id="basic-layout-form">Form Pengajuan Dana</h4>
                                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                </div>
                                {{-- Tampilkan pesan sukses --}}
                                @if (session('success'))
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            Swal.fire({
                                                title: 'Sukses!',
                                                text: "{{ session('success') }}",
                                                icon: 'success',
                                                confirmButtonText: 'OK'
                                            });
                                        });
                                    </script>
                                @endif
                                {{-- Tampilkan error validasi --}}
                                @if ($errors->any())
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Tutup">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif
                                <div class="card-content collapse show">
                                    <div class="card-body">
                                        <form method="POST" action="{{ route('kirim.pengajuan') }}"
                                            enctype="multipart/form-data" id="formPengajuan">
                                            @csrf
                                            <div class="form-body">
                                                {{-- Pilih Rekening --}}
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="rekening_id">Pilih Rekening Penerima
                                                                <a href="#" data-toggle="modal"
                                                                    data-target="#modalTambahRekening">
                                                                    <i class="la la-plus-circle"></i> Daftarkan Nomor
                                                                    Rekening
                                                                </a>
                                                            </label>
                                                            <select name="rekening_id" id="rekening_id"
                                                                class="select2 form-control">
                                                                <option value="">--Pilih Nomor Rekening--</option>
                                                                @foreach ($norekening as $rek)
                                                                    <option value="{{ $rek->no_rekening }}">
                                                                        {{ $rek->no_rekening }} - {{ $rek->nm_bank }} -
                                                                        {{ $rek->atas_nama }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- Pilih Pengajuan Dana --}}
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="pengajuan_id">Pilih Pengajuan Dana</label>
                                                            <select name="noperkiraan" id="noperkiraan"
                                                                class="select2 form-control">
                                                                <option value="">--Pengajuan--</option>
                                                                @foreach ($noperkiraan as $perkiraan)
                                                                    <option
                                                                        value="{{ $perkiraan->no_perkiraan }}|{{ $perkiraan->keterangan }}">
                                                                        {{ $perkiraan->keterangan }}
                                                                    </option>
                                                                @endforeach
                                                            </select>

                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- Keterangan Tambahan --}}
                                                <div class="form-group">
                                                    <label for="keterangan">Keterangan Tambahan</label>
                                                    <textarea id="keterangan" name="keterangantambahan" class="form-control" rows="4"
                                                        placeholder="Rincian Keterangan Dengan Lengkap Untuk Keperluan Apa">{{ old('keterangan') }}</textarea>
                                                </div>

                                                {{-- Tanggal Pengajuan dan Tanggal Diperlukan --}}
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="tanggal_pengajuan">Tanggal Pengajuan</label>
                                                            <input type="text" class="form-control" name="tgl_ajuan"
                                                                value="{{ now() }}" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="tanggal_kegiatan">Tanggal Diperlukan/Kegiatan <span
                                                                    class="text-danger">(H+3 dari tanggal
                                                                    pengajuan)</span></label>
                                                            <input type="date" class="form-control" name="tgl_dip"
                                                                required>
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- Jumlah Pengajuan --}}
                                                <div class="form-group">
                                                    <label for="jumlah">Jumlah Pengajuan (Rp.)</label>
                                                    <input type="number" class="form-control" name="jumlah"
                                                        placeholder="Nominal Diinput Tanpa Titik atau Koma">
                                                </div>

                                                {{-- Jenis Permohonan Dana --}}
                                                <div class="form-group">
                                                    <label>Jenis Permohonan Dana</label>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="type"
                                                            id="reimburse" value="1">
                                                        <label class="form-check-label" for="reimburse">Penggantian Dana
                                                            (Reimburse)</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="type"
                                                            id="baru" value="0" checked>
                                                        <label class="form-check-label" for="baru">Pengajuan
                                                            Baru</label>
                                                    </div>
                                                </div>

                                                {{-- NIP Karyawan --}}
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="nip">NIP Karyawan (Diisi Jika Pengajuan UPD /
                                                                Reimburse)</label>
                                                            <input type="text" name="nip" id="nip"
                                                                class="form-control"
                                                                placeholder="Isi Hanya Jika Pengajuan UPD">
                                                        </div>
                                                    </div>

                                                    {{-- Plat Nomor Kendaraan --}}
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="plat_nomor">Plat Nomor (Jika Pengajuan Service
                                                                Kendaraan)</label>
                                                            <select name="plat_nomor" id="plat_nomor"
                                                                class="form-control">
                                                                <option value="">-- Pilih Plat Nomor --</option>
                                                                @foreach ($dataplat as $plat)
                                                                    <option value="{{ $plat->id_plat }}">
                                                                        {{ $plat->plat_nopol }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- Upload Lampiran --}}
                                                <div class="form-group">
                                                    <label for="lampiran">Upload Lampiran (.pdf Maksimal 2 MB)</label>
                                                    <input type="file" name="lampiran" class="form-control-file"
                                                        accept="application/pdf">
                                                    <small class="text-muted">*Opsional untuk Pengajuan Baru, Wajib untuk
                                                        Reimburse</small>
                                                </div>
                                            </div>

                                            <div class="form-actions">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="la la-check-square-o"></i> Kirim Pengajuan
                                                </button>
                                                {{-- <a href="{{ route('pengajuan.index') }}" class="btn btn-danger">
                                                    <i class="ft-x"></i> Batal
                                                </a> --}}
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Rekening -->
    <div class="modal fade" id="modalTambahRekening" tabindex="-1" role="dialog"
        aria-labelledby="modalTambahRekeningLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('daftar.rekening') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Form Tambah Nomor Rekening</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <label for="bank">Pilih Bank <small>(Hubungi BAKU Jika Pilihan Bank Tidak
                                    Ada)</small></label>
                            <select name="nm_bank" class="select2 form-control" required>
                                <option value="">--Pilih Bank--</option>
                                @foreach ($bankpemohon as $bank)
                                    <option value="{{ $bank->id_bank }}">{{ $bank->nama_bank }}</option>
                                @endforeach
                            </select>

                        </div>

                        <div class="form-group">
                            <label>Nomor Rekening</label>
                            <input type="number" name="no_rekening" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Atas Nama</label>
                            <input type="text" name="atas_nama" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Informasi Tambahan</label>
                            <textarea name="info" class="form-control" placeholder="Informasi Cabang Atau Kosongkan Jika Tidak Diperlukan"></textarea>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
