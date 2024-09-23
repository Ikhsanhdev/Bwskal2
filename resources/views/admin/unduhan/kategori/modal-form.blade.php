@extends('layouts.modal')

{{-- Setup --}}
@php
$isEdit = isset($data);
$title = ($isEdit ? 'Ubah' : 'Tambah') . ' Kategori Unduhan';
$formAction = route('admin.unduhan.kategori.' . ($isEdit ? 'update' : 'store'));
@endphp

@section('title')
<i class="mdi mdi-clipboard-text-outline mr-2"></i>
<span class="font-weight-bold">{{ $title }}</span>
@endsection

@section('body')
<x-ak-input
  label="Nama Kategori"
  placeholder="Nama Kategori"
  name="name"
  :value="$data->name ?? ''"
  required
/>
@endsection

@section('footer')
  <button type="button" 
    data-dismiss="modal"
    class="btn btn-block btn-secondary mr-3"
    >BATAL</button>
  <button 
    type="submit"
    class="btn btn-block btn-primary m-0"
    >SIMPAN</button>
@endsection

@section('script')
<script>
  $(function () {
    AKForm.make({
      datatables: window.dTables,
      indicator: {
        overlay: true,
      },
    });
  });
</script>
@endsection
