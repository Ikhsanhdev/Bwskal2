<?php

namespace AyatKyo\Klorovel\Auth\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// TODO refactor
class AuthRole
{
    public function handle(Request $request, Closure $next, ...$roleList)
    {
        $user = false;
        if (Auth::check()) {
            $user = Auth::user();
        } else if ($request->header('Authorization') || $request->token) {
            try {
                // $token = $request->header('Authorization') ?? $request->token;
                // $parsedToken = KlorovelToken::isValid($token);
                // $user = User::where('token', $parsedToken->token)->first();
            } catch (\Throwable $th) {
            }
        }

        if ($user) {
            $userRole = $user->role;
            if (count($roleList) == 0) {
                $request->user = $user;
                return $next($request);
            }

            $role = $roleList[0];

            if (count($roleList) == 1 && $role[0] == '!' && substr($role, 1) != $userRole) {
                //  selain !role
                $request->user = $user;
                return $next($request);
            } else if (collect($roleList)->contains($userRole)) {
                //  semua di list
                $request->user = $user;
                return $next($request);
            }

            //  Jika json
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized',
                ], 401);
            }

            //  Guest ke beranda
            if ($userRole == 'guest') {
                return redirect('/');
            }

            return abort(401);
        }

        $redirectURL = Route::has('login') ? route('login') : null;

        if ($request->expectsJson()) {
            $data = [
                'success' => false,
                'message' => 'Unauthenticated',
            ];

            if ($redirectURL) {
                $data['redir'] = url($redirectURL);
            }

            return response()->json($data, 401);
        }

        return redirect()->guest($redirectURL);
    }
}