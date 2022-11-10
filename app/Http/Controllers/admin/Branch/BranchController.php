<?php

namespace App\Http\Controllers\admin\Branch;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Branch\Branch;
use App\Models\User;

class BranchController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $branches = Branch::all();
        return view('admin.branches.index',compact('branches'));
    }

    public function create()
    {
        return view('admin.branches.create');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'string|required',
            'email' => 'email|required|unique:users',
            'password' => 'string|required',
            'description' => 'string|nullable',
            'image' => 'image|nullable',
        ]);
        $image='';
        if(isset($request->image))
        {
            $image=request('image')->store('uploads','public');
        }
        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'photo'=>$image,
            'role'=>'Branch',
            'password'=>Hash::make($request->password),
        ]);

        $branch=Branch::create([
            'user_id' => $user->id,
            'name' => $user->name,
            'description' => $request->description,
        ]);

        return redirect('/admin/branches');
    }

    public function show(Branch $branch)
    {
        return view('admin.branches.show',compact('branch'));
    }

    public function edit(Branch $branch)
    {
        return view('admin.branches.edit',compact('branch'));
    }

    public function update(Request $request, Branch $branch)
    {
        // dd($request->all());
        $request->validate([
            "name" => "required|string",
            "email" => "required|email",
            "password" => "required|string",
            "old_password" => "required|string",
            "description" => "required|string",
            "oldImage" => 'string|nullable',
            "image" =>  'image|nullable',
            'isPinned' => 'string|required',
        ]);

        $img=$request->oldImage;

        if(isset($request->image))
        {
            $img=request('image')->store('uploads','public');
        }

        if($request->password == $request->old_password)
        {
            $password = $request->password;
        }
        else
        {
            $password=Hash::make($request->password);
        }

        $branch->user()->update([
            'name'=>$request->name,
            'photo'=>$img,
            'email'=>$request->email,
            'password'=>$password,
        ]);

        $branch->update([
            'name'=>$request->name,
            'isPinned' => $request->isPinned,
            'description' => $request->description,
        ]);

        return redirect('/admin/branches');
    }

    public function destroy(Branch $branch)
    {
        $branch->user()->delete();
        $branch->delete();
        return redirect('/admin/branches');
    }
}
