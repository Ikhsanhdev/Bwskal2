@extends('layouts.admin.app')

{{-- Setup --}}
@php
$isEdit = isset($data);
$title = ($isEdit ? 'Ubah' : 'Tambah') . ' Berita';
if ($isEdit && $data->status == 'draft') {
  $title = 'Ubah Draft Berita';
}
$formAction = route('admin.post.' . ($isEdit ? 'update' : 'store'));
@endphp

{{-- Libs --}}
@include('libs.akform')
@include('libs.izitoast')
@include('libs.cropit')

@section('adminHeader')
  <i class="mdi mdi-newspaper-variant d-none d-md-inline-block mr-3"></i>
  Berita
@endsection

@section('content')
  {{-- Atas --}}
  <div class="admin-content-title">
    <a href="{{ route('admin.post.index') }}"
      class="btn btn-icon text-primary px-2">
      <i class="mdi mdi-arrow-left-thick fz-lg"></i>
    </a>
    <div class="font-weight-bold fz-normal ml-2">{{ $title }}</div>
  </div>

  {{-- Isi --}}
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
        <div class="form-group">
          <label class="control-label mb-0"
            for="cover">Sampul <span class="fz-md font-weight-normal">(Opsional, Minimal berukuran 900px x 450px)</span></label>
          <div id="ciCover"
            class="ak-cropit"
            data-name="cover"></div>
        </div>

        <x-ak-input label="Judul"
          name="title"
          placeholder="Masukkan judul berita"
          :value="$data->title ?? ''"
          required />

        <x-ak-select name="category"
          label="Kategori Berita"
          :list="$kategoriList"
          placeholder="Pilih Kategori Berita"
          :value="$data->category_id ?? ''"
          required />

        <div class="form-group">
          <label class="control-label"
            for="content">Konten Berita</label>
          <textarea name="content"
            id="content"
            class="form-control">{{ $data->content ?? '' }}</textarea>
        </div>
      </div>
      <div class="card-footer d-flex justify-content-end btn-list-horizontal">
        @if (!$isEdit || ($isEdit && $data->status == 'draft'))
        <button class="btn btn-secondary"
          type="submit" name="save_status" value="draft">SIMPAN DRAFT</button>
        <button class="btn btn-primary"
          type="submit" name="save_status">PUBLISH</button>
        @else
        <button class="btn btn-primary"
          type="submit" name="save_status">SIMPAN</button>
        @endif
      </div>
    </form>
  </div>
@endsection

@section('jsAfterMain')
<script src="{{ url('libs/ckeditor/ckeditor.js') }}"></script>
<script>
  $(async function() {
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

    window.ciCover = new AKCropit('#ciCover', {
      width: 900,
      height: 450,
      teksPilih: 'Pilih',
      responsive: {
        xs: .3,
        sm: .5,
        md: .75,
        lg: .75,
        xl: .75
      },
      cropit: {
        smallImage: 'allow',
        @if ($isEdit && $data->cover)
          imageState: {
            src: '{{ url($data->cover_image) }}'
          },
        @endif
      },
    });

    AKForm.make({
      dataBuilder(data) {
        data.forEach(d => {
          if (d.type == "file" && d.name == "cover" && d.value != "") {
            d.value = ciCover.export();
          }
        });
        return data;
      },
    });
  });
</script>
@endsection
