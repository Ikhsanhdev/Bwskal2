@extends('layouts.modal')

@php
$isEdit = isset($data);
$judul = ($isEdit ? 'Ubah' : 'Tambah') . ' Slide';
$action = 'admin.slide.' . ($isEdit ? 'update' : 'store');

$tipeList = \App\Models\Slide::getTypeList();
@endphp

@section('title')
<i class="mdi mdi-camera-burst mr-2"></i>
<span class="font-weight-bold">{{ $judul }}</span>
@endsection

@section('form')
<form 
  action="{{ route($action) }}" 
  method="POST"
  id="formnya"
  novalidate
  >
  @if ($isEdit)
  @method('PUT')
  <input type="hidden" name="_id" value="{{ $data->id }}"/>
  @endif
@endsection

@section('body')
@if (! $isEdit)
<x-ak-select name="tipe"
  label="Tipe Slide"
  placeholder="Pilih tipe slide"
  v-model="formdata.tipe"
  required
  @change="tipeOnChange"
  :list="$tipeList" />
@endif
<template v-if="formdata.tipe == 'image'">
  <div class="form-group">
    <label class="control-label mb-0" for="gambar">Gambar Slide <span class="text-muted fz-md font-weight-normal">1258 x 550 px</span></label>
    <div id="ciGambar" class="ak-cropit" data-name="gambar" ></div>
  </div>
  {{-- Judul --}}
  <div class="form-group mb-1">
    <label for="judul" class="control-label">Judul Slide</label>
    <input
      type="text"
      class="form-control"
      placeholder="Judul Slide"
      name="judul"
      autocomplete="off"
      spellcheck="false"
      required
      minlength="3"
      v-model="formdata.judul"
      key="si-judul"
      >
  </div>
  {{-- Judul Tampil --}}
  <div class="ak-checkbox">
    <input 
      type="checkbox" 
      id="judul_tampil"
      name="judul_tampil"
      {!! checked_if(! $isEdit || ($isEdit && $data->show_title)) !!}
      key="si-judul-tampil">
    <label for="judul_tampil" class="cb"></label>
    <label for="judul_tampil" class="label fz-md">Tampilkan judul slide</label>
  </div>
  
  <div class="form-group mt-1">
    <label for="link" class="control-label">Link Slide <span class="fz-0-75rem text-muted fw-600">(Opsional)</span></label>
    <input
      type="url"
      class="form-control"
      placeholder="Link Slide"
      name="link"
      autocomplete="off"
      spellcheck="false"
      v-model="formdata.link"
      key="si-link"
      >
  </div>
</template>
<template v-else-if="formdata.tipe == 'post'">
  <div class="form-group mb-0">
    <label for="">Daftar Berita <span v-if="post.isLoading" class="ml-3"><i class="mdi mdi-loading mdi-spin"></i></span></label>
    <div class="artikelselector">
      <template v-if="post.list && post.list.length">
        <div class="artikelselector-item"
          v-for="p in post.list"
          @click="postOnClick(p)"
          :class="{ 'active' : post.selected.id == p.id }"
          :key="p.id"
          >
          <div class="thumbs" v-if="p.cover"
            :style="{ 'background-image': 'url({{ url('uploads/post/thumbs_') }}' + p.cover + ')' }"></div>
          <div v-else>
            <i class="icon mdi mdi-newspaper-variant fz-3-5rem mr-2 lh-1"></i>
          </div>
          <div>
            <div class="judul">@{{ p.title }}</div>
            <div class="meta">@{{ p.created_at | formatTanggal }}</div>
          </div>
        </div>
      </template>
      <template v-else>
        <div class="d-flex flex-column justify-content-center align-items-center lh-1-25 h-100">
          <div class="fw-700 fz-1-25rem text-dark">Data Kosong</div>
          <div class="text-secondary">Data berita masih kosong</div>
        </div>
      </template>
    </div>
    <input 
      type="text" 
      name="post_id" 
      :value="post.selected.id || ''" 
      required 
      :key="'artikel-id'"
      class="d-none"
      >
  </div>
</template>
@endsection

@section('footer')
  <button type="button" 
    data-dismiss="modal"
    class="btn btn-block btn-secondary mr-3"
    >BATAL</button>
  <button 
    class="btn btn-block btn-primary m-0"
    >SIMPAN</button>
@endsection

@section('script')
<script>
  $(document).ready(function () {
    window.slApp = new Vue({
      el: '#formnya',
      data() {
        return {
          formdata: {
            tipe: `{{ $isEdit ? $data->type : '' }}`,
          },
          post: {
            list: [],
            selected: [],
            isLoading: false,
          },
          ciGambar: null,
          form: null,
        };
      },
      filters: {
        formatTanggal(value) {
          return dayjs(value).format('DD MMMM YYYY');
        },
      },
      methods: {
        tipeOnChange() {
          switch (this.formdata.tipe) {
            case "image":
              setTimeout(() => {
                this.ciGambar = new AKCropit('#ciGambar', {
                  width: 1258,
                  height: 550,
                  teksPilih: 'Pilih Gambar',
                  responsive: {
                    xs: .2,
                    sm: .2,
                    md: .3,
                    lg: .3,
                    xl: .3
                  },
                  cropit: {
                    @if ($isEdit && $data->type == 'image')
                    imageState: {
                      src: '{{ url("uploads/slide/" . $data->value) }}',
                    },
                    @endif
                  },
                }); 
              }, 300);
              this.post.isLoading = false;
            break;
            case "post":
              this.post.isLoading = true;
              axios.post(`{{ route('admin.slide.post-list') }}`, {
                selected: this.post.selected?.id ?? null,
              })
              .then(res => {
                if (res.data?.success) {
                  this.post.list = res.data.data.list;
                } else {
                  AKToast.error(`Terjadi kesalahan saat mengambil daftar berita`);
                }
              })
              .catch(err => {
                AKToast.error(`Terjadi kesalahan saat mengambil daftar berita`);
              })
              .finally(() => {
                this.post.isLoading = false;
              });
            break;
          }
        },
        postOnClick(post) {
          this.post.selected = post;
        },
      },
      mounted() {
        @if ($isEdit)
        @if($data->type == 'image')
        this.formdata.judul = `{{ $data->title ?? '' }}`,
        this.formdata.link = `{{ $data->link ?? '' }}`,
        @elseif ($data->type == 'post')
        this.post.selected = {
          id: {{ $data->value }},
        };
        @endif
        this.tipeOnChange();
        this.$forceUpdate();
        @endif
        this.form = AKForm.make({
          datatables: dTables,
          dataBuilder: (data) => {
            @if ($isEdit)
            data.push({
              name: 'tipe',
              type: 'text',
              value: this.formdata.tipe,
            });
            @endif
            data.forEach(d => {
              if (d.type == "file" && d.name == "gambar" && d.value != "") {
                d.value = this.ciGambar.export();
              }
            });
            return data;
          },
        });
      }
    });
  });
</script>
@endsection
