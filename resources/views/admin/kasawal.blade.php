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
                                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                                <li class="breadcrumb-item"><a href="#">Tabel</a></li>
                                <li class="breadcrumb-item active">Data Top Up Awal</li>
                            </ol>
                        </div>
                    </div>
                </div>
                <div class="content-header-right col-md-6 col-12">
                    <div class="btn-group float-md-right">
                        <button class="btn btn-info dropdown-toggle mb-1" type="button" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">Tambah Data</button>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- Zero configuration table -->
                <section id="configuration">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                @if (session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                @if (session('error'))
                                    <div class="alert alert-danger">
                                        {{ session('error') }}
                                    </div>
                                @endif

                                <div class="card-header">
                                    <h4 class="card-title">Top up Kas Awal</h4>
                                </div>
                                <div class="card-content collapse show">
                                    <div class="box-body">
                                        <form action="{{ route('kas.proses') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead class="thead-dark">
                                                        <tr>
                                                            <th>No.</th>
                                                            <th>Keterangan</th>
                                                            <th>Jumlah Transfer</th>
                                                            <th>Status</th>
                                                            <th>Aksi</th>
                                                            <th>
                                                                <button type="submit" name="proses"
                                                                    class="btn btn-success">Proses</button>
                                                                @if ($dataKas->count() > 0)
                                                                    <input type="checkbox" onchange="checkAll(this)">
                                                                @endif
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $no = 1;
                                                            $total = 0;
                                                            $i = 0;
                                                        @endphp
                                                        @foreach ($dataKas as $item)
                                                            @php
                                                                $total += $item->jumlah;
                                                                $i++;
                                                            @endphp
                                                            <tr>
                                                                <td>{{ $no++ }}</td>
                                                                <input type="hidden" name="kode[]"
                                                                    value="{{ $item->no_perkiraan }}">
                                                                <input type="hidden" name="id_kampus[]"
                                                                    value="{{ $item->id_kampus }}">
                                                                <td>
                                                                    {{ $item->keterangan }}
                                                                    <input type="hidden" name="keterangan[]"
                                                                        value="{{ $item->keterangan }}">
                                                                </td>
                                                                <td>
                                                                    {{ number_format($item->jumlah) }},-
                                                                    <input type="hidden" name="jumlah[]"
                                                                        value="{{ $item->jumlah }}">
                                                                </td>
                                                                <td>{{ $sts }}</td>
                                                                <td>
                                                                    <button type="button" class="btn btn-warning btn-sm"
                                                                        onclick="editKas({{ $item->no_perkiraan }}, '{{ $item->keterangan }}', {{ $item->jumlah }})">Ubah</button>
                                                                </td>
                                                                <td align="center">
                                                                    <input type="checkbox" name="chkBox[]"
                                                                        value="{{ $item->no_perkiraan }},{{ $i }}">
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="2"
                                                                style="text-align: left; font-size: 17px; color: maroon;">
                                                                Total Transfer :</td>
                                                            <td style="font-size: 17px; text-align: left;">
                                                                <span style="color: green;">Rp.
                                                                    {{ number_format($total) }},-</span>
                                                            </td>
                                                            <td colspan="3"></td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                        </form>
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

    <!-- Modal Ubah Data -->
    <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="editLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editLabel">Ubah Data Kas Awal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('kasawal.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="no_perkiraan" id="no_perkiraan">

                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <input type="text" class="form-control" name="keterangan" id="keterangan" required>
                        </div>

                        <div class="form-group">
                            <label for="jumlah">Jumlah Transfer</label>
                            <input type="number" class="form-control" name="jumlah" id="jumlah" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

<!-- Script untuk Check All -->
<script>
    function checkAll(source) {
        checkboxes = document.querySelectorAll('input[type="checkbox"][name="chkBox[]"]');
        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = source.checked;
        }
    }
</script>

<!-- Script untuk Menampilkan Modal -->
<script>
    function editKas(no_perkiraan, keterangan, jumlah) {
        // Mengisi data ke modal
        $('#no_perkiraan').val(no_perkiraan);
        $('#keterangan').val(keterangan);
        $('#jumlah').val(jumlah);

        // Menampilkan modal
        $('#edit').modal('show');
    }
</script>
