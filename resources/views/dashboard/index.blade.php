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
                                <h5 class="text-white mb-0 mt-2 uppercase text-wrap">Sistem Manajemen Produksi</h5>
                                <small>ERP UD. Jaya Abadi</small>
                            </div>
                            <div class="row">
                                <div class="col-lg-7 col-md-9 col-12 order-2 order-md-1">
                                    <h6 class="text-white mt-0 mt-md-3 mb-3">Overview</h6>
                                    <p class="text-white text-wrap">Sebuah aplikasi berbasis website yang bertujuan meningkatkan UD. Jaya Abadi.</p>
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
                                <h5 class="text-white mb-0 mt-2 uppercase text-wrap">Sistem Manajemen Produksi</h5>
                                <small>ERP UD. Jaya Abadi</small>
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
                                <h5 class="text-white mb-0 mt-2 uppercase text-wrap">Sistem Manajemen Produksi</h5>
                                <small>ERP UD. Jaya Abadi</small>
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



        <!-- Support Tracker -->
        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between pb-0">
                    <div class="card-title mb-0">
                        <h5 class="mb-0">Grafik</h5>
                        <small class="text-muted"></small>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="position-category-chart"></canvas>
                </div>
            </div>
        </div>
        <!--/ Support Tracker -->



    </div>
</div>
<!-- / Content -->
@endsection
