<?php

namespace App\Http\Controllers\Branches\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Branch\BranchMember;

class MemberController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
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
        // dd($branch);
        $members = $branch->members;
        return view('branches.users.members.index',compact('members','branch'));
    }

    public function create()
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

        return view('branches.users.members.create',compact('branch'));
    }

    public function store(Request $request)
    {
        $branch = auth()->user()->branchProfile;
        if(!$branch)
        {
            abort(403,'Branch Error. Please Contact Branch Admin.');
        }
        // dd($request->all(),$branch);
        $request->validate([
            "name" => "string|required",
            "email" => "email|required",
            "contact" => "numeric|required",
            "password" => "string|required",
            "role" => "string|required",
        ]);

        $user=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'contact'=>$request->contact,
            'role'=>'Branch',
            'password'=>Hash::make($request->password),
        ]);

        $branch->members()->create([
            'user_id' => $user->id,
            'name' => $user->name,
            'role' => $request->role,
        ]);

        return redirect('/branch/members');
    }

    public function edit(BranchMember $member)
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

        return view('branches.users.members.edit',compact('branch','member'));
    }

    public function update(Request $request, BranchMember $member)
    {
        // dd($request->all(),$member);
        $request->validate([
            "name" => "required|string",
            "email" => "required|email",
            "contact" => "required|numeric",
            "password" => "required|string",
            "old_password" => "required|string",
            "role" => "required|string",
        ]);

        $member->update([
            'name' => $request->name,
            'role' => $request->role,
        ]);

        $password = $request->old_password;
        if($password != $request->password)
        {
            $password = Hash::make($request->password);
        }
        $member->user()->update([
            'name' => $request->name,
            'email' => $request->email,
            'contact' => $request->contact,
            'password' => $password,
        ]);
        return redirect('/branch/members');
    }

    public function destroy(BranchMember $member)
    {
        // dd($member,$member->user);
        $member->user()->delete();
        $member->delete();
        return redirect('/branch/members');
    }
}
