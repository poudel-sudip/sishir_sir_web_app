<?php

namespace App\Http\Controllers\profile;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Provience\Provience;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        if(auth()->user()->role=='Admin'){
            $header='admin.layouts.app';
        }elseif (auth()->user()->role=='Student'){
            $header='student.layouts.app';
        }elseif (auth()->user()->role=='Tutor'){
            $header='tutors.layouts.app';
        }elseif (auth()->user()->role=='Vendor'){
            $header='vendors.layouts.app';
        }elseif (auth()->user()->role=='Branch'){
            $header='branches.layouts.app';
        }elseif(auth()->user()->role=='Publisher'){
            $header='publishers.layouts.app';
        }elseif(auth()->user()->role=='Team'){
            $header='teams.layouts.app';
        }else{
            $header='layouts.app';
        }
        $headercategories=Categories::all()->where('status','=','Active');
        return view('profiles.index',compact('header','headercategories'));
    }

    public function edit()
    {
        if(auth()->user()->role=='Admin'){
            $header='admin.layouts.app';
        }elseif (auth()->user()->role=='Student'){
            $header='student.layouts.app';
        }elseif (auth()->user()->role=='Tutor'){
            $header='tutors.layouts.app';
        }elseif (auth()->user()->role=='Vendor'){
            $header='vendors.layouts.app';
        }elseif (auth()->user()->role=='Branch'){
            $header='branches.layouts.app';
        }elseif(auth()->user()->role=='Publisher'){
            $header='publishers.layouts.app';
        }elseif(auth()->user()->role=='Team'){
            $header='teams.layouts.app';
        }else{
            $header='layouts.app';
        }
        $proviences = Provience::all()->sortBy("name");
        $headercategories=Categories::all()->where('status','=','Active');
        return view('profiles.edit',compact('header','headercategories','proviences'));
    }

    public function professionaledit()
    {
        $header='tutors.layouts.app';
        $data=auth()->user()->tutorProfile;
        // dd($data);
        return view('profiles.professionaledit',compact('header','data'));
    }

    public function update()
    {
        $data=request()->validate([
            'name'=>'string | required',
            'email'=>'required | email',
            'contact'=>'required | numeric | digits:10',
            'district_city'=>'required | string |min:1 ',
            'provience'=>'required | string | min:1',
            'interests'=>'string|nullable',
            'old-photo'=>'',
            'photo'=>'',
        ]);
        $img=$data['old-photo'];
        if(isset($data['photo']))
        {
            $img=request('photo')->store('uploads','public');
        }
        auth()->user()->update([
            'name'=>$data['name'],
            'email'=>$data['email'],
            'contact'=>$data['contact'],
            'interests'=>$data['interests'] ?? '',
            'photo'=>$img,
            'district_city'=>ucwords($data['district_city']),
            'provience'=>ucwords($data['provience']),
        ]);

        return redirect('/profile');
    }

    public function professionalupdate(Request $request)
    {
        // dd($request->all());
        $request->validate([
            "experience" => "required | string",
            "qualification" => "required | string",
            "description" => "required | string",
        ]);

        auth()->user()->tutorProfile()->update([
            'experience'=>$request->experience,
            'qualification'=>$request->qualification,
            'description'=>$request->description,
        ]);
        return redirect('/profile');
    }

}
