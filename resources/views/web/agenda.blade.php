@extends('layouts.web.page')

@php
  $title = 'Agenda';
@endphp

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="page-top-wrap">
          <div class="page-title-wrap">
            <div class="title">AGENDA</div>
          </div>
          <div class="flex"></div>
          <div class="fz-0-85rem">
          </div>
        </div>
      </div>
    </div>

    <div class="page-content-box decor-bt-accent pb-4">
      @if (isset($list) && count($list))
      <div class="table-responsive">
        <table class="table-agenda table-bordered table-hover table">
          <thead>
            <tr>
              <th class="text-center">NO.</th>
              <th class="text-center" style="min-width: 300px">AGENDA</th>
              <th class="text-center">LAMPIRAN</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($list as $item)
              <tr class="agenda-item"
                id="agenda-{{ $item->slug }}">
                <td>
                  <div class="fw-800 fz-1-25rem text-center">{{ $loop->iteration }}</div>
                </td>
                <td>
                  <div class="d-flex align-items-center mb-1" style="gap: .75rem">
                    <div class="agenda-info">
                      <i class="mdi icon mdi-calendar"></i>
                      <div class="kata">{{ $item->date_range_text }}</div>
                    </div>
                    <div class="agenda-info">
                      <i class="mdi icon mdi-map-marker"></i>
                      <div class="kata">{{ $item->location }}</div>
                    </div>
                  </div>
                  <div class="title">{{ $item->title }}</div>
                  <div class="fz-0-8rem text-dark">{!! $item->description !!}</div>
                </td>
                <td class="text-center">
                  @if ($item->attachment)
                    <a href="{{ $item->attachment_url }}"
                      class="btn btn-outline-primary wide"
                      target="_blank">UNDUH</a>
                  @else
                    -
                  @endif
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      @else
        <x-pesan-tengah
          icon="mdi-calendar-clock"
          title="AGENDA KOSONG"
          subtitle="Data Agenda belum ada"
          />
      @endif
    </div>
  </div>
@endsection
