<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;
use App\User;
use Session;
class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            $user = Auth::user();
            // dump($user);
             if(isset($user->practices->first()->id) && !empty($user->practices->first()->id) && !$user->hasRole('practice_super_group')){
            $prac = $user->practices->first()->accepted_terms;
        }
          // dd(Session::get('currentPractice'));
        if(isset($prac) && $prac == null){
             return redirect('baa');
        }

          if($user->hasRole('compliance_admin') || $user->can('all access')){
            return redirect('overview');
            } elseif ($user->hasRole('practice_admin')|| $user->can('practice admin') || $user->hasRole('super_admin')||$user->hasRole('practice_super_group')){
                return redirect('patient');
            }elseif ($user->hasRole('internel_access')){
            return redirect('practice');
        }else{
                return redirect('patient');
            }
        }

        return $next($request);
    }
}
