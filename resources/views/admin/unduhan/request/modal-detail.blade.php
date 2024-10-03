@extends('layouts.modal')

@php
$isEdit = true;

switch ($data->status) {
  case 'reject':
    $headerClass = 'modal-danger';
    break;
  case 'approve':
    $headerClass = 'modal-success';
    break;
}

$formId = 'verify-form';
$formAction = route('admin.unduhan.request.verify');
@endphp

@section('title')
@if ($data->status == 'pending')
  <i class="mdi mdi-text-box-search mr-2"></i>
  <span class="font-weight-bold">Verifikasi Permohonan Akses</span>
@else
<div class="d-flex align-items-center lh-1">
  <i class="mdi mdi-text-box-search fz-2rem mr-3"></i>
  <div class="lh-1-25">
    <div class="font-weight-bold">Detail Permohonan Akses</div>
    <div class="fz-0-8rem">{{ $data->status_text }}</div>
  </div>
</div>
@endif
@endsection

@section('body')
  <div class="fw-700 fz-1-15rem mb-2">Unduhan tujuan</div>
  <div class="bg-light lh-1-15 rounded-sm d-flex flex justify-content-center align-items-center flex-column py-3">
    <i class="fi <?php echo flaticon_from_mime(optional($unduhan)->mime); ?> fz-4rem"></i>
    <div class="fw-800 fz-1-25rem mb-1">{{ optional($unduhan)->title }}</div>
    <div class="fz-0-85rem text-muted">Diunduh {{ optional($unduhan)->hit }} kali</div>
  </div>

  <div class="fw-700 fz-1-15rem mt-2">Detail Permohonan</div>
  <x-ak-text label="Diajukan pada"
    :value="$data->created_at->isoFormat('DD MMMM YYYY')" />

  <x-ak-text label="Nama Pemohon"
    :value="$data->name" />

  <x-ak-text label="Email Pemohon"
    :value="$data->email" />

  <x-ak-text label="Tujuan/ Keperluan Permintaan Dokumen"
    :value="$data->message" />

  <hr class="mb-2">

  @if ($data->status == 'pending')
  <x-ak-select label="Status Permohonan"
    name="status"
    required
    v-model="data.status"
    placeholder="Pilih Status Permohonan"
    :list="['approve' => 'Diterima', 'reject' => 'Ditolak']" />

  <template v-if="data.status == 'reject'">
    <x-ak-input name="message"
      label="Alasan Penolakan"
      placeholder="$label"
      v-model="data.message"
      type="textarea" />
  </template>
  @else
  <x-ak-text label="Status Permohonan"
    :value="$data->status_text" />
  @if ($data->status == 'reject')
  <x-ak-text label="Alasan Penolakan"
    :value="$data->admin_message ?? '-'" />
  @endif
  @endif
@endsection

@section('footer')
@if ($data->status == 'pending')
  <button type="button"
    data-dismiss="modal"
    class="btn btn-block btn-secondary mr-3">BATAL</button>
  <button class="btn btn-block btn-primary m-0" type="button"
    @click="submit">SIMPAN</button>
@endif
@endsection

@section('script')
@if ($data->status == 'pending')
<script>
  $(function () {
    let verifyApp = new Vue({
      el: `#{{ $formId }}`,
      data() {
        return {
          form: null,
          data: {
            status: '',
          },
        };
      },
      methods: {
        init() {
          this.form = AKForm.validation(`#{{ $formId }}`);
        },
        async submit() {
          if (!this.form.isValid()) {
            AKToast.error(`Inputan tidak valid`);
            return;
          }

          let payload = {
            id: @json($data->id),
            status: this.data.status,
            message: this.data?.message ?? null,
          };

          AKToast.loading(`Menyimpan Data`, `lp`);
          try {
            res = await axios.post(this.form.$selector.attr('action'), payload);
            if (res.data.success) {
              this.form.closeModal();
              window.dTables.reload();
              AKToast.success(res.data.message);
            }
          } catch (err) {
            res = this.form.handleAxiosError(err);
            AKToast.error(res?.message ?? 'Terjadi kesalahan saat menyimpan');
          } finally {
            AKToast.close('lp');
          }
        }
      },
      mounted() {
        this.init();
      },
    });
  })
</script>
@endif
@endsection
