@extends('layouts.modal')

{{-- Setup --}}
@php
  $isEdit = isset($data);
  $title = ($isEdit ? 'Ubah' : 'Tambah') . ' FAQ';
  
  $formHasFile = true;
  $formAction = route('admin.faq.' . ($isEdit ? 'update' : 'store'));
@endphp

@section('title')
  <i class="mdi mdi-message-question mr-2"></i>
  <span class="font-weight-bold">{{ $title }}</span>
@endsection

@section('body')
  <x-ak-input label="Pertanyaan"
    name="title"
    placeholder="$label"
    required
    :value="$data->title ?? ''"
    />

  <div class="form-group">
    <label class="control-label"
      for="content">Jawaban</label>
    <textarea name="content"
      id="content"
      class="form-control">{{ $data->content ?? '' }}</textarea>
  </div>

  <div class="ak-checkbox mt-3">
    <input 
      type="checkbox" 
      id="is_show"
      name="is_show"
      {{ $isEdit && !$data->is_show ? '' : 'checked' }}
      >
    <label for="is_show" class="cb"></label>
    <label for="is_show" class="label">Tampilkan pada halaman publik</label>
  </div>
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
      let contentEditor = AKCKEditorMake(document.querySelector('#content'));

      AKForm.make({
        datatables: window.faqApp,
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
