@extends('layouts.modal')

@section('title')
<i class="mdi mdi-clipboard-text-outline mr-2"></i>
<span class="font-weight-bold">Detail</span>
@endsection

@section('body')
  <x-ak-text
    label="Diterima pada"
    :value="$data->created_at->isoFormat('DD MMMM YYYY HH:mm')"
    />

  <x-ak-text
    label="Nama Lengkap"
    :value="$data->name"
    />

  <x-ak-text
    label="Email"
    :value="$data->email"
    />

  <x-ak-text
    label="Nomor Kontak/WhatsApp"
    :value="$data->contact"
    />

  <x-ak-text
    label="Topik"
    :value="$data->topic"
    />

  <x-ak-text
    label="Pesan/Pertanyaan"
    :value="$data->content"
    />
@endsection
