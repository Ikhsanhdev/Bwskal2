@extends('layouts.admin.app')

{{-- Setup --}}
@php
$title = "Agenda";
@endphp

{{-- Libs --}}
@include('libs.izitoast')
@include('libs.akform')
@include('libs.day')
@include('libs.datatables')
@include('libs.vue-datepicker')

@section('adminHeader')
<i class="mdi mdi-calendar-clock d-none d-md-inline-block mr-3"></i>
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
        <a class="btn btn-primary" href="#" id="btnTambah">
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
          title: '<center>Agenda</center>',
          render: function (row) {
            let t = dayjs(row.updated_at).format('DD MMMM YYYY - HH:mm');
            return `
            <div class="fz-md text-primary"><i class="mdi mdi-map-marker"></i> ${row.location}</div>
            <div class="font-weight-bold">${row.title}</div>
            <div class="fz-md text-muted">Diperbaharui : ${t}</div>
            `;
          }
        },
        { 
          title: '<center>Tanggal</center>',
          className: 'text-center',
          render: function (row) {
            return row.active_at;
          }
        },
        { 
          className: 'text-center',
          render: function(data, type, row) {
            return `
              <a class="btn btn-secondary btn-icon btn-ubah"
                data-judul="${row.title}"
                data-id="${row.id}"
                href="#"
                >
                <i class="mdi mdi-database-edit"></i>
              </a>
              <a class="btn btn-danger btn-icon btn-hapus"
                data-judul="${row.title}"
                data-id="${row.id}"
                >
                <i class="mdi mdi-trash-can-outline"></i>
              </a>
                `
              .replace(/\:id\:/gm, row.id);
          },
          width: '150px',
          title: 'Aksi',
        }
      ]
    })
    .on('click', '.btn-ubah', function (e) {
      e.preventDefault();
      AKModal.open({
        url: `{{ route('admin.agenda.edit') }}`,
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
        url: `{{ route('admin.agenda.destroy') }}`,
        loadingText: `Menghapus Agenda`,
        text: `Apakah anda yakin menghapus Agenda <strong>"${this.dataset.judul}"</strong>?`,
        data: {
          id: id,
        },
      });
    });
    $('#btnTambah').on('click', () => AKModal.open(
      {
        url: `{{ route('admin.agenda.create') }}`,
      }
    ));
  });
</script>
@endsection
