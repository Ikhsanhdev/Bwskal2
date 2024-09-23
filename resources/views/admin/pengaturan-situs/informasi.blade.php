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
    <div class="font-weight-bold fz-normal ml-2">Informasi</div>
  </div>

  {{-- Isi --}}
  <div class="admin-section">
    <form class="card"
      id="formnya"
      method="POST"
      action="{{ route('admin.pengaturan-situs.update', ['page' => 'informasi']) }}">
      @method('PUT')
      <div class="card-body">
        <div class="font-weight-bold fz-lg text-dark">Informasi Web</div>
        <x-ak-input name="profil"
          label="Profil Singkat"
          placeholder="$label"
          type="textarea"
          :value="$data->profil ?? ''" />

        <x-ak-input name="telepon"
          label="Nomor Telepon"
          :value="$data->telepon ?? ''" />

        <div class="font-weight-bold fz-lg text-dark d-flex align-items-center">
          <div>Informasi Kontak</div>
          <div class="flex"></div>
          <div>
            <button class="btn btn-secondary"
              type="button"
              id="btnTambahInfo">TAMBAH</button>
          </div>
        </div>
        <div id="infoApp"
          data-class="my-3 p-3 bg-light rounded"
          data-judul="Informasi Kontak"></div>
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

      let infoApp = initListApp('#infoApp', {
        inCard: true,
        typeMap: {
          "email": "Email",
          "link": "Link",
          "phone": "Telepon",
          "text": "Teks",
        },
        initData: @json(json_decode($data->kontak_list ?? '[]')),
        skemaData: [{
            name: `Nama`,
            key: 'name',
            type: 'text',
            required: true,
          },
          {
            name: "Tipe",
            key: "type",
            type: "select",
            value: [
              {
                text: 'Email',
                value: 'email',
              },
              {
                text: 'Link',
                value: 'link',
              },
              {
                text: 'Telepon',
                value: 'phone',
              },
              {
                text: 'Teks',
                value: 'text',
              },
            ],
            required: true,
          },
          {
            name: `Kontak`,
            key: 'value',
            type: 'text',
            required: true,
          }
        ],
        slot: {
          item: `
          <div>
            <div class="fz-0-75rem text-primary fw-700">@{{ opt.typeMap[s.item.type] }}</div>
            <div class="teks">@{{ s.item.name }}</div>
            <div class="subteks mt-0">@{{ s.item.value }}</div>
          </div>
          `,
        }
      });

      $('#btnTambahInfo').on('click', function() {
        infoApp.$refs.app.tambahOnClick();
      });

      setTimeout(() => {
        AKForm.make({
          indicator: {
            overlay: true
          },
          dataBuilder: (data) => {
            data.push({
              name: 'kontak_list',
              type: 'text',
              value: JSON.stringify(infoApp.getData() ?? []),
            });
            return data;
          },
        });
      }, 700);
    });
  </script>
@endsection
