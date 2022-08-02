<?php

namespace App\Http\Middleware;

use App\Models\Etudiant;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class Profile
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check())
            return redirect()->route('login');
        if (Auth::user()->profile === 'student' && Auth::user()->etudiant == null)
            return redirect()->route('etudiants.create');
        if (Auth::user()->profile === 'student' && Auth::user()->etudiant->cne == null && !in_array(Route::currentRouteName(), ['etudiants.edit', 'etudiants.update', 'account']))
            return redirect()->route('account');
        if (Auth::user()->profile === 'parent' && Auth::user()->parent == null)
            return redirect()->route('parents.create');
        if (Auth::user()->profile === 'teacher' && Auth::user()->enseignant == null)
            return redirect()->route('enseignants.create');

        return $next($request);
    }
}
