<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;

class PegawaiController extends Controller
{
    protected $viewPath = 'admin.pegawai.';

    public function datatable(Request $request)
    {
        $list = Pegawai::select([
            'id',
            'name',
            'position',
            'image',
        ])
            ->orderBy('order')
            ->get();

        return $this->jsonSuccess('', [
            'data' => [
                'foto_url' => url('uploads/pegawai') . '/',
                'pegawai' => $list,
            ],
        ]);
    }

    public function store(Request $request)
    {
        $validasi = validator($request->all(), [
            'name'     => 'required|min:3',
            'position' => 'required',
        ]);
        $this->responseFailsValidation($validasi);

        try {
            DB::beginTransaction();

            $pegawai = new Pegawai;
            $pegawai->name     = $request->name;
            $pegawai->position = $request->position;
            $pegawai->content  = $request->content;

            if ($request->image) {
                $foto = Image::make($request->image);
                $fotoName = generate_filename('png', $pegawai->name);
                $foto->save(Pegawai::UPLOAD_PATH . $fotoName);

                $pegawai->image = $fotoName;
            }
            
            $pegawai->save();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            if (isset($fotoName)) {
                try_delete_if_exists(Pegawai::UPLOAD_PATH . $fotoName);
            }

            return $this->jsonError([$th, "Gagal menambah data pegawai"]);
        }
        
        return $this->jsonSuccess("Berhasil menambah data pegawai", [
            'data' => [
                'id'    => $pegawai->id,
                'image' => $pegawai->image,
            ],
        ]);
    }

    public function edit(Request $request)
    {
        $data = Pegawai::whereId($request->id)->first();
        if (! $data) {
            return $this->jsonError('Data tidak ditemukan');
        }

        $data = $data->only('id', 'name', 'position', 'image', 'content');

        return $this->jsonSuccess('', [
            'data' => $data,
        ]);
    }

    public function update(Request $request)
    {
        $validasi = validator($request->all(), [
            '_id'      => 'required|integer',
            'name'     => 'required|min:3',
            'position' => 'required',
        ]);
        $this->responseFailsValidation($validasi);

        $pegawai = Pegawai::whereId($request->_id)->first();
        if (! $pegawai) {
            return $this->jsonError('Data tidak ditemukan');
        }

        try {
            DB::beginTransaction();
            
            $pegawai->name     = $request->name;
            $pegawai->position = $request->position;
            $pegawai->content  = $request->content;

            if ($request->image) {
                $foto = Image::make($request->image);
                $fotoName = generate_filename('png', $pegawai->name);
                $foto->save(Pegawai::UPLOAD_PATH . $fotoName);

                if ($pegawai->image) {
                    $fotoOld = $pegawai->image;
                }

                $pegawai->image = $fotoName;
            }
            
            $pegawai->save();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            
            if (isset($fotoName)) {
                try_delete_if_exists(Pegawai::UPLOAD_PATH . $fotoName);
            }

            return $this->jsonError([$th, "Gagal memperbaharui data pegawai"]);
        }

        if (isset($fotoOld)) {
            try_delete_if_exists(Pegawai::UPLOAD_PATH . $fotoOld);
        }
        
        return $this->jsonSuccess("Berhasil memperbaharui data pegawai", [
            'data' => [
                'image' => $pegawai->image,
            ],
        ]);
    }

    public function destroy(Request $request)
    {
        //  Validasi
        $validasi = validator($request->all(), [
            'id' => 'required|integer',
        ]);
        $this->responseFailsValidation($validasi);

        $data = Pegawai::whereId($request->id)->first();
        if (! $data) {
            return $this->jsonError('Data tidak ditemukan');
        }
        
        if (! $data->delete()) {
            return $this->jsonError('Gagal menghapus data');
        }

        try_delete_if_exists(Pegawai::UPLOAD_PATH . $data->image);

        return $this->jsonSuccess('Berhasil menghapus data');
    }

    public function putOrder(Request $request)
    {
        try {
            DB::beginTransaction();
            
            $queryUrut = "UPDATE `" . Pegawai::table() . "` SET `order` = CASE `id`";
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
