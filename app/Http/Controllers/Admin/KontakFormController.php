<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KontakForm;
use AyatKyo\Klorovel\DataTable\DataTables;
use Illuminate\Http\Request;

class KontakFormController extends Controller
{
    public $viewPath = 'admin.kontak-form.';

    public function datatable(Request $request)
    {
        $data = KontakForm::select([
            'id',
            'name',
            'email',
            'contact',
            'topic',
            'created_at',
            ])
            ->latest();

        $datatable = DataTables::makeWithSearch($data, [
            'name',
            'email',
            'contact',
            'topic',
            'content',
        ]);
        
        return $datatable->toJson();
    }

    public function edit(Request $request)
    {
        $data = KontakForm::hasId($request->id)->first();
        if (!$data) {
            return $this->jsonError('Data tidak ditemukan');
        }

        try {
            $data->has_read = true;
            $data->save();
        } catch (\Throwable $th) {
        }

        return $this->view('modal-detail', [
            'data' => $data,
        ]);
    }

    public function destroy(Request $request)
    {
        $validasi = validator($request->all(), [
            'id' => 'required|integer',
        ]);
        $this->responseFailsValidation($validasi);

        $item = KontakForm::hasId($request->id)->first();
        if (!$item) {
            return $this->jsonError('Data tidak ditemukan');
        }

        if (!$item->delete()) {
            return $this->jsonError('Gagal menghapus data');
        }

        return $this->jsonSuccess('Berhasil menghapus data');
    }
}
