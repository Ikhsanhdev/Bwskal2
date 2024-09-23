@extends('layouts.modal')

{{-- Setup --}}
@php
  $isEdit = isset($data);
  $title = ($isEdit ? 'Ubah' : 'Tambah') . ' item Album';
  $formAction = route('admin.gallery.' . ($isEdit ? 'update' : 'store'));
  $formHasFile = true;
@endphp

@section('title')
  <i class="mdi mdi-image-album mr-2"></i>
  <span class="font-weight-bold">{{ $title }}</span>
@endsection

@section('body')
  <input type="hidden"
    name="album"
    value="{{ $album->id }}" />

  <input type="hidden"
    name="type"
    value="image" />

  <div class="form-group">
    <label class="control-label mb-0"
      for="gambar">Gambar</label>
    <div class="fz-md text-muted">Gambar akan disimpan sesuai ukuran asli</div>
    <div id="ciGambar"
      class="ak-cropit"
      data-name="content"></div>
  </div>

  <x-ak-input label="Judul"
    placeholder="$label"
    name="name"
    v-model="formdata.name"
    required
    />

  <x-ak-input type="textarea"
    label="Keterangan"
    placeholder="$label"
    name="description"
    optional
    v-model="formdata.description" />

  <hr>

  <div class="ak-checkbox">
    <input 
      type="checkbox" 
      id="jadikan_sampul"
      name="as_cover"
      key="jadikan-sampul"
      v-model="formdata.as_cover">
    <label for="jadikan_sampul" class="cb"></label>
    <label for="jadikan_sampul" class="label">Jadikan sebagai sampul album</label>
  </div>
@endsection

@section('footer')
  <button type="button"
    data-dismiss="modal"
    class="btn btn-block btn-secondary mr-3">BATAL</button>
  <button class="btn btn-block btn-primary m-0">SIMPAN</button>
@endsection

@section('script')
  <script>
    $(document).ready(function() {
      window.gApp = new Vue({
        el: '#formnya',
        data: () => {
          return {
            imgPreview: '',
            gambar: null,
            form: null,
            formdata: {}
          };
        },
        methods: {
          init() {
            this.form = new AKForm("#formnya", {
              form: {
                beforeSubmit: (data) => {
                  let fiGambar = data.find(item => item.name == 'content' && item.type == 'file');
                  if (fiGambar && fiGambar.value != "") {
                    data.push({
                      name: 'thumb',
                      value: this.gambar.export()
                    });
                  }
                  tInfo = AKToast.info({
                    message: 'Sedang menyimpan',
                    icon: 'mdi mdi-send-circle'
                  }, false);
                },
                success: (res) => {
                  tInfo.close();
                  this.form.reset();
                  if (res.success) {
                    AKToast.success(res.message);
                    this.form.closeModal();
                    window.galeriApp.reload();
                  }
                },
                error: (xhr) => {
                  var res = AKForm.parseXhr(xhr);
                  tInfo.close();
                  AKToast.error(res.pesanToast);
                  this.form.parseError(xhr);
                }
              }
            });
            this.gambar = new AKCropit('#ciGambar', {
              width: 250,
              height: 250,
              teksPilih: 'Pilih Gambar',
              cropit: {
                smallImage: 'stretch',
                @if ($isEdit)
                imageState: {
                  src: '{{ url(\App\Models\Gallery::UPLOAD_PATH . 'thumbs_' . $data->content) }}'
                }
                @endif
              },
            });
          },
        },
        mounted() {
          @if ($isEdit)
            this.formdata.name = `{{ $data->name ?? '' }}`;
            this.formdata.description = `{{ $data->description ?? '' }}`;
            this.formdata.album = `{{ $data->album ?? '' }}`;
            this.formdata.as_cover = @json($data->content == $album->content);
            this.$forceUpdate();
          @endif
          this.init();
        }
      });
    });
  </script>
@endsection
