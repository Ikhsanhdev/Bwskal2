@extends('layouts.admin.app')

{{-- Setup --}}
@php
$title = 'Pengaturan Situs';
@endphp

{{-- Libs --}}
@include('libs.akform')
@include('libs.izitoast')

@section('adminHeader')
  <i class="mdi mdi-application-cog-outline d-none d-md-inline-block mr-3"></i>
  {{ $title }}
@endsection

@section('content')
  {{-- Isi --}}
  <div class="admin-section">
    <div class="font-weight-bold text-dark fz-lg mb-3">Pilih Menu Pengaturan</div>
    <div class="row">
      <div class="col-2 as-col">
        <a class="as-item" href="{{ route('admin.pengaturan-situs.page', ['page' => 'informasi']) }}">
          <div class="icon">
            <img src="{{ url('assets/images/icon/2039835.svg') }}" class="img-fluid">
          </div>
          <div class="label">Informasi</div>
        </a>
      </div>
      <div class="col-2 as-col">
        <a class="as-item" href="{{ route('admin.pengaturan-situs.page', ['page' => 'media-sosial']) }}">
          <div class="icon">
            <img src="{{ url('assets/images/icon/4187272.svg') }}" class="img-fluid">
          </div>
          <div class="label">Media Sosial</div>
        </a>
      </div>
    </div>
  </div>
@endsection
