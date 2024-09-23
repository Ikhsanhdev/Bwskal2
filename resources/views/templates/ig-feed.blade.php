<div class="ig-feed h-100">
  <div class="ig-feed-header d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center">
      <i class="mdi mdi-instagram fz-2-5rem mr-2"></i>
      <div class="lh-1">
        <div class="fz-1-15rem fw-700 mb-1">{{ '@' . $username }}</div>
        <div class="fz-0-75rem text-muted">{{ $mediaTotal }} media</div>
      </div>
    </div>
    <a class="btn btn-accent fw-600"
      href="https://www.instagram.com/{{ $username }}"
      target="_blank">Follow</a>
  </div>
  <div class="ig-feed-content mt-3">
    @foreach ($list as $item)
      <a href="{{ $item->link }}"
        class="ig-feed-item"
        target="_blank">
        <img src="{{ url('uploads/ig/' . $item->image) }}"
          class="ig-feed-img">
        <div class="ig-feed-caption">
          <div class="content">{{ $item->caption }}</div>
        </div>
        @switch($item->type)
          @case('IMAGE')
            <i class="mdi mdi-image ig-feed-icon"></i>
          @break

          @case('VIDEO')
            <i class="mdi mdi-video ig-feed-icon"></i>
          @break

          @case('CAROUSEL_ALBUM')
            <i class="mdi mdi-camera-burst ig-feed-icon"></i>
          @break
        @endswitch
      </a>
    @endforeach
  </div>
</div>
