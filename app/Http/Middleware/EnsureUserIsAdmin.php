<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->role === 'Admin') {
            return $next($request);
        }

        abort(403, 'Akses ditolak. Halaman ini khusus Admin.');
    }
}
