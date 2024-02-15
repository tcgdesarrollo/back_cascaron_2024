<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->header('Authorization');
        if (isset($token) ) {
            if (!auth('sanctum')->check()) {
                return \response(['data' => 'Debes autenticarte'], 401);
            }
        }
        $validLanguages = ['en', 'es'];

        $lang = $request->header('x-lang', 'es');
        if (!in_array($lang, $validLanguages)) {
            $lang = 'es';
        }
        if (isset($lang)) {
            app()->setLocale($lang);
        }
        return $next($request);
    }
}
