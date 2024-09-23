<?php
  $isEdit = isset($data);
  $title = ($isEdit ? 'Ubah' : 'Tambah') . ' item Galeri';
  $formAction = route('admin.gallery.' . ($isEdit ? 'update' : 'store'));
  $formHasFile = true;
?>

<?php $__env->startSection('title'); ?>
  <i class="mdi mdi-image-album mr-2"></i>
  <span class="font-weight-bold"><?php echo e($title); ?></span>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('body'); ?>
  <?php if(!$isEdit): ?>
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
  <?php endif; ?>
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
            :key="item.id">{{ item.name }}</option>
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
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.ak-input','data' => ['label' => 'Judul','placeholder' => '$label','name' => 'name','vModel' => 'formdata.name','required' => true]]); ?>
<?php $component->withName('ak-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => 'Judul','placeholder' => '$label','name' => 'name','v-model' => 'formdata.name','required' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.ak-input','data' => ['type' => 'textarea','label' => 'Keterangan','placeholder' => '$label','name' => 'description','optional' => true,'vModel' => 'formdata.description']]); ?>
<?php $component->withName('ak-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'textarea','label' => 'Keterangan','placeholder' => '$label','name' => 'description','optional' => true,'v-model' => 'formdata.description']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
  </template>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer'); ?>
  <button type="button"
    data-dismiss="modal"
    class="btn btn-block btn-secondary mr-3">BATAL</button>
  <button class="btn btn-block btn-primary m-0">SIMPAN</button>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
  <script>
    $(document).ready(function() {
      window.gApp = new Vue({
        el: '#formnya',
        data: () => {
          return {
            isEdit: <?php echo json_encode($isEdit, 15, 512) ?>,
            imgPreview: '',
            ytPreview: '',
            gambar: null,
            form: null,
            albumList: null,
            formdata: {
              type: `<?php echo e($isEdit ? $data->type : ''); ?>`,
              album: `<?php echo e($isEdit ? $data->album : ''); ?>`,
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
                      <?php if($isEdit): ?>
                        imageState: {
                          src: '<?php echo e(url(\App\Models\Gallery::UPLOAD_PATH . 'thumbs_' . $data->content)); ?>'
                        }
                      <?php endif; ?>
                      }
                    });
                  });
                }
                //  Ambil daftar album
                this.albumList = null;
                let res = await axios.get(`<?php echo e(route('admin.gallery.list-album')); ?>`);
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
          <?php if($isEdit): ?>
            this.formdata.name = `<?php echo e($data->name ?? ''); ?>`;
            this.formdata.description = `<?php echo e($data->description ?? ''); ?>`;
            this.formdata.album = `<?php echo e($data->album ?? ''); ?>`;
            <?php if($data->type == 'video'): ?>
              this.formdata.yt = `<?php echo e('https://www.youtube.com/watch?v=' . $data->content); ?>`;
              this.parseYT();
            <?php endif; ?>
            this.tipeOnChange();
            this.$forceUpdate();
          <?php endif; ?>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sda/balai/bwskalimantan2/resources/views/admin/gallery/modal-form.blade.php ENDPATH**/ ?>