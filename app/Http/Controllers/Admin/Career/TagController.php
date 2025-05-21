<?php

namespace App\Http\Controllers\Admin\Career;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categories as VaccancyTag;

class TagController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $tags = VaccancyTag::where('type','=','vaccancy_tag')->get();
        return view('admin.careers.tag.index',compact('tags'));
    }

    public function create()
    {
        return view('admin.careers.tag.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name'=>'string|required']);
        VaccancyTag::create(['name'=>$request->name,'type'=>'vaccancy_tag','status'=>'Active']);
        return redirect('/admin/careers-tag');
    }

    public function update(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'tag_id'=>'numeric|required',
            'tag_name'=>'string|required'
        ]);

        $tag = VaccancyTag::find($request->tag_id);
        if($tag)
        {
            $tag->update(['name'=>ucwords($request->tag_name)]);
        }

        return redirect('/admin/careers-tag');
    }

    public function destroy(VaccancyTag $tag)
    {
        $tag->delete();
        return redirect('/admin/careers-tag');
    }

    public function vaccancies(VaccancyTag $tag)
    {
        $vaccancies = $tag->vaccancies()->orderByDesc('id')->paginate(50);
        return view('admin.careers.tag.vaccancies',compact('tag','vaccancies'));
    }

}
