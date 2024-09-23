<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\KontakForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KontakController extends Controller
{
    public $viewPath = 'web.kontak.';
    
    public function index(Request $request)
    {
        if ($request->has('done')) {
            return $this->view('done');
        }

        return $this->view('index');
    }

    public function store(Request $request)
    {
        $input = validator($request->all(), [
            'name'                 => 'required|min:3',
            'email'                => 'required|email',
            'contact'              => 'required',
            'topic'                => 'required',
            'content'              => 'required',
            'g-recaptcha-response' => 'required|captcha'
        ]);
        $this->responseFailsValidation($input);

        try {
            DB::beginTransaction();

            $data = KontakForm::create($input->validated());

            //  Kirim email ke admin?

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            return $this->jsonError([$th, 'Gagal mengirim pesan']);
        }

        return $this->jsonSuccess('Pesan berhasil dikirim', [
            'redir' => route('web.kontak.index') . '?done',
        ]);
    }
}
