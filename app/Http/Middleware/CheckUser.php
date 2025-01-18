<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
       if (auth()->check()) {
        if (auth()->user()->is_approved ) {
            return $next($request);
        }else{
            return redirect()->route('user.not_approved');
        }
       }else{
        return response()->json(['message' => 'Unauthorized'], 401);
       }
    }
}
