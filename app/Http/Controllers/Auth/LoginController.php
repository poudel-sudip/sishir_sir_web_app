<?php

namespace App\Http\Controllers\Auth;
use App\Models\Reports\ReportUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Advertisement;
use App\Models\Categories;

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
    //    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectTo() {
        $user = Auth::user();
        if(!$user->contact)
        {
            Session::flash('status','Please Complete Your Profile Details.');
            return '/profile/edit';
        }
        $role = $user->role;
        switch ($role) {
            case 'Admin':
                return '/admin/home';
                break;
            case 'Student':
                return '/student/home';
                break;
            case 'Moderator':
                return '/moderator/home';
                break;
            default:
                return '/';
                break;
        }
    }

    protected function authenticated()
    {
        $user=auth()->user();
        $user->update(['last_login'=>date('Y-m-d H:i:s A')]);
        if($user->role != 'Vendor')
        {
            Auth::logoutOtherDevices(request('password'));
            Session::flash('status','Successful login  |  All Other Devices has been Logged Out');
        }
    }


    public function login(Request $request) {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        // This section is the only change
        if ($this->guard()->validate($this->credentials($request))) {
            $user = $this->guard()->getLastAttempted();

            // Make sure the user is active
            if ($user->status=='Active' && $this->attemptLogin($request)) {
                // Send the normal successful login response
                return $this->sendLoginResponse($request);
            } else {
                // Increment the failed login attempts and redirect back to the
                // login form with an error message.
                $this->incrementLoginAttempts($request);
                return redirect()
                    ->back()
                    ->withInput($request->only($this->username(), 'remember'))
                    ->withErrors([$this->username() => 'Your Account is deactivated. Contact the support team to activate.']);
            }
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    protected function showLoginForm()
    {
        $vision = Categories::where('type', '=', 'webpage-vision')->first();
        if(!$vision) {
            abort(403, 'Vision Page Not Found');
        }

        $contact = Categories::where('type', '=', 'webpage-contact')->first();
        if(!$contact) {
            abort(403, 'Contact Page Not Found');
        }

        return view('auth.login',[
            'user_count' => User::count(),
            'top_ad' => Advertisement::where('status','=','Active')->where('position','=','auth_top_ad')->first(),
            'bottom_ad' => Advertisement::where('status','=','Active')->where('position','=','auth_bottom_ad')->first(),
            'vision' => $vision,
            'contact' => $contact,
        ]);
    }

}
