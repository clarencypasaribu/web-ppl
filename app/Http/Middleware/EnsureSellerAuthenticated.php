<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureSellerAuthenticated
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->session()->has('seller_auth_id')) {
            return redirect()
                ->route('seller.login')
                ->withErrors('Silakan login sebagai penjual untuk mengelola produk.');
        }

        return $next($request);
    }
}
