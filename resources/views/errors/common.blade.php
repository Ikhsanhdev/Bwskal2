@extends('layouts.admin.single')

@php
$bodyClass = 'bg-primary-3';
$hasBack = $hasBack ?? true;
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
                <i class="mdi {{ $icon ?? 'mdi-human-dolly' }} fz-6rem my-4 d-block"></i>
                <div class="text-dark font-weight-bold ff-baloo2 fz-1-5rem text-uppercase">{{ $messageTitle }}</div>
                <div class="fz-0-8rem mt-1 lh-1-25">{!! $message !!}</div>
              </div>

            @if ($hasBack)
              <a href="{{ $backLink ?? 'javascript:history.back()' }}"
                class="btn btn-primary fz-1-25rem btn-block mt-1">KEMBALI</a>
            @endif
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
