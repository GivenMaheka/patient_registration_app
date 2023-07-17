<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest as AuthLoginRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function show()
    {
        return view(route('login'));
    }

    public function authenticate(AuthLoginRequest $req)
    {


        $req->validate([
            'email' => 'required',
            'password' => 'required|min:6',
        ]);

        $userId = User::where('email','=',$req->email)->first();
        $credentials = ['user_id' => $userId->user_id, 'password' => $req->password];


        if (Auth::attempt($credentials)) {
            
            $req->session()->regenerate();
            return redirect('/patients/all');
            // return redirect(route('get.patients'));
        } else {
            return back()->with('login_fail', 'Wrong credentials provided.');
        }
    }

    // protected function authenticated(Request $request, $user){
    //     return redirect(route('get.patients'));
    // }
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
    
}
