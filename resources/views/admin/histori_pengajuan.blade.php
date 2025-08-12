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
                                <li class="breadcrumb-item"><a href="index.html">Home</a>
                                </li>
                                <li class="breadcrumb-item"><a href="#">Tabel</a>
                                </li>
                                <li class="breadcrumb-item active">Data Pengajuan
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
                <div class="content-header-right col-md-6 col-12">
                    <div class="btn-group float-md-right">
                        <form action="" class="d-flex align-items-center gap-2">
                            <label for="tahun" class="mb-0 mr-1">Pilih Tahun:</label>
                            <select name="tahun" id="tahun" class="form-control mr-2" style="width: auto;">
                                <?php
                                $tahunSekarang = date('Y');
                                for ($tahun = 2024; $tahun <= $tahunSekarang; $tahun++) {
                                    echo "<option value=\"$tahun\">$tahun</option>";
                                }
                                ?>
                            </select>

                            <button type="submit" class="btn btn-info">
                                Tambah Data
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <form method="GET" action="{{ route('data.pengajuan') }}" class="mb-3">
                <div class="form-row align-items-center">
                    <div class="col-auto">
                        <select name="status" class="form-control" onchange="this.form.submit()">
                            <option value="">-- Semua Status --</option>
                            @foreach ($daftarStatus as $sts)
                                <option value="{{ $sts->kd_status }}" {{ $status == $sts->kd_status ? 'selected' : '' }}>
                                    {{ $sts->status }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </form>
            <div class="content-body">
                <section id="mobile-support">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Data Pengajuan {{ $statusLabel }}</h4>
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
                                        <table
                                            class="table table-striped table-bordered responsive dataex-rowre-mobilesupport">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>#</th>
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
                                                    <th>Detail</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            @php
                                                $userLevel = Auth::user()->level;
                                            @endphp

                                            <tbody>
                                                @foreach ($datapengajuan as $pengajuan)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>

                                                        {{-- Checkbox hanya untuk level 1 atau 2 --}}
                                                        <td>
                                                            @if (in_array($userLevel, [1, 2]))
                                                                <input type="checkbox" name="selected[]"
                                                                    value="{{ $pengajuan->id_pengajuan }}">
                                                            @endif
                                                        </td>

                                                        <td>{{ \Carbon\Carbon::parse($pengajuan->tanggal)->format('d M Y') }}
                                                        </td>
                                                        <td>{{ \Carbon\Carbon::parse($pengajuan->tanggal_dip)->format('d M Y') }}
                                                        </td>
                                                        <td>{{ \Illuminate\Support\Str::limit($pengajuan->keterangan, 50) }}
                                                        </td>
                                                        <td>{{ $pengajuan->pemakaian == 0 ? 'Baru' : 'Reimburse' }}</td>
                                                        <td>
                                                            @if ($pengajuan->bukti)
                                                                <a href="{{ asset('bukti/' . $pengajuan->bukti) }}"
                                                                    target="_blank">Lihat</a>
                                                            @else
                                                                -
                                                            @endif
                                                        </td>
                                                        <td>Rp {{ number_format($pengajuan->jumlah, 0, ',', '.') }}</td>
                                                        <td>{{ $pengajuan->nama_lengkap }}</td>
                                                        <td>{{ $pengajuan->rek_tujuan . ' - ' . $pengajuan->atas_nama }}
                                                        </td>
                                                        <td>{{ $pengajuan->catatan ?? '-' }}</td>
                                                        <td>
                                                            <span
                                                                class="badge badge-secondary">{{ $pengajuan->nama_status }}</span>
                                                        </td>

                                                        {{-- Expand: keterangan lengkap & aksi --}}
                                                        <td>{{ $pengajuan->keterangan }}</td>
                                                        <td>
                                                            <button class="btn btn-sm btn-warning">Revisi</button>
                                                            <button class="btn btn-sm btn-danger">Tolak</button>
                                                            <button class="btn btn-sm btn-info">Teruskan ke Ka.
                                                                BAKU</button>
                                                            <button class="btn btn-sm btn-success">Catatan Untuk Ka.
                                                                BAKU</button>
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
                </section>
            </div>
        </div>
    </div>
@endsection
