<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VaccancyPost;
use App\Models\VaccancyApplicant;
use App\Helpers\Helper;

class FrontCareerController extends Controller
{
     
        
    public function index(Request $request)
    {
        $data['vaccancies'] = VaccancyPost::where('status','=','Active')->orderByDesc('id')->paginate(15);
        return view('front.vaccancy.index',$data);
    }

    public function create()
    {
        $data = [];
        return view('front.vaccancy.create',$data);
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

        $pgurl = strtok($_SERVER['REQUEST_URI'], '?');
        // $pgurl = "//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
        $pgtype = 'article';
        $counterData = Helper::pageCounterCounts($vaccancy->title,$pgurl,$pgtype);

        return view('front.vaccancy.show',compact('vaccancy','counterData'));

    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'title' => 'required|string',
            'author' => 'required|string',
            'description' => 'required|string',
            'pdf_file' => 'nullable|file',
            'img_file' => 'nullable|file',
            'thumbnail' => 'required|image',
        ]);

        $pdf = null;
        $img = null;
        $thumbnail = null;

        if(isset($request->pdf_file))
        {
            $pdf = $request->pdf_file->store('uploads/vaccancy/pdf','public');
        }

        if(isset($request->img_file))
        {
            $img = $request->img_file->store('uploads/vaccancy/pdf','public');
        }

        if(isset($request->thumbnail))
        {
            $thumbnail = $request->thumbnail->store('uploads/vaccancy/thumbnail','public');
        }

        VaccancyPost::create([
            'user_id' => auth()->user()->id ?? null,
            'title' => ucwords($request->title),
            'thumbnail' => $thumbnail,
            'pdf_file' => $pdf,
            'img_file' => $img,
            'author' => ucwords($request->author ?? auth()->user()->name),
            'description' => $request->description,
            'status' => 'Inactive',
        ]); 

        return redirect('/vaccancies')->with('alert_message','The Vaccancy Has Been Posted. It Will Be Published To Public After Review.');

    }


    // public function showApplyForm($slug)
    // {
    //     $vaccancy = VaccancyPost::where('slug','=',$slug)->first();
    //     if(!$vaccancy)
    //     {
    //         abort(404);
    //     }
    //     return view('front.careers.applyform',compact('vaccancy'));

    // }

    // public function saveApplicant($slug, Request $request)
    // {
    //     $vaccancy = VaccancyPost::where('slug','=',$slug)->first();
    //     if(!$vaccancy)
    //     {
    //         abort(404);
    //     }

    //     $request->validate([
    //         "post_name" => "required|string",
    //         "applicant_name" => "required|string",
    //         "email" => "required|email",
    //         "contact" => "required|numeric|digits:10",
    //         "qualification" => "required|string",
    //         "photo" => "image|nullable",
    //         "applicant_cv" => "required",
    //     ]);

    //     $photo = '';
    //     if(isset($request->photo))
    //     {
    //         $photo = $request->photo->store('uploads','public');
    //     }

    //     $cv = '';
    //     if(isset($request->applicant_cv))
    //     {
    //         $cv = $request->applicant_cv->store('uploads/files','public');
    //     }

    //     $vaccancy->applicants()->create([
    //         'post_name' => $request->post_name,
    //         'name' => $request->applicant_name,
    //         'email' => $request->email,
    //         'contact' => $request->contact,
    //         'qualification' => $request->qualification,
    //         'photo' => $photo,
    //         'cv' => $cv,
    //     ]);

    //     return back()->with('successMessage','Your Applicaton is Submitted. You will be Notified once Reviewed.');
    // }
}
