<?php

namespace App\Http\Controllers\Branches\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Provience\Provience;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function allStudents()
    {
        $branch = auth()->user()->branchProfile;
        if(!$branch)
        {
            $member = auth()->user()->branchMemberProfile;
            if($member)
            {
                $branch = $member->branch;
            }
        }

        if(!$branch)
        {
            abort(403,'Branch and Member Association Error. Please Contact Branch Admin.');
        }

        $students = User::where('role','=','Student')->get();
        return view('branches.users.students.allstudents',compact('students','branch'));
    }

    public function editStudent(User $user)
    {
        $branch = auth()->user()->branchProfile;
        if(!$branch)
        {
            $member = auth()->user()->branchMemberProfile;
            if($member)
            {
                $branch = $member->branch;
            }
        }

        if(!$branch)
        {
            abort(403,'Branch and Member Association Error. Please Contact Branch Admin.');
        }

        $proviences = Provience::all()->sortBy('name');
        return view('branches.users.students.editstudent',compact('user','proviences','branch'));
    }

    public function updateStudent(Request $request, User $user)
    {
        // dd($request->all());
        $request->validate([
            "name" => "required | string",
            "email" => "required | email",
            "contact" => "required | numeric",
            "password" => "required | string",
            "old_password" => "required | string",
            "provience" => "string|required",
            "district" => "string|nullable",
        ]);

        if($request['password']===$request['old_password'])
        {
            $password=$request['password'];
        }
        else
        {
            $password=Hash::make($request['password']);
        }

        $user->update([
            'name'=>$request['name'],
            'email'=>$request['email'],
            'contact'=>$request['contact'],
            'password'=>$password,
            'district_city'=>$request['district'],
            'provience' => $request['provience'],
        ]);

        return redirect('/branch/all-students');
    }
}
