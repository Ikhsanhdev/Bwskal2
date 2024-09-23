@extends('layouts.modal')

{{-- Setup --}}
@php
  $isEdit = isset($data);
  $title = ($isEdit ? 'Ubah' : 'Tambah') . ' Link';
  
  $formHasFile = true;
  $formAction = route('admin.link-terkait.' . ($isEdit ? 'update' : 'store'));
@endphp

@section('title')
  <i class="mdi mdi-link mr-2"></i>
  <span class="font-weight-bold">{{ $title }}</span>
@endsection

@section('body')
  <div class="form-group">
    <label class="control-label mb-0"
      for="logo">Logo</label>
    <div class="fz-0-8rem text-muted font-weight-normal">Berukuran 400px x 200px</div>
    <div id="ciLogo"
      class="ak-cropit"
      data-name="logo"></div>
  </div>

  <x-ak-input label="Nama Link"
    name="name"
    placeholder="$label"
    required
    :value="$data->name ?? ''"
    />

  <x-ak-input label="Link Tujuan"
    name="link"
    placeholder="$label"
    required
    :value="$data->link ?? ''"
    />

@endsection

@section('footer')
  <button type="button"
    data-dismiss="modal"
    class="btn btn-block btn-secondary mr-3">BATAL</button>
  <button type="submit"
    class="btn btn-block btn-primary m-0"
    >SIMPAN</button>
@endsection

@section('script')
  <script>
    $(function() {
      let ciLogo = new AKCropit('#ciLogo', {
        width: 400,
        height: 200,
        teksPilih: 'Pilih',
        cropit: {
          smallImage: 'allow',
          @if ($isEdit && $data->image)
          imageState: {
            src: `{{ url(\App\Models\LinkTerkait::UPLOAD_PATH . $data->image) }}`,
          },
          @endif
        },
      })

      AKForm.make({
        datatables: window.listApp,
        indicator: {
          overlay: true,
        },
        dataBuilder(data) {
          data.forEach(d => {
            if (d.type == "file" && d.name == "logo" && d.value != "") {
              d.value = ciLogo.export();
            }
          });
          return data;
        },
      });
    });
  </script>
@endsection
