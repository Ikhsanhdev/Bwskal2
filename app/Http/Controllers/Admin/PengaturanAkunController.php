<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;

class PengaturanAkunController extends Controller
{
    protected $viewPath = 'admin.pengaturan-akun.';
    public $uploadPath = 'uploads/avatar/';

    public function index(Request $request)
    {
        return $this->view('index', [
            'data' => $request->user,
        ]);
    }

    public function update(Request $request)
    {
        //  Validasi
        $validasi = validator($request->all(), [
            'name'                  => 'required|min:2',
            'username'              => "required|min:2|unique:users,username,{$request->user->id}",
            'email'                 => "required|email|unique:users,email,{$request->user->id}",
            'sandi_baru'            => 'nullable|required_with:sandi_baru_konfirmasi,sandi_lama|min:5',
            'sandi_baru_konfirmasi' => 'nullable|required_with:sandi_baru,sandi_lama|min:5|same:sandi_baru',
        ]);
        $this->responseFailsValidation($validasi);

        try {
            DB::beginTransaction();

            $user = $request->user;
            $user->username = $request->username;
            $user->fullname = $request->name;
            $user->email = $request->email;

            if ($request->avatar) {
                $avatar = Image::make($request->avatar);
                $avatarName = generate_filename('png', $user->fullname);
                $avatar->save('uploads/avatar/' . $avatarName);

                if ($user->avatar) {
                    $avatarOld = $user->avatar;
                }
                $user->avatar = $avatarName;
            }

            //  Proses sandi
            if ($request->sandi_baru_konfirmasi) {
                $user->password = bcrypt($request->sandi_baru_konfirmasi);
            }
            
            $user->save();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            if (isset($avatarName)) {
                try_delete_if_exists('uploads/avatar/' . $avatarName);
            }

            return $this->jsonError([$th, "Gagal memperbaharui data akun"]);
        }

        if (isset($avatarOld)) {
            try_delete_if_exists('uploads/avatar/' . $avatarOld);
        }
        
        return $this->jsonSuccess("Berhasil memperbaharui data akun", [
            'redir' => route('admin.pengaturan-akun.index'),
        ]);
    }
}
