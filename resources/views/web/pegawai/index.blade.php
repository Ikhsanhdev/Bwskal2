@extends('layouts.web.page')

@php
  $title = 'Pegawai';
@endphp

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="page-top-wrap">
          <div class="page-title-wrap">
            <div class="title text-uppercase">
              <div class="text-uppercase">PEGAWAI</div>
            </div>
          </div>
          <div class="flex"></div>
          <div class="fz-0-85rem">

          </div>
        </div>
      </div>
    </div>
    <div class="page-content-box decor-bt-accent page-text-content">
      @if (isset($list) && count($list))
        <div class="row web-pegawai-wrap">
          @foreach ($list as $item)
            <div class="col-md-6 col-lg-3 pegawai-col">
              <div class="pegawai-item"
                data-id="{{ encrypt($item->id) }}"
                >
                <div class="foto">
                  <img src="{{ $item->foto_image }}">
                </div>
                <div class="name">{{ $item->name }}</div>
                <div class="position">{{ $item->position }}</div>
                <div class="__overlay">
                  <div class="btn btn-light fw-800">LIHAT DETAIL</div>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      @else
        <x-pesan-tengah 
          icon="mdi-card-account-details"
          title="Data Pegawai Kosong"/>
      @endif
    </div>
  </div>
@endsection

@section('jsAfter')
<script>
  $(document).ready(function () {
    $('.pegawai-item').on('click', function () {
      AKModal.open({
        url: `{{ route('web.pegawai.detail') }}`,
        data: {
          id: this.dataset.id,
        }
      });
    });
  });
</script>
@endsection
