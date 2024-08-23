<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categories;

class HighlightController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data['highlights'] = Categories::where('type','=','home_highlight')->get();
        return view('admin.highlight.index',$data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'=>'string|required',
            'link'=>'string|nullable',
        ]);

        Categories::create([
            'type' => 'home_highlight',
            'name' => ucwords($request->title),
            'description' => $request->link,
        ]);

        return redirect('/admin/highlights');
    }

    public function update(Request $request)
    {
        $request->validate([
            'highlight_id'=>'numeric|required',
            'highlight_title'=>'string|required|max:250',
            'highlight_link'=>'string|nullable',
        ]);

        $highlight = Categories::where('type','=','home_highlight')->find($request->highlight_id);
        if($highlight)
        {
            $highlight->update([
                'name' => $request->highlight_title,
                'description' => $request->highlight_link,
            ]);
        }
        
        return redirect('/admin/highlights');

    }

    public function destroy(Categories $highlight)
    {
        $highlight->delete();
        return redirect('/admin/highlights');

    }

}
