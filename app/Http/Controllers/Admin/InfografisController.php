<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Infografis;
use App\Models\User;
use AyatKyo\Klorovel\DataTable\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;

class InfografisController extends Controller
{
    public $viewPath = 'admin.infografis.';

    public function datatable(Request $request)
    {
        $data = Infografis::select([
            Infografis::table('id'),
            Infografis::table('name'),
            User::table('fullname as author'),
            Infografis::table('path'),
            Infografis::table('created_at'),
        ])
            ->joinUser()
            ->orderBy(Infografis::table('created_at'), 'DESC');

        $datatable = DataTables::makeWithSearch($data, [
            Infografis::table('nama'),
            User::table('fullname'),
        ]);

        return $datatable->toJson();
    }

    public function create(Request $request)
    {
        return $this->view('modal-form');
    }

    public function edit(Request $request)
    {
        $data = Infografis::whereId($request->id)->first();
        if (!$data) {
            return $this->jsonError('Poster tidak ditemukan');
        }

        return $this->view('modal-form', [
            'data' => $data,
        ]);
    }

    public function store(Request $request)
    {
        $validasi = validator($request->all(), [
            'name'  => 'required|min:2',
            'image' => 'required',
        ]);
        $this->responseFailsValidation($validasi);

        try {
            DB::beginTransaction();

            $infografis = new Infografis;
            $infografis->user_id = Auth::id();
            $infografis->name = $request->name;
            $infografis->slug = slug_with_random_number($infografis->name);

            $image = $request->image;
            $imageName = generate_filename($image, $infografis->name);
            $imageSource = Image::make($image);

            //  Create preview
            $imageSource
                ->widen(730)
                ->save(Infografis::UPLOAD_PATH . 'preview_' . $imageName);

            //  Create thumbs
            $imageSource
                ->fit(300, 300)
                ->save(Infografis::UPLOAD_PATH . 'thumbs_' . $imageName);

            //  Move file
            $image->move(Infografis::UPLOAD_PATH, $imageName);

            $infografis->path = $imageName;

            $infografis->save();

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            if (isset($imageName)) {
                try_delete_if_exists(Infografis::UPLOAD_PATH . $imageName);
                try_delete_if_exists(Infografis::UPLOAD_PATH . 'preview_' . $imageName);
                try_delete_if_exists(Infografis::UPLOAD_PATH . 'thumbs_' . $imageName);
            }

            return $this->jsonError([$th, "Gagal menyimpan poster"]);
        }

        return $this->jsonSuccess("Berhasil menyimpan poster");
    }

    public function update(Request $request)
    {
        $validasi = validator($request->all(), [
            '_id'  => 'required|integer',
            'name' => 'required|min:2',
        ]);
        $this->responseFailsValidation($validasi);

        $infografis = Infografis::whereId($request->_id)->first();
        if (!$infografis) {
            return $this->jsonError('Poster tidak ditemukan');
        }

        try {
            DB::beginTransaction();

            $infografis->name = $request->name;

            if ($request->image) {
                $image = $request->image;
                $imageName = generate_filename($image, $infografis->name);
                $imageSource = Image::make($image);

                //  Create preview
                $imageSource
                    ->widen(730)
                    ->save(Infografis::UPLOAD_PATH . 'preview_' . $imageName);

                //  Create thumbs
                $imageSource
                    ->fit(300, 300)
                    ->save(Infografis::UPLOAD_PATH . 'thumbs_' . $imageName);

                //  Move file
                $image->move(Infografis::UPLOAD_PATH, $imageName);

                $oldImage = $infografis->path;
                $infografis->path = $imageName;
            }

            $infografis->save();

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            if (isset($imageName)) {
                try_delete_if_exists(Infografis::UPLOAD_PATH . $imageName);
                try_delete_if_exists(Infografis::UPLOAD_PATH . 'preview_' . $imageName);
                try_delete_if_exists(Infografis::UPLOAD_PATH . 'thumbs_' . $imageName);
            }

            return $this->jsonError([$th, "Gagal memperbaharui poster"]);
        }

        if (isset($oldImage)) {
            try_delete_if_exists(Infografis::UPLOAD_PATH . $oldImage);
            try_delete_if_exists(Infografis::UPLOAD_PATH . 'preview_' . $oldImage);
            try_delete_if_exists(Infografis::UPLOAD_PATH . 'thumbs_' . $oldImage);
        }

        return $this->jsonSuccess("Berhasil memperbaharui poster");
    }

    public function destroy(Request $request)
    {
        $validasi = validator($request->all(), [
            'id' => 'required|integer',
        ]);
        $this->responseFailsValidation($validasi);

        $item = Infografis::hasId($request->id)->first();
        if (!$item) {
            return $this->jsonError('Poster tidak ditemukan');
        }

        if (!$item->delete()) {
            return $this->jsonError('Gagal menghapus poster');
        }

        try_delete_if_exists(Infografis::UPLOAD_PATH . $item->path);
        try_delete_if_exists(Infografis::UPLOAD_PATH . 'preview_' . $item->path);
        try_delete_if_exists(Infografis::UPLOAD_PATH . 'thumbs_' . $item->path);

        return $this->jsonSuccess('Berhasil menghapus poster');
    }
}
