<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckByRole
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $roles): Response
    {
        $user = $request->user();
        if (!$user) {
            abort(403, 'User Belum Login');
        }

        // Mengecek apakah user yang sedang login punya role yang diminta
        if (auth()->check() && auth()->user()->role !== $roles) {

            // Pengalihan otomatis jika role tidak sesuai
            if (auth()->user()->role === 'Supervisor') {
                return redirect()->route('task-reviews.index');
            }

            if (auth()->user()->role === 'Dealer') {
                return redirect()->route('task-submissions.index');
            }

            if (auth()->user()->role === 'Admin') {
                return redirect()->route('admin.users.index');
            }

            abort(403, 'Akses ditolak.');
        }

        // jika diizinkan → lanjutkan request ke Controller
        return $next($request);
    }
}
