@extends('layouts.admin.app')

{{-- Setup --}}
@php
$title = "Halaman";
@endphp

{{-- Libs --}}
@include('libs.datatables')
@include('libs.izitoast')
@include('libs.day')

@section('adminHeader')
<i class="mdi mdi-file d-none d-md-inline-block mr-3"></i>
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
        <a class="btn btn-primary"
          href="{{ route('admin.page.create') }}">
          <i class="mdi mdi-database-plus mr-2 fz-normal"></i>
          <span>TAMBAH</span>
        </a>
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
          title: '<center>Halaman</center>',
          render: function (row) {
            let t = dayjs(row.tanggal).format('DD MMMM YYYY - HH:mm');
            return `
              <div class="fz-md text-primary">${row.slug}</div>
              <div class="font-weight-bold text-dark">${row.title}</div>
              <div class="fz-md text-muted">Diperbaharui : ${t}</div>
              `;
          }
        },
        { 
          className: 'text-center',
          width: '160px',
          title: 'Aksi',
          render: function(data, type, row) {
            return `
              <a class="btn btn-secondary btn-icon"
                href="{{ url(':slug:') }}"
                target="_blank"
                >
                <i class="mdi mdi-database-search"></i>
              </a>
              <a class="btn btn-secondary btn-icon btn-ubah"
                href="{{ route('admin.page.edit', ['id' => ':id:']) }}"
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
              .replace(/\:id\:/gm, row.id)
              .replace(/\:slug\:/gm, row.slug)
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
        url: `{{ route('admin.page.destroy') }}`,
        loadingText: `Menghapus Data`,
        text: `Apakah anda yakin menghapus <strong>"${judul}"</strong>?`,
        data: {
          id: id,
        },
      });
    })
  });
</script>
@endsection