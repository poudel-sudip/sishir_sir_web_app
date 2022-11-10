<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/login';
   
    public function reset(Request $request)
    {
        $request->validate([
            'email'=>'required | email',
            'password'=>'required | string | min:5 | confirmed',
        ]);
        $credentials=$request->only(['email','password']);

        $user=User::where('email','=',$credentials['email'])->first();
        if(!$user)
        {
            die('Invalid User');
        }
        
        $user->update([
           'password'=>Hash::make($credentials['password']),     
        ]);
        $user->refresh();
        $token=DB::table('password_resets')->where('email','=',$user->email)->delete();
        return redirect('/login');

    }
    
    
}
