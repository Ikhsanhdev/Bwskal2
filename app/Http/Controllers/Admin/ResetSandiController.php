<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use AyatKyo\Klorovel\Core\Facades\KlorovelEncryption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResetSandiController extends Controller
{
    public function index(Request $request)
    {
        try {
            if (!$request->hasValidSignature()) {
                throw new \Exception("Invalid URL");
            }

            [$_, $email, $_] = explode("::", KlorovelEncryption::decrypt($request->route('token')));
            $user = User::whereEmail($email)
                ->whereStatus(User::STATUS_ACTIVE)
                ->first();

            if (! $user) {
                throw new \Exception("Invalid user");
            }
        } catch (\Throwable $th) {
            return view('errors.common', [
                'icon'         => 'mdi-file-search-outline',
                'messageTitle' => 'RESET SANDI',
                'message'      => 'Token tidak valid atau sudah kadaluwarsa',
            ]);
        }

        return view('auth.reset-sandi');
    }

    public function update(Request $request)
    {
        $input = validator($request->all(), [
            'sandibaru'            => 'required|min:5',
            'sandibaru_konfirmasi' => 'required|min:5|same:sandibaru',
        ]);
        $this->responseFailsValidation($input);

        try {
            if (!$request->hasValidSignature()) {
                throw new \Exception("Invalid signature");
            }

            [$_, $email, $_] = explode("::", KlorovelEncryption::decrypt($request->route('token')));
            $user = User::whereEmail($email)
                ->whereStatus(User::STATUS_ACTIVE)
                ->first();

            if (! $user) {
                throw new \Exception("Invalid user");
            }
        } catch (\Throwable $th) {
            return $this->jsonError('URL tidak valid atau sudah kadaluwarsa');
        }

        try {
            DB::beginTransaction();
            $user->password = bcrypt($request->sandibaru_konfirmasi);
            $user->save();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->jsonError('Gagal reset sandi, silakan dicoba kembali');
        }

        return $this->jsonSuccess("Reset Sandi berhasil, silakan login dengan sandi baru anda", [
            'redir' => route('login') . '?reset-sandi-success',
        ]);
    }
}
