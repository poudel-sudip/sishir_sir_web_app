<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EpsKorea;

class EpsKoreaController extends Controller
{
    public function index()
    {
        $eps=EpsKorea::all();
        return view('admin.epsKorea.index',compact('eps'));
    }
    public function create()
    {
        return view('front.epsKorea');
    }
    public function store()
    {
        $data=request()->validate([
            'fname'=>'required',
            'email'=>'required',
            'mobile'=>'required',
            'sector'=>'required',
            'subsector'=>'required',
            'photo'=>'required | image | max:200',
            'passport'=>'required | image | max:1024',
            'payment_slip'=>'required | image',
            // 'remarks'=>'nullable',  
        ]);
        $photoPath=request('photo')->store('uploads/korea','public');
        $ppPath=request('passport')->store('uploads/korea','public');
        $slipPath=request('payment_slip')->store('uploads/korea','public');
       $korea=EpsKorea::create([
            'fname'=>$data['fname'],
            'email'=>$data['email'],
            'mobile'=>$data['mobile'],
            'sector'=>$data['sector'],
            'subsector'=>$data['subsector'],
            'photo'=>$photoPath,
            'passport'=>$ppPath,
            'payment_slip'=>$slipPath,
            'status'=>'Unregistered',
        ]);
        return redirect('/eps-registration')->with('success','Your details has been submitted');
    }
    public function edit(EpsKorea $korea)
    {
        return view('admin.epsKorea.update',compact('korea'));
    }
    public function update(EpsKorea $korea)
    {
        $data=request()->validate([
            'status'=>'string | required',
        ]);
        $korea->update([
            // 'remarks'=>$data['remarks'],
            'status'=>$data['status'],
        ]);

        return redirect('admin/eps-registration');
    }

    public function show(EpsKorea $korea)
    {
        return view('admin.epsKorea.show',compact('korea'));
    }
    
    public function destroy(EpsKorea $korea)
    {
        $korea->delete();
        return redirect('admin/eps-registration');
    }
}
