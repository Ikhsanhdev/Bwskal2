@extends('layouts.web.page')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="page-top-wrap">
          <div class="page-title-wrap">
            <div class="title">BERITA</div>
            <div class="side-title">({!! info_paginate($list, "Berita") !!} <strong>{{ $category->name }}</strong>)</div>
          </div>
          <div class="flex"></div>
          <div class="d-flex align-items-center">
            <x-ak-select
              name="category"
              wrapper-class="mb-0"
              class="rounded-0"
              >
              <option value="all">Semua Kategori</option>
              @foreach ($categories as $item)
              <option value="{{ $item->slug }}" {{ selected_if(isset($category) && $category->slug == $item->slug) }}>{{ $item->name }}</option>
              @endforeach
            </x-ak-select>
            <button class="ml-2 btn rounded-0 btn-accent text-dark fw-700 px-4" id="btnFilter">Filter</button>
          </div>
        </div>
      </div>
    </div>
    <div class="page-content-box decor-bt-accent">
      @if ($list && count($list))
        <div class="row">
          @foreach ($list as $post)
            <div class="col-md-6">
              <div class="berita-card {{ $loop->iteration > 2 ? 'mt-md-5' : '' }}">
                <div class="cover mini">
                  <a href="{{ make_post_link($post) }}"
                    class="cover-img">
                    <img src="{{ $post->cover_image }}">
                  </a>
                  <div class="cover-content pb-4">
                    <div class="kategori-wrap">
                      <a href="{{ route('post.category', ['slug' => $post->category_slug]) }}"
                        class="kategori">{{ $post->category_name }}</a>
                    </div>
                    <a class="title fz-1-25rem"
                      data-maxline="3"
                      href="{{ make_post_link($post) }}">{{ $post->title }}</a>
                  </div>
                </div>
                <div class="isi text-dark">{{ \Str::limit(strip_tags($post->content), 280) }}</div>
                <div class="meta">Dipublikasi oleh <span class="font-weight-600">{{ $post->author }}</span> pada
                  {{ $post->created_at->isoFormat('DD MMMM YYYY') }} | Dilihat <span class="font-weight-600">{{ $post->hit_total }}</span> kali</div>
              </div>
            </div>
          @endforeach
        </div>
        @if (isset($list) && $list->total() > $list->perPage())
          <div class="mt-md-5 d-flex justify-content-center mt-3">
            {{ $list->links() }}
          </div>
        @endif
      @else
        <x-pesan-tengah icon="mdi-file-document-edit-outline"
          title="Data Berita Kosong" />
      @endif
    </div>
  </div>
@endsection

@section('jsAfterMain')
<script>
  $(function () {
    $('#btnFilter').on('click', function () {
      let target = @json(route('post.category', ['slug' => ':slug:']));
      target = target.replace(/\:slug\:/g, $(`[name="category"]`).val());
      location.href = target;
    });
  });
</script>
@endsection
