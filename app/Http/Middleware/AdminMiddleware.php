<?php

namespace App\Http\Middleware;

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
    public function handle(Request $request, Closure $next): Response
    {
        
        if (Auth::check()) {
            // Get the authenticated user
            $user = Auth::user();

            // Check if the user's role is admin (example)
            if ($user->role == 1) {
                return $next($request);
            }
        }

        // return redirect('/'); // Redirect unauthorized users to another route or page
        return response()->json([
            'status'=>400,
            'message'=>"Unauthorized",
        ]);
    }
}
