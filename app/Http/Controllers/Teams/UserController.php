<?php

namespace App\Http\Controllers\Teams;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Provience\Provience;
use App\Models\Provience\DistrictCity;
use App\Models\Vendors\VendorUser;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function allUsers()
    {
        $users = User::where('role','=','Student')->get();
        return view('teams.users.allusers',compact('users'));
    }

    public function showUser(User $user)
    {
        return view('teams.users.show',compact('user'));
    }

    public function index()
    {
        $team = auth()->user()->team;
        $vendor = $team->vendor;
        $users = [];
        if($vendor)
        {
            $users = $vendor->myusers()->where('team_id','=',$team->id)->get();
        }
        // dd($vendor,$users);
        return view('teams.users.index',compact('users'));
    }

    public function create()
    {
        $vendor = auth()->user()->team->vendor;
        $proviences = [];
        if($vendor)
        {
            if($vendor->coverage_type=='district')
            {
                $cities =array_map("trim",explode(",",$vendor->district_city));
                $pid = [];
                $districts = DistrictCity::whereIn('name',$cities)->get('provience_id');
                foreach ($districts as $d) {
                    $pid[] = $d->provience_id;
                }
                $pid = array_unique($pid);
                $proviences = Provience::find($pid);
            }
            elseif($vendor->coverage_type=='provience')
            {
                $prov =array_map("trim",explode(",",$vendor->provience));
                $proviences = Provience::whereIn('name',$prov)->get();
            }
            else{}
        }
        // dd($vendor,$proviences);
        return view('teams.users.create',compact('proviences'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            "name" => "required | String",
            "email" => "email | unique:users",
            "contact" => "numeric | digits:10",
            "provience" => "string | required | min:1",
            "district" => "nullable | string",
            "password" => "required | string | min:4",
            "status" => "required | String",
        ]);

        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'contact'=>$request->contact,
            'provience'=>$request->provience ?? '',
            'district_city'=>$request->district ?? '',
            'status'=>$request->status,
            'role'=>'Student',
            'password'=>Hash::make($request->password),
        ]);

        VendorUser::create([
            'vendor_id'=>auth()->user()->team->vendor_id ?? '',
            'team_id' => auth()->user()->team->id,
            'user_id' => $user->id,
        ]);

        return redirect('/team/users');
    }

    public function show(VendorUser $vuser)
    {
        // dd($vuser->user);
        $user = $vuser->user;
        return view('teams.users.show',compact('user'));
    }

    public function edit(VendorUser $vuser)
    {
        $user = $vuser->user;
        $vendor = auth()->user()->team->vendor;
        $proviences = [];
        if($vendor)
        {
            if($vendor->coverage_type=='district')
            {
                $cities =array_map("trim",explode(",",$vendor->district_city));
                $pid = [];
                $districts = DistrictCity::whereIn('name',$cities)->get('provience_id');
                foreach ($districts as $d) {
                    $pid[] = $d->provience_id;
                }
                $pid = array_unique($pid);
                $proviences = Provience::find($pid);
            }
            elseif($vendor->coverage_type=='provience')
            {
                $prov =array_map("trim",explode(",",$vendor->provience));
                $proviences = Provience::whereIn('name',$prov)->get();
            }
            else{}
        }

        return view('teams.users.edit',compact('vuser','user','proviences'));
    }

    public function update(VendorUser $vuser, Request $request)
    {
        // dd($request->all(),$vuser);
        $data = $request->validate([
            "name" => "required | String",
            "email" => "required | email",
            "contact" => "required | numeric",
            "password" => "required | String",
            "old_password" => "required | String",
            "status" => "required | String | min:1",
            "provience" => "string|required|min:1",
            "district" => "string|nullable",
        ]);

        if($data['password']==$data['old_password'])
        {
            $password=$data['password'];
        }
        else
        {
            $password=Hash::make($data['password']);
        }

        $vuser->user()->update([
            'name'=>$data['name'],
            'email'=>$data['email'],
            'contact'=>$data['contact'],
            'status'=>$data['status'],
            'password'=>$password,
            'district_city'=>$data['district'],
            'provience' => $data['provience'],
        ]);

        return redirect('/team/users');
    }

    public function destroy(VendorUser $vuser)
    {
        $vuser->user()->delete();
        $vuser->delete();
        return redirect('/team/users');
    }

}
