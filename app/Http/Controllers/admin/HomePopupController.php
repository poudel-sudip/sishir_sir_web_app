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
        $data=request()->validate([
            'title'=>'required',
            'image'=>'image | required',
            'link'=>'',
            'status'=>'',
        ]);
        $imagePath=request('image')->store('uploads','public');
        HomePopup::create([
            'title'=>$data['title'],
            'image'=>$imagePath,
            'link'=>$data['link'] ?? '',
            'status'=>$data['status']
        ]);
        return redirect('/admin/home-popup');
    }

    public function edit(HomePopup $popup)
    {
        return view('admin.homepopup.update',compact('popup'));
    }

    public function update(HomePopup $popup)
    {
        $data=request()->validate([
            'title'=>'',
            'link'=>'',
            'oldImage'=>'string',
            'image'=>'',
            'status'=>'',
        ]);

        $imagePath=$data['oldImage'];
        if(isset($data['image']))
        {
            $imagePath=request('image')->store('uploads','public');
        }
        $popup->update([
            'title'=>$data['title'],
            'image'=>$imagePath,
            'link'=>$data['link'],
            'status'=>$data['status'],
        ]);
        return redirect('/admin/home-popup');
    }

    public function destroy(HomePopup $popup)
    {
        $popup->delete();
        return redirect('/admin/home-popup');
    }

}
