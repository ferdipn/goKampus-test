<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Support\Facades\Auth;
use App\Models\User;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        $hasRole = User::select()
            ->where('id', Auth::id())
            ->where('role_id', $role)
            ->first();

        if( $hasRole === null ) {
            return redirect('/');
        }

        return $next($request);
    }
}
