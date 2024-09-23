@extends('layouts.admin.app')

@php
$title = "Galeri";
@endphp

@include('libs.akform')
@include('libs.izitoast')
@include('libs.datatables')
@include('libs.day')
@include('libs.cropit')

@section('adminHeader')
<i class="mdi mdi-image-album d-none d-md-inline-block mr-3"></i>
{{ $title }}
@endsection

@section('content')
<div class="admin-section"
  id="galeriApp">
  <div class="card card-search-box">
    <div class="card-header">
      <div class="title">
        <div>Daftar {{ $title }} <span v-if="isFiltered" class="fz-0-9rem font-weight-normal text-primary">(Terfilter)</span></div>
      </div>
      <div class="flex"></div>
      <div class="action btn-list-horizontal">
        <div class="btn-group mr-2">
          <button class="btn btn-secondary dropdown-toggle"
            type="button"
            data-toggle="dropdown">
            <i class="mdi mdi-filter mr-2 fz-normal"></i>
            <span class="mr-2">@{{ tsKata }}</span>
          </button>
          <div class="dropdown-menu">
            <div class="dropdown-item is-btn" v-for="t of tsList"
              :key="t.id"
              :class="{'active': t.id == listTipe }"
              @click="tsOnClick(t)">
              <i class="mdi mr-2 fz-normal" :class="t.icon"></i>
              <span class="">@{{ t.kata }}</span>
            </div>
          </div>
        </div>
        <a class="btn btn-primary"
          href="#"
          id="btnTambah">
          <i class="mdi mdi-database-plus mr-2 fz-normal"></i>
          <span>TAMBAH</span>
        </a>
      </div>
    </div>
    <div class="card-body bg-light pt-3 d-none">
      <input type="search"
        class="form-control form-control-sm bg-white"
        placeholder="Pencarian"
        aria-controls="tablenya">
    </div>
  </div>
  <div class="admin-galeri-wrap mt-4">
    <div class="row">
      <div class="col-md-6 col-lg-4 col-xl-3 gi-col"
        v-for="item of list"
        :key="item.id">
        <div class="galeri-item">
          <template v-if="item.type == 'album' && !item.content">
            <div class="cover-img d-flex align-items-center justify-content-center">
              <i class="mdi mdi-image-album fz-4-5rem"></i>
            </div>
          </template>
          <template v-else>
            <img :src="item.content" class="cover-img">
          </template>
          <div class="item-badge">
            <i class="mdi" :class="{
              'mdi-image-multiple': item.type == 'album',
              'mdi-image': item.type == 'image',
              'mdi-video': item.type == 'video',
              }"></i>
          </div>
          <div class="info">
            <div class="tipe">@{{ galeriTipeMap[item.type] }}</div>
            <div class="nama"
              v-html="item.name"></div> 
            <div class="tanggal">@{{ item.tanggal }}</div>
          </div>
          <div class="aksi">
            <div class="btn btn-secondary"
              v-if="item.type == 'album'"
              @click="itemKelolaClick(item)"
              >
              <span>KELOLA</span>
            </div>
            <div class="btn btn-secondary"
              @click="itemEditOnClick(item)">
              <i class="mdi mdi-database-edit"></i>
            </div>
            <div class="btn btn-danger"
              @click="itemDeleteOnClick(item)">
              <i class="mdi mdi-trash-can-outline"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="admin-galeri-footer"
    v-if="this.list">
    <div class="info">
      Menampilkan @{{ this.dataMulai }} - @{{ this.dataSelesai }} dari @{{ this.datainfo.totalFiltered }} Data @{{ dataInfoTerfilter }}
    </div>
    <div class="paging">
      <ul class="pagination mb-0">
        <li class="page-item"
          @click="btnDataPrev"
          :class="{
            'disabled': pDisablePrev,
          }">
          <div class="page-link is-btn">&lt;</div>
        </li>
        <li class="page-item"
          @click="btnDataNext"
          :class="{
            'disabled': pDisableNext,
          }">
          <div class="page-link is-btn">&gt;</div>
        </li>
      </ul>
    </div>
  </div>
</div>
@endsection

@section('jsAfterMain')
<script>
  $(document).ready(function () {
    @sessionErrorToast
    window.galeriApp = new Vue({
      el: '#galeriApp',
      data: {
        galeriTipeMap: {
          image: 'Foto',
          video: 'Video',
          album: 'Album',
        },
        datainfo: {
          index: 0,
          current: 0,
          length: 8,
          total: 0,
          totalFiltered: 0,
        },
        listTipe: 'all',
        list: null,
        //  Filter
        tsList: [
          {
            id: 'all',
            kata: 'Semua Tipe',
            icon: 'mdi-camera-burst'
          },
          {
            id: 'image',
            kata: 'Foto',
            icon: 'mdi-image'
          },
          {
            id: 'video',
            kata: 'Video',
            icon: 'mdi-video'
          },
        ],
      },
      computed: {
        pDisablePrev() {
          return this.datainfo.current == 0;
        },
        pDisableNext() {
          return (this.datainfo.current + this.datainfo.length) >= this.datainfo.totalFiltered;
        },
        dataMulai() {
          return this.datainfo.current + 1;
        },
        dataSelesai() {
          return this.datainfo.current + this.list.length;
        },
        dataInfoTerfilter() {
          if (this.datainfo.totalFiltered != this.datainfo.total) {
            return `(difilter dari ${this.datainfo.total} data) `;
          }
          return "";
        },
        tsKata() {
          switch (this.listTipe) {
            case 'all':
              return 'Semua Tipe';
              break;
            case 'image':
              return 'Foto';
              break;
            case 'video':
              return 'Video';
              break;
          }
        },
        isFiltered() {
          return this.listTipe != "all";
        },
      },
      methods: {
        btnDataPrev() {
          this.datainfo.index -= this.datainfo.length;
          this.loadData();
        },
        btnDataNext() {
          this.datainfo.index += this.datainfo.length;
          this.loadData();
        },
        reload() {
          this.datainfo.index = 0;
          this.loadData();
        },
        loadData() {
          AKToast.loading('Mengambil data', 'gl');
          axios.post(`{{ route('admin.gallery.datatable') }}`, {
            start: this.datainfo.index,
            length: this.datainfo.length,
            type: this.listTipe,
          })
          .then(res => {
            if (res.data?.data) {
              this.list = res.data.data;
              this.datainfo.current = res.data.input.start;
              this.datainfo.total = res.data.recordsTotal;
              this.datainfo.totalFiltered = res.data.recordsFiltered;
            }
          })
          .catch(err => {
            if (err?.response?.status == 419) {
              location.reload();
            } else {
              AKToast.error(err?.response?.data?.message ?? err.message);
            }
          })
          .finally(() => {
            AKToast.close('gl');
          });
        },
        itemKelolaClick(item) {
          let l = `{{ route('admin.gallery.album', ['album_id' => '::id::']) }}`;
          l = l.replace(/::id::/gm, item.id);
          location.href = l;
        },
        itemEditOnClick(item) {
          AKModal.open({
            url: `{{ route('admin.gallery.edit') }}`,
            data: {
              id: item.id,
            },
          });
        },
        itemDeleteOnClick(item) {
          AKHelper.DeleteConfirm({
            datatables: window.galeriApp,
            url: `{{ route('admin.gallery.destroy') }}`,
            loadingText: `Menghapus Item Galeri`,
            text: `<div>Apakah anda yakin menghapus <span class="font-weight-600">"${item.name}"</span> ?</div>${item.type == 'album' ? `<div ckass="mt-3">Item pada album akan diubah menjadi tanpa album.</div>` : ''}`,
            data: {
              id: item.id,
            },
          });
        },
        tsOnClick(t) {
          this.listTipe = t.id;
          this.reload();
        },
      },
      mounted() {
        this.loadData();
      }
    });
    $('#btnTambah').on('click', function (e) {
      e.preventDefault();
      AKModal.open(`{{ route('admin.gallery.create') }}`);
    });
  });
</script>
@endsection
