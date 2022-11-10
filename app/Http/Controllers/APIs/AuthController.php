<?php

namespace App\Http\Controllers\APIs;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
   
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }

    protected function guard()
    {
        return Auth::guard('api');
    }
  
    public function login(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'email'=>'required | email',
            'password'=>'required | string | min:3',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $token_validity = 60*60*24*365; // in seconds // 1 year = 365 days = 24*365 hours = 60*24*365 minutes = 60*60*24*265 seconds
        $this->guard()->factory()->setTTL($token_validity);
        if(!$token = $this->guard()->attempt($validator->validated())){
            return response()->json(['error'=>'Unable to Login. Invalid Email or Password.'], 401);
        }

        if($this->guard()->user()->status != 'Active'){
            $this->guard()->logout();
            return response()->json(['error'=>'Your Account is Deactivated.'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function register(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:4', 'confirmed'],
            'contact'=>['nullable','numeric','digits:10'],
            'district'=>['nullable','string'],
            'provience'=>['nullable','string'],
            // 'interests'=>'min:1',
        ]);

        if($validator->fails()){
            return response()->json([$validator->errors()], 400);
        }

        $user=User::create([
            'name' => $request->name,
            'email' => $request->email,
            'contact'=>$request->contact ?? '',
            'password' => Hash::make($request->password),
            'district_city'=>$request->district ?? '',
            'provience'=>$request->provience ?? '',
            'interests'=>$request->interests ?? '',
            'role'=>'Student',
        ]);

        return response()->json([
            'message'=>'User Created Successfully',
            'user'=>$user,
        ]);
    }

    
    public function logout()
    {
        $this->guard()->logout();

        return response()->json(['message' => 'User logged out Succesfully']);
    }

    public function profile()
    {
        return response()->json($this->guard()->user());
    }

    public function updateProfile(Request $request)
    {
        $user = $this->guard()->user();
        $validator = Validator::make($request->all(),[
            'name'=>'string | required',
            'email'=>'required | email',
            'contact'=>'required | numeric | digits:10',
            'district'=>'required | string |min:1 ',
            'provience'=>'required | string | min:1',
            'interests'=>'string|nullable',
            'photo'=>'string|nullable',
        ]);

        if($validator->fails()){
            return response()->json([$validator->errors()], 400);
        }

        if(isset($request->photo))
        {
            $user->update(['photo' => $request->photo]);
        }

        $user->update([
            'name'=>$request['name'],
            'email'=>$request['email'],
            'contact'=>$request['contact'],
            'interests'=>$request['interests'] ?? '',
            'district_city'=>ucwords($request['district']),
            'provience'=>ucwords($request['provience']),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Your Profile Has Been Updated',
            'user' => $user,
        ]);
    }

    public function deactivateAccount()
    {
        $user = $this->guard()->user();
        $user->update(['status'=>'Inactive']);
        $this->guard()->logout();
        return response()->json([
            'success' => true,
            'message' => 'User Account Deactivated Succesfully',
        ]);
    }
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        $token_validity = 60*60*24*365; // in seconds // 1 year = 365 days = 24*365 hours = 60*24*365 minutes = 60*60*24*265 seconds
        $token = $this->guard()->refresh();
        $this->guard()->factory()->setTTL($token_validity);
        return $this->respondWithToken($token);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'token_validity' =>$this->guard()->factory()->getTTL(),
        ]);
    }
}
