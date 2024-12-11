<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Banner;
use App\Sponsors;
use auth;
use Carbon\Carbon;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated(Request $request, $user)
    {


        // dump($prac[0]);
        // dump($request->all());
        // dd($user);

        if($user->hasRole('compliance_admin') || $user->can('all access')){
            return redirect('overview');
        } elseif ($user->hasRole('practice_admin') || $user->hasRole('super_admin') || $user->hasRole('practice_super_group') || $user->can('practice admin')){

        //     if(isset($user->practices->first()->id) && !empty($user->practices->first()->id) && !$user->hasRole('practice_super_group')){
        //                  $business_agree = $user->practices->first()->businessAgreement;
        //                  if($business_agree)
        //                    $prac = $business_agree->accepted_terms;
        //                    else
        //                    $prac = null;

                           
        // }

        //  if(isset($prac) || $prac == null || $prac ==0){
        // // dump($prac[0]);
        //  // dump($request->all());
        // // dd($user);
        //      return redirect('baa');
        // }

            return redirect('patient');
        }
        elseif ($user->hasRole('internel_access')){
          if(isset($user->practice_id) && $user->practice_id != 0){
         // $practice = practice::where('id', $user->practice_id)->first();
              // dd($practice);
           //     Session::put('practice', $practice);
            return redirect('practice');
        }else{
            return redirect('practice');
        }
        }
        else{
            auth()->logout();
        return back()->with('role_error', 'User does not have practice admin role.');
            // return redirect('patient-search');
        }
    }
    public function showLoginForm()
    {
        $data['banners'] = $banners=Banner::all();

        $banners = Sponsors::all();


        $data['login_page_slider'] = $banners->where('page_id', 1)->where('type_image', 'Slider');
        $data['login_page_simple'] = $banners->where('page_id', 1)->where('type_image', 'Simple');


        return view('auth.login', $data);
    }

    protected function validateLogin(Request $request)
    {
        $messages = [
            // 'identity.required' => 'Email cannot be empty',
            // 'email.exists' => 'Email or username already registered',
            // 'username.exists' => 'Username is already registered',
            'email.required' => 'Email is required',
            'password.required' => 'Password is required',
            'email.regex' => 'Email address is invalid',
            'email.email' => 'Email address is invalid'
        ];

        $request->validate([
            // 'identity' => 'required|string',
            'password' => 'required|string',
            'email' => 'required|email|regex:/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,6})+$/',
            // 'username' => 'string|exists:users',
        ], $messages);
    }

     public function logout(Request $request)
    {
          if (auth::user()->hasRole('practice_admin') || auth::user()->can('practice admin')){
      $chat_messages =  \App\PracticeComplianceadminChat::where('to',auth::user()->id)
        ->orWhere('from',auth::user()->id)->delete();
      $chat_session =  auth::user()->pharmacySessions()->delete();
        // return response()->json(['chat_messages'=>$chat_messages,'chat_session'=>$chat_session]);
    }

        $this->guard()->logout();
        $request->session()->flush();
        $request->session()->regenerate();

        if (\App::environment(['Production'])) {
        return redirect()->to('https://www.compliancereward.com');
    }else{
         return redirect()->to('/');
    }
        // return redirect()->to('https://www.compliancereward.com')->send();
    }

}
