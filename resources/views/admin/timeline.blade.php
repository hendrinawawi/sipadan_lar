@extends('layouts.main')

@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">Data Nomor Perkiraan</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Home</a>
                                </li>
                                <li class="breadcrumb-item"><a href="#">Form</a>
                                </li>
                                <li class="breadcrumb-item active">Timeline
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
                <style>
                    .timeline {
                        position: relative;
                        padding: 0;
                        margin: 0;
                        list-style: none;
                        margin-left: 20px;
                        border-left: 3px solid #d9534f;
                    }

                    .timeline-label {
                        margin: 20px 0;
                        text-align: left;
                    }

                    .timeline-label .badge {
                        font-size: 14px;
                        padding: 5px 15px;
                    }

                    .timeline-item {
                        position: relative;
                        margin: 20px 0;
                        padding-left: 30px;
                    }

                    .timeline-item::before {
                        content: '';
                        position: absolute;
                        left: -7px;
                        top: 8px;
                        width: 14px;
                        height: 14px;
                        background: #d9534f;
                        border-radius: 50%;
                        border: 2px solid #fff;
                        z-index: 1;
                    }

                    .timeline-badge {
                        position: absolute;
                        left: -42px;
                        top: 0;
                        background: #d9534f;
                        color: #fff;
                        border-radius: 50%;
                        width: 30px;
                        height: 30px;
                        text-align: center;
                        line-height: 30px;
                        font-size: 14px;
                    }

                    .timeline-card {
                        margin-left: 10px;
                        border-left: 3px solid transparent;
                        background: #f7f7f7;
                        border-radius: 6px;
                        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
                    }

                    .timeline-card .card-body {
                        padding: 15px;
                        position: relative;
                    }
                </style>
                <!-- Detail Ajuan -->
                <div class="row">
                    <div class="col-md-8">
                        <h4 class="mb-2">Detail Ajuan</h4>

                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title"><i class="ft-clock"></i> Detail Pengajuan</h5>
                            </div>
                            <div class="card-body">
                                <ul class="timeline">
                                    @foreach ($logs->groupBy(function ($item) {
            return \Carbon\Carbon::parse($item->tanggal)->format('d M Y');
        }) as $date => $items)
                                        <li class="timeline-label">
                                            <span class="badge badge-pill badge-danger">
                                                {{ \Carbon\Carbon::parse($date)->translatedFormat('d M Y') }}
                                            </span>
                                        </li>
                                        @foreach ($items as $log)
                                            <li class="timeline-item">
                                                <div class="timeline-badge">
                                                    <i class="ft-mail"></i>
                                                </div>
                                                <div class="timeline-card card">
                                                    <div class="card-content">
                                                        <div class="card-body">
                                                            <h5 class="card-title">Keterangan: {{ $log->catatan }}</h5>
                                                            <p class="mb-0 text-muted">
                                                                User - ({{ $log->eksekutor_name ?? '-' }})
                                                            </p>
                                                            <span class="text-muted float-right">
                                                                <i class="ft-clock"></i>
                                                                {{ \Carbon\Carbon::parse($log->tanggal)->format('H:i:s') }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Dokumen Pengajuan -->
                    <div class="col-md-4">
                        <h4 class="mb-2">Data Dokumen</h4>
                        <div class="card bg-gradient-directional-danger text-white">
                            <div class="card-body">
                                <h6 class="card-title">Lampiran Pengajuan</h6>
                                <a href="{{ asset('dok_ajuan/' . $pengajuan->bukti) }}" class="text-white" target="_blank">
                                    <strong>Download</strong>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Detail Ajuan -->
            </div>
        </div>
    </div>
@endsection
