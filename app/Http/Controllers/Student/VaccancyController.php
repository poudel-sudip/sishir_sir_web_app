<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VaccancyPost;
use App\Models\VaccancyApplicant;
use App\Helpers\Helper;
use App\Models\Categories as Category;
use Storage;
use Number;

class VaccancyController extends Controller
{
    public function index(Request $request)
    {
        $data['tag_categories'] = Category::where('type','=','vaccancy_tag')->get();
        $data['vaccancies'] = VaccancyPost::where('status','=','Active')->orderByDesc('id')->paginate(10);
        return view('student.vaccancy.index',$data);
    }

    public function tagVaccancies(Category $tag, Request $request)
    {   
        $data['selected_tag'] = $tag;
        $data['tag_categories'] = Category::where('type','=','vaccancy_tag')->get();
        $data['vaccancies'] = $tag->vaccancies()->where('status','=','Active')->orderByDesc('id')->paginate(15);
        return view('student.vaccancy.tagwise',$data);
    }

    public function create()
    {
        $data['tag_categories'] = Category::where('type','=','vaccancy_tag')->get();
        return view('student.vaccancy.create',$data);
    }

    public function show(VaccancyPost $vaccancy)
    {
        // $vaccancy = VaccancyPost::where('slug','=',$slug)->first();
        // if(!$vaccancy)
        // {
        //     abort(404);
        // }

        if($vaccancy->status != 'Active')
        {
            abort(404);
        }

        $pdf_size = "0 KB";
        try {
            $pdf_size = Storage::disk('public')->size($vaccancy->pdf_file);
            $pdf_size = Number::fileSize($pdf_size);
        } catch (\Throwable $th) {
            //throw $th;
        }
        $vaccancy->pdf_size = $pdf_size;

        $img_size = "0 KB";
        try {
            $img_size = Storage::disk('public')->size($vaccancy->img_file);
            $img_size = Number::fileSize($img_size);
        } catch (\Throwable $th) {
            //throw $th;
        }
        $vaccancy->img_size = $img_size;
        
        // $pgurl = strtok($_SERVER['REQUEST_URI'], '?');
        // $pgurl = "//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
        $pgurl = "/vaccancies/".$vaccancy->id;
        $pgtype = 'article';
        $counterData = Helper::pageCounterCounts($vaccancy->title,$pgurl,$pgtype);

        return view('student.vaccancy.show',compact('vaccancy','counterData'));

    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'title' => 'required|string',
            'author' => 'required|string',
            'description' => 'required|string',
            'pdf_file' => 'nullable|file',
            'thumbnail' => 'required|image',
            'related_rags' => 'array|nullable',
            'source' => 'nullable|source',
        ]);

        $pdf = null;
        $thumbnail = null;
        $related_tags = [];
        if(isset($request->related_tags) && is_array($request->related_tags))
        {
            $related_tags = (array_map('intval', $request->related_tags));
        }

        if(isset($request->pdf_file))
        {
            $pdf = $request->pdf_file->store('uploads/vaccancy/pdf','public');
        }

        if(isset($request->thumbnail))
        {
            $thumbnail = $request->thumbnail->store('uploads/vaccancy/thumbnail','public');
        }

        VaccancyPost::create([
            'user_id' => auth()->user()->id ?? null,
            'title' => $request->title,
            'thumbnail' => $thumbnail,
            'pdf_file' => $pdf,
            'author' => ucwords($request->author ?? auth()->user()->name),
            'description' => $request->description,
            'status' => 'Inactive',
            'tag_ids' => $related_tags,
            'source' => $request->source,
        ]); 

        return redirect('/student/vaccancies')->with('alert_message','The Vacancy Has Been Posted. It Will Be Published To Public After Review.');

    }
}
