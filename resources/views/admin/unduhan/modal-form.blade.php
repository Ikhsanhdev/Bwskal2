@extends('layouts.modal')

{{-- Setup --}}
@php
  $isEdit = isset($data);
  $title = ($isEdit ? 'Ubah' : 'Tambah') . ' Unduhan';
  $formAction = route('admin.unduhan.' . ($isEdit ? 'update' : 'store'));
  $formHasFile = true;
@endphp

@section('title')
  <i class="mdi mdi-file-download mr-2"></i>
  <span class="font-weight-bold">{{ $title }}</span>
@endsection

@section('body')
  <div class="form-group">
    <label class="control-label"
      for="file">Berkas</label>
    @if ($isEdit)
      <div class="d-flex justify-content-center align-items-center flex-column flex">
        <i class="mdi mdi-file fz-3-5rem"></i>
        <div class="fz-md font-weight-bold text-center">{{ $data->file }}</div>
        <div class="mt-2 text-center">
          <a href="#"
            class="btn btn-secondary">UNDUH BERKAS</a>
        </div>
      </div>
    @else
      <div class="d-flex justify-content-center align-items-center flex-column flex">
        <i class="mdi mdi-file fz-3-5rem"></i>
        <div class="fz-1-15rem font-weight-bold text-center"
          id="fFileName">Silakan pilih berkas</div>
        <div class="fz-md text-muted text-center"
          id="fFileSize">{{ 'Bertipe ' . \App\Models\Unduhan::getExtensionList() }}</div>
      </div>
      <div class="form-group">
        <label for=""
          class="d-none"></label>
        <input type="file"
          id="iFile"
          class="vis-hidden"
          name="berkas"
          required>
      </div>
      <div class="btn-list-horizontal mb-md-0 mt-3 mb-3 text-center">
        <button class="btn btn-secondary"
          type="button"
          id="bPilih">Pilih Berkas</button>
      </div>
    @endif
  </div>

  <x-ak-input name="title"
    placeholder="Judul uduhan"
    label="Judul Unduhan"
    :value="$data->title ?? ''"
    required />

  <x-ak-select name="category"
    label="Kategori"
    :list="$kategoriList"
    placeholder="Pilih Kategori"
    :value="$data->category_id ?? ''"
    required />

  <div class="ak-checkbox">
    <input 
      type="checkbox" 
      id="is_private"
      name="is_private"
      {!! checked_if($isEdit && $data->is_private) !!}>
    <label for="is_private" class="cb"></label>
    <label for="is_private" class="label ">Batasi akses berkas</label>
  </div>
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
      @if (!$isEdit)
        let fd = {
          name: `Silakan pilih berkas`,
          size: `{{ 'Bertipe ' . \App\Models\Unduhan::getExtensionList() }}`,
        };
        let fFileName = $('#fFileName');
        let fFileSize = $('#fFileSize');
        let fPilih = $('#bPilih');
        let fFile = $('#iFile');
        fPilih.on('click', () => fFile.click());
        fFile.on('change', (e) => {
          let t = e.target;
          if (t.files.length) {
            let ff = t.files[0];
            fFileName.html(ff.name);
            fFileSize.html(formatByte(ff.size));
          } else {
            fFileName.html(fd.name);
            fFileSize.html(fd.size);
            fFile.val('');
          }
        });
      @endif

      let fForm = AKForm.make({
        datatables: dTables,
      });
    });
  </script>
@endsection
