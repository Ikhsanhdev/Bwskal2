@extends('layouts.modal')

{{-- Setup --}}
@php
  $isEdit = isset($data);
  $title = ($isEdit ? 'Ubah' : 'Tambah') . ' Agenda';
  
  $formId = 'agendaForm';
  $formAction = route('admin.agenda.' . ($isEdit ? 'update' : 'store'));
@endphp

@section('title')
  <i class="mdi mdi-calendar-clock mr-2"></i>
  <span class="font-weight-bold">{{ $title }}</span>
@endsection

@section('body')
  <x-ak-input label="Judul"
    placeholder="$label"
    name="title"
    :value="$data->title ?? ''"
    v-model="data.title"
    required />
  <x-ak-input label="Lokasi"
    placeholder="$label"
    name="location"
    :value="$data->location ?? ''"
    v-model="data.location" />
  <div class="form-group" id="w-tanggal">
    <label for="">Tanggal</label>
    <date-picker v-model="data.tanggal"
      type="date"
      format="DD MMMM YYYY"
      value-type="DD-MM-YYYY"
      class="w-100"
      :input-attr="{name:'tanggal',required:true,'data-errors-container':'#w-tanggal'}"
      placeholder="Pilih tanggal agenda"
      range
      @input="datePickerChange('tanggal')"
      
      ></date-picker>
  </div>
  <x-ak-input type="textarea"
    label="Keterangan"
    placeholder="$label"
    name="description"
    :value="$data->description ?? ''"
    optional
    v-model="data.description" />

  <ak-file name="lampiran"
    ref="lampiran"
    label="Lampiran"
    subtitle="Bertipe pdf, ppt, pptx, doc, docx, xls, xlsx, zip atau gambar (Max 50MB)."
    optional
    v-model="data.lampiran" />
@endsection

@section('footer')
  <button type="button"
    data-dismiss="modal"
    class="btn btn-block btn-secondary mr-3">BATAL</button>
  <button class="btn btn-block btn-primary m-0"
    @click="submit">SIMPAN</button>
@endsection

@section('script')
  <script>
    $(function() {
      let mApp = new Vue({
        el: `#{{ $formId }}`,
        data() {
          return {
            form: null,
            data: {},
          };
        },
        methods: {
          init() {
            this.form = AKForm.validation(`#{{ $formId }}`);
          },
          datePickerChange(name) {
            this.$nextTick(() => {
              $(`[name="${name}"]`)?.parsley()?.validate();
            });
          },
          async submit() {
            if (!this.form.isValid()) {
              AKToast.error(`Inputan tidak valid`);
              return;
            }

            let payload = new FormData();
            @if ($isEdit)
              payload.append('_method', 'PUT');
              payload.append('_id', @json($data->id));
            @endif

            payload.append('title', this.data.title);
            payload.append('location', this.data.location);
            payload.append('tanggal', this.data.tanggal);
            payload.append('description', this.data.description);

            if (this.data.lampiran?.file) {
              payload.append('lampiran', this.data.lampiran.file);
            } else if (this.data.lampiran?.deleted) {
              payload.append('lampiran_deleted', 1);
            }

            let res;
            AKToast.loading(`Menyimpan Data`, `lp`);
            try {
              res = await axios.post(this.form.$selector.attr('action'), payload);
              if (res.data.success) {
                window.dTables.reload();
                this.form.closeModal();
                AKToast.success(res.data.message);
              }
            } catch (err) {
              res = this.form.handleAxiosError(err);
              AKToast.error(res?.message ?? 'Terjadi kesalahan saat menyimpan');
            } finally {
              AKToast.close('lp');
            }
          },
        },
        mounted() {
          this.init();
          @if($isEdit)
          this.$set(this, 'data', {
            title: @json($data->title),
            location: @json($data->location),
            description: @json($data->description),
            tanggal: @json($data->tanggal),
          });
          @if($data->attachment)
          this.$refs.lampiran.setOldFile(@json($data->attachment_url));
          @endif
          @endif
        },
      });
    });
  </script>
@endsection
