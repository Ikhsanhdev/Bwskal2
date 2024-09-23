<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Unduhan;
use App\Models\UnduhanKategori;
use AyatKyo\Klorovel\DataTable\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UnduhanController extends Controller
{
    public $viewPath = 'admin.unduhan.';

    public function datatable(Request $request)
    {
        $data = Unduhan::select([
            Unduhan::table('id'),
            Unduhan::table('title'),
            Unduhan::table('updated_at'),
            UnduhanKategori::table('name as category_name'),
        ])
            ->leftJoin(UnduhanKategori::table(), UnduhanKategori::table('id'), '=', Unduhan::table('category_id'));

        $datatable = DataTables::makeWithSearch($data, [
            Unduhan::table('title')
        ]);

        return $datatable->toJson();
    }

    public function create(Request $request)
    {
        $kategoriList = UnduhanKategori::getSelectOptions();

        return $this->view('modal-form', [
            'kategoriList' => $kategoriList,
        ]);
    }

    public function edit(Request $request)
    {
        $kategoriList = UnduhanKategori::getSelectOptions();
        $data = Unduhan::whereId($request->id)->first();
        if (!$data) {
            return $this->jsonError('Unduhan tidak ditemukan');
        }

        return $this->view('modal-form', [
            'data'         => $data,
            'kategoriList' => $kategoriList,
        ]);
    }

    public function store(Request $request)
    {
        $validasi = validator($request->all(), [
            'title'    => 'required|min:3',
            'category' => 'required|integer',
            'berkas'   => 'required|file|mimetypes:' . Unduhan::getMimeList(),
        ], [
            'berkas.mimetypes' => 'Berkas harus berupa ' . Unduhan::getExtensionList()
        ]);
        $this->responseFailsValidation($validasi);

        try {
            DB::beginTransaction();

            $unduhan = new Unduhan;
            $unduhan->user_id     = Auth::id();
            $unduhan->category_id = $request->category;
            $unduhan->title       = $request->title;
            $unduhan->slug        = slug_with_random_number($unduhan->title);
            $unduhan->is_private  = isset($request->is_private) && $request->is_private;

            $berkas = $request->berkas;

            //  Process mime
            try {
                $unduhan->mime = $berkas->getMimeType();
            } catch (\Throwable $th) {
                $unduhan->mime = $berkas->getClientMimeType();
            }

            //  handle file
            $berkasName = generate_filename($berkas->getClientOriginalExtension(), $unduhan->title);
            $berkas->move(Unduhan::UPLOAD_PATH, $berkasName);
            $unduhan->file = $berkasName;

            $unduhan->save();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->jsonError([$th, "Gagal menambah unduhan"]);
        }

        return $this->jsonSuccess("Berhasil menambah unduhan");
    }

    public function update(Request $request)
    {
        $validasi = validator($request->all(), [
            '_id'      => 'required|integer',
            'title'    => 'required|min:3',
            'category' => 'required|integer',
        ]);
        $this->responseFailsValidation($validasi);

        $unduhan = Unduhan::whereId($request->_id)->first();
        if (!$unduhan) {
            return $this->jsonError('Unduhan tidak ditemukan');
        }

        $unduhan->title       = $request->title;
        $unduhan->category_id = $request->category;
        $unduhan->is_private  = isset($request->is_private) && $request->is_private;

        if (!$unduhan->save()) {
            return $this->jsonError('Gagal memperbaharui data unduhan');
        }

        return $this->jsonSuccess('Berhasil memperbaharui data unduhan');
    }

    public function destroy(Request $request)
    {
        $validasi = validator($request->all(), [
            'id' => 'required|integer',
        ]);
        $this->responseFailsValidation($validasi);
        
        $data = Unduhan::hasId($request->id)->first();
        
        if (! $data) {
            return $this->jsonError('Unduhan tidak ditemukan');
        }

        if (! $data->delete()) {
            return $this->jsonError('Gagal menghapus unduhan');
        }

        return $this->jsonSuccess('Berhasil menghapus unduhan');
    }
}
