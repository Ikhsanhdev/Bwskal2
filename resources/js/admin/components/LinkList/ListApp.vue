<template>
  <div
    class="listapp"
    :class="{ 'card': !opt.inCard }"
  >
    <Teleport to="body">
      <div
        class="modal fade"
        role="dialog"
        :id="'modalnya-' + appid"
      >
        <div
          class="modal-dialog"
          role="document"
        >
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">
                <span>{{ modaldata.mode == 'tambah' ? 'Tambah Item' : 'Ubah Item' }}</span>
              </h5>
              <button
                class="close"
                type="button"
                data-dismiss="modal"
                aria-label="Close"
              >
                <i class="mdi mdi-close"></i>
              </button>
            </div>
            <form :id="'formnya-' + appid">
              <div class="modal-body">
                <div
                  v-for="skema in opt.skemaData"
                  :key="skema.key"
                >
                  <template v-if="skema.type == 'text'">
                    <div class="form-group">
                      <label class="d-inline-flex">
                        <div v-html="skema.name"></div>
                        <span
                          class="ml-1 text-danger"
                          v-if="skema.required"
                        >*</span>
                      </label>
                      <input
                        type="text"
                        class="form-control"
                        :name="skema.key"
                        v-model="modaldata[skema.key]"
                        :placeholder="skema.placeholder ? skema.placeholder : skema.name"
                        autocomplete="off"
                        spellcheck="false"
                        :required="skema.required ? true : false"
                      >
                    </div>
                  </template>
                  <template v-else-if="skema.type == 'select'">
                    <div class="form-group">
                      <label class="d-inline-flex">
                        <div v-html="skema.name"></div>
                        <span
                          class="ml-1 text-danger"
                          v-if="skema.required"
                        >*</span>
                      </label>
                      <select
                        class="form-control"
                        :name="skema.key"
                        v-model="modaldata[skema.key]"
                        :required="skema.required ? true : false"
                      >
                        <option value="">{{ skema.placeholder ? skema.placeholder : `Pilih ${skema.name}` }}</option>
                        <option
                          v-for="sv in skema.value"
                          :value="sv.value"
                          :key="sv.value"
                        >{{ sv.text }}</option>
                      </select>
                    </div>
                  </template>
                </div>
              </div>
              <div class="modal-footer flex-nowrap">
                <button
                  type="button"
                  data-dismiss="modal"
                  class="btn btn-block btn-secondary mr-3"
                >BATAL</button>
                <button
                  type="button"
                  class="btn btn-block btn-primary m-0"
                  @click="modalSimpanOnClick"
                >SIMPAN</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </Teleport>

    <div
      class="card-header mb-2"
      v-if="!opt.inCard"
    >
      <div class="title">
        <i
          class="mr-2"
          :class="judulIcon"
          v-if="judulIcon"
        ></i>
        <span>{{ judul }}</span>
      </div>
      <div class="flex"></div>
      <div class="action">
        <button
          class="btn btn-secondary"
          type="button"
          @click="tambahOnClick"
        >TAMBAH</button>
      </div>
    </div>
    <div :class="{ 'card-body': !opt.inCard }">
      <div
        v-if="isLoading"
        class="d-flex justify-content-center align-items-center"
      >
        <i class="mdi mdi-spin mdi-loading fz-xxl"></i>
      </div>
      <div
        v-if="(!list || list.length == 0) && !isLoading"
        class="d-flex justify-content-center align-items-center flex-column py-3"
      >
        <i class="mdi mdi-cloud-off-outline fz-xxl"></i>
        <div class="font-weight-bold">Data kosong</div>
      </div>
      <draggable
        class="link-menuitem-wrap"
        handle=".handle"
        v-bind="{
          animation: 200,
          ghostClass: 'ghost'
        }"
        v-model="list"
      >
        <div
          class="link-menuitem"
          v-for="(item, index) in list"
          :key="item.id"
        >
          <div class="atas bg-white">
            <i class="mdi mdi-drag fz-lg mr-2 handle"></i>
            <slot
              name="itemtpl"
              :item="item"
            ></slot>
            <!-- <div class="teks">{{ item.text }}</div>
            <div class="subteks">{{ item.link }}</div>  -->
            <div class="flex"></div>
            <div class="aksi">
              <button
                class="btn btn-icon btn-ubah btn-secondary"
                type="button"
                @click="ubahOnClick(index)"
              >
                <i class="mdi mdi-database-edit"></i>
              </button>
              <button
                class="btn btn-danger btn-icon btn-hapus"
                type="button"
                @click="hapusOnClick(index)"
              >
                <i class="mdi mdi-trash-can-outline"></i>
              </button>
            </div>
          </div>
        </div>
      </draggable>
    </div>
    <template v-if="!opt.inCard">
      <div class="card-footer text-right">
        <button
          class="btn btn-primary"
          @click="simpanOnClick"
        >SIMPAN</button>
      </div>
    </template>
  </div>
</template>

<script>
export default {
  props: [
    'judul',
    'judulIcon',
    'url',
    'opt',
  ],
  data() {
    return {
      appid: '00',
      list: [],
      modaldata: {},
      formnya: null,
      isLoading: false,
    };
  },
  methods: {
    // async loadData() {
    //   this.isLoading = true;
    //   let res = await axios.get(this.url);
    //   this.isLoading = false;
    //   if (res.data && res.data.data && res.data.data.list) {
    //     this.list = res.data.data.list;
    //   }
    // },
    loadInitData() {
      this.isLoading = true;
      this.list = this.opt.initData;
      this.isLoading = false;
    },
    tambahOnClick() {

      this.modaldata = {
        mode: 'tambah',
      };
      this.opt.skemaData.forEach(skema => {
        this.modaldata[skema.key] = "";
      });
      this.formnya.reset();
      $('#modalnya-' + this.appid).modal('show');
      return;
      this.list.push({
        id: Date.now(),
        text: "Link Teks",
        link: "Link Url",
      });
    },
    ubahOnClick(index) {
      let item = this.list[index];
      this.modaldata = _.cloneDeep(item);
      this.modaldata.mode = 'ubah';
      this.modaldata.index = index;

      this.formnya.reset();
      $('#modalnya-' + this.appid).modal('show');
    },
    async simpanOnClick() {
      AKHelper.ajaxPost({
        url: this.url,
        data: {
          _method: 'PUT',
          list: JSON.stringify(this.list)
        },
        beforePost: function () {
          AKToast.loading('Sedang Menyimpan', 'tsimpan', 'mdi-spin mdi-loading');
        },
        onFail: function (err) {
          AKToast.close('tsimpan');
        },
        done: function (res) {
          AKToast.close('tsimpan');
          if (res.success && res.message) {
            AKToast.success(res.message);
          }
        }
      });
    },
    hapusOnClick(index) {
      AKToast.confirm({
        pesan: "Hapus item ini",
        buttons: [
          {
            text: '<button class="col-sm">BATAL</button>'
          },
          {
            text: '<button class="btn-danger col-sm"><b>HAPUS</b></button>',
            autoHide: false,
            onpress: (hide) => {
              this.list.splice(index, 1);
              hide();
            }
          },
        ]
      });
    },
    modalSimpanOnClick() {
      this.formnya.pform.validate();
      if (!this.formnya.pform.isValid()) {
        return;
      }

      switch (this.modaldata.mode) {
        case "tambah":
          let dataTambah = {
            id: Date.now(),
          };
          this.opt.skemaData.forEach(skema => {
            dataTambah[skema.key] = this.modaldata[skema.key];
          });
          this.list.push(dataTambah);
          break;
        case "ubah":
          let item = this.list[this.modaldata.index];
          this.opt.skemaData.forEach(skema => {
            item[skema.key] = this.modaldata[skema.key];
          });
          break;
      }

      $('#modalnya-' + this.appid).modal('hide');
      setTimeout(() => {
        this.modaldata = {};
      }, 500);
    },
    getData() {
      return this.list;
    },
  },
  created() {
    this.appid = Date.now();
  },
  mounted() {
    this.formnya = new AKForm('#formnya-' + this.appid, {
      form: { beforeSubmit: data => true, }
    });
    //  Ambil data jika init data tidak ada
    if (!this.opt.initData) {
      // this.loadData();
    } else {
      this.loadInitData();
    }
  }
}
</script>

<style scopped>.link-menuitem:last-of-type {
  margin-bottom: 0;
}
</style>
