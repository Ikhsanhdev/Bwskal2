<?php
  $title = 'Aplikasi Terkait/ Tautan Luar';
?>

<?php echo $__env->make('libs.akform', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('libs.day', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('libs.izitoast', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('libs.cropit', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('libs.vue-draggable', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->startSection('adminHeader'); ?>
  <i class="mdi mdi-link d-none d-md-inline-block mr-3"></i>
  <?php echo e($title); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
  <div class="admin-section"
    id="listApp">
    
    <div class="card card-table card-table-fit">
      <div class="card-header"
        style="position: sticky;top: 4.35rem;background: white;">
        <div class="title">Daftar Link</div>
        <div class="flex"></div>
        <div class="action">
          <div class="btn btn-primary"
            @click="tambahClick">
            <i class="mdi mdi-database-plus fz-normal mr-2"></i>
            <span>TAMBAH</span>
          </div>
        </div>
      </div>
      <div class="card-body pb-0">
        <template v-if="list && list.length">
          <draggable class="link-menuitem-wrap"
            handle=".handle"
            v-bind="{
          animation: 200,
          ghostClass: 'ghost'
        }"
            @change="onChange"
            v-model="list">
            <div class="link-menuitem mb-3"
              v-for="(item, index) in list"
              :key="item.id">
              <div class="atas">
                <i class="mdi mdi-drag fz-lg handle mr-2"></i>
                <div class="mr-3">
                  <img :src="item.image" class="img-contain" style="max-height: 80px; max-width: 100px;">
                </div>
                <div class="content">
                  <div class="teks text-dark">
                    {{ item.name }}
                  </div>
                  <div class="fz-0-8rem">{{ item.link }}</div>
                </div>
                <div class="flex"></div>
                <div class="aksi">
                  <button class="btn btn-icon btn-ubah btn-secondary"
                    type="button"
                    @click="changeClick(item)">
                    <i class="mdi mdi-database-edit"></i>
                  </button>
                  <button class="btn btn-danger btn-icon btn-hapus"
                    type="button"
                    @click="deleteClick(item)">
                    <i class="mdi mdi-trash-can-outline"></i>
                  </button>
                </div>
              </div>
            </div>
          </draggable>
        </template>
        <template v-else>
          <div class="d-flex flex-column p-5 text-center">
            <i class="mdi mdi-database-off-outline fz-3rem"></i>
            <div class="font-weight-bold fz-1-5rem">Data <?php echo e($title); ?> Kosong</div>
            <div class="fz-0-8rem">Gunakan tombol <strong>TAMBAH</strong> di atas untuk menambah data.</div>
          </div>
        </template>
      </div>
      <div class="card-footer"></div>
    </div>
  </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('jsAfterMain'); ?>
  <script>
    $(function() {
      window.listApp = new Vue({
        el: '#listApp',
        data() {
          return {
            list: [],
            isSavingOrder: false,
          };
        },
        methods: {
          tambahClick() {
            AKModal.open({
              url: `<?php echo e(route('admin.link-terkait.create')); ?>`,
              size: 'lg'
            })
          },
          onChange() {
            this.saveOrder();
          },
          changeClick(item) {
            AKModal.open({
              url: `<?php echo e(route('admin.link-terkait.edit')); ?>`,
              data: {
                id: item.id,
              },
              size: 'lg'
            })
          },
          deleteClick(item) {
            AKHelper.DeleteConfirm({
              datatables: this,
              url: `<?php echo e(route('admin.link-terkait.destroy')); ?>`,
              loadingText: `Menghapus Link`,
              text: `Apakah anda yakin menghapus <strong>"${item.name}"</strong>?`,
              data: {
                id: item.id,
              },
            });
          },
          reload() {
            axios.post(`<?php echo e(route('admin.link-terkait.datatable')); ?>`)
              .then(res => {
                if (res?.data?.success) {
                  this.list = res.data.data;
                }
              });
          },
          saveOrder() {
            let order = this.list.map(item => item.id);
            this.isSavingOrder = true;
            axios.post(`<?php echo e(route('admin.link-terkait.order')); ?>`, {
                _method: 'PUT',
                order: order,
              })
              .then(res => {
                if (res?.data?.success) {
                  AKToast.success(res.data.message);
                }
              })
              .finally(() => {
                this.isSavingOrder = false;
              });
          },
        },
        mounted() {
          this.reload();
        },
      });
    });
  </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sda/balai/bwskalimantan2/resources/views/admin/link-terkait/index.blade.php ENDPATH**/ ?>