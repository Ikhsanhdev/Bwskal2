<template>
  <div class="form-group">
    <label
      v-bind:for="name"
      v-html="labelComputed"
    ></label>
    <div class="box-dashed">
      <div class="d-flex justify-content-center align-items-center flex-column flex">
        <i class="mdi mdi-file fz-3-5rem"></i>
        <div
          class="fz-1-15rem lh-1-25 font-weight-bold text-center max-w-100"
          v-html="titleData"
        ></div>
        <div
          class="fz-md text-muted text-center"
          v-html="subtitleData"
          v-if="showInEdit"
        ></div>
      </div>

      <div class="form-group">
        <label
          for=""
          class="d-none"
        ></label>
        <input
          type="file"
          class="vis-hidden"
          :name="name"
          ref="input"
          @change="berkasChange"
        >
      </div>

      <div class="btn-list-horizontal mb-md-0 mt-3 mb-3 text-center" v-if="showInEdit">
        <button
          class="btn btn-danger"
          type="button"
          v-if="file || link"
          @click="hapusClick"
        >{{ deleteText }}</button>
        <button
          class="btn btn-secondary"
          type="button"
          @click="pilihClick"
          v-if="! deleted"
        >{{ selectText }}</button>
      </div>

      <template v-if="link">
        <div class="d-flex align-items-center justify-content-center mt-3">
          <a
            class="btn btn-success"
            :href="link"
            target="_blank"
          >
            <i class="mdi mdi-download-box fz-1-5rem mr-2"></i>
            <span class="fz-1rem">UNDUH LAMPIRAN</span>
          </a>
        </div>
      </template>
    </div>
  </div>
</template>

<script>
export default {
  name: 'ak-file',
  props: {
    name: {
      type: String,
    },
    label: {
      type: String,
    },
    optional: {
      type: Boolean,
      default: false,
    },
    title: {
      type: String,
      default: `Silakan pilih berkas`,
    },
    subtitle: {
      type: String,
      default: `Bertipe pdf atau gambar. <strong>Maksimal 2 MB.</strong>`,
    },
    canChange: {
      type: Boolean,
      default: true,
    },
    optional: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      file: null,
      link: null,
      titleData: ``,
      subtitleData: ``,
      deleted: false,
    };
  },
  computed: {
    labelComputed() {
      return this.label + (this.optional ? `<span class="ml-1 fz-0-75rem text-muted fw-600">(Opsional)</span>` : '');
    },
    selectText() {
      if (this.file || this.link) {
        return `Ganti Berkas`;
      }
      return `Pilih Berkas`;
    },
    deleteText() {
      if (!this.link && this.file) {
        return `Hapus Berkas`;
      } else if (this.link && this.file) {
        return `Batal Ganti`;
      } else if (this.link && !this.deleted) {
        return `Hapus Berkas`;
      } else if (this.link && this.deleted) {
        return `Batal Hapus Berkas`;
      }
      return `Hapus Berkas`;
    },
    showInEdit() {
      return !this.link || (this.link && this.canChange);
    },
  },
  methods: {
    infoReset() {
      this.titleData = this.title;
      this.subtitleData = this.subtitle;
    },
    infoUpdate() {
      if (this.file) {
        this.titleData = this.file.name;
        this.subtitleData = formatByte(this.file.size);
      } else if (this.link) {
        this.titleData = this.link.split("/").pop();
        if (this.deleted) {
          this.subtitleData = `Lampiran ini akan dihapus`;
        } else {
          this.subtitleData = `Gunakan tombol "Ganti Berkas" untuk mengganti lampiran`;
        }
      } else {
        this.infoReset();
      }

      this.$emit('input', {
        file: this.file,
        deleted: this.deleted,
      });
    },
    berkasChange(e) {
      if (e.target.files.length) {
        this.file = e.target.files[0];
        this.infoUpdate();
      }
    },
    hapusClick() {
      if (this.link && this.deleted) {
        this.deleted = false;
      } else if (this.link && !this.file) {
        this.deleted = true;
      } else if (this.link && this.file) {
        this.file = null;
      } else {
        this.file = null;
      }
      this.infoUpdate();
    },
    pilihClick() {
      this.$refs.input.click();
    },
    getFile() {
      return this.file;
    },
    isDeleted() {
      return this.deleted;
    },
    setOldFile(link) {
      this.link = link;
      this.infoUpdate();
    },
    reset() {
      this.file = null;
      this.$refs.file = null;
      this.link = null;
      this.deleted = false;
    },
  },
  mounted() {
    this.infoUpdate();
  },
}
</script>
