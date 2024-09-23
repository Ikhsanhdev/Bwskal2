@extends('layouts.web.page')

@php
  $title = 'Kontak';
@endphp

@include('libs.akform')
@include('libs.izitoast')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="page-top-wrap">
          <div class="page-title-wrap">
            <div class="title text-uppercase">
              <div class="text-uppercase">KONTAK</div>
            </div>
          </div>
          <div class="flex"></div>
          <div class="fz-0-85rem">

          </div>
        </div>
      </div>
    </div>
    <div class="page-content-box decor-bt-accent page-text-content">
      <div class="text-center">
        <img src="{{ url('assets/images/terima-kasih.svg') }}"
          class="img-fluid"
          style="width: 500px">
        <div class="fz-1-5rem mt-3 fw-800">Terima kasih telah menghubungi kami</div>
      </div>
    </div>
  </div>
@endsection
