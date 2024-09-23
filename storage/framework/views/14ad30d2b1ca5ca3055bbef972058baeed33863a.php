<?php
  $title = 'Pejabat/ Pegawai';
?>

<?php echo $__env->make('libs.akform', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('libs.izitoast', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('libs.cropit', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('libs.ckeditor', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('libs.quill', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('libs.vue-draggable', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->startSection('adminHeader'); ?>
  <i class="mdi mdi-card-account-details d-none d-md-inline-block mr-3"></i>
  <?php echo e($title); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
  <div class="admin-section"
    id="pegawaiApp">
    <div class="modal fade"
      role="dialog"
      id="mPegawai">
      <div class="modal-dialog modal-xl"
        role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">
              <span class="font-weight-bold">{{ mode == 'tambah' ? 'Tambah Pegawai' : 'Ubah Pegawai' }}</span>
            </h5>
            <button class="close"
              type="button"
              data-dismiss="modal"
              aria-label="Close">
              <i class="mdi mdi-close"></i>
            </button>
          </div>
          <form id="fPegawai">
            <div class="modal-body">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="control-label"
                      for="foto">Foto Pegawai</label>
                    <div id="cPegawai"
                      class="ak-cropit"
                      data-name="foto"></div>
                  </div>
                  <div class="form-group">
                    <label class="control-label"
                      for="name">Nama Lengkap </label>
                    <input class="form-control"
                      name="name"
                      type="text"
                      autocomplete="off"
                      placeholder="Nama Lengkap"
                      required
                      v-model="formdata.name">
                  </div>
                  <div class="form-group">
                    <label class="control-label"
                      for="position">Jabatan </label>
                    <input class="form-control"
                      name="position"
                      type="text"
                      autocomplete="off"
                      placeholder="Jabatan"
                      required
                      v-model="formdata.position">
                  </div>
                </div>
                <div class="col-md-8">
                  <div class="form-group">
                    <label class="control-label"
                      for="content">Detail Pegawai <span class="fz-0-75rem text-muted fw-600">(Opsional)</span></label>
                    <div ref="qePegawai"></div>
                    <textarea class="form-control d-none"
                      name="content"
                      placeholder="Detail Pegawai"
                      v-model="formdata.content"></textarea>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer flex-nowrap">
              <button type="button"
                data-dismiss="modal"
                class="btn btn-block btn-secondary mr-3">BATAL</button>
              <button class="btn btn-block btn-primary m-0"
                @click="simpanClick">SIMPAN</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="card card-search-box">
      <div class="card-header">
        <div class="title">
          <div>Daftar <?php echo e($title); ?></div>
        </div>
        <div class="flex"></div>
        <div class="action btn-list-horizontal">
          <div class="btn btn-secondary"
            v-if="list.length > 1"
            @click="saveOrder">
            <i class="mdi mdi-sort-variant-lock fz-normal mr-2"></i>
            <span>SIMPAN URUTAN</span>
          </div>
          <div class="btn btn-primary"
            @click="tambahOnClick">
            <i class="mdi mdi-database-plus fz-normal mr-2"></i>
            <span>TAMBAH</span>
          </div>
        </div>
      </div>
    </div>

    <div class="admin-pp-wrap mt-4">
      <template v-if="list.length">
        <draggable class="row"
          v-model="list"
          ghost-class="ghost"
          handle=".__drag-handle"
          :animation="200"
          :scroll-sensitivity="100"
          @start="onDragStart"
          @end="onDragEnd">
          <div class="col-3 pp-item-col"
            v-for="(p, index) in list"
            :key="p.id">
            <div class="pp-item"
              @mouseover="itemOnOver"
              @mousemove="itemOnOver"
              @mouseleave="itemOnOut"
              :data-id="'ak-' + p.id"
              :class="{ 'hover': is_active(p) }">
              <div class="foto">
                <img :src="pegawaiFoto(p)">
              </div>
              <div class="nama">{{ p.name }}</div>
              <div class="jabatan">{{ p.position }}</div>
              <div class="__action"
                v-if="is_active(p)">
                <div class="__action-item __drag-handle">
                  <i class="mdi mdi-cursor-move"></i>
                </div>
                <div class="__action-item"
                  @click="ubahOnClick(p)">
                  <i class="mdi mdi-database-edit"></i>
                </div>
                <div class="__action-item bg-danger"
                  @click="hapusOnClick(p, index)">
                  <i class="mdi mdi-trash-can"></i>
                </div>
              </div>
            </div>
          </div>
        </draggable>
      </template>
      <template v-else>
        <div class="card-body">
          <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.pesan-tengah','data' => ['title' => 'Data Pegawai Kosong']]); ?>
<?php $component->withName('pesan-tengah'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['title' => 'Data Pegawai Kosong']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
        </div>
      </template>
    </div>
  </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('jsAfterMain'); ?>
  <script>
    $(function() {
      window.pegawaiApp = new Vue({
        el: `#pegawaiApp`,
        data() {
          return {
            baseurl: '',
            blankImage: window.get_blank_image(),
            list: [],
            isDrag: false,
            active: null,
            mode: 'tambah',
            form: null,
            formdata: {},
            cropper: null,
            quill: null,
          };
        },
        methods: {
          is_active(p) {
            return !this.isDrag && this.active == `ak-${p.id}`;
          },
          onDragStart() {
            this.isDrag = true;
          },
          onDragEnd() {
            this.isDrag = false;
            this.active = '';
          },
          itemOnOver(e) {
            this.active = e.currentTarget.dataset.id;
          },
          itemOnOut(e) {
            this.active = '';
          },
          initForm() {
            this.form = AKForm.validation('#fPegawai');
            this.cropper = new AKCropit('#cPegawai', {
              width: 180,
              height: 200,
              teksPilih: 'Pilih Gambar',
            });
            this.quill = new Quill(this.$refs.qePegawai, {
              theme: 'snow',
              placeholder: 'Masukkan detail pegawai',
              modules: {
                toolbar: {
                  container: [
                    [{
                      'header': [1, 2, 3, 4, 5, 6, false]
                    }],
                    ['bold', 'italic', 'underline'],
                    [{
                      'align': ''
                    }, {
                      'align': 'center'
                    }, {
                      'align': 'right'
                    }, {
                      'align': 'justify'
                    }, ],
                    [{
                      'list': 'ordered'
                    }, {
                      'list': 'bullet'
                    }],
                    [
                      'link',
                    ],
                    ['clean']
                  ],
                }
              }
            });
            this.quill.on('text-change', (delta, oldDelta, src) => {
              let html = this.$refs.qePegawai.children[0].innerHTML;
              if (html === '<p><br></p>') html = '';
              this.formdata.content = html;
              this.$forceUpdate();
            });
          },
          setDetail(isi) {
            this.$refs.qePegawai.children[0].innerHTML = isi;
          },
          resetCrop() {
            let c = this.cropper.$selector;
            c.find('.cropit-preview').removeClass('cropit-image-loaded');
            c.find('.cropit-preview-background').attr('src', '');
            c.find('.cropit-preview-background').removeAttr('style');
            c.find('.cropit-preview-background').attr('style', 'position: relative; left: 30px; top: 30px; transform-origin: left top 0px; will-change: transform;');
            c.find('.cropit-preview-image').attr('src', '');
            c.find('.cropit-preview-image').removeAttr('style');
            c.find('.cropit-preview-image').attr('style', 'transform-origin: left top 0px; will-change: transform;');
            c.find('input.cropit-image-input').val('');
            c.find('.cropit-image-zoom-input').val('0');
          },
          loadData() {
            AKToast.loading(`Mengambil data`, 'll');
            axios.post(`<?php echo e(route('admin.pegawai.datatable')); ?>`)
              .then(res => {
                if (res?.data?.data) {
                  this.baseurl = res.data.data.foto_url;
                  this.list = res.data.data.pegawai;
                }
              })
              .finally(() => {
                AKToast.close('ll');
              });
          },
          pegawaiFoto(item) {
            return this.baseurl + item.image;
          },
          tambahOnClick() {
            this.mode = 'tambah';
            this.form.reset();
            this.formdata = {
              name: '',
              position: '',
            };
            this.resetCrop();
            this.setDetail('');
            $('#mPegawai').modal('show');
          },
          ubahOnClick(item) {
            this.mode = 'ubah';
            AKToast.loading(`Mengambil data Pegawai`, 'lp');
            axios.post(`<?php echo e(route('admin.pegawai.edit')); ?>`, {
                id: item.id,
              })
              .then(res => {
                if (res?.data?.success) {
                  this.form.reset();
                  this.formdata = {
                    id: res.data.data.id,
                    name: res.data.data.name,
                    position: res.data.data.position,
                    __old: item,
                  };

                  this.resetCrop();
                  this.setDetail(res.data.data.content);
                  if (res.data.data.image)
                    this.cropper.$selector.cropit('imageSrc', this.baseurl + res.data.data.image);
                  $('#mPegawai').modal('show');
                }
              })
              .finally(() => {
                AKToast.close('lp');
              });
          },
          simpanClick() {
            if (!this.form.isValid()) {
              AKToast.error(`Form tidak valid`);
              return;
            }

            let dataKirim, res;
            switch (this.mode) {
              case 'tambah':
                dataKirim = {
                  name: this.formdata.name,
                  position: this.formdata.position,
                  content: this.formdata.content,
                };
                if (this.cropper.$selector.cropit('imageSrc')) {
                  dataKirim.image = this.cropper.export();
                }

                AKToast.loading("Menambah Pegawai", 'lp');
                axios.post(`<?php echo e(route('admin.pegawai.store')); ?>`, dataKirim)
                  .then(res => {
                    if (res.data?.success) {
                      this.list.push({
                        id: res.data.data.id,
                        name: this.formdata.name,
                        position: this.formdata.position,
                        image: res.data.data.image,
                      });

                      AKToast.success(res.data.message)
                      $('#mPegawai').modal('hide');
                    }
                  })
                  .catch(err => {
                    res = this.form.handleAxiosError(err);
                    AKToast.error(res?.message ?? 'Terjadi kesalahan saat menyimpan data Pegawai');
                  })
                  .finally(() => {
                    AKToast.close('lp');
                  });
                break;
              case 'ubah':
                dataKirim = {
                  _method: 'PUT',
                  _id: this.formdata.id,
                  name: this.formdata.name,
                  position: this.formdata.position,
                  content: this.formdata.content,
                };

                if (this.cropper.$selector.find('#akcropit-ifile')[0].value) {
                  dataKirim.image = this.cropper.export();
                }

                AKToast.loading("Memperbaharui Pegawai", 'lp');
                axios.post(`<?php echo e(route('admin.pegawai.update')); ?>`, dataKirim)
                  .then(res => {
                    if (res.data?.success) {
                      this.formdata.__old.name = dataKirim.name;
                      this.formdata.__old.position = dataKirim.position;
                      this.formdata.__old.image = res.data.data.image;

                      AKToast.success(res.data.message)
                      $('#mPegawai').modal('hide');
                    }
                  })
                  .catch(err => {
                    res = this.form.handleAxiosError(err);
                    AKToast.error(res?.message ?? 'Terjadi kesalahan saat memperbaharui data Pegawai');
                  })
                  .finally(() => {
                    AKToast.close('lp');
                  });
                break;
            }
          },
          hapusOnClick(item, index) {
            AKHelper.DeleteConfirm({
              text: `Apakah anda yakin menghapus data "${item.name}"?`,
              loadingText: 'Menghapus Pegawai',
              url: `<?php echo e(route('admin.pegawai.destroy')); ?>`,
              data: {
                id: item.id,
              },
              done: (res) => {
                if (res.success) {
                  AKToast.success(res.message);
                  this.list.splice(index, 1);
                }
              },
            });
          },
          saveOrder() {
            let urutan = this.list.map(item => item.id);
            AKToast.loading(`Menyimpan Urutan Pegawai`, 'lp');
            axios.post(`<?php echo e(route('admin.pegawai.order')); ?>`, {
                _method: 'PUT',
                order: urutan,
              })
              .then(res => {
                if (res?.data?.success) {
                  AKToast.success(res.data.message);
                }
              })
              .catch(error => {
                AKToast.error(error?.response?.data?.message ?? error.message ?? `Gagal menyimpan urutan`);
              })
              .finally(() => {
                AKToast.close('lp');
              });
          },
        },
        mounted() {
          this.initForm();
          this.loadData();
        },
      });
    });
  </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sda/balai/bwskalimantan2/resources/views/admin/pegawai/index.blade.php ENDPATH**/ ?>