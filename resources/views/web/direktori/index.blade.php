@extends('layouts.web.page')

@php
  $title = 'Direktori';
@endphp

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="page-top-wrap">
          <div class="page-title-wrap">
            <div class="title">DIREKTORI</div>
          </div>
          <div class="flex"></div>
          <div class="fz-0-85rem">
            {!! info_paginate($list, "Berkas", $dataFiltered) !!} | Dilihat <strong>{{ Visitor::countRoute('direktori.index') }}</strong> kali
          </div>
        </div>
      </div>
    </div>

    <div class="page-content-box decor-bt-accent pb-4">
      <form class="unduhan-filter"
        method="GET">
        <input type="text"
          class="form-control rounded-0 bg-light border-0 px-3"
          placeholder="cari judul berkas..."
          name="q"
          value="{{ isset($filterQuery['q']) ? $filterQuery['q'] : '' }}"
          >
        <select name="kategori"
          class="form-control rounded-0 bg-light border-0">
          <option value="all">Semua Kategori</option>
          @foreach ($kategoriList as $kategori)
          <option value="{{ $kategori->id }}"
            {{ selected_if(isset($filterQuery['kategori']) && $filterQuery['kategori'] == $kategori->id) }}>{{ $kategori->name }}</option>
          @endforeach
        </select>
        <button class="btn rounded-0 btn-accent text-dark fw-700 px-4">Cari</button>
      </form>

      <hr class="mt-0 d-md-none">

      @if (isset($list) && count($list))
        <div class="unduhan-list">
          @foreach ($list as $item)
            <div class="item">
              <i class="fi {!! flaticon_from_mime($item->mime) !!} icon"></i>
              <div class="tulisan">
                <div class="nama">{{ $item->title }}</div>
                <div class="meta">
                  <a class="kategori"
                    href="#">{{ $item->kategori_name }}</a>
                  <div class="info">Diterbitkan {{ $item->created_at->isoFormat('DD MMMM YYYY') }} | Diunduh {{ $item->hit }}
                    kali</div>
                </div>
              </div>
              @if ($item->is_private)
              <a class="btn btn-unduh btn-primary-alt"
                href="{{ route('direktori.download', ['slug' => $item->slug]) }}"
                target="_blank">
                <i class="mdi mdi-lock mr-2"></i>
                <span>Minta Akses</span>
              </a>
              @else
              <a class="btn btn-unduh btn-primary-alt"
                href="{{ route('direktori.download', ['slug' => $item->slug]) }}"
                target="_blank">Unduh</a>
              @endif
            </div>
          @endforeach
        </div>

        @if (isset($list) && $list->total() > $list->perPage())
        <div class="mt-5 d-flex justify-content-center">
          @if (count($filterQuery) > 0)
          {{ $list->appends($filterQuery)->links() }}
          @else
          {{ $list->links() }}
          @endif
        </div>
        @endif
      @else
      <x-pesan-tengah
        icon="mdi-folder-download"
        title="DIREKTORI KOSONG"
        :subtitle="$dataFiltered ? 'Pencarian tidak ditemukan' : 'Data unduhan belum tersedia'"
        />
      @endif
    </div>
  </div>
@endsection
