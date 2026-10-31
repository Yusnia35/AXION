<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (! $user || ! $user->isAdmin()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Akses ditolak: Hanya Administrator yang diizinkan.'], 403);
            }

            return redirect()->route('dashboard')
                ->with('error', 'Akses ditolak: Menu ini hanya dapat diakses oleh Administrator.');
        }

        return $next($request);
    }
}
