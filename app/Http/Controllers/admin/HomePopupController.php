<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomePopup;
use Illuminate\Http\Request;

class HomePopupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $popup=HomePopup::all();
        return view('admin.homepopup.index', compact('popup'));
    }

    public function create()
    {
        return view('admin.homepopup.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'description'=>'string|nullable|max:250',
            'image'=>'image | nullable',
            'status'=>'required',
        ]);

        if(!trim($request->description) && !isset($request->image))
        {
            return back()->withInput()->withErrors(['description'=>'Please Enter Either Description or Image.']);
        }
        
        $img = null;
        if(isset($request->image))
        {
            $img=$request->image->store('uploads','public');

        }

        HomePopup::create([
            'title'=>$request->description,
            'image'=>$img,
            'status'=>$request->status
        ]);
        return redirect('/admin/home-popup');
    }

    public function edit(HomePopup $popup)
    {
        return view('admin.homepopup.update',compact('popup'));
    }

    public function update(HomePopup $popup, Request $request)
    {
        $request->validate([
            'description'=>'string|nullable|max:250',
            'image'=>'image | nullable',
            'oldImage'=>'string|nullable',
            'status'=>'required',
        ]);

        $img = $request->oldImage;
        if(isset($request->image))
        {
            $img=$request->image->store('uploads','public');

        }
               
        $popup->update([
            'title'=>$request->description,
            'image'=>$img,
            'status'=>$request->status
        ]);
        return redirect('/admin/home-popup');
    }

    public function destroy(HomePopup $popup)
    {
        $popup->delete();
        return redirect('/admin/home-popup');
    }

}
