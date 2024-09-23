@extends('layouts.admin.app')

{{-- Setup --}}
@php
$judul = "Urutkan Slide";
@endphp

{{-- Libs --}}
@include('libs.akform')
@include('libs.izitoast')
@include('libs.day')
@include('libs.vue-draggable')

@section('adminHeader')
<i class="mdi {{ iconFromModel('Slide') }} d-none d-md-inline-block mr-3"></i>
Slide
@endsection

@section('content')
{{-- Atas --}}
<div class="admin-content-title">
  <a href="{{ route('admin.slide.index') }}"
    class="btn btn-icon text-primary px-2">
    <i class="mdi mdi-arrow-left-thick fz-lg"></i>
  </a>
  <div class="font-weight-bold fz-normal ml-2">{{ $judul }}</div>
</div>

{{-- Isi --}}
<div class="admin-section">
  <div class="card card-table card-table-fit overflow-hidden" id="uApp">
    <div class="card-header">
      <div class="title">Daftar Slide Featured</div>
      <div class="flex"></div>
      <div class="action">
        <div class="btn btn-primary" @click="simpanOnClick">
          <i class="mdi mdi-sort-numeric-ascending mr-2 fz-normal"></i>
          <span>SIMPAN URUTAN</span>
        </div>
      </div>
    </div>
    <div class="card-body bg-light pt-3">
      <template v-if="list.length">
        <draggable
          v-model="list"
          ghost-class="ghost"
          :animation="200"
          :scroll-sensitivity="100"
          >
          <div
            v-for="item in list"
            :key="item.id"
            class="featured-item"
            >
            <div class="fz-md text-primary font-weight-bold">@{{ tipeMap[item.tipe] }}</div>
            <div class="font-weight-bold">@{{ item.judul }}</div>
          </div>
          </draggable>
      </template>
      <template v-else>
        <div class="card-body">
          @include('components.pesan-tengah', [
            'judul' => 'Tidak ada slide featured'
          ])
        </div>
      </template>
    </div>
  </div>
</div>
@endsection

@section('cssAfterMain')
<style>
.featured-item {
  background: white;
  padding: .5rem 1rem;
  border-radius: 8px;
  border: 1px solid rgba(0,0,0,0.075);
}
.featured-item + .featured-item{
  margin-top: 1rem;
}
</style>
@endsection

@section('jsAfterMain')
<script>
  $(function () {
    @sessionErrorToast
    window.tipeMap = {
      post: 'Berita',
      image: 'Gambar',
    };
    window.uApp = new Vue({
      el: '#uApp',
      data() {
        return {
          list: @json($list),
        };
      },
      methods: {
        simpanOnClick() {
          let urutan = this.list.map(item => item.id);
          AKToast.loading(`Menyimpan Urutan`, 'ld');
          axios.post(`{{ route('admin.slide.urutkan.put') }}`, {
            _method: 'PUT',
            urutan: urutan,
          })
          .then(res => {
            if (res?.data?.success) {
              AKToast.success(res.data.message);
            }
          })
          .finally(() => {
            AKToast.close('ld');
          });
        },
      },
    });
  });
</script>
@endsection