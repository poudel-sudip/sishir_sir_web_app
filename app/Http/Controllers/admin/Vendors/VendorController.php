<?php

namespace App\Http\Controllers\admin\Vendors;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Vendors\Vendor;
use App\Models\Provience\Provience;
use App\Models\Provience\DistrictCity;

class VendorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $vendors=Vendor::all();
        // dd($vendors);
        return view('admin.vendor.index',compact('vendors'));
    }

    public function create()
    {
        $proviences = Provience::all()->sortBy('name');
        return view('admin.vendor.create',compact('proviences'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required | String',
            'description' => 'required|string',
            'image' => 'image|nullable',
            'email'=>'email | unique:users',
            'contact'=>'integer | min:10',
            'password'=>'required|string|min:4',
            'discount' => 'required|numeric|lte:100',
            'provience' => 'required|string|min:1',
        ]);
        $image='';
        if(isset($request->image))
        {
            $image=request('image')->store('uploads','public');
        }
        $user=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'contact'=>$request->contact,
            'photo'=>$image,
            'role'=>'Vendor',
            'password'=>Hash::make($request->password),
            'provience' => ucwords($request->provience)
        ]);

        $vendor=Vendor::create([
            'user_id' => $user->id,
            'name' => $user->name,
            'vendor_discount' => $request->discount,
            'description' => $request->description,
            'provience' => $request->provience,
        ]);
        return redirect('/admin/vendor');
    }

    public function show(Vendor $vendor)
    {
        // dd($vendor);
        return view('admin.vendor.show',compact('vendor'));
    }

    public function edit(Vendor $vendor)
    {
        $proviences = Provience::all()->sortBy('name');
        $districts = DistrictCity::all()->sortBy('provience_id');
        return view('admin.vendor.edit',compact('vendor','proviences','districts'));
    }

    public function update(Request $request, Vendor $vendor)
    {
        // dd($request->all(),$vendor);
        $request->validate([
            "name" => "required|string",
            "email" => "required|email",
            "contact" => "required|numeric|min:10",
            "password" => "required|string",
            "old_password" => "required|string",
            'discount' => 'required|numeric|lte:100',
            "description" => "required|string",
            "oldImage" => 'string|nullable',
            "image" =>  'image|nullable',
            'status' => 'string|required|min:1',
            'isPinned' => 'string|required',
            'user_access' => 'string|required',
            'enquiry_access' => 'string|required',
            'manual_booking_access' => 'string|required',
            'coverage_type' => 'string|required|min:1',
            'provience' => 'array|nullable',
            'district' => 'array|nullable',
        ]);

        $provience = '';
        $district_city = '';

        if($request->coverage_type=="provience")
        {
            if($request->provience)
            {
                $provience = implode(", ",$request->provience);
            }
            else
            {
                return back()->withInput()->withErrors(['provience'=>'Please Select At Least One Provience.']);
            }
        }
        elseif($request->coverage_type=="district")
        {
            if($request->district)
            {
                $district_city = implode(", ",$request->district);
            }
            else
            {
                return back()->withInput()->withErrors(['district'=>'Please Select At Least One District/City.']);
            }
        }
        else
        {
            return back()->withInput()->withErrors(['coverage_type'=>'Please Select One Coverage Type.']);
        }

        // dd($request->coverage_type,$provience,$district_city);

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

        $vendor->user()->update([
            'name'=>$request->name,
            'photo'=>$img,
            'email'=>$request->email,
            'contact'=>$request->contact,
            'password'=>$password,
            'status' => $request->status,
        ]);

        $vendor->update([
            'name'=>$request->name,
            'vendor_discount' => $request->discount,
            'isPinned' => $request->isPinned,
            'user_access' => $request->user_access,
            'enquiry_access' => $request->enquiry_access,
            'manual_booking_access' => $request->manual_booking_access,
            'description' => $request->description,
            'coverage_type' => $request->coverage_type,
            'provience' => $provience,
            'district_city' => $district_city,
        ]);
        return redirect('/admin/vendor');
    }

    public function destroy(Vendor $vendor)
    {
        // dd($vendor);
        $vendor->user()->delete();
        $vendor->delete();
        return redirect('/admin/vendor');
    }

    public function students(Vendor $vendor)
    {
        $users = $vendor->myusers;
        return view('admin.vendor.students',compact('vendor','users'));
    }
}
