@extends('layouts.modal')

{{-- Setup --}}
@php
$isEdit = isset($data);
$title = ($isEdit ? 'Ubah' : 'Tambah') . ' Pengguna';

$formId = 'userForm';
$formAction = route('admin.user.' . ($isEdit ? 'update' : 'store'));
@endphp

@section('title')
<div class="d-flex align-items-center">
  <i class="mdi mdi-account-group mr-3 {{ $isEdit ? 'fz-2rem' : '' }}"></i>
  <div class="lh-1">
    <div class="font-weight-bold">{{ $title }}</div>
    @if ($isEdit)
    <div class="badge badge-primary fz-0-75rem mt-1">{{ $data->role_kata }}</div>
    @endif
  </div>
</div>
@endsection

@section('body')
  <div class="row flex-lg-row-reverse">
    <div class="col-lg-4">
      <div class="form-group">
        <label class="control-label mb-0"
          for="photo">Foto</label>
        <div class="fz-0-8rem text-muted font-weight-normal">Minimal 300px x 300px</div>
        <div id="ciPhoto"
          class="ak-cropit"
          data-name="photo"></div>
      </div>
    </div>
    <div class="col-lg-8">
      <h5 class="text-dark font-weight-bold">Informasi Pengguna</h5>
      @if (!$isEdit)
      <x-ak-select name="role"
        label="Jenis Pengguna"
        placeholder="Pilih jenis pengguna"
        v-model="data.role"
        required
        :list="$roleList" />
      @endif

      <x-ak-input label="Nama Lengkap"
        name="nama"
        required
        v-model="data.nama" />

      <x-ak-input label="Alamat Email"
        name="email"
        required
        v-model="data.email" />
      
      <x-ak-input label="Nama Pengguna"
        name="username"
        required
        v-model="data.username" />
      
      <x-ak-select name="status"
        label="Status Akun"
        placeholder="Pilih Status Akun"
        v-model="data.status"
        required
        :list="App\Models\User::getStatusList()" />

      <h5 class="text-dark font-weight-bold">Kata Sandi
        @if ($isEdit)
        <span class="font-weight-normal fz-md">(Isi Jika ingin mengganti kata sandi)</span>
        @endif
      </h5>
      <div class="row">
        <div class="col-md-6">
          <x-ak-input label="Kata Sandi"
            name="sandi"
            type="password"
            placeholder="$label"
            :required="!$isEdit"
            v-model="data.sandi" />
        </div>
        <div class="col-md-6">
          <x-ak-input label="Konfirmasi Kata Sandi"
            name="sandi_confirmation"
            type="password"
            placeholder="$label"
            :required="!$isEdit"
            v-model="data.sandi_confirmation" />
        </div>
      </div>
    </div>
  </div>
@endsection

@section('footer')
  <button type="button"
    data-dismiss="modal"
    class="btn btn-block btn-secondary mr-3">BATAL</button>
  <button class="btn btn-block btn-primary m-0"
    @click="simpanClick">SIMPAN</button>
@endsection

@section('script')
  <script>
    $(function() {
      let userApp = new Vue({
        el: '#{{ $formId }}',
        data() {
          return {
            form: null,
            data: {
              role: '',
              status: '',
            },
            photo: null,
          };
        },
        methods: {
          init() {
            this.form = AKForm.validation(`#{{ $formId }}`);
            this.photo = new AKCropit('#ciPhoto', {
              width: 300,
              height: 300,
              teksPilih: 'Pilih Foto',
              cropit: {
                imageState: {
                  @if (isset($data) && $data->avatar)
                    src: @json($data->avatar_image),
                  @endif
                },
                smallImage: "allow",
              },
              responsive: {
                xs: .65,
                sm: .65,
                md: .65,
                lg: .65,
                xl: .65
              }
            })
          },
          async simpanClick() {
            if (!this.form.isValid()) {
              AKToast.error(`Inputan tidak valid`);
              return;
            }
            
            //  Proses form
            let dataKirim = {};
            @if ($isEdit)
            dataKirim._method = 'PUT';
            dataKirim._id = @json($data->id);
            @endif

            for (let i of [
              'role',
              'nama',
              'email',
              'username',
              'status',
              'sandi',
              'sandi_confirmation',
            ]) {
              dataKirim[i] = this.data[i];
            }

            let dataGambar;
            if (this.photo.$selector.find('#akcropit-ifile')[0].files.length) {
              dataGambar = this.photo.export();
              dataKirim.avatar = dataGambar;
            }

            let res;
            AKToast.loading(`Menyimpan Data`, `lp`);
            try {
              res = await axios.post(this.form.$selector.attr('action'), dataKirim);
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
          @if ($isEdit)
          this.data.role = @json($data->role);
          this.data.nama = @json($data->fullname);
          this.data.email = @json($data->email);
          this.data.username = @json($data->username);
          this.data.status = @json($data->status);
          @endif
        },
      });
    });
  </script>
@endsection
