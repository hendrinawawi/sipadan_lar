@extends('layouts.main')
@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
                    <h3 class="content-header-title mb-0 d-inline-block">Data No Rek</h3>
                    <div class="row breadcrumbs-top d-inline-block">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Home</a>
                                </li>
                                <li class="breadcrumb-item"><a href="#">Tabel</a>
                                </li>
                                <li class="breadcrumb-item active">Data No Rek
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
                <div class="content-header-right col-md-6 col-12">
                    <div class="btn-group float-md-right">
                        <button type="button" class="btn btn-info mb-1" data-toggle="modal"
                            data-target="#modalTambahRekening">
                            Tambah Data
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
                                                        <th>No.</th>
                                                        <th>#.</th>
                                                        <th>Nama Bank</th>
                                                        <th>No. Rekening</th>
                                                        <th>Atas Nama</th>
                                                        <th>Kampus</th>
                                                        <th>Status</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($datarekening as $index => $rek)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ $rek->id }}</td>
                                                            <td>{{ $rek->nm_bank }}</td>
                                                            <td>{{ $rek->no_rekening }}</td>
                                                            <td>{{ $rek->atas_nama }}</td>
                                                            <td>{{ $rek->nama_kampus ?? '-' }}</td>
                                                            <!-- jika join kampus -->
                                                            <td>
                                                                @if ($rek->status == 'Aktif')
                                                                    <span class="badge badge-success">Aktif</span>
                                                                @else
                                                                    <span class="badge badge-secondary">Nonaktif</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <button type="button" class="btn btn-warning btn-sm"
                                                                    onclick="editrekening({{ $rek->id }})">
                                                                    <i class="la la-edit"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
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
    <!-- Modal Edit Rekening -->
    <div class="modal fade" id="modalEditRekening" tabindex="-1" role="dialog" aria-labelledby="modalEditRekeningLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="editRekeningForm" action="{{ route('admin.updateRekeningStatus') }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="edit-id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Rekening</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Rekening -->
                        <div class="form-group">
                            <label>No. Rekening</label>
                            <input type="text" id="edit-rekening" class="form-control" readonly>
                        </div>

                        <!-- Atas Nama -->
                        <div class="form-group">
                            <label>Atas Nama</label>
                            <input type="text" id="edit-nama" class="form-control" readonly>
                        </div>

                        <!-- Kampus -->
                        <div class="form-group">
                            <label>Kampus</label>
                            <input type="text" id="edit-kampus" class="form-control" readonly>
                        </div>

                        <!-- Status -->
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" id="edit-status" class="form-control" required>
                                <option value="">-Pilih Status-</option>
                                <option value="Aktif">Aktif</option>
                                <option value="Tidak Aktif">Tidak Aktif</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tambah Data -->
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
    <!-- Akhir Tambah-->
    <script>
        // Data JSON seluruh rekening (dikirim dari controller sebagai JSON)
        let dataRekening = @json($datarekening);

        function editrekening(id) {
            // Cari data berdasarkan id
            let rek = dataRekening.find(item => item.id == id);
            if (!rek) return alert('Data tidak ditemukan');

            // Isi ke modal
            $('#edit-id').val(rek.id);
            $('#edit-rekening').val(rek.no_rekening);
            $('#edit-nama').val(rek.atas_nama);
            $('#edit-kampus').val(rek.nama_kampus ?? '-');
            $('#edit-status').val(rek.status);

            // Tampilkan modal
            $('#modalEditRekening').modal('show');
        }
    </script>
@endsection
