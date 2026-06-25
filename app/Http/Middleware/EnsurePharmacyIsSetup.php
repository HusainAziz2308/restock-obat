<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsurePharmacyIsSetup
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && empty($user->pharmacy_id)) {
            
            if ($request->is('admin*')) {
                
                if (! $request->is('admin/setup-apotek*')) {
                    return redirect('/admin/setup-apotek');
                }
            }
        }

        return $next($request);
    }
}
