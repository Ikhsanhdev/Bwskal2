@extends('layouts.admin.app')

{{-- Setup --}}
@php
$title = "Kategori Berita";
@endphp

{{-- Libs --}}
@include('libs.akform')
@include('libs.datatables')
@include('libs.izitoast')

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
  <div class="card card-table card-table-fit">
    <div class="card-header">
      <div class="title">Daftar {{ $title }}</div>
      <div class="flex"></div>
      <div class="action">
        <div class="btn btn-primary"
          id="btnTambah">
          <i class="mdi mdi-database-plus mr-2 fz-normal"></i>
          <span>TAMBAH</span>
        </div>
      </div>
    </div>
    <table id="tablenya"
      class="table table-bordered table-fit table-hover table-striped w-100"></table>
  </div>
</div>
@endsection

@section('jsAfterMain')
<script>
  $(function () {
    @sessionErrorToast

    window.dTables = AKTable.make({
      columns: [
        { 
          data: '@nomor',
        },
        { 
          title: '<center>Kategori Berita</center>',
          render: function (row) {
            return `
              <div class="font-weight-bold text-dark">${row.name}</div>
              <div class="fz-md text-muted">${row.slug}</div>
              `;
          }
        },
        { 
          className: 'text-center',
          width: '110px',
          title: 'Aksi',
          render: function(data, type, row) {
            return `
              <a class="btn btn-secondary btn-icon btn-ubah"
                data-id="${row.id}"
                >
                <i class="mdi mdi-database-edit"></i>
              </a>
              <a class="btn btn-danger btn-icon btn-hapus"
                data-id="${row.id}"
                data-judul="${row.name}"
                >
                <i class="mdi mdi-trash-can"></i>
              </a>
              `;
          },
        }
      ]
    })
    .on('click', '.btn-ubah', function (e) {
      e.preventDefault();
      AKModal.open({
        url: `{{ route('admin.post-category.edit') }}`,
        data: {
          id: $(this).data('id'),
        },
      });
    })
    .on('click', '.btn-hapus', function (e) {
      e.preventDefault();
      let id = this.dataset?.id || null;
      let judul = this.dataset?.judul || null;
      if (! id) return;
      AKHelper.DeleteConfirm({
        datatables: window.dTables,
        url: `{{ route('admin.post-category.destroy') }}`,
        loadingText: `Menghapus Data`,
        text: `Apakah anda yakin menghapus <strong>"${judul}"</strong>?`,
        data: {
          id: id,
        },
      });
    })
    $('#btnTambah').on('click', () => AKModal.open(
      {
        url: `{{ route('admin.post-category.create') }}`,
      }
    ));
  });
</script>
@endsection
