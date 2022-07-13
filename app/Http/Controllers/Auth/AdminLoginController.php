<?php
namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\MessageBag;

/*==========================================
=            Author: Media City            =
    Author URI: https://mediacity.co.in
=            Author: Media City            =
=            Copyright (c) 2020            =
==========================================*/

class AdminLoginController extends Controller
{
    

    public function showLoginForm()
    {
        if(!empty(Auth::user()) && Auth::user()->role == 'admin'){
            return redirect()->intended(route('admin.home'));
        }
        return view('admin.login');
    }

    
    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->guest(route( 'admin.login' ));
    }


    public function adminLogin(Request $request)
    {   
        if (Auth::attempt(['email' => $request->get('email') , 'password' => $request->get('password'),'status' => 1], $request->remember))
        {
            if (Auth::user()->role == 'admin')
            {
                notify()->success('Welcome '.Auth::user()->name);
                return redirect()->intended(route('admin.home'));
            }else if(Auth::user()->role == 'user'){
                return redirect()->intended(url('/'));
            }
            else
            {
                Auth::logout();
                notify()->error('Access Denied !');
                return Redirect::back();
            }
        }
        else
        {
            $errors = new MessageBag(['email' => ['Email or password is invalid or your account is deactive/ unverified']]);
            return Redirect::back()->withErrors($errors)->withInput($request->except('password'));
           
        }
    }

}