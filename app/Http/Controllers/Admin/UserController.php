<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use AyatKyo\Klorovel\DataTable\DataTables;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    protected $viewPath = 'admin.user.';

    public function datatable(Request $request)
    {
        $roleIgnore = ['supermin'];

        $data = User::where('id', '<>', $request->user->id)
            ->whereNotIn('role', $roleIgnore);

        $datatable = DataTables::makeWithSearch($data, [
            User::table('fullname'),
        ]);

        return $datatable->toJson();
    }

    public function create(Request $request)
    {
        $roleList = User::getRoleList();
        if ($request->user->role != 'supermin') {
            Arr::forget($roleList, 'supermin');
        }

        return $this->view('modal-form', [
            'roleList' => $roleList,
        ]);
    }

    public function edit(Request $request)
    {
        //  TODO limit yang bisa edit
        $data = User::whereId($request->id)->first();
        if (!$data) {
            return $this->jsonError('Pengguna tidak ditemukan');
        }

        $roleList = User::getRoleList();
        if ($request->user->role != 'supermin') {
            Arr::forget($roleList, 'supermin');
        }

        return $this->view('modal-form', [
            'data' => $data,
            'roleList' => $roleList,
        ]);
    }

    public function store(Request $request)
    {
        //  Validasi
        $rule = [
            'role'     => 'required',
            'nama'     => 'required',
            'email'    => 'nullable|email|unique:App\Models\User,email',
            'username' => 'required|unique:App\Models\User,username',
            'status'   => 'required',
            'sandi'    => 'required|confirmed',
        ];

        $validasi = validator($request->all(), $rule);
        $this->responseFailsValidation($validasi);

        try {
            DB::beginTransaction();

            //  Create User
            $user           = new User;
            $user->role     = $request->role;
            $user->fullname = $request->nama;
            $user->username = $request->username;
            $user->email    = $request->email;
            $user->status   = $request->status;
            $user->password = bcrypt($request->sandi_confirmation);

            if ($request->avatar) {
                $avatar = Image::make($request->avatar);
                $avatarName = generate_filename('png', $user->fullname);
                $avatar->save('uploads/avatar/' . $avatarName);

                $user->avatar = $avatarName;
            }

            $user->save();

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            if (isset($avatarName)) {
                try_delete_if_exists('uploads/avatar/' . $avatarName);
            }

            return $this->jsonError([$th, "Gagal membuat Akun Pengguna"]);
        }

        return $this->jsonSuccess("Berhasil membuat Akun Pengguna");
    }

    public function update(Request $request)
    {
        //  Validasi
        $validasi = validator($request->all(), [
            '_id'      => 'required|integer',
            'nama'     => 'required',
            'email'    => 'nullable|email|unique:App\Models\User,email,' . $request->_id,
            'username' => 'required|unique:App\Models\User,username,' . $request->_id,
            'status'   => 'required',
            'sandi'    => 'sometimes|confirmed',
        ]);
        $this->responseFailsValidation($validasi);

        try {
            DB::beginTransaction();

            //  Cari user
            $user = User::whereId($request->_id)->first();
            if (!$user) {
                return $this->jsonError('Akun Pengguna tidak ditemukan');
            }

            $user->fullname = $request->nama;
            $user->username = $request->username;
            $user->email    = $request->email;
            $user->status   = $request->status;

            if ($request->avatar) {
                $avatar = Image::make($request->avatar);
                $avatarName = generate_filename('png', $user->fullname);
                $avatar->save('uploads/avatar/' . $avatarName);

                if ($user->avater) {
                    $avatarOld = $user->avatar;
                }
                $user->avatar = $avatarName;
            }

            //  Handle sandi
            if ($request->sandi_confirmation) {
                $user->password = bcrypt($request->sandi_confirmation);
            }

            $user->save();

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            if (isset($avatarName)) {
                try_delete_if_exists('uploads/avatar/' . $avatarName);
            }

            return $this->jsonError([$th, "Gagal memperbaharui Akun Pengguna"]);
        }
        
        if (isset($avatarOld)) {
            try_delete_if_exists('uploads/avatar/' . $avatarOld);
        }

        return $this->jsonSuccess("Berhasil memperbaharui Akun Pengguna");
    }

    public function destroy(Request $request)
    {
        //  Validasi
        $validasi = validator($request->all(), [
            'id' => 'required|integer',
        ]);
        $this->responseFailsValidation($validasi);

        $data = User::whereId($request->id);

        $data = $data->first();
        if (!$data) {
            return $this->jsonError('Pengguna tidak ditemukan');
        }

        try {
            DB::beginTransaction();

            $data->delete();

            //  TODO hapus data terkait?

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->jsonError([$th, "Gagal menghapus pengguna"]);
        }

        if ($data->avatar) {
            delete_if_exists('uploads/avatar/' . $data->avatar);
        }

        return $this->jsonSuccess("Berhasil menghapus pengguna");
    }
}
