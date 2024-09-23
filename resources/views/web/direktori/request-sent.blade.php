@extends('layouts.web.page')

@php
  $title = 'Form Permohonan Akses Dokumen';
@endphp

@include('libs.akform')
@include('libs.izitoast')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="page-top-wrap">
          <div class="page-title-wrap">
            <div class="title text-center text-md-left lh-1">{{ $title }}</div>
          </div>
        </div>
      </div>
    </div>

    <div class="page-content-box decor-bt-accent py-5 text-center">
      <x-pesan-tengah icon="mdi-email-check"
        padding="p-md-5"
        title="Permintaan Akses Terkirim"
        subtitle="Akses akan diberikan setelah permintaan dikonfirmasi oleh Administrator yang bersangkutan,<br>silakan cek email Anda secara berkala untuk informasi lebih lanjut." />

        <a href="{{ route('direktori.index') }}" class="btn btn-primary fw-700 mt-3 mt-md-0">KEMBALI KE DIREKTORI</a>
    </div>
  </div>
@endsection

@section('jsAfterMain')
  <script>
    $(function() {
      @sessionErrorToast
    });
  </script>
@endsection
