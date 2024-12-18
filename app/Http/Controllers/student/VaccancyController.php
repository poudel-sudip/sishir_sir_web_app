<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VaccancyPost;
use App\Models\VaccancyApplicant;
use App\Helpers\Helper;

class VaccancyController extends Controller
{
    public function index(Request $request)
    {
        $data['vaccancies'] = VaccancyPost::where('status','=','Active')->orderByDesc('id')->paginate(10);
        return view('student.vaccancy.index',$data);
    }

    public function create()
    {
        $data = [];
        return view('student.vaccancy.create',$data);
    }

    public function show($slug)
    {
        $vaccancy = VaccancyPost::where('slug','=',$slug)->first();
        if(!$vaccancy)
        {
            abort(404);
        }

        if($vaccancy->status != 'Active')
        {
            abort(404);
        }

        // $pgurl = strtok($_SERVER['REQUEST_URI'], '?');
        // $pgurl = "//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
        $pgurl = "/vaccancies/".$vaccancy->slug;
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
        ]);

        $pdf = null;
        $thumbnail = null;

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
        ]); 

        return redirect('/student/vaccancies')->with('alert_message','The Vaccancy Has Been Posted. It Will Be Published To Public After Review.');

    }
}
