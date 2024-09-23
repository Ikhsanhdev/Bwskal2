@extends('layouts.admin.app')

{{-- Setup --}}
@php
$title = "Berita";
@endphp

{{-- Libs --}}
@include('libs.datatables')
@include('libs.izitoast')
@include('libs.day')

@section('adminHeader')
<i class="mdi mdi-newspaper-variant d-none d-md-inline-block mr-3"></i>
{{ $title }}
@endsection

@section('content')
{{-- Isi --}}
<div class="admin-section">
  <div class="card card-table card-table-fit">
    <div class="card-header">
      <div class="title">Daftar {{ $title }}</div>
      <div class="flex"></div>
      <div class="action">
        <a class="btn btn-secondary" href="{{ route('admin.post-category.index') }}">
          <i class="mdi mdi-tag mr-2 fz-normal"></i>
          <span>KATEGORI</span>
        </a>
        <a class="btn btn-primary"
          href="{{ route('admin.post.create') }}">
          <i class="mdi mdi-database-plus mr-2 fz-normal"></i>
          <span>TAMBAH</span>
        </a>
      </div>
    </div>
    <div class="card-body d-flex pb-2 mt-2">
      <div class="dataTables_filter flex mx-0">
        <label class="mb-0">
          <input type="search"
            class="form-control form-control-sm"
            placeholder="Pencarian"
            id="tb_search"
            />
        </label>
      </div>
      <x-ak-select name="selected_category"
        :list="$kategoriList"
        wrapper-class="mb-0 ml-3"
        />
      <x-ak-select name="selected_status"
        :list="['all' => 'Semua Status Berita', 'publish' => 'Dipublikasi', 'draft' => 'Draft',]"
        wrapper-class="mb-0 ml-3"
        />
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

    AKTableConfig.domFit = `<'card-body p-0'<'d-none'f><'row'<'col-sm-12'<'table-responsive'tr>>>><'card-footer d-flex align-items-center justify-content-between'<'info'i><'paging'p>>`,
    
    $('[name="selected_category"]').on('change', function (e) {
      e.preventDefault();
      dTables.reload();
    });

    $('[name="selected_status"]').on('change', function (e) {
      e.preventDefault();
      dTables.reload();
    });

    function setSearch() {
      $(`#tablenya_filter input`).val($('#tb_search').val());
      $(`#tablenya_filter input`).trigger('input');
    }

    $('#tb_search').on('input', _.debounce(setSearch, 300));

    window.dTables = AKTable.make({
      dataBuilder(d) {
        d.f_category = $('[name="selected_category"]').val();
        d.f_status   = $('[name="selected_status"]').val();
      },
      columns: [
        { 
          data: '@nomor',
        },
        { 
          title: '<center>Berita</center>',
          render: function (row) {
            let t = dayjs(row.updated_at).format('DD MMMM YYYY - HH:mm');
            let ret = '<div>';
            if (row.status == 'draft') {
            ret += `<div class="badge badge-secondary px-2 py-1 mr-1">DRAFT</div>`;
            }
            ret += `<div class="badge badge-primary px-2 py-1">${row.category_name}</div></div><div class="font-weight-bold">${row.title}</div>`;
            ret += `<div class="fz-md text-muted">Ditulis oleh <strong class="text-primary">${row.author}</strong></div>`;
            ret += `<div class="fz-md text-muted">Diperbaharui pada ${t}</div>`;
            return ret;
          }
        },
        { 
          className: 'text-center',
          width: '110px',
          title: 'Aksi',
          render: function(data, type, row) {
            return `
              <a class="btn btn-secondary btn-icon btn-ubah"
                href="{{ route('admin.post.edit', ['id' => ':id:']) }}"
                data-id="${row.id}"
                >
                <i class="mdi mdi-database-edit"></i>
              </a>
              <a class="btn btn-danger btn-icon btn-hapus"
                data-id="${row.id}"
                data-judul="${row.title}"
                >
                <i class="mdi mdi-trash-can"></i>
              </a>
              `
              .replace(/\:id\:/gm, row.id);
          },
        }
      ]
    })
    .on('click', '.btn-hapus', function (e) {
      e.preventDefault();
      let id = this.dataset?.id || null;
      let judul = this.dataset?.judul || null;
      if (! id) return;
      AKHelper.DeleteConfirm({
        datatables: window.dTables,
        url: `{{ route('admin.post.destroy') }}`,
        loadingText: `Menghapus Data`,
        text: `Apakah anda yakin menghapus <strong>"${judul}"</strong>?`,
        data: {
          id: id,
        },
      });
    })
    $('#btnTambah').on('click', () => AKModal.open(
      {
        url: `{{ route('admin.post.create') }}`,
        size: 'lg',
      }
    ));
  });
</script>
@endsection
