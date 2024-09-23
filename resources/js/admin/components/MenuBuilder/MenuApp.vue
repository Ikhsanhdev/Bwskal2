<template>
  <div class="menuapp">
    <div class="modal fade" role="dialog" id="modalnya">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">
              <i class="mdi mdi-timeline-text mr-2"></i>
              <span class="font-weight-bold">{{ modaldata.mode == 'tambah' ? 'Tambah Menu' : 'Ubah Menu' }}</span>
            </h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <i class="mdi mdi-close"></i>
            </button>
          </div>
          <form id="formnya">
            <div class="modal-body" >
              <!-- Tipe Menu -->
              <div class="form-group" v-if="modaldata.mode == 'tambah'">
                <label class="control-label" for="">Tipe Menu</label>
                <select
                  name="tipe"
                  class="form-control"
                  v-model="modaldata.type"
                  required
                  @change="tipeMenuChange"
                  >
                  <option value="">Pilih Tipe Menu</option>
                  <option v-for="tipe in tipemenu"
                    :key="tipe.value"
                    :value="tipe.value">{{ tipe.name }}</option>
                </select>
              </div>

              <!-- Default Menu -->
              <template 
                v-if="modaldata.type == 'default'"
                >
                <div class="form-group">
                  <label for="">
                    Menu Default 
                  </label>
                  <select 
                    name="menu"
                    class="form-control"
                    v-model="modaldata.data"
                    autocomplete="off"
                    spellcheck="false"
                    required
                    key="tambah-md-select"
                    ref="t_menu"
                    >
                    <option value="">Pilih Menu Default</option>
                    <option 
                      v-for="dm in defaultmenu" 
                      :value="dm.data"
                      :data-judul="dm.text"
                      :key="dm.text"
                      >
                      {{ dm.text }}
                    </option>
                  </select>
                </div>
                <div class="form-group">
                  <label class="d-flex align-items-center">
                    <div class="flex">Nama Menu</div>
                    <button 
                      type="button"
                      class="py-1 px-2 fz-sm btn btn-secondary"
                      @click="setNamaDefault('t_menu')"
                      >Nama Default</button>
                  </label>
                  <input type="text"
                    class="form-control"
                    v-model="modaldata.text"
                    name="nama"
                    placeholder="Nama Menu"
                    autocomplete="off"
                    spellcheck="false"
                    required
                    >
                </div>
              </template>
              <template 
                v-else-if="modaldata.type == 'link'"
                >
                <div class="form-group">
                  <label for="">Nama Menu</label>
                  <input type="text"
                    class="form-control"
                    v-model="modaldata.text"
                    name="nama"
                    placeholder="Nama Menu"
                    autocomplete="off"
                    spellcheck="false"
                    required
                    >
                </div>
                <div class="form-group">
                  <label for="">Link Tujuan</label>
                  <input type="text"
                    class="form-control"
                    v-model="modaldata.data"
                    name="link"
                    placeholder="Link Tujuan"
                    autocomplete="off"
                    spellcheck="false"
                    required
                    >
                </div>
              </template>
              <template 
                v-else-if="modaldata.type == 'dropdown'"
                >
                <div class="form-group">
                  <label for="">Nama Menu</label>
                  <input type="text"
                    class="form-control"
                    v-model="modaldata.text"
                    name="nama"
                    placeholder="Nama Menu"
                    autocomplete="off"
                    spellcheck="false"
                    required
                    >
                </div>
              </template>
              <template 
                v-else-if="modaldata.type == 'halaman'"
                >
                <div class="form-group">
                  <label for="">
                    Halaman Tujuan 
                    <i class="mdi mdi-spin mdi-loading ml-1" v-show="loadingHalaman"></i>
                  </label>
                  <select 
                    name="halaman"
                    class="custom-select"
                    v-model="modaldata.data"
                    autocomplete="off"
                    spellcheck="false"
                    required
                    key="ubah-halaman-select"
                    ref="t_halaman"
                    >
                    <option value="">Pilih Halaman</option>
                    <option v-for="halaman in halamanList"
                      :key="halaman.id"
                      :value="halaman.slug">{{ halaman.title }}</option>
                  </select>
                </div>
                <div class="form-group">
                  <label class="d-flex align-items-center">
                    <div class="flex">Nama Menu</div>
                    <button 
                      type="button"
                      class="py-1 px-2 fz-sm btn btn-secondary"
                      @click="setNamaDefault('t_halaman')"
                      >Nama Default</button>
                  </label>
                  <input type="text"
                    class="form-control"
                    v-model="modaldata.text"
                    name="nama"
                    placeholder="Nama Menu"
                    autocomplete="off"
                    spellcheck="false"
                    required
                    >
                </div>
              </template>

            </div>
            <div class="modal-footer flex-nowrap">
              <button type="button" 
                data-dismiss="modal"
                class="btn btn-block btn-secondary mr-3"
                >BATAL</button>
              <button 
                class="btn btn-block btn-primary m-0"
                @click="modalSimpan"
                >SIMPAN</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="card card-table card-table-fit">
      <div class="card-header">
        <div class="title">Menu Builder</div>
        <div class="flex"></div>
        <div class="action btn-list-horizontal">
          <a class="btn btn-secondary"
            href="#"
            @click.prevent="simpanOnClick"
            >
            <i class="mdi mdi-database-lock mr-2 fz-normal"></i>
            <span>SIMPAN</span>
          </a>
          <a class="btn btn-primary"
            href="#"
            @click.prevent="tambahOnClick"
            >
            <i class="mdi mdi-database-plus mr-2 fz-normal"></i>
            <span>TAMBAH</span>
          </a>
        </div>
      </div>
      <div class="card-body">
        <div class="menuapp-body">
          <draggable
            class="menuitem-wrap"
            handle=".handle"
            v-bind="{
              animation: 200,
              ghostClass: 'ghost'
            }"
            v-model="menulist"
            :group="{name:'menu-item'}"
            :scroll-sensitivity="100"
            :force-fallback="true"
            >
            <menu-item v-for="(menu, menuindex) in menulist"
              :key="menu.id"
              :data="menu"
              :index="menuindex"
              @edit="onEdit"
              @hapus="onHapus"
              />
          </draggable>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import MenuItem from './MenuItem.vue';

export default {
  components: {
    MenuItem,
  },
  data () {
    return {
      tipemenu: [
        {
          name: "Default Menu",
          value: "default"
        },
        {
          name: "Link",
          value: "link"
        },
        {
          name: "Halaman",
          value: "halaman"
        },
        {
          name: "Dropdown",
          value: "dropdown"
        },
      ],
      menulist: [],
      defaultmenu: [],
      halamanList: [],
      loadingHalaman: false,
      modaldata: {},
      formnya: null,
    };
  },
  computed: {
    
  },
  methods: {
    tipeMenuChange() {
      this.modaldata.data = "";
      this.modaldata.text = "";
      this.loadPilihanHalaman();
    },
    setNamaDefault(sumber) {
      if (this.$refs[sumber].selectedOptions &&
        this.$refs[sumber].selectedOptions[0] &&
        this.$refs[sumber].selectedOptions[0].value != "") {
        this.modaldata.text = this.$refs[sumber].selectedOptions[0].innerText.trim();
        }
    },
    generateId() {
      return String((new Date()).getTime());
    },
    loadInitData() {
      this.menulist = window.menu_init_data.list;
      this.defaultmenu = window.menu_init_data.default;
      this.loadPilihanHalaman(true);
    },
    tambahOnClick() {
      this.modaldata = {
        type: "",
        data: "",
        text: "",
        mode: 'tambah',
      };
      this.formnya.reset();
      $('#modalnya').modal('show');
    },
    pilihanGanti: function (holder, event) {
      if (! this[holder].nama || this[holder].nama == "" || this[holder].nama.trim().length == 0) {
        if ($(event.target).find('option:selected').length > 0 && $(event.target).find('option:selected').data('judul')) {
          this[holder].nama = $(event.target).find('option:selected').data('judul').trim();
          this.$forceUpdate();
        }
      }
    },
    async loadPilihanHalaman(force = false) {
      if (! force && this.modaldata.type != 'halaman') return;
      this.loadingHalaman = true;
      let res = await axios.get(`${window.urllist.menu}/halaman`);
      if (res.data && res.data.data) {
        this.halamanList = res.data.data;
      } else {
        AKToast.error(`Gagal mengambil daftar halaman`);
      }
      this.loadingHalaman = false;
    },
    modalSimpan() {
      this.formnya.pform.validate();
      if (! this.formnya.pform.isValid()) {
        return;
      }

      switch (this.modaldata.mode) {
        case "tambah":
          let id = this.generateId();
          switch (this.modaldata.type) {
            case "default":
            case "link":
            case "halaman":
              this.menulist.push({
                id: id,
                text: this.modaldata.text,
                type: this.modaldata.type,
                data: this.modaldata.data,
              });
            break;
            case "dropdown":
              this.menulist.push({
                id: id,
                text: this.modaldata.text,
                type: this.modaldata.type,
                data: [],
              });
            break;
          }
        break;
        case "edit":
          let penampung = this.menulist;
          if (this.modaldata.parent != undefined) {
            let keySub = this.modaldata.parent.replace(/\./g, '.data.');
            let dataParent = _.get(this.menulist, keySub);
            penampung = dataParent.data;
          }

          let data = penampung[this.modaldata.index];
          data.text = this.modaldata.text;
          data.data = this.modaldata.data;
        break;
      }
      
      $('#modalnya').modal('hide');
      this.modaldata = {};
    },
    async simpanOnClick() {
      AKHelper.ajaxPost({
        url: window.urllist.menu,
        data: {
          _method: 'PUT',
          menulist: JSON.stringify(this.menulist)
        },
        beforePost: function() {
          AKToast.loading('Menyimpan Menu', 'tsimpan', 'mdi-spin mdi-loading');
        },
        onFail: function(err) {
          AKToast.close('tsimpan');
          AKToast.error('Terjadi kesalahan saat menyimpan Menu');
        },
        done: function (res) {
          AKToast.close('tsimpan');
          if (res.success && res.message) {
            AKToast.success(res.message);
          }
        }
      });
    },
    onEdit(data) {
      let penampung = this.menulist;
      if (data.parent != undefined) {
        let keySub = data.parent.replace(/\./g, '.data.');
        let dataParent = _.get(this.menulist, keySub);
        penampung = dataParent.data;
      }
      this.modaldata = _.cloneDeep(penampung[data.index]);
      this.modaldata.mode = 'edit';
      this.modaldata.parent = data.parent;
      this.modaldata.index = data.index;
      this.formnya.reset();
      this.loadPilihanHalaman();
      $('#modalnya').modal('show');
    },
    onHapus(data) {
      let pesan = `Hapus menu ini ?`;
      let penampung = this.menulist;

      if (data.parent != undefined) {
        let keySub = data.parent.replace(/\./g, '.data.');
        let dataParent = _.get(this.menulist, keySub);
        penampung = dataParent.data;
      }

      if (penampung[data.index].type == "dropdown" && penampung[data.index].data.length) {
        pesan = `Hapus menu ini beserta submenu nya ?`;
      }

      AKToast.confirm({
        pesan: pesan,
        buttons: [
          {
            text: '<button class="col-sm">BATAL</button>'
          },
          {
            text: '<button class="btn-danger col-sm"><b>HAPUS</b></button>',
            autoHide: false,
            onpress: (hide) => {
              penampung.splice(data.index, 1);
              hide();
            }
          },
        ]
      });
    },
  },
  mounted () {
    this.loadInitData();
    this.formnya = new AKForm('#formnya', {
      form: {
        beforeSubmit: data => false,
      }
    });
  }
}
</script>

<style lang="scss">
.menuitem {
  border-radius: 5px;
  display: flex;
  justify-content: center;
  flex-direction: column;
  overflow: hidden;
  margin-bottom: 1rem;
  background: rgba(0, 0, 0, 0.05);

  .handle:hover {
    cursor: move;
  }
  .atas {
    padding: 0.5rem 1rem;
    display: flex;
    align-items: center;
    // background: #777f92;
    // color: #ffffff;
    .teks {
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
      font-weight: bold;
    }
    .aksi {
      min-width: max-content;
      margin-left: .5rem;
    }
  }


  .menuitem {
    margin: .75rem 1rem;
    .atas {
      background: rgba(0, 0, 0, 0.025);
    }
  }

  &.dropdown > .atas {
    background: #777f92;
    color: #ffffff;
    .subteks {
      font-size: .65rem;
      color: rgba(255, 255, 255, 0.75);
    }
  }

  & > .subitem-wrap .subitem-wrap .subitem-wrap &:not(.dropdown) > .atas {
    background: rgb(231, 231, 231);
  }
}
.subitem-wrap.kosong {
  min-height: 20px;
}
</style>
