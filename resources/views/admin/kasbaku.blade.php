@extends('layouts.main')
@section('content')
    @php
        use Carbon\Carbon;
    @endphp

    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
                    <h3 class="content-header-title mb-0 d-inline-block">Saldo Kas</h3>
                    <div class="row breadcrumbs-top d-inline-block">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item"><a href="#">Kas</a></li>
                                <li class="breadcrumb-item active">Saldo Kas Bulan
                                    {{ Carbon::createFromFormat('m', $bulan)->format('F Y') }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <section id="html5">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Laporan Kas</h4>
                                </div>

                                <div class="card-content collapse show">
                                    <div class="card-body card-dashboard">

                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered zero-configuration">
                                                @php
                                                    \Carbon\Carbon::setLocale('id');
                                                    $bulanSebelumnya = \Carbon\Carbon::create(
                                                        $tahun,
                                                        $bulan,
                                                        1,
                                                    )->subMonth();
                                                    $labelBulan = $bulanSebelumnya->translatedFormat('F Y'); // contoh: Mei 2025
                                                @endphp

                                                <tr>
                                                    <td>Sisa Saldo Akhir Bulan {{ $labelBulan }}</td>
                                                    <td colspan="4" align="right">
                                                        {{ number_format($saldoAkhir ?? $saldoAwal, 0, ',', '.') }}
                                                    </td>
                                                </tr>

                                            </table>
                                        </div>
                                        <br>
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered dataex-html5-export">
                                                <thead>
                                                    <tr>
                                                        <th>Tanggal</th>
                                                        <th>Keterangan</th>
                                                        <th>Kredit</th>
                                                        <th>Debet</th>
                                                        <th>Saldo</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $saldo = $saldoAwal;
                                                        $saldoAkhir = $saldoAwal;
                                                    @endphp
                                                    @foreach ($kasBulanIni as $kas)
                                                        @php
                                                            $saldo += $kas->jumlah - $kas->keluar;
                                                            $saldoAkhir = $saldo;
                                                        @endphp
                                                        <tr>
                                                            <td>{{ \Carbon\Carbon::parse($kas->tgl)->format('d M Y') }}</td>
                                                            <td>{{ $kas->keterangan }}</td>
                                                            <td>{{ number_format($kas->jumlah, 0, ',', '.') }}</td>
                                                            <td>{{ number_format($kas->keluar, 0, ',', '.') }}</td>
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
                </section>
            </div>
        </div>
    </div>
@endsection
