<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest as AuthLoginRequest;
use App\Http\Requests\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    // use AuthenticatesUsers;

    public function show()
    {
        return view(route('login'));
    }
    
    public function authenticate(AuthLoginRequest $req)
    {

        $credentials = $req->only('email', 'password');
        // $credentials = $req->getCredentials();

        if(!Auth::validate($credentials)){
            return redirect(route('login'))
                ->withErrors(trans('auth.failed'));
        }else{
            return redirect()->intended(route('get.patients'));

        }

        // $user = Auth::getProvider()->retrieveByCredentials($credentials);

        // Auth::login($user);

        // return $this->authenticated($req, $user);


        // $req->validate([
        //     'email' => 'required',
        //     'password' => 'required|min:6',
        // ]);
        // $credentials = $req->only(['email','password']);

    
        //     // $uname = $req->username;
        //     // $pass = str_replace(' ','',$req->password);
    
        //     // $user = User::where('email','=',$uname)->first();
    
        //     if(Auth::attempt($credentials)){
        //         $user = Auth::getProvider()->retrieveByCredentials($credentials);
        //         // return redirect()->int;
        //         // return $this->authenticated($request, $user);
        //         Auth::user($user);
        //         return redirect(route('get.patients'));
        //     }else{
        //         return back()->with('login_fail','Wrong credentials provided.');
        //     }


        // $this->middleware('guest')->except('logout');
    }

    protected function authenticated(Request $request, $user) 
    {
        return redirect(route('get.patients'));
    }
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
        $this->middleware('auth:api');
        $this->middleware('guest')->except('logout');
    }
}
