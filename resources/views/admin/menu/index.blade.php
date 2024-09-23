@extends('layouts.admin.app')

@php
  $title = 'Menu';
@endphp

@include('libs.izitoast')
@include('libs.akform')

@section('adminHeader')
  <i class="mdi mdi-form-dropdown d-none d-md-inline-block mr-3"></i>
  {{ $title }}
@endsection

@section('content')
<div class="admin-section" id="menuApp-AKsc">
  <menu-app />
</div>
@endsection

@section('jsAfterMain')
<script src="//cdn.jsdelivr.net/npm/sortablejs@1.8.4/Sortable.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/Vue.Draggable/2.20.0/vuedraggable.umd.min.js"></script>
@endsection

@section('jsBeforeMain')
<script>
  window.urllist = {
    menu: `{{ route('admin.menu.update') }}`,
  };
  window.menu_init_data = {
    list: {!! json_encode($menulist->menulist) !!},
    default: {!! json_encode($defaultmenu->default_list) !!},
  };
</script>
@endsection
