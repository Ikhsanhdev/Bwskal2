@extends('layouts.web.page')

@php
  $title = 'Pencarian "' . request()->query('q') . '"';
@endphp

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="page-top-wrap">
          <div class="page-title-wrap">
            <div class="title text-uppercase">
              <div class="text-uppercase">HASIL PENCARIAN</div>
              <div class="font-weight-normal fz-0-85rem"
                data-maxline="1">
                "{{ request()->query('q') }}"
              </div>
            </div>
          </div>
          <div class="flex"></div>
          <div class="fz-0-85rem">
            {!! info_paginate($list, "Hasil") !!}
          </div>
        </div>
      </div>
    </div>
    <div class="page-content-box decor-bt-accent page-text-content">
      @if ($list && count($list))
      <ul class="list-group">
        @foreach ($list as $item)
        <li class="list-group-item list-group-item-action">
          <a 
            href="{{ make_post_link($item) }}"
            class="d-flex align-items-center no-line">
            <div class="tulisan flex">
              <div class="text-primary fz-0-8rem">
                {{ $item->created_at->isoFormat('DD MMMM YYYY') }}
              </div>
              <div class="text-dark2 font-weight-600 fz-1-15rem mb-1">{{ $item->title }}</div>
              <div class="text-muted fz-0-8rem">{!! Str::limit((strip_tags($item->content)), 250) !!}</div>
            </div>
            <div class="icon ml-3">
              <i class="mdi mdi-newspaper-variant-outline text-dark fz-2-15rem"></i>
            </div>
          </a>
        </li>
        @endforeach
      </ul>
      @if (isset($list) && $list->total() > $list->perPage())
      <div class="mt-5 d-flex justify-content-center">
        {{ $list->links() }}
      </div>
      @endif
      @else
        @php
        $subtitle = 'Tidak ada hasil yang cocok untuk "' . request()->query('q') . '"';
        @endphp
        <x-pesan-tengah
          icon="mdi-text-box-search"
          title="Pencarian Tidak Ditemukan"
          :subtitle="$subtitle"
          />
      @endif
    </div>
  </div>
@endsection
