<div class="modal-body pegawai-modal-body">
  <div class="pegawai-header">
    <div class="text-content">
      <div class="name">{{ $data->name }}</div>
      <div class="position">{{ $data->position }}</div>
    </div>
    <img src="{{ $data->foto_image }}">
  </div>
  <div class="pegawai-content">
    @if ($data->content)
    {!! $data->content !!}
    @else
    <div class="text-center">Detail Pegawai belum ada</div>
    @endif
  </div>
</div>
<div class="modal-footer flex-nowrap">
  <button type="button"
    data-dismiss="modal"
    class="btn btn-secondary wide">TUTUP</button>
</div>
