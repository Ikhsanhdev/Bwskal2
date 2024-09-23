@props([
  'file',
  'path' => 'uploads/berkas/',
])
@if ($file)
  <a href="{{ url($path . $file) }}"
    class="btn btn-primary btn-block"
    target="_blank">
    <i class="mdi mdi-download fz-1-25rem mr-2"></i>
    <span class="fz-1rem">UNDUH BERKAS</span>
  </a>
@else
  <div class="box-dashed text-center align-items-center">
    <i class="mdi mdi-file-outline fz-1-25rem mr-2"></i>
    <span class="fz-1rem fw-700">BERKAS TIDAK TERSEDIA</span>
  </div>
@endif