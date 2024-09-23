@extends('layouts.admin.app')

{{-- Setup --}}
@php
$isEdit = isset($data);
$title = ($isEdit ? 'Ubah' : 'Tambah') . ' Halaman';
$formAction = route('admin.page.' . ($isEdit ? 'update' : 'store'));
@endphp

{{-- Libs --}}
@include('libs.akform')
@include('libs.izitoast')

@section('adminHeader')
<i class="mdi mdi-file d-none d-md-inline-block mr-3"></i>
{{ $title }}
@endsection

@section('content')
<div class="admin-content-title">
  <a href="{{ route('admin.page.index') }}"
    class="btn btn-icon text-primary px-2">
    <i class="mdi mdi-arrow-left-thick fz-lg"></i>
  </a>
  <div class="font-weight-bold fz-normal ml-2">{{ $title }}</div>
</div>

<div class="admin-section">
  <form action="{{ $formAction }}"
    class="card"
    method="POST"
    id="formnya">
    @if ($isEdit)
      @method('PUT')
      <input type="hidden"
        name="_id"
        value="{{ $data->id }}" />
    @endif
    <div class="card-body">
      <x-ak-input label="Judul Halaman"
        name="title"
        placeholder="Masukkan judul halaman"
        :value="$data->title ?? ''"
        required />
      
      <div class="form-group">
        <label for="">URL Halaman</label>
        <input type="text"
          class="form-control"
          id="iUrl"
          name="url"
          {{ $isEdit && $data->is_custom_slug ? '' : 'readonly' }}
          required
          data-parsley-alphadash
          value="{{ $data->slug ?? '' }}"
          >
        <div class="ak-checkbox mt-3">
          <input 
            type="checkbox" 
            id="is_custom"
            name="is_custom_slug"
            {{ $isEdit && $data->is_custom_slug ? 'checked' : '' }}
            >
          <label for="is_custom" class="cb"></label>
          <label for="is_custom" class="label fz-md">Gunakan custom URL</label>
        </div>
      </div>

      <div class="form-group">
        <label class="control-label"
          for="content">Konten Halaman</label>
        <textarea name="content"
          id="content"
          class="form-control">{{ $data->content ?? '' }}</textarea>
      </div>
    </div>
    <div class="card-footer d-flex justify-content-end">
      <button class="btn btn-primary"
        type="submit">SIMPAN</button>
    </div>
  </form>
</div>
@endsection

@section('jsAfterMain')
<script src="{{ url('libs/ckeditor/ckeditor.js') }}"></script>
<script>
  $(async function () {
    @sessionErrorToast
    let topViewport = document.querySelector('.admin-header').offsetHeight + 40;
    let editorOptions = {
      ui: {
        viewportOffset: {
          top: topViewport,
        }
      },
    };
    let contentEditor = await AKCKEditorMake(document.querySelector('#content'), editorOptions);
    let fForm = AKForm.make({});
    $('input[name="title"]').on('keyup', function(){
      if ($('#is_custom').prop('checked'))
        return;
      var $this = $(this);
      var slug = $this.val();
      slug = slug.toLowerCase()
        .replace(/[^\w ]+/g, '')
        .replace(/ +/g, '-')
        ;
      $('#iUrl').val(slug);
    });
    $('#is_custom').on('change', function(){
      if ($('#is_custom').prop('checked')) {
        $('#iUrl').removeAttr('readonly');
      } else {
        $('#iUrl').attr('readonly', 'readonly');
        $('input[name="title"]').trigger('keyup');
      }
    });
  });
</script>
@endsection