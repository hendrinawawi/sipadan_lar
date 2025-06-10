@extends('layouts.main')
@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <!-- eCommerce statistic -->
                <div class="row">
                    <!-- Menunggu Persetujuan -->
                    <div class="col-xl-3 col-md-6 col-12">
                        <div class="card bg-gradient-directional-info">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="media d-flex">
                                        <div class="media-body text-white text-left">
                                            <h3 class="text-white">{{ count($pengajuanMenunggu) }}</h3>
                                            <span>Pengajuan Baru</span>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="icon-rocket text-white font-large-2 float-right"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Dicek Staff Baku -->
                    <div class="col-xl-3 col-md-6 col-12">
                        <div class="card bg-gradient-directional-secondary">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="media d-flex">
                                        <div class="media-body text-white text-left">
                                            <h3 class="text-white">{{ count($pengajuanDicek) }}</h3>
                                            <span>Dicek Staff Baku</span>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="icon-pie-chart  text-white font-large-2 float-right"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Revisi Pengajuan -->
                    <div class="col-xl-3 col-md-6 col-12">
                        <div class="card bg-gradient-directional-warning">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="media d-flex">
                                        <div class="media-body text-white text-left">
                                            <h3 class="text-white">{{ count($pengajuanRevisi) }}</h3>
                                            <span>Revisi Pengajuan</span>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="icon-user text-white font-large-2 float-right"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sudah Revisi -->
                    <div class="col-xl-3 col-md-6 col-12">
                        <div class="card bg-gradient-directional-primary">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="media d-flex">
                                        <div class="media-body text-white text-left">
                                            <h3 class="text-white">{{ count($pengajuansudahRev) }}</h3>
                                            <span>Sudah Revisi</span>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="icon-pencil text-white font-large-2 float-right"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Selesai -->
                    <div class="col-xl-3 col-md-6 col-12">
                        <div class="card bg-gradient-directional-success">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="media d-flex">
                                        <div class="media-body text-white text-left">
                                            <h3 class="text-white">{{ count($pengajuanSelesai) }}</h3>
                                            <span>Selesai</span>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="icon-heart text-white font-large-2 float-right"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Ditolak -->
                    <div class="col-xl-3 col-md-6 col-12">
                        <div class="card bg-gradient-directional-danger">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="media d-flex">
                                        <div class="media-body text-white text-left">
                                            <h3 class="text-white">{{ count($pengajuanDitolak) }}</h3>
                                            <span>Ditolak</span>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="icon-close text-white font-large-2 float-right"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Menunggu Pencairan -->
                    <div class="col-xl-3 col-md-6 col-12">
                        <div class="card bg-gradient-directional-success">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="media d-flex">
                                        <div class="media-body text-white text-left">
                                            <h3 class="text-white">{{ count($pengajuanaccbaku) }}</h3>
                                            <span>Menunggu Pencairan</span>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="icon-wallet text-white font-large-2 float-right"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Menunggu Bukti -->
                    <div class="col-xl-3 col-md-6 col-12">
                        <div class="card bg-gradient-directional-danger">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="media d-flex">
                                        <div class="media-body text-white text-left">
                                            <h3 class="text-white">{{ count($menunggubukti) }}</h3>
                                            <span>Menunggu Bukti</span>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="icon-camera text-white font-large-2 float-right"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sudah Upload Bukti -->
                    <div class="col-xl-3 col-md-6 col-12">
                        <div class="card bg-gradient-directional-info">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="media d-flex">
                                        <div class="media-body text-white text-left">
                                            <h3 class="text-white">{{ count($sudahuploadbukti) }}</h3>
                                            <span>Sudah Upload Bukti</span>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="icon-check text-white font-large-2 float-right"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                    <!-- Pengajuan Sudah Transfer -->
                    <div class="col-xl-3 col-md-6 col-12">
                        <div class="card bg-gradient-directional-warning">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="media d-flex">
                                        <div class="media-body text-white text-left">
                                            <h3 class="text-white">{{ count($pengajuansudahTrf) }}</h3>
                                            <span>Belum Input Kas</span>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="icon-credit-card text-white font-large-2 float-right"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ Basic Horizontal Timeline -->
            </div>
        </div>
    </div>
@endsection
