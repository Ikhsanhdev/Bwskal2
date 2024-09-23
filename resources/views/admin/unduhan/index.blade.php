@extends('layouts.admin.app')

{{-- Setup --}}
@php
$title = "Direktori/Unduhan";
@endphp

{{-- Libs --}}
@include('libs.akform')
@include('libs.izitoast')
@include('libs.datatables')
@include('libs.day')

@section('adminHeader')
<i class="mdi mdi-file-download d-none d-md-inline-block mr-3"></i>
{{ $title }}
@endsection

@section('content')
{{-- Isi --}}
<div class="admin-section">
  {{-- Datatables --}}
  <div class="card card-table card-table-fit">
    <div class="card-header">
      <div class="title">Daftar Berkas</div>
      <div class="flex"></div>
      <div class="action btn-list-horizontal">
        <a class="btn btn-secondary" href="{{ route('admin.unduhan.request.index') }}">
          <i class="mdi mdi-clipboard-check mr-2 fz-normal"></i>
          <span>VERIFIKASI</span>
          @if (isset($_menuBadge['unduhan_request']) && $_menuBadge['unduhan_request'] > 0)
          <span class="ml-2 mt-1 badge badge-light fz-0-75rem">{{ $_menuBadge['unduhan_request'] }}</span>
          @endif
        </a>
        <a class="btn btn-secondary" href="{{ route('admin.unduhan.kategori.index') }}">
          <i class="mdi mdi-tag mr-2 fz-normal"></i>
          <span>KATEGORI</span>
        </a>
        <a class="btn btn-primary" href="#" id="btnTambah">
          <i class="mdi mdi-database-plus mr-2 fz-normal"></i>
          <span>TAMBAH</span>
        </a>
      </div>
    </div>
    <table class="table table-bordered table-fit table-hover table-striped w-100" id="tablenya"></table>
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
          title: '<center>Berkas</center>',
          render: function (row) {
            let t = dayjs(row.updated_at).format(`DD MMMM YYYY - HH:mm`);

            return `
              <div class="fz-md text-primary">${row.category_name}</div>
              <div class="font-weight-bold text-dark">${row.title}</div>
              <div class="fz-md text-muted">${t}</div>
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
                data-judul="${row.title}"
                >
                <i class="mdi mdi-database-edit"></i>
              </a>
              <a class="btn btn-danger btn-icon btn-hapus"
                data-id="${row.id}"
                data-judul="${row.title}"
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
        url: `{{ route('admin.unduhan.edit') }}`,
        data: {
          id: $(this).data('id'),
        },
        size: 'lg',
      });
    })
    .on('click', '.btn-hapus', function (e) {
      e.preventDefault();
      let id = this.dataset?.id || null;
      let judul = this.dataset?.judul || null;
      if (! id) return;
      AKHelper.DeleteConfirm({
        datatables: window.dTables,
        url: `{{ route('admin.unduhan.destroy') }}`,
        loadingText: `Menghapus Data`,
        text: `Apakah anda yakin menghapus <strong>"${judul}"</strong>?`,
        data: {
          id: id,
        },
      });
    })
    $('#btnTambah').on('click', () => AKModal.open(
      {
        url: `{{ route('admin.unduhan.create') }}`,
        size: 'lg',
      }
    ));
  });
</script>
@endsection
