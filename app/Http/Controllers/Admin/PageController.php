<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use AyatKyo\Klorovel\DataTable\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    protected $viewPath = 'admin.page.';

    public function datatable(Request $request)
    {
        $data = Page::select([
            'id',
            'title',
            'slug',
            'updated_at',
            ])
            ->orderBy(Page::table('updated_at'), 'desc');

        $datatable = DataTables::makeWithSearch($data, [
            Page::table('title'),
            Page::table('slug'),
        ]);

        return $datatable->toJson();
    }

    public function create(Request $request)
    {
        return $this->view('form');
    }

    public function edit(Request $request, $id)
    {
        $data = Page::hasId($id)->first();
        if (!$data) {
            return redirect()
                ->route('admin.page.index')
                ->with('error', 'Halaman tidak ditemukan');
        }

        $data->content = decode_local_upload($data->content);

        return $this->view('form', [
            'data' => $data,
        ]);
    }

    public function store(Request $request)
    {
        //  Validasi
        $validasi = validator($request->all(), [
            'title'   => 'required',
            'content' => 'required',
            'url'     => 'required|alpha_dash|routable',
        ]);
        $this->responseFailsValidation($validasi);

        try {
            DB::beginTransaction();
            
            $page = new Page;
            $page->user_id = Auth::id();
            $page->title = $request->title;
            $page->content = $request->content;
            $page->slug = $request->url;
            $page->is_custom_slug = $request->is_custom_slug ? 1 : 0;
            $page->save();

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->jsonError([$th, "Gagal menyimpan halaman"]);
        }

        return $this->jsonSuccess("Berhasil menyimpan halaman", [
            'redir' => route('admin.page.index'),
        ]);
    }

    public function update(Request $request)
    {
        //  Validasi
        $validasi = validator($request->all(), [
            '_id'     => 'required|integer',
            'title'   => 'required',
            'content' => 'required',
            'url'     => 'required|alpha_dash|routable',
        ]);
        $this->responseFailsValidation($validasi);

        $page = Page::hasId($request->_id)->first();
        if (!$page) {
            return $this->jsonError('Halaman tidak ditemukan');
        }

        try {
            $page->title = $request->title;
            $page->content = $request->content;
            $page->slug = $request->url;
            $page->is_custom_slug = $request->is_custom_slug ? 1 : 0;
            $page->save();
        } catch (\Throwable $th) {
            return $this->jsonError([$th, "Gagal memperbaharui halaman"]);
        }

        return $this->jsonSuccess("Berhasil memperbaharui halaman");
    }

    public function destroy(Request $request)
    {
        $validasi = validator($request->all(), [
            'id' => 'required|integer',
        ]);
        $this->responseFailsValidation($validasi);

        $data = Page::hasId($request->id)->first();
        if (! $data) {
            return $this->jsonError('Halaman tidak ditemukan');
        }

        if (! $data->delete()) {
            return $this->jsonError("Gagal menghapus halaman");
        }

        return $this->jsonSuccess("Berhasil menghapus halaman");
    }
}
