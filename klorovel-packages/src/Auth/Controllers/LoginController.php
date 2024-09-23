<?php

namespace AyatKyo\Klorovel\Auth\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use AyatKyo\Klorovel\Core\Traits\ControllerTrait;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    use ControllerTrait;

    protected $redirectTo = 'admin';

    public $errorMessage;


    public function show(Request $request)
    {
        return $this->view('auth.login');
    }

    //  TODO customizable input name
    public function store(Request $request)
    {
        //  Validate
        $withUsername = config('klorovel.packages.Auth.with_username', true);
        $penggunaRule = 'required|string|min:3|email';
        if ($withUsername) {
            $penggunaRule = 'required|string|min:3';
        }

        $validasi = validator()->make($request->all(), [
            'pengguna' => $penggunaRule,
            'sandi' => 'required|string',
        ]);
        $this->responseFailsValidation($validasi);

        //  Check rate limit
        $this->ensureIsNotRateLimited($request);

        $loginType = 'email';

        //  Cek apakah yang diinput adalah email
        if ($withUsername) {
            $loginType = filter_var($request->pengguna, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        }

        $loginData = [
            $loginType => $request->input('pengguna'),
            'password' => $request->input('sandi'),
        ];

        //  Attempt login
        if (!Auth::attempt($loginData, $request->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey($request));

            return $this->responseValidationErrors(ValidationException::withMessages([
                'pengguna' => trans('auth.failed'),
            ])->errors());
        }

        //  Check account status
        $hasStatus = config('klorovel.packages.Auth.has_status', false);
        if ($hasStatus && Auth::user()->role !== User::ROLE_SUPERMIN && Auth::user()->status != 'active') {
            $userStatus = Auth::user()->status;
            Auth::logout();

            $errorMessage = '';
            switch ($userStatus) {
                case 'pending':
                    $errorMessage = 'Akun belum aktif, silakan periksa email untuk verifikasi';
                    break;
                case 'freeze':
                    $errorMessage = 'Akun nonaktif, kontak admin untuk mengaktifkan kembali akun anda.';
                    break;
                case 'banned':
                    $errorMessage = 'Akun dibanned, kontak admin untuk mengaktifkan kembali akun anda.';
                    break;
                default:
                    $errorMessage = 'Status akun tidak dikenali "' . $userStatus . '".';
                    break;
            }

            return $this->responseValidationErrors(ValidationException::withMessages([
                'pengguna' => $errorMessage,
            ])->errors());
        }

        //  Handle success login
        //  Clear rate limit
        RateLimiter::clear($this->throttleKey($request));

        $request->session()->regenerate();

        //  Ajax response
        if ($request->ajax()) {
            return $this->jsonSuccess('Login Berhasil', [
                'redir' => session()->pull('url.intended', url(RouteServiceProvider::HOME)),
            ]);
        }

        return redirect()->intended(url(RouteServiceProvider::HOME));
    }

    public function ensureIsNotRateLimited(Request $request)
    {
        $throttleKey = $this->throttleKey($request);
        if (!RateLimiter::tooManyAttempts($throttleKey, 5)) {
            return;
        }

        event(new Lockout($request));

        $seconds = RateLimiter::availableIn($throttleKey);

        return $this->jsonError('Data yang anda masukkan tidak valid', [
            'error' => [
                'type' => 'input_validation',
                'data' => [
                    'errors' => ValidationException::withMessages([
                        'pengguna' => trans('auth.throttle', [
                            'seconds' => '::seconds::',
                        ]),
                    ])->errors(),
                    'wait' => $seconds,
                ]
            ]
        ], 429)->send() && exit;
    }

    public function throttleKey(Request $request)
    {
        return Str::lower($request->input('pengguna')) . '|' . $request->ip();
    }

    public function destroySession(Request $request)
    {
        if (Auth::user()) {
            Auth::logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }

    public function destroy(Request $request)
    {
        $this->destroySession($request);

        if ($request->ajax()) {
            return new JsonResponse([], 204);
        }

        return redirect('/');
    }
}
