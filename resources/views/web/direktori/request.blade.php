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
            <div class="title">{{ $title }}</div>
          </div>
          <div class="flex"></div>
          <div class="fz-0-85rem">

          </div>
        </div>
      </div>
    </div>

    <div class="page-content-box decor-bt-accent pb-4">
      <div class="row">
        <div class="col-12 col-md-4 d-flex">
          <div class="d-flex flex justify-content-center align-items-center flex-column">
            <i class="fi {!! flaticon_from_mime($unduhan->mime) !!} fz-5rem"></i>
            <div class="fw-800 fz-1-25rem text-center">{{ $unduhan->title }}</div>
            <div class="text-muted fz-0-85rem text-center">Diunduh {{ $unduhan->hit }} kali</div>
          </div>
        </div>
        <div class="col-12 d-md-none">
          <hr>
        </div>
        <div class="col-12 col-md-8">
          <form id="request-form"
            action="{{ route('direktori.request', request()->route()->parameters) }}"
            method="POST"
            >
            @csrf
            <div class="fw-800 fz-1-25rem">Form Permohonan Akses</div>
            <div class="mb-3 text-secondary">Anda memerlukan izin untuk mengakses dokumen ini, silakan lengkapi form berikut.</div>
            <x-ak-input name="name"
              label="Nama Lengkap"
              placeholder="$label"
              required />

            <x-ak-input type="email"
              name="email"
              label="Email Aktif"
              placeholder="$label"
              required />

            <x-ak-input type="textarea"
              name="message"
              label="Tujuan/ Keperluan Permintaan Dokumen"
              placeholder="$label"
              required />

            <div class="d-flex justify-content-end">
              {!! NoCaptcha::displaySubmit('request-form', 'Minta Akses', [
                'class' => 'btn btn-primary fw-700"',
                'data-callback' => 'onSubmitformnya',
              ]) !!}
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('cssAfter')
{!! NoCaptcha::renderJs() !!}
@endsection

@section('jsAfterMain')
<script>
  $(function () {
    @sessionErrorToast

    window.fform = AKForm.make({
      el: '#request-form',
      indicator: {overlay: true},
    });
    
    window.onSubmitformnya = function () {
      fform.submit();
    }
  });
</script>
@endsection
