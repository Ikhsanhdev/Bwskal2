<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\ResetSandiMail;
use App\Models\User;
use AyatKyo\Klorovel\Core\Facades\KlorovelEncryption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

class LupaSandiController extends Controller
{
    public function index(Request $request)
    {
        return view('auth.lupa-sandi');
    }

    public function store(Request $request)
    {
        $input = validator($request->all(), [
            'email' => 'required|email',
        ]);
        $this->responseFailsValidation($input);

        $user = User::whereEmail($request->email)
            ->whereStatus(User::STATUS_ACTIVE)
            ->first();
        if ($user) {
            try {
                $link = URL::temporarySignedRoute('reset-sandi.index', now()->addMonths(1), [
                    'token' => KlorovelEncryption::encrypt(time() . '::' . $user->email . '::' . time()),
                ]);
                Mail::to($user->email)
                    ->send(new ResetSandiMail([
                        'user' => $user,
                        'link' => $link,
                    ]));
            } catch (\Throwable $th) {
                return $this->jsonError("Instruksi reset sandi gagal dikirim");
            }
        }

        return $this->jsonSuccess("Instruksi berhasil dikirim", [
            'redir' => route('login') . '?lupa-sandi-success',
        ]);
    }
}
