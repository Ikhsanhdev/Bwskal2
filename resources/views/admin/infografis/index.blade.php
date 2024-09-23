@extends('layouts.admin.app')

{{-- Setup --}}
@php
$title = "Poster";
@endphp

{{-- Libs --}}
@include('libs.izitoast')
@include('libs.akform')
@include('libs.day')
@include('libs.datatables')
@include('libs.cropit')
@include('libs.filestyle')

@section('adminHeader')
<i class="mdi mdi-tooltip-image d-none d-md-inline-block mr-3"></i>
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
          width: '100px',
          title: '',
          className: 'text-center',
          render: function (row) {
            let imgSrc = `{{ url(\App\Models\Infografis::UPLOAD_PATH) }}/thumbs_` + row.path;
            return `<img src="${imgSrc}" class="img-fluid img-thumbs" />`;
          }
        },
        { 
          title: '<center>Poster</center>',
          render: function (row) {
            return `<div class="font-weight-bold">${row.name}</div>
            <div class="fz-md text-muted">Oleh ${row.author ?? '-'}</div>
            `;
          }
        },
        { 
          title: 'Tanggal',
          width: '150px',
          className: 'text-center',
          render: function (row) {
            let t = dayjs(row.created_at);
            return t.format('DD MMMM YYYY - HH:mm');
          }
        },
        { 
          className: 'text-center',
          render: function(data, type, row) {
            return `
              <a class="btn btn-secondary btn-icon btn-ubah"
                href="#"
                data-title="${row.name}"
                data-id="${row.id}"
                >
                <i class="mdi mdi-database-edit"></i>
              </a>
              <a class="btn btn-danger btn-icon btn-hapus"
                data-title="${row.name}"
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
        url: `{{ route('admin.poster.edit') }}`,
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
        url: `{{ route('admin.poster.destroy') }}`,
        loadingText: `Menghapus Infografis`,
        text: `Apakah anda yakin menghapus Poster <strong>"${this.dataset.title}"</strong>?`,
        data: {
          id: id,
        },
      });
    });
    $('#btnTambah').on('click', () => AKModal.open(
      {
        url: `{{ route('admin.poster.create') }}`,
      }
    ));
  });
</script>
@endsection
