@extends('layouts.admin.app')

@section('adminHeader')
  <i class="mdi {{ $icon }} d-none d-md-inline-block mr-3"></i>
  {{ $title }}
@endsection

@section('content')
  @if (isset($topBackLink))
    <div class="admin-content-title">
      <a href="{{ $topBackLink }}"
        class="btn btn-icon text-primary px-2">
        <i class="mdi mdi-arrow-left-thick fz-lg"></i>
      </a>
      <div class="font-weight-bold fz-normal ml-2">{{ $title }}</div>
    </div>
  @endif
  
  <div class="admin-section">
    <div class="lh-1 mb-4 text-center d-flex flex-column align-items-center justify-content-center" style="height: 75vh">
      <i class="mdi {{ $messageIcon ?? 'mdi-human-dolly' }} fz-6rem d-block my-4"></i>
      <div class="text-dark font-weight-bold ff-baloo2 fz-1-5rem text-uppercase">{!! $messageTitle !!}</div>
      <div class="fz-0-8rem mt-1 fw-600">{!! $message !!}</div>
    </div>
  </div>
@endsection
