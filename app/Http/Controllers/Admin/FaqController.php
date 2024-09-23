<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FaqController extends Controller
{
    public $viewPath = 'admin.faq.';

    public function datatable(Request $request)
    {
        $data = Faq::select([
            'id',
            'title',
            'is_show',
            'updated_at',
            ])
            ->orderBy('position', 'ASC')
            ->get();

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
        $data = Faq::whereId($request->id)->first();
        if (! $data) {
            return $this->jsonError('Data tidak ditemukan');
        }

        return $this->view('modal-form', compact('data'));
    }

    public function store(Request $request)
    {
        $validasi = validator($request->all(), [
            'title'   => 'required|min:3',
            'content' => 'required',
        ]);
        $this->responseFailsValidation($validasi);

        $item = new Faq;
        $item->user_id = Auth::id();
        $item->title   = $request->title;
        $item->slug    = slug_with_random_number($item->title);
        $item->content = $request->content;
        $item->is_show = $request->has('is_show');

        if (! $item->save()) {
            return $this->jsonError('Gagal menyimpan data');
        }

        return $this->jsonSuccess('Data berhasil tersimpan');
    }

    public function update(Request $request)
    {
        $validasi = validator($request->all(), [
            '_id'     => 'required|integer',
            'title'   => 'required|min:3',
            'content' => 'required',
        ]);
        $this->responseFailsValidation($validasi);

        $data = Faq::whereId($request->_id)->first();
        if (! $data) {
            return $this->jsonError('Data tidak ditemukan');
        }

        $data->title   = $request->title;
        $data->content = $request->content;
        $data->is_show = $request->has('is_show');
        
        if (!$data->save()) {
            return $this->jsonError('Gagal memperbaharui data');
        }

        return $this->jsonSuccess("Berhasil memperbaharui data");
    }

    public function destroy(Request $request)
    {
        $validasi = validator($request->all(), [
            'id' => 'required|integer',
        ]);
        $this->responseFailsValidation($validasi);

        $data = Faq::whereId($request->id)->first();
        if (! $data) {
            return $this->jsonError('Data tidak ditemukan');
        }
        
        if (! $data->delete()) {
            return $this->jsonError('Gagal menghapus data');
        }

        return $this->jsonSuccess('Berhasil menghapus data');
    }

    public function putOrder(Request $request)
    {
        try {
            DB::beginTransaction();
            
            $queryUrut = "UPDATE `" . Faq::table() . "` SET `position` = CASE `id`";
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
