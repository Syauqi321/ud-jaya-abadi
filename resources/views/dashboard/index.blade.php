@extends('layout.master')
@section('title', 'Dashboard')

@include('dashboard._js.index')

@push('vendor-style')
<link rel="stylesheet" href="{{ url('assets/vendor/libs/apex-charts/apex-charts.css') }}" />
<link rel="stylesheet" href="{{ url('assets/vendor/libs/swiper/swiper.css') }}" />
@endpush

@section('content')
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">

        <!-- Website Analytics -->
        <div class="col-12 mb-4">
            <div class="swiper-container swiper-container-horizontal swiper swiper-card-advance-bg"
                id="swiper-with-pagination-cards">
                <div class="swiper-wrapper">
                    <!-- Slide 1: Overview of the BEST System -->
                    <div class="swiper-slide">
                        <div class="row pt-3">
                            <div class="col-12">
                                <h5 class="text-white mb-0 mt-2 uppercase text-wrap">ERP (Enterprise Resource Planning)</h5>
                                <small>ERP UD. Sejati</small>
                            </div>
                            <div class="row">
                                <div class="col-lg-7 col-md-9 col-12 order-2 order-md-1">
                                    <h6 class="text-white mt-0 mt-md-3 mb-3">Overview</h6>
                                    <p class="text-white text-wrap">Sebuah aplikasi berbasis website yang bertujuan meningkatkan penguatan akuntabilitas kinerja melalui sistem pemilihan pegawai berkinerja terbaik di ERP UD. Sejati.</p>
                                </div>
                                <div class="col-lg-5 col-md-3 col-12 order-1 order-md-2 my-4 my-md-0 text-center">
                                    <img src="{{ url('assets/img/illustrations/card-website-analytics-1.png') }}"
                                        alt="Website Analytics" width="170" class="card-website-analytics-img mt-2" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 2: Features of the BEST System -->
                    <div class="swiper-slide">
                        <div class="row pt-3">
                            <div class="col-12">
                                <h5 class="text-white mb-0 mt-2 uppercase text-wrap">ERP (Enterprise Resource Planning)</h5>
                                <small>ERP UD. Sejati</small>
                            </div>
                            <div class="col-lg-7 col-md-9 col-12 order-2 order-md-1">
                                <h6 class="text-white mt-0 mt-md-3 mb-3">Fitur Utama</h6>
                                <div class="row">
                                    <div class="col-12 col-md-6 mb-4">
                                        <ul class="list-unstyled mb-0">
                                            <li class="d-flex mb-4 align-items-center text-wrap">
                                                <p class="mb-0 fw-medium me-2 website-analytics-text-bg">Penilaian</p>
                                                <p class="mb-0">Berbasis BerAKHLAK</p>
                                            </li>
                                            <li class="d-flex align-items-center mb-2 text-wrap">
                                                <p class="mb-0 fw-medium me-2 website-analytics-text-bg">Pengarsipan</p>
                                                <p class="mb-0">Dokumentasi Digital</p>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <ul class="list-unstyled mb-0">
                                            <li class="d-flex mb-4 align-items-center text-wrap">
                                                <p class="mb-0 fw-medium me-2 website-analytics-text-bg">Laporan</p>
                                                <p class="mb-0">Rekam Jejak</p>
                                            </li>
                                            <li class="d-flex align-items-center mb-2 text-wrap">
                                                <p class="mb-0 fw-medium me-2 website-analytics-text-bg">Pemetaan</p>
                                                <p class="mb-0">Talenta & Suksesi</p>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-3 col-12 order-1 order-md-2 my-4 my-md-0 text-center">
                                <img src="{{ url('assets/img/illustrations/card-website-analytics-2.png') }}"
                                    alt="Website Analytics" width="170" class="card-website-analytics-img mt-2" />
                            </div>
                        </div>
                    </div>

                    <!-- Slide 3: Impact and Benefits -->
                    <div class="swiper-slide">
                        <div class="row pt-3">
                            <div class="col-12">
                                <h5 class="text-white mb-0 mt-2 uppercase text-wrap">ERP (Enterprise Resource Planning)</h5>
                                <small>ERP UD. Sejati</small>
                            </div>
                            <div class="col-lg-7 col-md-9 col-12 order-2 order-md-1">
                                <h6 class="text-white mt-0 mt-md-3 mb-3">Dampak dan Manfaat</h6>
                                <p class="text-white text-wrap">Tersedianya sistem pemilihan pegawai berkinerja terbaik yang optimal dengan pemanfaatan teknologi berupa aplikasi berbasis web di ERP UD. Sejati.</p>
                                <p class="text-white text-wrap">Memotivasi pegawai untuk berkontribusi lebih maksimal dan memberikan pelayanan publik yang prima.</p>
                            </div>
                            <div class="col-lg-5 col-md-3 col-12 order-1 order-md-2 my-4 my-md-0 text-center">
                                <img src="{{ url('assets/img/illustrations/card-website-analytics-3.png') }}"
                                    alt="Website Analytics" width="170" class="card-website-analytics-img mt-2" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
        <!--/ Website Analytics -->


        <!-- Pendidikan -->
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <div class="card-title mb-0">
                        <h5 class="mb-0">Grafik</h5>
                        <small class="text-muted">Jumlah Pegawai Berdasarkan Tingkat Pendidikan</small>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="study-chart"></canvas>
                </div>
            </div>
        </div>
        <!--/ Pendidikan -->

        <!-- Generasi -->
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <div class="card-title mb-0">
                        <h5 class="mb-0">Grafik</h5>
                        <small class="text-muted">Jumlah Pegawai Berdasarkan Generasi</small>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="generation-chart"></canvas>
                </div>
            </div>
        </div>
        <!--/ Generasi -->

        <!-- Gender -->
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <div class="card-title mb-0">
                        <h5 class="mb-0">Grafik</h5>
                        <small class="text-muted">Jumlah Pegawai Berdasarkan Jenis Kelamin</small>
                    </div>
                </div>
                <div class="card-body" id="gender-chart">

                </div>
            </div>
        </div>
        <!--/ Gender -->

        <!-- Support Tracker -->
        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between pb-0">
                    <div class="card-title mb-0">
                        <h5 class="mb-0">Grafik</h5>
                        <small class="text-muted">Jumlah Pegawai Berdasarkan Kategori Jabatan</small>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="position-category-chart"></canvas>
                </div>
            </div>
        </div>
        <!--/ Support Tracker -->

        {{-- REPORT --}}
        <div class="col-md-12 mb-4 order-1 order-lg-2 mb-4 mb-lg-0">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-12">
                            <h5 class="mb-0">Data</h5>
                            <small class="text-muted">List Pegawai Terbaik Tahun Ini Per Periode</small>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered nowrap">
                            <thead>
                                <tr>
                                    <th>Periode</th>
                                    <th>Nama</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data dari AJAX akan dimasukkan di sini -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- / Content -->
@endsection
