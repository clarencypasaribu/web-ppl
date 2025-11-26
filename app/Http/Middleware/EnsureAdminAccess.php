<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminAccess
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->session()->get('is_admin')) {
            return $next($request);
        }

        return redirect()
            ->route('admin.login')
            ->withErrors('Silakan login sebagai admin untuk mengakses halaman verifikasi.');
    }
}
