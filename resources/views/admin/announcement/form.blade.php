@extends('layouts.admin.app')

{{-- Setup --}}
@php
$isEdit = isset($data);
$title = ($isEdit ? 'Ubah' : 'Tambah') . ' Pengumuman';
@endphp

{{-- Libs --}}
@include('libs.akform')
@include('libs.izitoast')
@include('libs.cropit')
@include('libs.flatpickr')

@section('adminHeader')
<i class="mdi mdi-bullhorn d-none d-md-inline-block mr-3"></i>
Pengumuman
@endsection

@section('content')
{{-- Atas --}}
<div class="admin-content-title">
  <a href="{{ route('admin.announcement.index') }}"
    class="btn btn-icon text-primary px-2">
    <i class="mdi mdi-arrow-left-thick fz-lg"></i>
  </a>
  <div class="font-weight-bold fz-normal ml-2">{{ $title }}</div>
</div>

{{-- Isi --}}
<div class="admin-section">
  <form class="card"
    id="formnya"
    method="POST"
    action="{{ route('admin.announcement.' . ($isEdit ? 'update' : 'store')) }}">
    @if ($isEdit)
    @method('PUT')
    <input type="hidden"
      name="_id"
      value="{{ $data->id }}" />
    @endif
    <div class="card-body">
      {{-- Sampul --}}
      <div class="form-group">
        <label class="control-label mb-0"
          for="cover">Sampul <span class="fz-md font-weight-normal">(Opsional, Minimal berukuran 900px x 350px)</span></label>
        <div id="ciSampul"
          class="ak-cropit"
          data-name="cover"></div>
      </div>
      
      <x-ak-input
        label="Judul Pengumuman"
        placeholder="Judul Pengumuman"
        name="title"
        :value="$data->title ?? ''"
        required
      />
      
      <div class="form-group">
        <label for="">Tanggal Aktif</label>
        <input type="text"
          class="form-control"
          name="tgl_aktif"
          placeholder="Tanggal pengumuman aktif"
          autocomplete="off"
          value="{{ isset($waktu) ? $waktu : '' }}"
          >
      </div>

      <div class="form-group">
        <label class="control-label"
          for="content">Isi</label>
        <textarea name="content"
          id="content"
          class="form-control">{{ $data->content ?? '' }}</textarea>
      </div>
    </div>
    <div class="card-footer text-right">
      <button class="btn btn-primary">SIMPAN</button>
    </div>
  </form>
</div>
@endsection

@section('jsAfterMain')
<script src="{{ url('libs/ckeditor/ckeditor.js') }}"></script>
<script>
  $(async function () {
    let topViewport = document.querySelector('.admin-header').offsetHeight + 40;
    let editorOptions = {
      ui: {
        viewportOffset: {
          top: topViewport,
        }
      },
    };
    let contentEditor = await AKCKEditorMake(document.querySelector('#content'), editorOptions);

    let tInfo;
    var taIsi = $('#isinya');
    $('[name="tgl_aktif"]').flatpickr({
      mode: 'range',
      altInput: true,
      altFormat: 'j F Y',
      dateFormat: 'd:m:Y',
    });
    window.ciSampul = new AKCropit('#ciSampul', {
      width: 900,
      height: 350,
      teksPilih: 'Pilih',
      responsive: {
        xs: .3,
        sm: .5,
        md: .75,
        lg: .75,
        xl: .75
      },
      @if ($isEdit && $data->cover)
      cropit: {
        imageState: {
          src: '{{ url("uploads/announcement/" . $data->cover) }}'
        },
      },
      @endif
    }); 
    window.fForm = AKForm.make({
      dataBuilder: function (data) {
        data.forEach(d => {
          if (d.name == 'tgl_aktif' && d.value.indexOf('-') == -1) {
            d.value = d.value + ' - ' + d.value;
          } else if (d.type == "file" && d.name == "cover" && d.value != "") {
            d.value = ciSampul.export();
          }
        });
        return data;
      }
    });
  });
</script>
@endsection
