@extends('layouts.admin.app')

{{-- Setup --}}
@php
  $title = 'Feed Media Sosial';
@endphp

{{-- Libs --}}
@include('libs.izitoast')
@include('libs.akform')
@include('libs.day')

@section('adminHeader')
  <i class="mdi mdi-timeline-text-outline d-none d-md-inline-block mr-3"></i>
  {{ $title }}
@endsection

@section('content')
  {{-- Isi --}}
  <div class="admin-section">
    <form class="card"
      id="formnya"
      method="POST"
      action="{{ route('admin.medsos-feed.update') }}">
      @method('PUT')
      <div class="card-header">
        <div class="font-weight-bold fz-lg text-dark">Feed Media Sosial</div>
      </div>
      <div class="card-body">
        @if (config('medsos-feed.instagram.app_id') && config('medsos-feed.instagram.app_secret'))
        <h4 class="text-dark fw-800">Instagram</h4>
        <div class="fz-0-85rem">Feed Instagram akan otomatis diperbaharui setiap 30 menit, atau gunakan tombol <strong>Refresh Feed</strong> (akan muncul jika access token tersedia).</div>
        <div class="form-group">
          <label for="">Instagram Access Token</label>
          <div class="input-group">
            <input type="text" class="form-control" placeholder="Access Token" readonly value="{{ $data->ig_token ?? '' }}">
            <div class="input-group-append">
              <a class="btn btn-warning fz-0-9rem" href="{{ $igLoginUrl }}">Get Access Token</a>
            </div>
          </div>
          @if ($data->ig_token && $data->ig_token_expire)
          <div class="mt-1 fz-0-85rem">Token ini akan expired pada <span class="fw-700 text-danger">{{ \Carbon\Carbon::createFromTimestamp($data->ig_token_expire)->isoFormat('DD MMMM YYYY HH:mm:ss') }}</span></div>
          @endif
        </div>
        @if ($data->ig_token)
        <button type="button" class="btn btn-warning fz-0-9rem" id="btnRefreshIG">
          <i class="mdi mdi-refresh mr-2"></i>
          <span>Refresh Feed</span>
        </button>
        @endif
        <hr>
        @endif
        <h4 class="text-dark fw-800">Media Sosial Lainnya</h4>
        <x-ak-input name="facebook"
          label="Facebook URL"
          placeholder="$label"
          :value="$data->facebook ?? ''"
          />
        <x-ak-input name="twitter"
          label="Twitter URL"
          placeholder="$label" 
          :value="$data->twitter ?? ''"
          />
      </div>
      <div class="card-footer text-right">
        <button class="btn btn-primary text-uppercase fz-1rem"
          type="submit">SIMPAN</button>
      </div>
    </form>
  </div>
@endsection

@section('jsAfterMain')
  <script>
    $(function() {
      @sessionErrorToast
      AKForm.make({
        indicator: {
          overlay: true
        },
      });

      $('#btnRefreshIG').on('click', function () {
        let l = AKToast.loading(`Refresh Instagram Feed`);
        axios.post(`{{ route('admin.medsos-feed.refresh-ig') }}`)
          .then(res => {
            AKToast.success(res.data.message);
          })
          .catch(err => {
            AKToast.error(err?.response?.data?.message ?? err.message)
          })
          .finally(() => {
            l.close();
          });
      });
    });
  </script>
@endsection
