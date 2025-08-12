@extends('layouts.main')
@section('content')
    @php
        use Carbon\Carbon;
    @endphp

    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">Kas Periode</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Home</a>
                                </li>
                                <li class="breadcrumb-item"><a href="#">Tabel</a>
                                </li>
                                <li class="breadcrumb-item active">kas Periode
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-body">
                <!-- DOM - jQuery events table -->
                <section id="dom">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Kas Periode</h4>
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
                                <div class="card-body">
                                    <form action="{{ route('kas.filterperiode') }}" method="POST"
                                        class="form form-horizontal">
                                        @csrf
                                        <div class="row">
                                            <div class="form-group col-md-4">
                                                <label for="tgl_awal" class="">Tanggal Awal</label>
                                                <input type="date" id="tgl_awal" name="tgl_awal" class="form-control">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="tgl_akhir" class="">Tanggal Akhir</label>
                                                <input type="date" id="tgl_akhir" name="tgl_akhir" class="form-control">
                                            </div>
                                            <div class="form-group col-md-4 d-flex align-items-center">
                                                <button type="submit" class="btn btn-primary mt-2">Tampilkan</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="card-content collapse show">
                                    <div class="card-body card-dashboard">
                                        <div class="card-body card-dashboard dataTables_wrapper dt-bootstrap">
                                            <div class="table-responsive">

                                                @php
                                                    $saldo = $saldoSebelumnya;
                                                @endphp

                                                <table class="table table-striped">
                                                    <tr>
                                                        <td>Akumulasi Sisa Saldo Sebelumnya</td>
                                                        <td colspan="4" align="right">
                                                            {{ number_format($saldoSebelumnya, 0, ',', '.') }}
                                                        </td>
                                                    </tr>
                                                </table>
                                                <br>

                                                <table class="table table-striped table-bordered zero-configuration">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Tanggal</th>
                                                            <th>Keterangan</th>
                                                            <th>Debet</th>
                                                            <th>Kredit</th>
                                                            <th>Saldo</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($dataKas as $kas)
                                                            @php
                                                                $debet = $kas->jumlah ?? 0;
                                                                $kredit = $kas->keluar ?? 0;
                                                                $saldo += $debet - $kredit;
                                                            @endphp
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>{{ $kas->tgl }}</td>
                                                                <td>{{ $kas->keterangan }}</td>
                                                                <td>{{ number_format($debet, 0, ',', '.') }}</td>
                                                                <td>{{ number_format($kredit, 0, ',', '.') }}</td>
                                                                <td>{{ number_format($saldo, 0, ',', '.') }}</td>
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
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection
