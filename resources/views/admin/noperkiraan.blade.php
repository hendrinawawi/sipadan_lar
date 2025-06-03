@extends('layouts.main')
@section('content')
    <!-- Column selectors table -->
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
                                <li class="breadcrumb-item"><a href="#">Tabel</a>
                                </li>
                                <li class="breadcrumb-item active">No Perkiraan
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
                <div class="content-header-right col-md-6 col-12">
                    <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
                        <button class="btn btn-info round dropdown-toggle dropdown-menu-right box-shadow-2 px-2 mb-1"
                            id="btnGroupDrop1" type="button" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false"><i class="ft-settings icon-left"></i> Settings</button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1"><a class="dropdown-item"
                                href="card-bootstrap.html">Cards</a><a class="dropdown-item"
                                href="component-buttons-extended.html">Buttons</a></div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <section id="column-selectors">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Nomor Perkiraan</h4>
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
                                        {{-- <p>
                                            One of the most commonly used is the columns option which defines the columns
                                            that should be
                                            used as part of the export. This is given as a column-selector, making it simple
                                            to tell it
                                            if you want only visible columns, or a mix of the columns available.
                                        </p> --}}
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered dataex-html5-selectors">
                                                <thead>
                                                    <tr>
                                                        <th>No Perkiraan</th>
                                                        <th>Keterangan</th>
                                                        <th>Kategori</th>
                                                        <th>Level Pemohon</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($datanoperki as $data)
                                                        <tr>
                                                            <td>{{ $data->no_perkiraan }}</td>
                                                            <td>{{ $data->keterangan }}</td>
                                                            <td>
                                                                @if ($data->kategori == 1)
                                                                    Masuk
                                                                @else
                                                                    Keluar
                                                                @endif
                                                            </td>

                                                            <td>{{ $data->level_pemohon }}</td>
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
