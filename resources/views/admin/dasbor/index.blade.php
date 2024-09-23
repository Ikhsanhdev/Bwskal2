@extends('layouts.admin.app')

@section('adminHeader')
<i class="mdi mdi-monitor d-none d-md-inline-block mr-3"></i>
Dashboard
@endsection

@section('content')
<div class="admin-section">
  <div class="card mb-4">
    <div class="card-body">
      <div class="text-center">
        <div class="font-weight-bold text-dark fz-1-75rem">Balai Wilayah Sungai Kalimantan II</div>
        <div>Data diperbaharui pada <strong>{{ $statData->last_update ?? '-' }}</strong></div>
      </div>
    </div>
  </div>
  
  {{-- Visitor --}}
  <div class="fz-1-25rem font-weight-bold text-dark mb-3">Statistik Pengunjung</div>
  <div class="row">
    <div class="col-sm-12 col-md-6 col-xl-3">
      <x-dashboard-card 
        label="Total Pengunjung"
        :value="short_number($statData->visit->total)"
        />
    </div>
    <div class="col-sm-12 col-md-6 col-xl-3">
      <x-dashboard-card 
        label="Pengunjung Bulan ini"
        :value="short_number($statData->visit->bulan)"
        />
    </div>
    <div class="col-sm-12 col-md-6 col-xl-3">
      <x-dashboard-card 
        label="Pengunjung Minggu ini"
        :value="$statData->visit->minggu"
        />
    </div>
    <div class="col-sm-12 col-md-6 col-xl-3">
      <x-dashboard-card 
        label="Pengunjung Hari ini"
        :value="$statData->visit->hari"
        />
    </div>
  </div>

  <div class="fz-1-25rem font-weight-bold text-dark mb-3">Statistik Lainnya</div>
  <div class="row">
    <div class="col-sm-12 col-md-6 col-xl-3">
      <x-dashboard-card 
        label="Total Berita"
        icon="mdi-newspaper-variant"
        :value="$statData->post_total"
        />
    </div>
    <div class="col-sm-12 col-md-6 col-xl-3">
      <x-dashboard-card 
        label="Total Berita Ditjen SDA"
        icon="mdi-newspaper-variant-multiple"
        :value="$statData->post_sda"
        />
    </div>
    {{-- Unduhan --}}
    <div class="col-sm-12 col-md-6 col-xl-3">
      <x-dashboard-card 
        label="Total Unduhan"
        icon="mdi-file-download"
        :value="$statData->unduhan"
        />
    </div>
    <div class="col-sm-12 col-md-6 col-xl-3">
      <x-dashboard-card
        label="Total Unduhan diunduh"
        icon="mdi-download-circle-outline"
        :value="$statData->unduhan_diunduh"
        />
    </div>
    <div class="col-sm-12 col-md-6 col-xl-3">
      <x-dashboard-card 
        label="Total Galeri Foto"
        icon="mdi-image"
        :value="short_number($statData->galeri_foto)"
        />
    </div>
    <div class="col-sm-12 col-md-6 col-xl-3">
      <x-dashboard-card 
        label="Total Galeri Video"
        icon="mdi-video-box"
        :value="short_number($statData->galeri_video)"
        />
    </div>
    <div class="col-sm-12 col-md-6 col-xl-3">
      <x-dashboard-card 
        label="Total Poster"
        icon="mdi-tooltip-image-outline"
        :value="short_number($statData->poster)"
        />
    </div>
    <div class="col-sm-12 col-md-6 col-xl-3">
      <x-dashboard-card 
        label="Total Pengumuman"
        icon="mdi-bullhorn"
        :value="short_number($statData->pengumuman)"
        />
    </div>
  </div>
</div>
@endsection
