<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use AyatKyo\Klorovel\Core\Facades\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;

class KontakWaController extends Controller
{
    public $viewPath = 'admin.kontak-wa.';

    public function index(Request $request)
    {
        return $this->view('index', [
            'data' => Setting::loadOrCreateFromDb('floating-wa'),
        ]);
    }

    public function update(Request $request)
    {
        $validasi = validator($request->all(), [
            'telepon' => 'required',
        ]);
        $this->responseFailsValidation($validasi);

        try {
            DB::beginTransaction();

            $setting = Setting::loadOrCreateFromDb('floating-wa');
            $setting->telepon    = '+62' . phone_normalize($request->telepon);
            $setting->nama       = $request->nama;
            $setting->keterangan = $request->keterangan;
            $setting->pesan      = $request->pesan ? encode_local_upload($request->pesan) : null;

            if ($request->foto) {
                $foto = Image::make($request->foto);
                $fotoName = generate_filename('png', 'wa-contact');
                $fotoPath = 'uploads/avatar/' . $fotoName;
                $foto->fit(100, 100)->save($fotoPath);

                if ($setting->foto) {
                    $fotoOld = $setting->foto;
                }
                
                $setting->foto = $fotoName;
            }

            if (! Setting::save('floating-wa', $setting, true)) {
                throw new \Exception("Gagal menyimpan", 1);
            }
            
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            if (isset($fotoName)) {
                try_delete_if_exists('uploads/avatar/' . $fotoName);
            }

            return $this->jsonError('Gagal menyimpan pengaturan kontak wa');
        }

        if (isset($fotoOld)) {
            try_delete_if_exists('uploads/avatar/' . $fotoOld);
        }

        return $this->jsonSuccess('Berhasil menyimpan pengaturan kontak wa', [
            'redir' => isset($fotoName) ? route('admin.kontak-wa.index') : null, 
        ]);
    }
}
