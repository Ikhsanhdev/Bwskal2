<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use AyatKyo\Klorovel\Core\Facades\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class PengaturanSitusController extends Controller
{
    public $viewPath = 'admin.pengaturan-situs.';

    public function getPage(Request $request, $page)
    {
        $viewData = [
            'data' => null,
        ];

        //  Ambil data jika ada
        $pageMethod = Str::slug($page, '_');
        if (method_exists($this, "getData_$pageMethod")) {
            $data = $this->{"getData_$pageMethod"}($request);
            if ($data) {
                $viewData['data'] = $data;
            }
        }

        //  check page tujuan
        if (! File::exists(resource_path('views/admin/pengaturan-situs/' . $page . '.blade.php'))) {
            return view('errors.common-panel', [
                'icon'         => 'mdi-application-cog-outline',
                'messageIcon'  => 'mdi-file-hidden',
                'title'        => 'Pengaturan Situs',
                'messageTitle' => 'Halaman Tidak Dikenali',
                'message'      => "Halaman yang anda tuju tidak dikenali",
                'topBackLink'  => route('admin.pengaturan-situs.index'),
            ]);
        }

        return $this->view($page, $viewData);
    }

    public function update(Request $request, $page)
    {
        $pageMethod = Str::slug($page, '_');
        if (method_exists($this, "update_$pageMethod")) {
            return $this->{"update_$pageMethod"}($request);
        }
        
        return $this->jsonError("Gagal menyimpan data, handler '$page' tidak ditemukan");
    }

    public function getData_informasi(Request $request)
    {
        return Setting::loadOrCreateFromDb('web');
    }

    public function update_informasi(Request $request)
    {
        $validasi = validator($request->all(), [
            'profil'     => 'required',
        ]);
        $this->responseFailsValidation($validasi);

        $webSetting = Setting::loadOrCreateFromDb('web');
        $webSetting->profil = $request->profil;
        $webSetting->telepon = $request->telepon;
        $webSetting->kontak_list = $request->kontak_list;

        if (! Setting::save('web', $webSetting, true)) {
            return $this->jsonError('Gagal menyimpan pengaturan informasi');
        }

        return $this->jsonSuccess('Berhasil menyimpan pengaturan informasi');
    }

    public function getData_media_sosial(Request $request)
    {
        try {
            $jsonPath = resource_path('json/web_medsos.json');
            if (File::exists($jsonPath)) {
                return json_decode(File::get($jsonPath))->list;
            }
        } catch (\Throwable $th) {
        }
    }

    public function update_media_sosial(Request $request)
    {
        $validasi = validator($request->all(), [
            'list' => 'required',
        ]);
        $this->responseFailsValidation($validasi);

        try {
            //  Simpan ke json
            $data = json_decode($request->list);
            $col = collect();
            $col->put('list', $data);
            File::put(resource_path('json/web_medsos.json'), $col->toJson());

            //  generate
            $view = view('templates.medsos', [
                'list' => $col->get('list'),
            ]);
            File::put(resource_path('views/components/web/medsos-link.blade.php'), $view);
        } catch (\Throwable $th) {
            return $this->jsonError([$th, 'Terjadi kesalahan saat menyimpan data']);
        }

        return $this->jsonSuccess('Berhasil menyimpan data');
    }
}
