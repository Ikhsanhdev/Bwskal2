@extends('layouts.admin.app')

{{-- Setup --}}
@php
  $title = 'Kontak WA';
@endphp

{{-- Libs --}}
@include('libs.akform')
@include('libs.izitoast')
@include('libs.cropit')

@section('adminHeader')
  <i class="mdi mdi-whatsapp d-none d-md-inline-block mr-3"></i>
  {{ $title }}
@endsection

@section('content')
  {{-- Isi --}}
  <div class="admin-section">
    <form class="card"
      id="formnya"
      method="POST"
      action="{{ route('admin.kontak-wa.update') }}">
      @method('PUT')
      <div class="card-body">
        <div class="font-weight-bold fz-lg text-dark">Pengaturan Tombol Kontak WA</div>
        <x-ak-input name="telepon"
          label="Nomor Telepon Tujuan"
          placeholder="$label"
          :value="$data->telepon ?? ''" />

        <hr class="mt-4">
        
        <div class="font-weight-bold fz-lg text-dark">Pengaturan Popup Kontak WA</div>
        <div class="alert alert-warning d-flex mt-2">
          <i class="mdi mdi-information fz-2rem mr-3"></i>
          <div>
            <div class="fw-700">Harap diperhatikan!</div>
            <div class="fz-0-85rem">Foto, nama dan isi pesan <strong>wajib</strong> diisi jika ingin memunculkan popup.</div>
          </div>
        </div>
        <div class="form-group">
          <label for="">Foto <span class="fz-0-75rem text-muted fw-600">(Opsional)</span></label>
          <div id="ciPhoto"
            class="ak-cropit"
            data-name="foto"></div>
        </div>

        <x-ak-input name="nama"
          label="Nama"
          placeholder="$label"
          optional
          :value="$data->nama ?? ''" />

        <x-ak-input name="keterangan"
          label="Keterangan"
          placeholder="$label"
          optional
          :value="$data->keterangan ?? ''" />

        <div class="form-group">
          <label class="control-label"
            for="pesan">Isi Pesan <span class="fz-0-75rem text-muted fw-600">(Opsional)</span></label>
          <textarea name="pesan"
            id="pesan"
            class="form-control">{{ $data->pesan ?? '' }}</textarea>
        </div>
        
      </div>
      <div class="card-footer text-right">
        <button class="btn btn-primary text-uppercase fz-1rem"
          type="submit">SIMPAN</button>
      </div>
    </form>
  </div>
@endsection

@section('jsAfterMain')
  <script src="{{ url('libs/ckeditor/ckeditor.js') }}"></script>
  <script>
    $(function() {
      @sessionErrorToast

      setTimeout(async () => {
        let topViewport = document.querySelector('.admin-header').offsetHeight + 40;
        let editorOptions = {
          ui: {
            viewportOffset: {
              top: topViewport,
            }
          },
        };
        let contentEditor = await AKCKEditorMake(document.querySelector('#pesan'), editorOptions);
        let cropper = new AKCropit('#ciPhoto', {
          width: 100,
          height: 100,
          teksPilih: 'Pilih Foto',
          cropit: {
            imageState: {
              @if ($data->foto)
                src: @json(url('uploads/avatar/' . $data->foto)),
              @endif
            },
            smallImage: "allow",
          },
        });
        AKForm.make({
          indicator: {
            overlay: true
          },
          dataBuilder: (data) => {
            data.forEach(d => {
              if (d.type == "file" && d.name == "foto") {
                if (d.value) {
                  d.value = cropper.export();
                }
              }
            });
            return data;
          },
        });
      }, 700);
    });
  </script>
@endsection
