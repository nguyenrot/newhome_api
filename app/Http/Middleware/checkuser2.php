<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class checkuser2
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();
        if ($user->account_type == 2) return $next($request);
        else return response()->json(['msg' => 'Bạn không có quyền truy cập'],203,
            ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
    }
}
