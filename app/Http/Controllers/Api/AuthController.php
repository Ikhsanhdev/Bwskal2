<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $loginType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $loginData = [
            'password' => $request->password,
            $loginType => $request->login,
        ];

        //  Attempt login
        if (! Auth::attempt($loginData)) {
            return $this->jsonError('Unauthorized', [
                'status_code' => 401
            ]);
        }

        $user = Auth::user();
        
        //  Revoke other token?
        // $user->tokens()->delete();

        //  Prepare return data
        $data = $user->only(['name', 'username', 'email']);

        //  Create 1 week token
        $data['access_token'] = $user->createToken('access_token')->plainTextToken;

        return $this->jsonSuccess('Login Success', [
            'data' => $data,
        ]);
    }
}
