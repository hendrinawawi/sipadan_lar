@extends('layouts.main')
@section('content')
<<<<<<< HEAD
  <div class="app-content content">
=======
    <div class="app-content content">
>>>>>>> 0b8f2a4f51b14d58eb6e8f5f84f115632ee3170d
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <!-- eCommerce statistic -->
                <div class="row">
<<<<<<< HEAD
                    <div class="col-xl-3 col-lg-6 col-12">
                        <div class="card pull-up">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="media d-flex">
                                        <div class="media-body text-left">
                                            <h3 class="info">850</h3>
                                            <h6>Products Sold</h6>
                                        </div>
                                        <div>
                                            <i class="icon-basket-loaded info font-large-2 float-right"></i>
                                        </div>
                                    </div>
                                    <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                                        <div class="progress-bar bg-gradient-x-info" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
=======
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
>>>>>>> 0b8f2a4f51b14d58eb6e8f5f84f115632ee3170d
                                </div>
                            </div>
                        </div>
                    </div>
<<<<<<< HEAD
                    <div class="col-xl-3 col-lg-6 col-12">
                        <div class="card pull-up">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="media d-flex">
                                        <div class="media-body text-left">
                                            <h3 class="warning">$748</h3>
                                            <h6>Net Profit</h6>
                                        </div>
                                        <div>
                                            <i class="icon-pie-chart warning font-large-2 float-right"></i>
                                        </div>
                                    </div>
                                    <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                                        <div class="progress-bar bg-gradient-x-warning" role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
=======

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
>>>>>>> 0b8f2a4f51b14d58eb6e8f5f84f115632ee3170d
                                </div>
                            </div>
                        </div>
                    </div>
<<<<<<< HEAD
                    <div class="col-xl-3 col-lg-6 col-12">
                        <div class="card pull-up">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="media d-flex">
                                        <div class="media-body text-left">
                                            <h3 class="success">146</h3>
                                            <h6>New Customers</h6>
                                        </div>
                                        <div>
                                            <i class="icon-user-follow success font-large-2 float-right"></i>
                                        </div>
                                    </div>
                                    <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                                        <div class="progress-bar bg-gradient-x-success" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
=======

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
>>>>>>> 0b8f2a4f51b14d58eb6e8f5f84f115632ee3170d
                                </div>
                            </div>
                        </div>
                    </div>
<<<<<<< HEAD
                    <div class="col-xl-3 col-lg-6 col-12">
                        <div class="card pull-up">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="media d-flex">
                                        <div class="media-body text-left">
                                            <h3 class="danger">99.89 %</h3>
                                            <h6>Customer Satisfaction</h6>
                                        </div>
                                        <div>
                                            <i class="icon-heart danger font-large-2 float-right"></i>
                                        </div>
                                    </div>
                                    <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                                        <div class="progress-bar bg-gradient-x-danger" role="progressbar" style="width: 85%" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
=======

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
>>>>>>> 0b8f2a4f51b14d58eb6e8f5f84f115632ee3170d
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
<<<<<<< HEAD

    @endsection
=======
@endsection
>>>>>>> 0b8f2a4f51b14d58eb6e8f5f84f115632ee3170d
