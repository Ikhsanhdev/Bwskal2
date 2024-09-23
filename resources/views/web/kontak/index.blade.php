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
      <div class="d-flex justify-content-md-between align-items-md-center flex-column flex-md-row mb-4">
        <div class="fw-800 fz-1-5rem">Hubungi Kami</div>
        <div class="text-secondary fz-0-85rem">Semua formulir wajib diisi</div>
      </div>
      <form action="{{ route('web.kontak.store') }}"
        id="formnya"
        method="POST">
        @csrf
        <x-ak-input
          label="Nama Lengkap"
          name="name"
          placeholder="Silakan isi nama"
          required
          />

        <x-ak-input
          label="Email"
          name="email"
          placeholder="Silakan isi email"
          required
          />

        <x-ak-input
          label="Nomor Kontak/WhatsApp"
          name="contact"
          placeholder="Silakan isi nomor kontak/WhatsApp"
          required
          />

        <x-ak-input
          label="Topik"
          name="topic"
          placeholder="Silakan isi topik"
          required
          />

        <x-ak-input
          type="textarea"
          label="Pesan/Pertanyaan"
          name="content"
          placeholder="Silakan isi pesan/petanyaan"
          required
          rows="5"
          />
        
        {!! NoCaptcha::displaySubmit('formnya', 'KIRIM PESAN', [
          'class' => 'btn btn-primary wide fz-1rem btn-w-600 px-4 fw-700"',
          'data-callback' => 'onSubmitformnya',
        ]) !!}
      </form>
    </div>
  </div>
@endsection

@section('cssAfter')
{!! NoCaptcha::renderJs() !!}
@endsection

@section('jsAfter')
  <script>
    $(document).ready(function() {
      window.fform = AKForm.make({
        indicator: {
          overlay: true
        },
      });
      window.onSubmitformnya = function () {
        fform.submit();
      }
    });
  </script>
@endsection
