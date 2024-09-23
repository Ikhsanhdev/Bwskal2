@extends('layouts.admin.app')

{{-- Setup --}}
@php
$title = 'Pengaturan Akun';
@endphp

{{-- Libs --}}
@include('libs.akform')
@include('libs.cropit')
@include('libs.izitoast')

@section('adminHeader')
  <i class="mdi mdi-account-box d-none d-md-inline-block mr-3"></i>
  {{ $title }}
@endsection

@section('content')
  {{-- Isi --}}
  <div class="admin-section">
    <form action="{{ route('admin.pengaturan-akun.update') }}"
      class="card"
      id="formnya"
      method="POST">
      @method('PUT')
      <div class="card-body">
        <div class="row">
          <div class="col-lg-3">
            <div class="form-group">
              <label for="">Foto Profil</label>
              <div id="ciPhoto"
                class="ak-cropit"
                data-name="avatar"></div>
            </div>
          </div>
          <div class="col-lg-9">
            <h4 class="text-dark fw-800">Informasi Akun</h4>
            <x-ak-input name="name"
              label="Nama Lengkap"
              required
              :value="$data->fullname" />
              
            <x-ak-input name="username"
              label="Nama Pengguna"
              type="text"
              required
              :value="$data->username" />

            <x-ak-input name="email"
              label="Alamat Email"
              type="email"
              required
              :value="$data->email" />

            <h4 class="text-dark fw-800 mt-4 mb-1">Kata Sandi</h4>
            <div class="text-muted fz-0-8rem mb-2">Isi jika ingin mengganti kata sandi</div>
            <div class="row">
              <div class="col-md-6">
                <x-ak-input 
                  name="sandi_baru"
                  label="Kata Sandi Baru"
                  placeholder="$label"
                  type="password"
                  />
              </div>
              <div class="col-md-6">
                <x-ak-input 
                  name="sandi_baru_konfirmasi"
                  label="Konfirmasi Sandi Baru"
                  placeholder="$label"
                  type="password"
                  />
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="card-footer text-right">
        <button type="submit"
          class="btn btn-primary text-uppercase fz-1rem">SIMPAN</button>
      </div>
    </form>
  </div>
@endsection

@section('jsAfterMain')
  <script>
    $(function() {
      @sessionErrorToast
      let cropper = new AKCropit('#ciPhoto', {
        width: 300,
        height: 300,
        teksPilih: 'Pilih Foto',
        cropit: {
          imageState: {
            @if ($data->avatar)
              src: @json($data->avatar_image),
            @endif
          },
          smallImage: "allow",
        },
        responsive: {
          xs: .65,
          sm: .65,
          md: .65,
          lg: .65,
          xl: .65
        }
      });
      let f = AKForm.make({
        indicator: {
          overlay: true
        },
        dataBuilder(data) {
          data.forEach(d => {
            if (d.type == "file" && d.name == "avatar") {
              if (d.value) {
                d.value = cropper.export();
              }
            }
          });
          return data;
        },
      });
    });
  </script>
@endsection
