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
                                <li class="breadcrumb-item active">
                                    Saldo Kas {{ $kampus->kampus }}
                                </li>
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
                                    <h4 class="card-title">Laporan Kas {{ $kampus->kampus }}</h4>
                                </div>
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    {{-- <h4 class="card-title mb-0">Laporan Kas {{ $kampus->kampus }}</h4> --}}
                                    <form action="{{ route('kas.cabangfilter', $kampus->id_kampus) }}" method="POST"
                                        class="form-inline">
                                        @csrf
                                        <label class="mr-2 font-weight-bold">Pilih Bulan</label>
                                        <select name="bulan" class="form-control mr-2" style="min-width: 120px;">
                                            @for ($i = 1; $i <= 12; $i++)
                                                <option value="{{ $i }}"
                                                    {{ $selectedBulan == $i ? 'selected' : '' }}>
                                                    {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                                                </option>
                                            @endfor
                                        </select>
                                        <label class="mr-2 font-weight-bold">Tahun</label>
                                        <select name="tahun" class="form-control mr-2" style="min-width: 90px;">
                                            @for ($th = now()->year; $th >= 2024; $th--)
                                                <option value="{{ $th }}"
                                                    {{ $selectedTahun == $th ? 'selected' : '' }}>
                                                    {{ $th }}
                                                </option>
                                            @endfor
                                        </select>
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fa fa-search"></i> Tampilkan
                                        </button>
                                    </form>
                                </div>

                                <div class="card-content collapse show">
                                    <div class="card-body card-dashboard">
                                        <div class="table-responsive">
                                            @php
                                                \Carbon\Carbon::setLocale('id');
                                                // $carbonBulanLalu sudah di-pass dari controller
                                                $labelBulan = $carbonBulanLalu->translatedFormat('F Y');
                                            @endphp

                                            <div class="table-responsive">
                                                <table class="table table-striped">
                                                    <tr>
                                                        <td>Sisa Saldo Akhir Bulan {{ $labelBulan }}</td>
                                                        <td colspan="4" align="right">
                                                            {{ number_format($saldoAkhir, 0, ',', '.') }}
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered zero-configuration">
                                                <thead>
                                                    <tr>
                                                        <th>Tanggal</th>
                                                        <th>Keterangan</th>
                                                        <th>Debet</th>
                                                        <th>Kredit</th>
                                                        <th>Saldo</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $saldo = $saldoAwal;
                                                    @endphp
                                                    @foreach ($kasBulanIni as $kas)
                                                        @php
                                                            $debet = $kas->masuk ?? 0;
                                                            $kredit = $kas->keluar ?? 0;
                                                            $saldo += $debet - $kredit;
                                                        @endphp
                                                        <tr>
                                                            <td>{{ \Carbon\Carbon::parse($kas->tgl)->format('d M Y') }}
                                                            </td>
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
                </section>
            </div>
        </div>
    </div>
@endsection
