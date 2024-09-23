@extends('layouts.admin.app')

{{-- Setup --}}
@php
  $title = 'Peta';
@endphp

{{-- Libs --}}
@include('libs.akform')
@include('libs.izitoast')

@section('adminHeader')
  <i class="mdi mdi-map-marker-radius d-none d-md-inline-block mr-3"></i>
  {{ $title }}
@endsection

@section('content')
  {{-- Isi --}}
  <div class="admin-section">
    <form action="{{ route('admin.peta.update') }}"
      class="card"
      id="formnya"
      method="POST">
      @method('PUT')
      <div class="card-body">
        <h4 class="text-dark fw-800">Peta</h4>
        <x-ak-input
          name="alamat"
          label="Alamat Kantor"
          type="textarea"
          :value="$data->alamat ?? ''"
          />
        <x-ak-input
          name="google_map"
          label="Link Peta"
          placeholder="Link Peta google map"
          :value="$data->google_map ?? ''"
          />
      </div>
      <div class="card-footer text-right">
        <button type="submit"
          class="btn btn-primary text-uppercase fz-1rem">SIMPAN</button>
      </div>
    </form>
  </div>
@endsection

@section('jsAfterMain')
  <script>
    $(function() {
      @sessionErrorToast
      let f = AKForm.make({
        indicator: {
          overlay: true
        },
      });
    });
  </script>
@endsection
