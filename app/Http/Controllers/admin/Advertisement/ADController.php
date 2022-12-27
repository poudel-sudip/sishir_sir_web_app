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
        return view('admin.advertisement.create');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'banner' => 'image|required',
            'link' => 'string|nullable',
        ]);
        $img = '';
        if(isset($request->banner))
        {
            $img = $request->banner->store('uploads','public');
        }
        Advertisement::create([
            'banner' => $img,
            'link' => $request->link,
        ]);
        return redirect('/admin/advertisement');
    }

    public function destroy(Advertisement $ad)
    {
        $ad->delete();
        return redirect('/admin/advertisement');
    }
}
