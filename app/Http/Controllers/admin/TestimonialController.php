<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TestimonialController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $testimonials=Testimonial::all()->sortByDesc('created_at');
        return view('admin.testimonial.index',compact('testimonials'));
    }

    public function create()
    {
        Gate::authorize('permission','testimonial');
        return view('admin.testimonial.create');
    }

    public function store()
    {
        Gate::authorize('permission','testimonial');
        $data=request()->validate([
            'name'=>'required | string',
            'role'=>'',
            'email'=>'',
            'description'=>'string',
            'image'=>'',
        ]);
        $imgpath='';
        if(isset($data['image']))
        {
            $imgpath=request('image')->store('uploads','public');
        }
        Testimonial::create([
           'name'=>$data['name'],
           'role'=>$data['role'] ?? 'Visitor',
           'email'=>$data['email'],
           'message'=>$data['description'],
           'image'=>$imgpath,
        ]);
        return redirect('/admin/testimonials');
    }

    public function edit(Testimonial $testimonial)
    {
        Gate::authorize('permission','testimonial');
        return view('admin.testimonial.edit',compact('testimonial'));
    }

    public function update(Testimonial $testimonial)
    {
        Gate::authorize('permission','testimonial');
        $data=request()->validate([
            'name'=>'required | string',
            'role'=>'',
            'email'=>'',
            'description'=>'string',
            'image'=>'',
            'oldImage'=>'string',
        ]);
        $imagePath=$data['oldImage'];
        if(isset($data['image']))
        {
            $imagePath=request('image')->store('uploads','public');
        }
        $testimonial->update([
            'name'=>$data['name'],
            'role'=>$data['role'] ?? 'Visitor',
            'email'=>$data['email'],
            'message'=>$data['description'],
            'image'=>$imagePath,
        ]);
        return redirect('/admin/testimonials');
    }

    public function destroy(Testimonial $testimonial)
    {
        Gate::authorize('permission','testimonial');
        $testimonial->delete();
        return redirect('/admin/testimonials');
    }
}
