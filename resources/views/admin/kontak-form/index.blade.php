@extends('layouts.admin.app')

{{-- Setup --}}
@php
$title = "Kontak Form";
@endphp

{{-- Libs --}}
@include('libs.akform')
@include('libs.izitoast')
@include('libs.datatables')
@include('libs.day')

@section('adminHeader')
<i class="mdi mdi-card-account-phone d-none d-md-inline-block mr-3"></i>
{{ $title }}
@endsection

@section('content')
{{-- Isi --}}
<div class="admin-section">
  <div class="card card-table card-table-fit">
    <div class="card-header">
      <div class="title">Data {{ $title }}</div>
      <div class="flex"></div>
      <div class="action">
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
          title: '<center>Data</center>',
          render: function (row) {
            return `
              <div class="fz-md text-primary fw-700">${row.topic}</div>
              <div class="font-weight-bold text-dark">${row.name}</div>
              <div class="fz-md text-muted fw-600">${row.email}</div>
              `;
          }
        },
        { 
          title: '<center>Tanggal</center>',
          width: '200px',
          className: 'text-center',
          render: function (row) {
            return dayjs(row.created_at).format('DD MMMM YYYY - HH:mm');
          }
        },
        { 
          className: 'text-center',
          width: '110px',
          title: 'Aksi',
          render: function(data, type, row) {
            return `
              <a class="btn btn-secondary btn-icon btn-detail"
                data-id="${row.id}"
                >
                <i class="mdi mdi-database-search"></i>
              </a>
              <a class="btn btn-danger btn-icon btn-hapus"
                data-id="${row.id}"
                >
                <i class="mdi mdi-trash-can"></i>
              </a>
              `;
          },
        }
      ]
    })
    .on('click', '.btn-detail', function (e) {
      e.preventDefault();
      AKModal.open({
        url: `{{ route('admin.kontak-form.edit') }}`,
        data: {
          id: $(this).data('id'),
        },
      });
    })
    .on('click', '.btn-hapus', function (e) {
      e.preventDefault();
      let id = this.dataset?.id || null;
      if (! id) return;
      AKHelper.DeleteConfirm({
        datatables: window.dTables,
        url: `{{ route('admin.kontak-form.destroy') }}`,
        loadingText: `Menghapus Data`,
        text: `Apakah anda yakin menghapus data ini?`,
        data: {
          id: id,
        },
      });
    })
  });
</script>
@endsection 
