@extends('layouts.admin.app')

{{-- Setup --}}
@php
  $title = 'Pengaturan Web';
@endphp

{{-- Libs --}}
@include('libs.akform')
@include('libs.izitoast')
@include('libs.vue-draggable')

@section('adminHeader')
  <i class="mdi mdi-cog d-none d-md-inline-block mr-3"></i>
  {{ $title }}
@endsection

@section('content')
  {{-- Atas --}}
  <div class="admin-content-title">
    <a href="{{ route('admin.pengaturan-situs.index') }}"
      class="btn btn-icon text-primary px-2">
      <i class="mdi mdi-arrow-left-thick fz-lg"></i>
    </a>
    <div class="font-weight-bold fz-normal ml-2">Media Sosial</div>
  </div>

  {{-- Isi --}}
  <div class="admin-section">
    <div id="listApp"
      data-class="mb-5"
      data-judul="Media Sosial"
      data-url="{{ route('admin.pengaturan-situs.update', ['page' => 'media-sosial']) }}">
    </div>
  </div>
@endsection

@section('jsAfterMain')
  <script>
    $(function() {
      @sessionErrorToast

      let medsosApp = initListApp('#listApp', {
        initData: @json($data ?? []),
        skemaData: [
          {
            name: "Tipe",
            key: "type",
            type: "select",
            value: [{
                text: 'Website',
                value: 'web',
              },
              {
                text: 'Facebook',
                value: 'facebook',
              },
              {
                text: 'Twitter',
                value: 'twitter',
              },
              {
                text: 'Linkedin',
                value: 'linkedin',
              },
              {
                text: 'Instagram',
                value: 'instagram',
              },
              {
                text: 'Youtube',
                value: 'youtube',
              },
            ],
            required: true,
          },
          {
            name: "Nama",
            key: "name",
            type: "text",
            required: true,
          },
          {
            name: "Link",
            key: "link",
            type: "text",
          },
        ],
        slot: {
          item: `
        <i class="mdi fz-2rem mr-2 medsos-link-colored"
          :class="[{
            'mdi-web' : s.item.type == 'web',
            'mdi-facebook' : s.item.type == 'facebook',
            'mdi-twitter' : s.item.type == 'twitter',
            'mdi-linkedin' : s.item.type == 'linkedin',
            'mdi-instagram' : s.item.type == 'instagram',
            'mdi-youtube' : s.item.type == 'youtube',
          }, s.item.type]"></i>
        <div>
          <div class="teks mb-0">@{{ s.item.name }}</div>
          <div class="subteks mt-0">@{{ s.item.link }}</div>
        </div>
        `,
        }
      });
    });
  </script>
@endsection
