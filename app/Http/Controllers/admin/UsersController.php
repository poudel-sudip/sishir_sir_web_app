<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Course;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('admin.users.index',[
            'users'=>User::whereIn('role',['Admin','Student'])->get(),
        ]);
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store()
    {
        $data=request()->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255','unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role'=>['required'],
            'contact'=>['required', 'min:10'],
            'status'=>['required'],
        ]);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role'=>$data['role'],
            'contact'=>$data['contact'],
            'status'=>$data['status'],
            'last_login'=>date('Y-m-d H:i:s'),
        ]);

        return redirect('/admin/users');

    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $courses = Course::all()->sortBy('order');
        return view('admin.users.edit', compact('user','courses'));
    }

    public function update(User $user)
    {
        // dd(request()->all());
        Gate::authorize('permission','user-crud');
        $data=request()->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255'],
            'role'=>['required','string'],
            'contact'=>['required', 'string','min:10'],
            'status'=>['required','string'],
            'password'=>'string',
            'old_password'=>'string',
        ]);

        if($data['password']===$data['old_password'])
        {
            $password=$data['password'];
        }
        else
        {
            $password = Hash::make($data['password']);
        }
        $user->update([
            'name'=>$data['name'],
            'email'=>$data['email'],
            'contact'=>$data['contact'],
            'role'=>$data['role'],
            'status'=>$data['status'],
            'password'=>$password,
        ]);

        return redirect('/admin/users');
    }

    public function destroy(User $user)
    {   
        $user->bookings()->delete();
        $user->exam_bookings()->delete();
        $user->delete();
        return redirect('/admin/users');
    }
}
