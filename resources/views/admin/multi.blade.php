@extends('layouts.main')

@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">Input Multi Pengajuan</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Home</a>
                                </li>
                                <li class="breadcrumb-item"><a href="#">Form</a>
                                </li>
                                <li class="breadcrumb-item active">Multi Pengajuan
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>

                {{-- STEP 1: Input Jumlah Personil --}}
                <div class="col-md-8 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title" id="from-actions-center-search">Input Multiple Pengajuan</h4>
                            <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <form method="GET" action="{{ route('pengajuan.multi') }}">
                                    <div class="card bg-light mb-3">
                                        <div class="card-body">
                                            <label><strong>Jumlah Personil</strong></label>
                                            <input type="number" name="jumlah" class="form-control d-inline-block w-25"
                                                value="{{ request('jumlah') }}" required min="1">
                                            <button type="submit" class="btn btn-primary">Proses</button>
                                            <a href="#" class="ml-3" data-toggle="modal"
                                                data-target="#modalTambahRekening">
                                                <i class="ft-plus"></i> Daftarkan Nomor Rekening
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <script>
                            @if ($errors->any())
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    html: `{!! implode('<br>', $errors->all()) !!}`
                                });
                            @endif

                            @if (session('success'))
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: '{{ session('success') }}',
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                            @endif
                        </script>
                        <div class="card-content">
                            <div class="card-body">
                                {{-- STEP 2: Form Pengajuan --}}
                                @if (request('jumlah'))
                                    <form id="formMultiAjuan" enctype="multipart/form-data">
                                        @csrf
                                        <div class="card bg-light mb-3">
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label>Pengajuan</label>
                                                    <select class="select2 form-control" name="noperkiraan" required>
                                                        <option value="">-- Pengajuan --</option>
                                                        @foreach ($noperkiraan as $noperki)
                                                            <option
                                                                value="{{ $noperki->no_perkiraan }}|{{ $noperki->keterangan }}">
                                                                {{ $noperki->keterangan }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label>Keterangan Pengajuan Tambahan</label>
                                                    <textarea class="form-control" name="keterangantambahan"></textarea>
                                                </div>

                                                <div class="form-row">
                                                    <div class="form-group col-md-4">
                                                        <label>Tanggal Pengajuan</label>
                                                        <input type="datetime-local" name="tgl_ajuan" class="form-control"
                                                            value="{{ now()->format('Y-m-d H:i:s') }}" required>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label>Tanggal Diperlukan</label>
                                                        <input type="date" name="tgl_dip" class="form-control" required>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label>Tujuan</label>
                                                        <input type="text" class="form-control" value="BAKU" readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label>Upload Lampiran (.pdf) <span class="text-danger">- Maksimal 2
                                                            MB</span></label>
                                                    <input type="file" name="lampiran" accept=".pdf"
                                                        class="form-control" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card mb-3">
                                            <div class="card-header">Data Personil</div>
                                            <div class="card-body">
                                                @for ($i = 0; $i < request('jumlah'); $i++)
                                                    <div class="form-row mb-3 border-bottom pb-2">
                                                        <div class="form-group col-md-4">
                                                            <label>NIP</label>
                                                            <select name="personil[{{ $i }}][nip]"
                                                                class="select2 form-control" required>
                                                                <option value="">Pilih NIP...</option>
                                                                @foreach ($karyawan as $p)
                                                                    <option value="{{ $p->nip }}|{{ $p->nama }}">
                                                                        {{ $p->nama }} ({{ $p->nip }})</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label>No Rekening</label>
                                                            <select name="personil[{{ $i }}][rekening_id]"
                                                                class="select2 form-control" required>
                                                                <option value="">Pilih Rekening...</option>
                                                                @foreach ($noRekening as $rek)
                                                                    <option value="{{ $rek->no_rekening }}">
                                                                        {{ $rek->nm_bank }} - ({{ $rek->no_rekening }}) -
                                                                        {{ $rek->atas_nama }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label>Nominal</label>
                                                            <input type="number"
                                                                name="personil[{{ $i }}][jumlah]"
                                                                class="form-control" value="0" required>
                                                        </div>
                                                        <input type="hidden" name="personil[{{ $i }}][type]"
                                                            value="0">
                                                    </div>
                                                @endfor
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-success">Kirim Pengajuan</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
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

    <script>
        $('#formMultiAjuan').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);

            $.ajax({
                url: "{{ route('pengajuan.multiajuankirim') }}",
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: res.message ?? 'Pengajuan multi berhasil disimpan.'
                    }).then(() => location.reload());
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let err = xhr.responseJSON.errors;
                        let msg = Object.values(err).map(val => Array.isArray(val) ? val.join('<br>') :
                            val).join('<br>');
                        Swal.fire({
                            icon: 'error',
                            title: 'Validasi Gagal',
                            html: msg
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Terjadi kesalahan sistem'
                        });
                    }
                }
            });
        });
    </script>

@endsection
