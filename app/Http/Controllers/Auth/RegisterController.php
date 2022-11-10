<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Reports\ReportUser;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Tutor;
use App\Models\Vendors\Vendor;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Provience\Provience;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::LOGIN;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'contact'=>['required','numeric','digits:10'],
            'district_city'=>['required','string','min:1'],
            'provience'=>['required','string','min:1'],
            'interests'=>'min:1',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'contact'=>$data['contact'],
            'password' => Hash::make($data['password']),
            'district_city'=>ucwords($data['district_city']),
            'provience'=>ucwords($data['provience']),
            'interests'=>$data['interests'] ?? '',
        ]);
    }

    protected function showRegistrationForm()
    {
        $courses=Course::all()->sortBy('order');
        return view('auth.register',[
            'courses'=>$courses,
            'proviences' => Provience::all()->sortBy('name'),
        ]);
    }

    protected function showTutorRegForm()
    {
        return view('auth.registertutor',[
            'proviences' => Provience::all()->sortBy('name'),
        ]);
    }

    protected function showVendorRegForm()
    {
        return view('auth.registervendor',[
            'proviences' => Provience::all()->sortBy('name'),
        ]);
    }

    protected function registerTutor(Request $request)
    {
        // dd($request->all());
        $request->validate([
            "name" => "string|required",
            "email" => "required|string|email|unique:users",
            "contact" => "required|numeric|digits:10",
            "qualification" => "required|string",
            "experience" => "string|required",
            "description" => "required|string",
            "password" => "required|string|min:5|confirmed",
        ]);

        $user = User::create([
            'name'=>$request['name'],
            'email'=>$request['email'],
            'contact'=>$request['contact'],
            'role'=>'Tutor',
            'status'=>'Inactive',
            'password'=>Hash::make($request['password']),
        ]);

        $tutor=Tutor::create([
            'user_id'=>$user->id,
            'name'=>$user->name,
            'experience'=>$request['experience'],
            'qualification'=>$request['qualification'],
            'description'=>$request['description'],
            'status'=>'Inactive',
        ]);
        return redirect('/');
    }

    protected function registerVendor(Request $request)
    {
        // dd($request->all());
        $request->validate([
            "name" => "string|required",
            "email" => "required|string|email|unique:users",
            "contact" => "required|numeric|digits:10",
            "provience" => "required|string|min:1",
            "district_city" => "nullable|string",
            "description" => "required|string",
            "password" => "required|string|min:5|confirmed",
        ]);

        $user=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'contact'=>$request->contact,
            'role'=>'Vendor',
            'status'=>'Inactive',
            'password'=>Hash::make($request->password),
            'provience' => ucwords($request->provience)
        ]);

        $vendor=Vendor::create([
            'user_id' => $user->id,
            'name' => $user->name,
            'vendor_discount' => "1",
            'description' => $request->description,
            'provience' => $request->provience,
        ]);

        return redirect('/');
    }

}
