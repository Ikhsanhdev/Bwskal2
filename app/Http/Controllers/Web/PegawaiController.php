<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    public $viewPath = 'web.pegawai.';

    public function index(Request $request)
    {
        $list = Pegawai::select([
            'id',
            'name',
            'position',
            'image',
            ])
            ->orderBy('order')
            ->get();

        return $this->view('index', [
            'list' => $list,
        ]);
    }

    public function detail(Request $request)
    {
        try {
            $pegawaiID = decrypt($request->id);
            $pegawai = Pegawai::findOrFail($pegawaiID);
        } catch (\Throwable $th) {
            return $this->jsonError('Pegawai tidak ditemukan');
        }

        return $this->view('modal-detail', [
            'data' => $pegawai,
        ]);
    }
}
