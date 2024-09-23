<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostCategory;
use AyatKyo\Klorovel\DataTable\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PostCategoryController extends Controller
{
    public $viewPath = 'admin.post-category.';

    public function datatable(Request $request)
    {
        $data = PostCategory::select([
            PostCategory::table('id'),
            PostCategory::table('name'),
            PostCategory::table('slug'),
            ])
            ->whereIsDefault(false);

        $datatable = DataTables::makeWithSearch($data, [
            PostCategory::table('name'),
        ]);
        
        return $datatable->toJson();
    }

    public function create(Request $request)
    {
        return $this->view('modal-form', [

        ]);
    }

    public function edit(Request $request)
    {
        $data = PostCategory::hasId($request->id)
            ->whereIsDefault(false)
            ->first();
        if (! $data) {
            return $this->jsonError('Kategori berita tidak ditemukan');
        }
        
        return $this->view('modal-form', [
            'data' => $data,
        ]);
    }

    public function store(Request $request)
    {
        $validasi = validator($request->all(), [
            'name' => 'required|min:3|uniq_slug_model:PostCategory',
        ], [
            'name.uniq_slug_model' => 'Kategori ini sudah ada'
        ]);
        $this->responseFailsValidation($validasi);

        try {
            DB::beginTransaction();
            
            $data = new PostCategory;
            $data->name = $request->name;
            $data->slug = Str::slug($data->name);
            $data->save();

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->jsonError([$th, "Gagal menambah kategori berita"]);
        }
        
        return $this->jsonSuccess("Berhasil menambah kategori berita");
    }

    public function update(Request $request)
    {
        $validasi = validator($request->all(), [
            '_id'  => 'required|integer',
            'name' => 'required|min:3|uniq_slug_model:PostCategory,slug,@_id',
        ], [
            'name.uniq_slug_model' => 'Kategori ini sudah ada'
        ]);
        $this->responseFailsValidation($validasi);

        $data = PostCategory::hasId($request->_id)
            ->whereIsDefault(false)
            ->first();
        if (! $data) {
            return $this->jsonError('Kategori berita tidak ditemukan');
        }
        
        try {
            DB::beginTransaction();
            
            $data->name = $request->name;
            $data->slug = Str::slug($data->name);
            $data->save();

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->jsonError([$th, "Gagal memperbaharui kategori berita"]);
        }
        
        return $this->jsonSuccess("Berhasil memperbaharui kategori berita");
    }

    public function destroy(Request $request)
    {
        $validasi = validator($request->all(), [
            'id' => 'required|integer',
        ]);
        $this->responseFailsValidation($validasi);

        $data = PostCategory::hasId($request->id)
            ->whereIsDefault(false)
            ->first();
        if (! $data) {
            return $this->jsonError('Kategori Berita tidak ditemukan');
        }

        try {
            DB::beginTransaction();

            Post::whereCategoryId($data->id)
                ->update([
                    'category_id' => 0,
                ]);

            if (! $data->delete())
                throw new \Exception();
            
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->jsonError([$th, "Gagal menghapus Kategori Berita"]);
        }
        
        return $this->jsonSuccess("Berhasil menghapus Kategori Berita");
    }
}
