@extends('layouts.web.page')

@php
$title = '404 Not Found';
@endphp

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="page-top-wrap">
          <div class="page-title-wrap">
            <div class="title">{{ $title }}</div>
          </div>
          <div class="flex"></div>
        </div>
      </div>
    </div>
    <div class="page-content-box decor-bt-accent">
      <div class="lh-1 mb-4 text-center d-flex flex-column align-items-center justify-content-center" style="height: 50vh">
        <i class="mdi mdi-file-search-outline fz-6rem d-block my-4"></i>
        <div class="text-dark font-weight-bold ff-baloo2 fz-1-5rem text-uppercase">{!! $title !!}</div>
        <div class="fz-0-8rem mt-1 fw-600">Opps, halaman yang anda tuju tidak ditemukan</div>
      </div>
    </div>
  </div>
@endsection
