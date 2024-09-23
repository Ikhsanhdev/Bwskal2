@extends('layouts.admin.single')

@php
  $title = 'Reset Sandi';
  $bodyClass = 'bg-primary-3';
@endphp

@include('libs.akform')
@include('libs.izitoast')

@section('content')
  <div class="bg-dot">
    <div class="bg-ornament-1"></div>
    <div class="row h-100v justify-content-center align-items-center m-0 overflow-hidden">
      <div class="col-12 col-md-4">
        <div class="admin-content mb-3">
          <div class="app-branding on-dark justify-content-center flex-column lh-1">
            <img src="{{ url('assets/images/logo-baru.svg') }}"
              alt="Logo"
              class="img-fluid mb-3"
              style="image-rendering: optimizeQuality">
          </div>
          <div class="card card-login"
            style="margin-top: 1.75rem;">
            <div class="card-body pt-3">
              <form method="POST"
                id="formnya">
                @method('PUT')
                @csrf
                <h5 class="font-weight-600 text-dark2 mb-0">Form Reset Sandi</h5>
                <div class="fz-0-9rem text-muted mb-3">Masukkan Kata Sandi baru untuk akun anda</div>
                <x-ak-input
                  type="password"
                  label="Sandi Baru"
                  placeholder="Sandi Baru"
                  name="sandibaru"
                  required
                  />
                <x-ak-input
                  type="password"
                  label="Ulangi Sandi Baru"
                  placeholder="Ulangi Sandi Baru"
                  name="sandibaru_konfirmasi"
                  required
                  />
                <button class="btn btn-block btn-primary is-btn mt-2">
                  <div class="fz-normal">RESET SANDI</div>
                </button>
              </form>
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

@section('jsAfterMain')
  <script>
    $(document).ready(function() {
      window.fForm = AKForm.make({
        indicator: {
          overlay: true,
          message: `Sedang proses`,
        }
      });
    });
  </script>
@endsection
