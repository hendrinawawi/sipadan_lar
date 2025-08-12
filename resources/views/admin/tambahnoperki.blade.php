@extends('layouts.main')
@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
                    <h3 class="content-header-title mb-0 d-inline-block">Tambah No Perkiraan</h3>
                    <div class="row breadcrumbs-top d-inline-block">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Home</a>
                                </li>
                                <li class="breadcrumb-item"><a href="#">Form</a>
                                </li>
                                <li class="breadcrumb-item active">Tambah No Perkiraan
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- Basic form layout section start -->
                <section id="basic-form-layouts">
                    <div class="row match-height">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title" id="basic-layout-form">Form Tambah No Perkiraan</h4>
                                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                </div>

                                {{-- Tampilkan pesan sukses --}}
                                @if (session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('success') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Tutup">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif

                                {{-- Tampilkan error validasi --}}
                                @if ($errors->any())
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Tutup">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif
                                <div class="card-content collapse show">
                                    <div class="card-body">
                                        <form action="{{ route('perkiraan.store') }}" method="POST">
                                            @csrf
                                            <div class="row">
                                                <div class="form-group col-md-4">
                                                    <label for="id_subkat">Pilih Kategori</label>
                                                    <select class="select2 form-control" name="kategori" id="id_subkat"
                                                        required>
                                                        <option value="">-- Pilih Kategori --</option>
                                                        @foreach ($kategori as $kat)
                                                            <option value="{{ $kat->id_subkat }}">{{ $kat->id_subkat }} -
                                                                {{ $kat->nm_subkat }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="form-group col-md-8">
                                                    <label for="keterangan">Keterangan Tambahan</label>
                                                    <textarea class="form-control" name="keterangan" id="keterangan" rows="2" required></textarea>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-4">
                                                    <label>Sub Kategori 1</label>
                                                    <input type="text" name="subkategori1" id="subkategori1"
                                                        class="form-control" readonly>
                                                </div>

                                                <div class="form-group col-md-4">
                                                    <label>Sub Kategori 2</label>
                                                    <input type="text" name="subkategori2" class="form-control"
                                                        value="0000">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label>Sub Kategori 3</label>
                                                    <input type="text" name="subkategori3" class="form-control"
                                                        value="0000">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="kampus">Pilih Kampus</label>
                                                <div class="form-check mb-2">
                                                    <input type="checkbox" class="form-check-input" id="select_all_kampus">
                                                    <label class="form-check-label" for="select_all_kampus">Pilih Semua
                                                        Kampus</label>
                                                </div>
                                                <script>
                                                    document.addEventListener('DOMContentLoaded', function() {
                                                        const selectAll = document.getElementById('select_all_kampus');
                                                        const checkboxes = document.querySelectorAll('input[name="kampus[]"]');
                                                        selectAll.addEventListener('change', function() {
                                                            checkboxes.forEach(cb => cb.checked = selectAll.checked);
                                                        });
                                                    });
                                                </script>
                                                <div class="row">
                                                    @php
                                                        $chunks = $kampus->chunk(10);
                                                    @endphp
                                                    @foreach ($chunks as $chunk)
                                                        <div class="col-md-4">
                                                            @foreach ($chunk as $kp)
                                                                <div class="form-check">
                                                                    <input type="checkbox" class="form-check-input"
                                                                        name="kampus[]" value="{{ $kp->id_kampus }}"
                                                                        id="kampus_{{ $kp->id_kampus }}">
                                                                    <label class="form-check-label"
                                                                        for="kampus_{{ $kp->id_kampus }}">{{ $kp->kampus }}</label>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="fakultas">Pilih Fakultas</label>
                                                    <select name="fakultas" id="fakultas" class="form-control" required>
                                                        <option value="">-- Pilih Fakultas --</option>
                                                        @foreach ($fakultas as $fak)
                                                            <option value="{{ $fak->id_fakultas }}">
                                                                {{ $fak->nama_fakultas }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="prodi">Pilih Prodi</label>
                                                    <select name="prodi" id="prodi" class="form-control" required>
                                                        <option value="">-- Pilih Prodi --</option>
                                                        {{-- Data prodi akan muncul setelah fakultas dipilih --}}
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="level">Pilih Level Akses</label>
                                                @foreach ($levels as $lv)
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="level[]"
                                                            value="{{ $lv->id_level }}" id="level_{{ $lv->id_level }}">
                                                        <label class="form-check-label" for="level_{{ $lv->id_level }}">
                                                            {{ $lv->level }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="form-actions">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="la la-check-square-o"></i> Simpan
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $('#fakultas').on('change', function() {
            var id_fakultas = $(this).val();
            $('#prodi').html('<option value="">Loading...</option>');

            if (id_fakultas) {
                $.get('/get-prodi/' + id_fakultas, function(data) {
                    let options = '<option value="00">-- Pilih Prodi --</option>';
                    data.forEach(function(item) {
                        options += `<option value="${item.id_prodi}">${item.prodi}</option>`;
                    });
                    $('#prodi').html(options);
                });
            } else {
                $('#prodi').html('<option value="00">-- Pilih Prodi --</option>');
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#id_subkat').on('change', function() {
                var kode = $(this).val();
                if (kode) {
                    $.get('/get-subkategori1/' + kode, function(data) {
                        $('#subkategori1').val(data.subkategori1);
                    });
                } else {
                    $('#subkategori1').val('');
                }
            });
        });
    </script>
@endsection
