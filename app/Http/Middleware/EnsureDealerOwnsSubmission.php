<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureDealerOwnsSubmission
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $submission = $request->route('submission');

        if (is_numeric($submission)) {
            $submission = \App\Models\TaskSubmission::findOrFail($submission);
        }

        $user = auth()->user();

        if ($user->role !== 'supervisor' && $submission->dealer_id !== $user->dealer_id) {
            abort(403, 'Anda tidak memiliki akses ke data pengumpulan tugas ini.');
        }

        return $next($request);
    }
}
