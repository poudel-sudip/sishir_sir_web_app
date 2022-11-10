<?php

namespace App\Http\Controllers\admin\Orientation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Orientation;

class OrientationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $orientations = Orientation::all();
        // dd($orientations);
        return view('admin.orientation.index',compact('orientations'));
    }

    public function create()
    {
        return view('admin.orientation.create');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            "course" => "string|required",
            "date" => "string|required",
            "time" => "string|nullable",
            "join_link" => "string|nullable",
            "description" => "string|nullable",
            "status" => "string|required",
            "image" => "image|nullable",
        ]);
        $img = null;
        if(isset($request->image))
        {
            $img = $request->image->store('uploads','public');
        }

        Orientation::create([
            'course' => ucwords($request->course),
            'image' => $img,
            'join_link' => $request->join_link,
            'date' => $request->date,
            'time' => $request->time,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        return redirect('/admin/orientations');
    }

    public function show(Orientation $orientation)
    {
        return view('admin.orientation.show',compact('orientation'));
    }

    public function edit(Orientation $orientation)
    {
        return view('admin.orientation.edit',compact('orientation'));
    }

    public function update(Orientation $orientation, Request $request)
    {
        // dd($orientation,$request->all());
        $request->validate([
            "course" => "string|required",
            "date" => "string|required",
            "time" => "string|nullable",
            "join_link" => "string|nullable",
            "description" => "string|nullable",
            "status" => "string|required",
            "old_image" => "string|nullable",
            "image" => "image|nullable",
        ]);
        $img = $request->old_image;
        if(isset($request->image))
        {
            $img = $request->image->store('uploads','public');
        }
        $orientation->update([
            'course' => ucwords($request->course),
            'image' => $img,
            'join_link' => $request->join_link,
            'date' => $request->date,
            'time' => $request->time,
            'description' => $request->description,
            'status' => $request->status,
        ]);
        return redirect('/admin/orientations');

    }

    public function destroy(Orientation $orientation)
    {
        // dd($orientation);
        $orientation->delete();
        return redirect('/admin/orientations');
    }
}
