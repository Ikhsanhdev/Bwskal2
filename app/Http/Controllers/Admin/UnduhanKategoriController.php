<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Unduhan;
use App\Models\UnduhanKategori;
use AyatKyo\Klorovel\DataTable\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UnduhanKategoriController extends Controller
{
    public $viewPath = 'admin.unduhan.kategori.';

    public function datatable(Request $request)
    {
        $data = UnduhanKategori::select([
            UnduhanKategori::table('id'),
            UnduhanKategori::table('name'),
            UnduhanKategori::table('slug'),
        ]);

        $datatable = DataTables::makeWithSearch($data, [
            UnduhanKategori::table('name'),
        ]);
        
        return $datatable->toJson();
    }

    
    public function create(Request $request)
    {
        return $this->view('modal-form');
    }

    public function edit(Request $request)
    {
        $data = UnduhanKategori::hasId($request->id)->first();
        if (! $data) {
            return $this->jsonError('Kategori unduhan tidak ditemukan');
        }
        
        return $this->view('modal-form', [
            'data' => $data,
        ]);
    }

    public function store(Request $request)
    {
        $validasi = validator($request->all(), [
            'name' => 'required|min:3|uniq_slug_model:UnduhanKategori',
        ], [
            'name.uniq_slug_model' => 'Kategori ini sudah ada'
        ]);
        $this->responseFailsValidation($validasi);

        try {
            DB::beginTransaction();
            
            $data = new UnduhanKategori;
            $data->name = $request->name;
            $data->slug = Str::slug($data->name);
            $data->save();

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->jsonError([$th, "Gagal menambah kategori unduhan"]);
        }
        
        return $this->jsonSuccess("Berhasil menambah kategori unduhan");
    }

    public function update(Request $request)
    {
        $validasi = validator($request->all(), [
            '_id'  => 'required|integer',
            'name' => 'required|min:3|uniq_slug_model:UnduhanKategori,slug,@_id',
        ], [
            'name.uniq_slug_model' => 'Kategori ini sudah ada'
        ]);
        $this->responseFailsValidation($validasi);

        $data = UnduhanKategori::hasId($request->_id)->first();
        if (! $data) {
            return $this->jsonError('Kategori unduhan tidak ditemukan');
        }
        
        try {
            DB::beginTransaction();
            
            $data->name = $request->name;
            $data->slug = Str::slug($data->name);
            $data->save();

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->jsonError([$th, "Gagal memperbaharui kategori unduhan"]);
        }
        
        return $this->jsonSuccess("Berhasil memperbaharui kategori unduhan");
    }

    public function destroy(Request $request)
    {
        $validasi = validator($request->all(), [
            'id' => 'required|integer',
        ]);
        $this->responseFailsValidation($validasi);

        $data = UnduhanKategori::hasId($request->id)->first();
        if (! $data) {
            return $this->jsonError('Kategori Unduhan tidak ditemukan');
        }

        try {
            DB::beginTransaction();

            Unduhan::whereCategoryId($data->id)
                ->update([
                    'category_id' => 0,
                ]);

            if (! $data->delete())
                throw new \Exception();
            
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->jsonError([$th, "Gagal menghapus Kategori Unduhan"]);
        }
        
        return $this->jsonSuccess("Berhasil menghapus Kategori Unduhan");
    }
}
