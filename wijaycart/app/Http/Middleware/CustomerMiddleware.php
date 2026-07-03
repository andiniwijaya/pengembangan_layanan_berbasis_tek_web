<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomerMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! auth()->check() || ! auth()->user()->isCustomer()) {
            if (auth()->check() && auth()->user()->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }

            abort(403, 'Akses ditolak. Hanya customer yang dapat mengakses halaman ini.');
        }

        return $next($request);
    }
}
