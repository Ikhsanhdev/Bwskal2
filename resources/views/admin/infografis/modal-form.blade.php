@extends('layouts.modal')

{{-- Setup --}}
@php
  $isEdit = isset($data);
  $title = ($isEdit ? 'Ubah' : 'Tambah') . ' Poster';
  $formAction = route('admin.poster.' . ($isEdit ? 'update' : 'store'));
  $formHasFile = true;
@endphp

@section('title')
  <i class="mdi mdi-tooltip-image mr-2"></i>
  <span class="font-weight-bold">{{ $title }}</span>
@endsection

@section('body')
  <x-ak-input name="name"
    placeholder="Nama poster"
    label="Nama Poster"
    :value="$data->name ?? ''"
    required />

  @if ($isEdit)
    <div class="form-group">
      <label for="">Preview Gambar</label>
      <div class="px-5">
        <img src="{{ url(\App\Models\Infografis::UPLOAD_PATH . 'preview_' . $data->path) }}"
          class="img-fluid rounded">
      </div>
    </div>
    <div class="form-group">
      <label for="">File Gambar <span class="fz-md text-muted font-weight-normal">(Pilih file jika ingin mengganti)</span></label>
      <input type="file"
        name="image"
        class="form-control-file"
        id="image-file"
        >
    </div>
  @else
    <div class="form-group">
      <label for="">File Gambar</label>
      <input type="file"
        name="image"
        class="form-control-file"
        id="image-file"
        required>
    </div>
  @endif
@endsection

@section('footer')
  <button type="button"
    data-dismiss="modal"
    class="btn btn-block btn-secondary mr-3">BATAL</button>
  <button class="btn btn-block btn-primary m-0">SIMPAN</button>
@endsection

@section('script')
  <script>
    $(document).ready(function() {
      $('#image-file').filestyle();
      let fForm = AKForm.make({
        datatables: dTables,
      });
    });
  </script>
@endsection
