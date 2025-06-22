<?php

namespace App\Http\Middleware;

use App\Enums\Role;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Pastikan user sudah login
        if (!Auth::check()) {
            // Simpan intended URL untuk redirect setelah login
            session()->put('url.intended', $request->url());
            return redirect('/login');
        }

        $user = Auth::user();

        // Cek role user
        if ($user->role !== Role::admin) {
            // User biasa tidak boleh akses halaman admin
            abort(403, 'Access denied. Admin privileges required.');
        }

        return $next($request);
    }
}
