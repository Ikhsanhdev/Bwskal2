@extends('layouts.admin.single')

@php
$title = 'UNAUTHORIZED';
$bodyClass = 'bg-primary-3';
@endphp

@section('content')
  <div class="bg-dot">
    <div class="bg-ornament-1"></div>
    <div class="row h-100v justify-content-center align-items-center m-0 overflow-hidden">
      <div class="col-12"
        style="max-width: 380px">
        <div class="admin-content mb-3">
          <div class="app-branding on-dark justify-content-center flex-column lh-1">
            <img src="{{ url('assets/images/logo.png') }}" alt="Logo" class="img-fluid mb-3">
          </div>
          <div class="card card-login"
            style="margin-top: 1.75rem;">
            <div class="card-body pt-3">
              <div class="text-center mb-4 lh-1">
                <i class="mdi mdi-account-lock fz-6rem my-4 d-block"></i>
                <div class="text-dark font-weight-bold ff-baloo2 fz-1-75rem text-uppercase">401 UNAUTHORIZED</div>
                <div class="fz-0-8rem mt-1">Hak akses tidak terpenuhi</div>
              </div>

              @auth
              <a href="{{ url('/login-callback') }}" class="btn btn-primary fz-1-25rem btn-block mt-1">KEMBALI</a>
              @else
              <a href="{{ url('/') }}" class="btn btn-primary fz-1-25rem btn-block mt-1">KE BERANDA</a>
              @endauth
            </div>
          </div>
        </div>
        @include('layouts.admin.footer-center', [
            'footerClass' => 'm-0 text-light',
        ])
      </div>
    </div>
  </div>
@endsection
