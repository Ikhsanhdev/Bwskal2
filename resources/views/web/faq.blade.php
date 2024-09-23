@extends('layouts.web.page')

@php
  $title = 'Frequently Asked Questions (FAQ)';
@endphp

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="page-top-wrap">
          <div class="page-title-wrap">
            <div class="title">{{ $title }}</div>
          </div>
          <div class="flex"></div>
          <div class="fz-0-85rem">
            @if ($lastUpdate)
            Diperbaharui <strong>{{ $lastUpdate }}</strong> |
            @endif
            Dilihat <strong>{{ Visitor::countRoute('web.faq') }}</strong> kali
          </div>
        </div>
      </div>
    </div>

    <div class="page-content-box decor-bt-accent pb-4">
      @if ($faqs && count($faqs))
      <div class="text-center fz-1-25rem mb-5 fw-800 text-dark">Beberapa Pertanyaan yang Sering Diajukan Kepada Kami</div>
      <div class="faq-list" style="min-height: 30vh">
        @foreach ($faqs as $item)
        <div class="faq-item">
          <div class="faq-title" data-toggle="collapse" data-target="#collapse-{!! $item->slug !!}">{{ $item->title }}</div>
          <div class="faq-content-wrap collapse" id="collapse-{!! $item->slug !!}">
            <div class="faq-content mt-3 ck-content">{!! $item->content !!}</div>
          </div>
        </div>
        @endforeach
      </div>
      @else
      <x-pesan-tengah
        icon="mdi-message-question"
        title="Data FAQ kosong"
        subtitle="Data item FAQ belum tersedia"
        />
      @endif
    </div>
  </div>
@endsection
