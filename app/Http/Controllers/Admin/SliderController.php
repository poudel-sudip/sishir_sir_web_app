<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class SliderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $sliders=Slider::all()->sortBy('order');
        return view('admin.slider.index',compact('sliders'));
    }

    public function create()
    {
        return view('admin.slider.create');
    }

    public function store()
    {
        $data=request()->validate([
            'sliderImage'=>'image',
            'order'=>'',
            'title'=>'',
            'description'=>'',
        ]);
        $imagePath=request('sliderImage')->store('uploads','public');
        Slider::create([
            'order'=>$data['order'],
            'title'=>$data['title'],
            'description'=>$data['description'],
            'image'=>$imagePath,
        ]);
        return redirect('/admin/sliders');
    }

    public function edit(Slider $slider)
    {
        return view('admin.slider.edit',compact('slider'));
    }

    public function update(Slider $slider)
    {
        $data=request()->validate([
            'order'=>'',
            'title'=>'',
            'description'=>'',
            'oldImage'=>'string',
            'sliderImage'=>'',
        ]);

        $imagePath=$data['oldImage'];
        if(isset($data['sliderImage']))
        {
            $imagePath=request('sliderImage')->store('uploads','public');
        }
        $slider->update([
            'order'=>$data['order'],
            'title'=>$data['title'],
            'description'=>$data['description'],
            'image'=>$imagePath,
        ]);
        return redirect('/admin/sliders');
    }

    public function destroy(Slider $slider)
    {
        $slider->delete();
        return redirect('/admin/sliders');
    }
}
