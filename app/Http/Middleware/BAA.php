<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use Closure;
use Session;
use Carbon\Carbon;
class BAA
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if(Auth::check()){
            // dd(Session::get('currentPractice'));
           $user = Auth::user();
         if(isset($user->practices->first()->id) && !empty($user->practices->first()->id)  && !$user->hasRole('compliance_admin')){
            $business_agree = $user->practices->first()->businessAgreement;
            if($business_agree)
              $prac = $business_agree->accepted_terms;
              else
              $prac = null;

            $business_agree_rp = $user->practices->first()->businessAgreement;
                         if($business_agree_rp)
                         $rp_agr = $business_agree_rp->rp_accepted_terms;
                           else
                           $rp_agr = null;

//  dd($prac);
                // dd($rp_agr);
        // dump($request->all());
        // dd($user);
        if((!isset($prac) && $prac == null) || $prac == 0 ){
            // dd($prac);
             return redirect('baa');
        }
        
        if((!isset($rp_agr) && $rp_agr == null)|| $rp_agr == 0){
          return redirect('rppa');
     }
        
      //   if(isset($prac) && $prac != null &&  $prac != 0){
      //     if($rp_agr){

      //         $end_date = Carbon::parse($business_agree_rp->accepted_terms_dt)->addYear();
      //         // $end_date = Carbon::parse($business_agree->accepted_terms_dt)->addYear()->format('Y-m-d h:m:s');
      //         // dump($end_date);
      //         // dump($business_agree->accepted_terms_dt);
      //         // dump(Carbon::now());
      //         if($end_date <= Carbon::now()){
      //           $business_agree_rp->accepted_terms = 0;
      //           $business_agree_rp->rp_accepted_terms = 0;
      //           $business_agree_rp->save();
      //             return redirect('rppa');
      //         }
             
      //     }
      // }

      
        }


        return $next($request);
    }
    }
}
