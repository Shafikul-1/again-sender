<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleManager
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $roles): Response
    {
        if(!Auth::user()){
            return redirect()->route('home')->with('error', 'You not login');
        }

        $userRole = Auth::user()->role;
        $roles = explode('|', $roles);

        $roleMapping = [
            'user' => 0,
            'admin' => 1,
            'editor' => 2,
        ];
        if(in_array($userRole, array_map(function($value) use ($roleMapping) {
            return $roleMapping[$value];
        }, $roles))){
            return $next($request);
        }

        return match ($userRole) {
            0 => redirect()->route('user'),
            1 => redirect()->route('admin'),
            2 => redirect()->route('editor'),
            default => redirect()->route('home'),
        };
    }
}
