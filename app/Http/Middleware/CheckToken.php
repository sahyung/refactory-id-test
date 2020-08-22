<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class CheckToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->header('authorization')) {
            $startWith = strtolower(trim(substr($request->header('authorization'), 0, 5)));
            if ($startWith === 'token') {
                $token = explode(' ', $request->header('authorization'));
                if (sizeof($token) > 1) {
                    $user = User::where('remember_token', '=', $token[1])->first();
                    if ($user) {
                        Auth::login($user);
                        return $next($request);
                    }
                }
            }
        }
        return response()->json(['error' => 'Unauthorized'], 403);
    }
}
