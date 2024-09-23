@extends('layouts.modal')

{{-- Setup --}}
@php
  $isEdit = isset($data);
  $title = ($isEdit ? 'Ubah' : 'Tambah') . ' item Galeri';
  $formAction = route('admin.gallery.' . ($isEdit ? 'update' : 'store'));
  $formHasFile = true;
@endphp

@section('title')
  <i class="mdi mdi-image-album mr-2"></i>
  <span class="font-weight-bold">{{ $title }}</span>
@endsection

@section('body')
  @if (!$isEdit)
    <div class="form-group">
      <label for="">Jenis Item</label>
      <select name="type"
        class="form-control"
        required
        v-model="formdata.type"
        @change="tipeOnChange">
        <option value="">Pilih Jenis Item</option>
        <option value="album">Album</option>
        <option value="image">Foto</option>
        <option value="video">Video</option>
      </select>
    </div>
  @endif
  <template v-if="formdata.type == 'image'">
    <div class="form-group">
      <label class="control-label mb-0"
        for="gambar">Gambar</label>
      <div class="fz-md text-muted">Gambar akan disimpan sesuai ukuran asli</div>
      <div id="ciGambar"
        class="ak-cropit"
        data-name="content"></div>
    </div>
    <div class="form-group">
      <label for="">Album</label>
      <select name="album"
        class="form-control"
        v-model="formdata.album">
        <template v-if="!albumList">
          <option value="">Sedang mengambil Daftar Album</option>
        </template>
        <template v-else-if="albumList.length">
          <option value="">Tanpa Album</option>
          <option v-for="item in albumList"
            :value="item.id"
            :key="item.id">@{{ item.name }}</option>
        </template>
        <template v-else>
          <option value="">Data Album tidak ada</option>
        </template>
      </select>
    </div>
  </template>
  <template v-else-if="formdata.type == 'video'">
    <div class="form-group">
      <label for="">Link video</label>
      <div v-if="ytPreview"
        class="mb-3 text-center">
        <img :src="ytPreview">
      </div>
      <input type="text"
        class="form-control"
        name="content"
        placeholder="Link video (Youtube)"
        v-model="formdata.yt"
        required
        data-parsley-youtube-url
        @input="parseYT">
    </div>
  </template>
  <template v-if="formdata.type.length > 0">
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
  </template>
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
            isEdit: @json($isEdit),
            imgPreview: '',
            ytPreview: '',
            gambar: null,
            form: null,
            albumList: null,
            formdata: {
              type: `{{ $isEdit ? $data->type : '' }}`,
              album: `{{ $isEdit ? $data->album : '' }}`,
            }
          };
        },
        methods: {
          parseYT() {
            this.ytPreview = "";
            if (!this.formdata.yt || this.formdata.yt.length == 0) return;
            if (!isYoutubeUrl(this.formdata.yt)) return;
            let ytID = _.clone(window.ytregex).exec(this.formdata.yt);
            if (!ytID) return;
            ytID = ytID[1];

            this.ytPreview = `https://img.youtube.com/vi/${ytID}/mqdefault.jpg`;
          },
          async tipeOnChange() {
            switch (this.formdata.type) {
              case "image":
                this.formdata.yt = null;
                this.ytPreview = "";
                if (!this.gambar) {
                  this.$nextTick(() => {
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
                      }
                    });
                  });
                }
                //  Ambil daftar album
                this.albumList = null;
                let res = await axios.get(`{{ route('admin.gallery.list-album') }}`);
                if (!this.isEdit) {
                  this.formdata.album = "";
                }
                this.albumList = res.data?.data ?? [];
                break;
              case "video":
                this.imgPreview = "";
                break;
              case "album":
                this.imgPreview = "";
                this.formdata.yt = null;
                this.ytPreview = "";
                break;
            }
          },
        },
        mounted() {
          @if ($isEdit)
            this.formdata.name = `{{ $data->name ?? '' }}`;
            this.formdata.description = `{{ $data->description ?? '' }}`;
            this.formdata.album = `{{ $data->album ?? '' }}`;
            @if ($data->type == 'video')
              this.formdata.yt = `{{ 'https://www.youtube.com/watch?v=' . $data->content }}`;
              this.parseYT();
            @endif
            this.tipeOnChange();
            this.$forceUpdate();
          @endif
          this.form = new AKForm("#formnya", {
            form: {
              beforeSubmit: (data) => {
                let fiGambar = data.find(item => item.name == 'content' && item.type == 'file');
                if (this.formdata.type == 'image' && fiGambar && fiGambar.value != "") {
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
        }
      });
    });
  </script>
@endsection
