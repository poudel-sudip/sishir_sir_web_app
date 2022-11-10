<?php

namespace App\Http\Controllers\Vendors;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Course;
use App\Models\Vendors\VendorUser;
use App\Models\Provience\Provience;
use App\Models\Provience\DistrictCity;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $vendor=auth()->user()->vendor;
        // dd($vendor,$vendor->myusers,$vendor->user);
        $users=$vendor->myusers;
        return view('vendors.users.index',compact('users'));
    }

    public function create()
    {
        $vendor = auth()->user()->vendor;
        $proviences = [];
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
        // dd($provience,$cities);
        return view('vendors.users.create',compact('proviences'));
    }

    public function store(Request $request)
    {
        // dd($request->all(),auth()->user()->vendor);
        $request->validate([
            "name" => "required | String",
            "email" => "email | unique:users",
            "contact" => "integer | min:10",
            "provience" => "string | required | min:1",
            "district" => "nullable | string",
            "password" => "required|string|min:4",
            "status" => "required | String",
        ]);

        $user=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'contact'=>$request->contact,
            'provience'=>$request->provience,
            'district_city'=>$request->district ?? '',
            'status'=>$request->status,
            'role'=>'Student',
            'password'=>Hash::make($request->password),
        ]);

        VendorUser::create([
            'vendor_id'=>auth()->user()->vendor->id,
            'user_id' => $user->id,
        ]);

        return redirect('/vendor/users');
    }

    public function show(VendorUser $vendoruser)
    {
        $user=$vendoruser->user;
        // dd($vendoruser,$user);
        return view('vendors.users.show',compact('user'));
    }

    public function edit(VendorUser $vendoruser)
    {
        $user=$vendoruser->user;
        $courses=Course::whereIn('status',['Active','Running'])->get();
        $vendor = auth()->user()->vendor;
        $proviences = [];
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
        // dd($vendoruser,$user);
        return view('vendors.users.edit',compact('user','vendoruser','courses','proviences'));
    }

    public function update(Request $request, VendorUser $vendoruser)
    {
        // dd($request->all(),$vendoruser,$vendoruser->user);
        $data = $request->validate([
            "name" => "required | String",
            "email" => "required | email",
            "contact" => "required | numeric",
            "password" => "required | String",
            "old_password" => "required | String",
            "old_interests" => "nullable | String",
            "interests" => "nullable | String",
            "status" => "required | String | min:1",
            "provience" => "string|required|min:1",
            "district" => "string|nullable",
        ]);

        $interests=trim(trim($data['old_interests'],", ").', '.trim($data['interests']),", ");
        
        if($data['password']===$data['old_password'])
        {
            $password=$data['password'];
        }
        else
        {
            $password=Hash::make($data['password']);
        }

        $vendoruser->user()->update([
            'name'=>$data['name'],
            'email'=>$data['email'],
            'contact'=>$data['contact'],
            'status'=>$data['status'],
            'password'=>$password,
            'interests'=>$interests,
            'district_city'=>$data['district'],
            'provience' => $data['provience'],
        ]);

        return redirect('/vendor/users');
    }

    public function destroy(VendorUser $vendoruser)
    {
        $vendoruser->user()->delete();
        $vendoruser->delete();
        return redirect('/vendor/users');
    }

    public function allUsers()
    {
        $vendor = auth()->user()->vendor;
        if(ucwords($vendor->user_access) != 'Yes' )
        {
            return redirect('/vendor/home');
        }
        $users = User::where('role','=','Student')->get();
        return view('vendors.users.provience.allusers',compact('users'));
    }

    public function listProvienceUsers()
    {
        $vendor = auth()->user()->vendor;
        if(ucwords($vendor->user_access) != 'Yes' )
        {
            return redirect('/vendor/home');
        }
        $users = [];
        $coverageArea = '';
        if($vendor->coverage_type=='district')
        {
            $coverageArea = $vendor->district_city;
            $cities =array_map("trim",explode(",",$coverageArea));
            $users = $coverageArea!='' ? User::where('role','=','Student')->whereIn('district_city',$cities)->get() : [];
        }
        elseif($vendor->coverage_type=='provience')
        {
            $coverageArea = $vendor->provience;
            $proviences =array_map("trim",explode(",",$coverageArea));
            $users = $coverageArea!='' ? User::where('role','=','Student')->whereIn('provience',$proviences)->get() : [];
        }
        else{}

        // dd($vendor,$coverageArea,$users);
        return view('vendors.users.provience.index',compact('users','coverageArea','vendor'));
    }

    public function showProvienceUser(User $user)
    {
        return view('vendors.users.provience.show',compact('user'));
    }

    public function editProvienceUser(User $user)
    {
        $vendor = auth()->user()->vendor;
        $proviences = [];
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

        // dd($proviences);
        $courses=Course::whereIn('status',['Active','Running'])->get();
        return view('vendors.users.provience.edit',compact('user','courses','proviences'));
    }

    public function updateProvienceUser(Request $request, User $user)
    {
        // dd($request->all(),$user);
        $data = $request->validate([
            "name" => "required | String",
            "email" => "required | email",
            "password" => "required | String",
            "old_password" => "required | String",
            "old_interests" => "nullable | String",
            "interests" => "nullable | String",
            "provience" => "string|required|min:1",
            "district" => "string|nullable",
        ]);

        $interests=trim(trim($data['old_interests'],", ").', '.trim($data['interests']),", ");
        if($data['password']===$data['old_password'])
        {
            $password=$data['password'];
        }
        else
        {
            $password=Hash::make($data['password']);
        }
        $user->update([
            'email'=>$data['email'],
            'password'=>$password,
            'interests'=>$interests,
            'district_city'=>$data['district'],
            'provience' => $data['provience'],
        ]);
        return redirect('/vendor/provience-users');
    }

    public function showUser(User $user)
    {
        return view('vendors.users.provience.showuser',compact('user'));
    }
}
