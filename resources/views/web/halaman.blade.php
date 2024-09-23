@extends('layouts.web.page')

@php
  $title = $data->title;
@endphp

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="page-top-wrap">
          <div class="page-title-wrap">
            <div class="title text-uppercase">{{ $data->title }}</div>
          </div>
          <div class="flex"></div>
          <div class="fz-0-85rem">
            Diperbaharui pada <span class="fw-700">{{ $data->updated_at->isoFormat('DD MMMM YYYY') }}</span> | Dilihat <span class="fw-700">{{ $data->hit }}</span> kali
          </div>
        </div>
      </div>
    </div>
    <div class="page-content-box decor-bt-accent page-text-content ck-content">
      {!! $data->content !!}
    </div>
  </div>
@endsection
