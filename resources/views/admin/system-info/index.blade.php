@extends('layouts.admin.app')

@section('adminHeader')
  <i class="mdi mdi-book-information-variant d-none d-md-inline-block mr-3"></i>
  System Info
@endsection

@section('content')
  <div class="admin-section">
    <div class="card mb-4">
      <div class="card-header bg-light">
        <div class="title d-flex align-items-center">
          <i class="mdi mdi-book-information-variant fz-1-5rem mr-2"></i>
          <span>System Info</span>
        </div>
      </div>
      <div class="card-body pt-3">
        <x-ak-text label="App Version"
          :value="config('app.version')" />
        <x-ak-text label="PHP Version"
          :value="phpversion()" />
        <x-ak-text label="Laravel Version"
          :value="app()->version()" />
      </div>
    </div>
  </div>
@endsection
