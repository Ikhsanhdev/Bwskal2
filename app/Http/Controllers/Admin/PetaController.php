<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use AyatKyo\Klorovel\Core\Facades\Setting;
use Illuminate\Http\Request;

class PetaController extends Controller
{
    public $viewPath = 'admin.peta.';

    public function index(Request $request)
    {
        return $this->view('index', [
            'data' => Setting::loadOrCreateFromDb('web'),
        ]);
    }

    public function update(Request $request)
    {
        $validasi = validator($request->all(), [
            'alamat'     => 'required',
            'google_map' => "nullable|url",
        ]);
        $this->responseFailsValidation($validasi);

        $webSetting = Setting::loadOrCreateFromDb('web');
        $webSetting->alamat = $request->alamat;
        $webSetting->google_map = $request->google_map;

        if (! Setting::save('web', $webSetting, true)) {
            return $this->jsonError('Gagal menyimpan pengaturan peta');
        }

        return $this->jsonSuccess('Berhasil menyimpan pengaturan peta');
    }
}
