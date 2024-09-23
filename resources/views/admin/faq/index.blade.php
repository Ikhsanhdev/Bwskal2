@extends('layouts.admin.app')

@php
  $title = 'FAQ';
@endphp

@include('libs.akform')
@include('libs.day')
@include('libs.izitoast')
@include('libs.ckeditor')
@include('libs.vue-draggable')

@section('adminHeader')
  <i class="mdi mdi-message-question d-none d-md-inline-block mr-3"></i>
  {{ $title }}
@endsection

@section('content')
  <div class="admin-section"
    id="listApp">
    
    <div class="card card-table card-table-fit">
      <div class="card-header"
        style="position: sticky;top: 4.35rem;background: white;">
        <div class="title">Daftar FAQ</div>
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
                <i class="mdi mdi-drag fz-lg handle mr-3"></i>
                <div class="content">
                  <div class="teks text-dark">
                    @{{ item.title }}
                  </div>
                  <div class="fz-0-8rem">Diperbaharui pada <strong>@{{ formatTanggal(item.updated_at) }}</strong></div>
                </div>
                <div class="flex"></div>
                <div class="mr-2">
                  <div class="badge px-3 py-2"
                    :class="{'badge-success': item.is_show, 'badge-danger': !item.is_show}">
                    <span class="fz-0-65rem">@{{ item.is_show ? 'DITAMPILKAN' : 'DISEMBUNYIKAN'}}</span>
                  </div>
                </div>
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
            <div class="font-weight-bold fz-1-5rem">Data {{ $title }} Kosong</div>
            <div class="fz-0-8rem">Gunakan tombol <strong>TAMBAH</strong> di atas untuk menambah data.</div>
          </div>
        </template>
      </div>
      <div class="card-footer"></div>
    </div>
  </div>
@endsection

@section('jsAfterMain')
  <script>
    $(function() {
      window.faqApp = new Vue({
        el: '#listApp',
        data() {
          return {
            list: [],
            isSavingOrder: false,
          };
        },
        methods: {
          formatTanggal(tanggal) {
            return dayjs(tanggal).format('DD MMMM YYYY HH:mm');
          },
          tambahClick() {
            AKModal.open({
              url: `{{ route('admin.faq.create') }}`,
              size: 'lg'
            })
          },
          onChange() {
            this.saveOrder();
          },
          changeClick(item) {
            AKModal.open({
              url: `{{ route('admin.faq.edit') }}`,
              data: {
                id: item.id,
              },
              size: 'lg'
            })
          },
          deleteClick(item) {
            AKHelper.DeleteConfirm({
              datatables: this,
              url: `{{ route('admin.faq.destroy') }}`,
              loadingText: `Menghapus item FAQ`,
              text: `Apakah anda yakin menghapus <strong>"${item.title}"</strong>?`,
              data: {
                id: item.id,
              },
            });
          },
          reload() {
            axios.post(`{{ route('admin.faq.datatable') }}`)
              .then(res => {
                if (res?.data?.success) {
                  this.list = res.data.data;
                }
              });
          },
          saveOrder() {
            let order = this.list.map(item => item.id);
            this.isSavingOrder = true;
            axios.post(`{{ route('admin.faq.order') }}`, {
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
@endsection
