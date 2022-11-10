<?php

namespace App\Http\Controllers\admin\Teams;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Teams\Team;
use App\Models\Vendors\Vendor;
use App\Models\User;

class TeamController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $teams = Team::all();
        // dd('Teams Index',$teams);
        return view('admin.teams.index',compact('teams'));
    }

    public function create()
    {
        $vendors = Vendor::all();
        return view('admin.teams.create',compact('vendors'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            "vendor" => "numeric|required|min:1",
            "name" => "string|required",
            "email" => "email|required|unique:users",
            "contact" => "numeric|required|digits:10",
            "password" => "string|required",
            "image" => "image|nullable",
        ]);

        $image = null;
        if(isset($request->image))
        {
            $image = request('image')->store('uploads','public');
        }

        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'contact'=>$request->contact,
            'photo'=>$image,
            'role'=>'Team',
            'password'=>Hash::make($request->password),
        ]);

        $team = Team::create([
            'user_id' => $user->id,
            'name' => $user->name,
            'vendor_id' => $request->vendor,
        ]);

        return redirect('/admin/teams');
    }

    public function show(Team $team)
    {
        return view('admin.teams.show',compact('team'));
    }

    public function edit(Team $team)
    {
        $vendors = Vendor::all();
        return view('admin.teams.edit',compact('team','vendors'));
    }

    public function update(Team $team, Request $request)
    {
        // dd($request->all());
        $request->validate([
            "vendor" => "required|numeric|min:1",
            "name" => "required|string",
            "email" => "required|email",
            "contact" => "required|numeric|min:10",
            "password" => "required|string",
            "old_password" => "required|string",
            "old_image" => "string|nullable",
            "image" =>  "image|nullable",
            "status" => "string|required|min:1",
        ]);
       
        $img=$request->old_image;
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

        $team->user()->update([
            'name'=>$request->name,
            'email'=>$request->email,
            'contact'=>$request->contact,
            'photo'=>$img,
            'password'=>$password,
            'status' => $request->status,
        ]);

        $team->update([
            'name' => $request->name,
            'vendor_id' => $request->vendor,
        ]);

        return redirect('/admin/teams');
    }

    public function destroy(Team $team)
    {
        $team->user()->delete();
        $team->delete();
        return redirect('/admin/teams');
    }

}
