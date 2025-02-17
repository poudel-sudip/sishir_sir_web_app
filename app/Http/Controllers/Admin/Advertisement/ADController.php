<?php

namespace App\Http\Controllers\Admin\Advertisement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Advertisement;

class ADController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = [];
        $data['ads'] = Advertisement::all();
        return view('admin.advertisement.index',$data);
    }

    public function create()
    {
        abort(403,'Not Allowed');
        return view('admin.advertisement.create');
    }

    public function store(Request $request)
    {
        abort(403,'Not Allowed');
        // dd($request->all());
        $request->validate([
            'info'=>'string|nullable|max:250',
            'banner'=>'image | required',
            'status'=>'required|string',
            'position'=>'required|string',
        ]);
        
        $img = '';
        if(isset($request->banner))
        {
            $img = $request->banner->store('uploads','public');
        }

        Advertisement::create([
            'banner' => $img,
            'info' => $request->info,
            'position' => $request->position,
            'status' => $request->status,
        ]);

        return redirect('/admin/advertisement');
    }

    public function edit(Advertisement $ad)
    {
        return view('admin.advertisement.edit',compact('ad'));
    }

    public function update(Advertisement $ad, Request $request)
    {
        $request->validate([
            'info'=>'string|nullable|max:250',
            'banner'=>'image | nullable',
            'old_banner'=>'string | nullable',
            'status'=>'required|string',
            'position'=>'required|string',
            
        ]);

        $img = $request->old_banner;
        if(isset($request->banner))
        {
            $img=$request->banner->store('uploads/advertisement','public');

        }
               
        $ad->update([
            'banner' => $img,
            'status' => $request->status,
        ]);

        return redirect('/admin/advertisement');
    }

    public function destroy(Advertisement $ad)
    {
        abort(403,'Not Allowed');
        $ad->delete();
        return redirect('/admin/advertisement');
    }
}
