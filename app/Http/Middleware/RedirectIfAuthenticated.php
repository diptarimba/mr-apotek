<?php

namespace App\Http\Middleware;

use App\Models\RoleHome;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $dataRaw = RoleHome::get();
        $roleHome = $dataRaw->pluck('home', 'name')->toArray();
        $guards = empty($guards) ? [null] : $guards;
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $authHome = Auth()->user()->getRoleNames()[0] ?? null;
                if ($authHome) {
                    return redirect()->route($roleHome[$authHome]);
                }
            }
        }

        return $next($request);
    }
}
