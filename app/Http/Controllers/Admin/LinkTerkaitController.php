<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LinkTerkait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;

class LinkTerkaitController extends Controller
{
    public $viewPath = 'admin.link-terkait.';

    public function datatable(Request $request)
    {
        $data = LinkTerkait::select([
            'id',
            'name',
            'image',
            'link',
            ])
            ->orderBy('position', 'ASC')
            ->get();

        foreach ($data as $item) {
            $item->image = $item->logo_image;
        }

        return $this->jsonSuccess('', [
            'data' => $data,
        ]);
    }

    public function create(Request $request)
    {
        return $this->view('modal-form');
    }

    public function edit(Request $request)
    {
        $data = LinkTerkait::whereId($request->id)->first();
        if (! $data) {
            return $this->jsonError('Data tidak ditemukan');
        }

        return $this->view('modal-form', compact('data'));
    }

    public function store(Request $request)
    {
        $validasi = validator($request->all(), [
            'name' => 'required|min:3',
            'link' => 'required|url',
            'logo' => 'required',
        ]);
        $this->responseFailsValidation($validasi);

        $item = new LinkTerkait;
        $item->name = $request->name; 
        $item->link = $request->link;

        $logo = Image::make($request->logo);
        $logoName = generate_filename('png', $item->name);
        $logo->fit(400, 200)->save(LinkTerkait::UPLOAD_PATH . $logoName);

        $item->image = $logoName;

        if (! $item->save()) {
            if (isset($logoName)) {
                try_delete_if_exists(LinkTerkait::UPLOAD_PATH . $logoName);
            }

            return $this->jsonError('Gagal menyimpan data');
        }

        return $this->jsonSuccess('Data berhasil tersimpan');
    }

    public function update(Request $request)
    {
        $validasi = validator($request->all(), [
            '_id'   => 'required|integer',
            'name' => 'required|min:3',
            'link' => 'required|url',
        ]);
        $this->responseFailsValidation($validasi);

        $data = LinkTerkait::whereId($request->_id)->first();
        if (! $data) {
            return $this->jsonError('Data tidak ditemukan');
        }

        try {
            DB::beginTransaction();
            
            $data->name = $request->name; 
            $data->link = $request->link;

            if ($request->logo) {
                $logo = Image::make($request->logo);
                $logoName = generate_filename('png', $data->name);
                $logo->fit(400, 200)->save(LinkTerkait::UPLOAD_PATH . $logoName);
        
                $logoOld = $data->image;
                $data->image = $logoName;
            }

            $data->save();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            if (isset($logoName)) {
                try_delete_if_exists(LinkTerkait::UPLOAD_PATH . $logoName);
            }

            return $this->jsonError([$th, "Gagal memperbaharui data"]);
        }

        if (isset($logoOld)) {
            try_delete_if_exists(LinkTerkait::UPLOAD_PATH . $logoOld);
        }
        
        return $this->jsonSuccess("Berhasil memperbaharui data");
    }

    public function destroy(Request $request)
    {
        //  Validasi
        $validasi = validator($request->all(), [
            'id' => 'required|integer',
        ]);
        $this->responseFailsValidation($validasi);

        $data = LinkTerkait::whereId($request->id)->first();
        if (! $data) {
            return $this->jsonError('Data tidak ditemukan');
        }
        
        if (! $data->delete()) {
            return $this->jsonError('Gagal menghapus data');
        }

        try_delete_if_exists(LinkTerkait::UPLOAD_PATH . $data->image);

        return $this->jsonSuccess('Berhasil menghapus data');
    }

    public function putOrder(Request $request)
    {
        try {
            DB::beginTransaction();
            
            $queryUrut = "UPDATE `" . LinkTerkait::table() . "` SET `position` = CASE `id`";
            $idList = [];

            foreach ($request->order as $order => $id) {
                $queryUrut .= " WHEN " . $id . " THEN " . $order;
                $idList[] = $id; 
            }
            
            $queryUrut .= " END WHERE `id` IN (" . implode(",", $idList) . ")";

            DB::update($queryUrut);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->jsonError([$th, "Gagal menyimpan urutan"]);
        }
        
        return $this->jsonSuccess("Berhasil menyimpan urutan");
    }
}
