<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class MenuController extends Controller
{
    protected $viewPath = 'admin.menu.';

    public function index(Request $request)
    {
        $dataMenu = json_decode('{"menulist":[]}');
        $menuDefaultPath = resource_path('json/web_menu_default.json');
        $menuPath = resource_path('json/web_menu.json');
        if (File::exists($menuPath)) {
            $dataMenu = json_decode(File::get($menuPath));
        }
        
        $defaultMenu = json_decode(File::get($menuDefaultPath));

        return $this->view('index', [
            'menulist' => $dataMenu,
            'defaultmenu' => $defaultMenu,
        ]);
    }

    public function update(Request $request)
    {
        //  Validasi
        $validasi = validator($request->all(), [
            'menulist' => 'required',
        ]);
        $this->responseFailsValidation($validasi);

        try {
            $dataMenu = json_decode($request->menulist);

            //  Buat view
            $menuView = view('layouts.menubuilder.menu-tpl', [
                'menulist' => $dataMenu,
            ]);
            File::put(resource_path('views/components/web/mainmenu.blade.php'), $menuView);

            //  Simpan data menu
            File::put(resource_path('json/web_menu.json'), json_encode([
                'menulist' => $dataMenu,
            ]));
        } catch (\Throwable $th) {
            return $this->jsonError([$th, 'Terjadi kesalahaan saat menyimpan Menu']);
        }

        return $this->jsonSuccess('Berhasil menyimpan Menu');
    }

    public function getHalaman(Request $request)
    {
        $pages = Page::select([
            'id',
            'slug',
            'title',
        ])
            ->orderBy('title')
            ->get();

        return $this->jsonSuccess('', [
            'data' => $pages,
        ]);
    }
}
