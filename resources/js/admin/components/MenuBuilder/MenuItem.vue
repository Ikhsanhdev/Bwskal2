<template>
  <div class="menuitem"
    :class="data.type"
    >
    <div class="atas">
      <i class="mdi mdi-drag fz-lg mr-2 handle"></i>
      <i class="mdi mr-2 fz-lg"
        :class="menuIcon"
        ></i>
      <div class="teks">{{ data.text }}</div>
      <!--
      <div>
        <div class="subteks">@{{ data.subteks }}</div> 
      </div>
      -->
      <div class="flex"></div>
      <div class="aksi">
        <button class="btn btn-icon btn-collapse btn-success"
          v-if="data.type == 'dropdown'"
          type="button"
          @click="collapseClick"
          >
          <i class="mdi"
            :class="{
              'mdi-chevron-down': !isSubHidden,
              'mdi-chevron-left': isSubHidden,
            }"></i>
        </button>
        <button class="btn btn-icon btn-ubah"
          :class="{
            'btn-secondary' : ['link', 'halaman', 'default'].indexOf(data.type) > -1,
            'btn-light' : ['dropdown'].indexOf(data.type) > -1,
          }"
          type="button"
          @click="editItem"
          >
          <i class="mdi mdi-database-edit"></i>
        </button>
        <button class="btn btn-danger btn-icon btn-hapus"
          type="button"
          v-if="data.type != 'default' || true"
          @click="hapusItem"
          >
          <i class="mdi mdi-trash-can-outline"></i>
        </button>
      </div>
    </div>
    
    <template v-if="data.type == 'dropdown'">
      <draggable
        class="subitem-wrap"
        v-bind="{
          animation: 200,
          ghostClass: 'ghost'
        }"
        handle=".handle"
        v-model="data.data"
        :group="{name:'menu-item'}"
        :class="{'kosong': data.data.length == 0}"
        style="display: none;"
        :scroll-sensitivity="100"
        :force-fallback="true"
        >
        <menu-item
          v-for="(submenu, subindex) in data.data"
          :data="submenu"
          :key="submenu.id"
          :index="subindex"
          :parent="(parent ? parent + '.' : '' ) + index"
          @edit="onEdit"
          @hapus="onHapus"
          />
      </draggable>
    </template>
  </div>
</template>

<style lang="scss">
</style>


<script>
export default {
  name: 'menu-item',
  props: [
    'data',
    'index',
    'parent',
  ],
  data: function () {
    return {
      isSubHidden: true,
    };
  },
  computed: {
    menuIcon() {
      switch (this.data.type) {
        case "default":
          return "mdi-circle-medium";
        break;
        case "dropdown":
          return "mdi-cards-variant";
        break;
        case "halaman":
          return "mdi-file-document-outline";
        break;
        case "link":
          return "mdi-link";
        break;
      }
    },
  },
  methods: {
    collapseClick() {
      $(this.$el).children('.subitem-wrap').slideToggle(400, () => {
        this.$nextTick(() => {
          this.isSubHidden = $(this.$el).children('.subitem-wrap').css('display') == 'none';
        })
      });
    },
    editItem: function () {
      this.$emit('edit', {
        parent: this.parent,
        index: this.index,
      });
    },
    hapusItem() {
      this.$emit('hapus', {
        parent: this.parent,
        index: this.index,
      });
    },
    onEdit(data) {
      this.$emit('edit', data);
    },
    onHapus(data) {
      this.$emit('hapus', data);
    },
  },
  mounted() {
  }
};
</script>
