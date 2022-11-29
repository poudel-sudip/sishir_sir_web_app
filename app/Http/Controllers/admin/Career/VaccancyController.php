<?php

namespace App\Http\Controllers\Admin\Career;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VaccancyPost;

class VaccancyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $vaccancies = VaccancyPost::all();
        return view('admin.careers.index',compact('vaccancies'));
    }

    public function create()
    {
        return view('admin.careers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'=>['required','string'],
            'description'=>['required','string'],
            'status'=>['required','string'],
        ]);

        VaccancyPost::create([
            'title'=>$request->title,
            'description'=>$request->description,
            'status'=>$request->status,
        ]);
        return redirect('/admin/careers');
    }

    public function show(VaccancyPost $vaccancy)
    {
        return view('admin.careers.show',compact('vaccancy'));
    }

    public function edit(VaccancyPost $vaccancy)
    {
        return view('admin.careers.edit',compact('vaccancy'));
    }

    public function update(VaccancyPost $vaccancy,Request $request)
    {
        $request->validate([
            'title' =>['required','string'],
            'description' => ['required','string'],
            'status' => 'required|min:1',
        ]);
        
        $vaccancy->update([
            'title'=>$request->title,
            'description'=>$request->description,
            'status'=>$request->status,
        ]);
        return redirect('/admin/careers');
    }

    public function destroy(VaccancyPost $vaccancy)
    {
        $vaccancy->delete();
        return redirect('/admin/careers');
    }
}
