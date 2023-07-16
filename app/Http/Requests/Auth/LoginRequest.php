<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use App\Models\sessionUpdate;
use App\Models\User;
use Session;
use DB;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|string|string',
            'password' => 'required|string',
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(Request $request){
        $this->ensureIsNotRateLimited();

        // $credentials = array('id'=>$this->input('email'),'password'=>$this->input('password'));

        // $userRole = DB::table('roles')->where('user_id', '=',$this->input('email'))->limit(1)->get();
        // // if(1 !== 0){

        //     $redirectTo ='';

            // switch ($userRole[0]->role) {
            //     case 'admin':
            //         $redirectTo = '/studentDashboard';
            //         // RateLimiter::hit($this->throttleKey());
            //         // throw ValidationException::withMessages([
            //         //     'id'=>"Your are an admin "
            //         // ]);
            //         break;
                
            //     case 'super_admin':
            //         $redirectTo = '/studentDashboard';
            //         // RateLimiter::hit($this->throttleKey());
            //         // throw ValidationException::withMessages([
            //         //     'id'=>"Your are a superAdmin "
            //         // ]);
            //         break;
                
            //     case 'student':
            //         $redirectTo = '/studentDashboard';
            //         // RateLimiter::hit($this->throttleKey());
            //         // throw ValidationException::withMessages([
            //         //     'id'=>"Your are a student "
            //         // ]);
            //         break;
                
            //     default:
            //         $redirectTo = '/';
            //         // RateLimiter::hit($this->throttleKey());
            //         // throw ValidationException::withMessages([
            //         //     'id'=>"This account is not identified "
            //         // ]);
            //         break;
            // }
        // if($redirectTo === 'student'){
        //         // RateLimiter::hit($this->throttleKey());
        //         // throw ValidationException::withMessages([
        //         //     'id'=>"Your account is not activated ".json_encode($userRole)
        //         // ]);
        //     }else{
            $user = User::where('email',$this->input('email'))->first();
            
            if($user){
                $credentials = array('email'=>$this->input('email'),'password'=>$this->input('password'));
                if($user->status === 1){
                    if(!Auth::attempt($credentials)){
                        RateLimiter::hit($this->throttleKey());
                        throw ValidationException::withMessages([
                            'email'=>"Credentials do not match any user"
                        ]);
                    }else{
                            RateLimiter::clear($this->throttleKey());
                            // return Redirect::to($redirectTo);
                            // return redirect()->route($redirectTo);
                            
                        }
                }else{
                    throw ValidationException::withMessages([
                        'id'=>"Not allowed to access the system. Contact the admin"
                    ]);
                }
                
            //     RateLimiter::clear($this->throttleKey());
            }else{
                throw ValidationException::withMessages([
                    'id'=>"User not found, register to get access"
                ]);
            }


        // $user = DB::table('users')->where('id', '=',$this->input('email'))->limit(1)->get();
        
        
        // if(! Hash::check($this->input('password'),$user[0]->password)){
        //     RateLimiter::hit($this->throttleKey());
            
        //     throw ValidationException::withMessages([
        //         'error' => 'Your credentials did not match',
        //     ]);
            
        // }else{
        //     $userRole = DB::table('roles')->where('user_id', '=',$user[0]->id)->limit(1)->get();
        //     if($user[0]->status === 0){
        //         $userData = array(
        //             'id' => $user[0]->id,
        //             'name' => $user[0]->surname.' '.$user[0]->other_names,
        //             'email' => $user[0]->email,
        //             'role' => $userRole
        //         );
                
        //         $request->session()->put('user', $userData);
        //         // $request->session()->put('user', json_encode($userData));
        //         // $id = $user[0]->id;

                
        //         // $data = DB::table("session")->where('user_id','=',$id)->limit(1)->get();
                
        //         // if(sizeOf($data) < 1){
        //         //     $createNewSession = new sessionUpdate();

        //         //     $createNewSession->user_id = $user[0]->id;
        //         //     $createNewSession->last_activity = '2023-03-12 01:45';
        //         //     $createNewSession->status = 0;

        //         //     $createNewSession->timestamps = false; 
        //         //     $createNewSession->save(); 
        //         // }else{
        //         //     DB::table('session')->where('user_id','=',$id)->update(['last_activity'=>'2023-03-12 01:55','status'=>'1']);
        //         // }

        //             // echo Auth::user();


        //             RateLimiter::clear($this->throttleKey());
        //             // return redirect()->route('/studentDashboard')->with('success','log');
        //         // return redirect('/studentDashboard');
        //         // echo $this->session()->get($user[0]->id);
        //     }else{
        //         $error = ValidationException::withMessages([
        //             'error1'=> 'Your account was successfully found',
        //             'error2'=> 'Unfortunately you cannot access the system',
        //             'error3'=> 'Reach out to the admin to activate your account']) ;
        //         throw $error;
        //     }
        // }

    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(){
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'id' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     *
     * @return string
     */
    public function throttleKey()
    {
        return Str::lower($this->input('email')).'|'.$this->ip();
    }
}
