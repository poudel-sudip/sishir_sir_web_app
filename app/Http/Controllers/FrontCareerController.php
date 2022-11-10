<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VaccancyPost;
use App\Models\VaccancyApplicant;

class FrontCareerController extends Controller
{
    public function index()
    {
        $vaccancies = VaccancyPost::where('status','=','Active')->get()->sortByDesc('id');
        return view('front.careers.careerlist',compact('vaccancies'));
    }

    public function show($slug)
    {
        $vaccancy = VaccancyPost::where('slug','=',$slug)->first();
        if(!$vaccancy)
        {
            abort(404);
        }
        return view('front.careers.careerdetails',compact('vaccancy'));

    }

    public function showApplyForm($slug)
    {
        $vaccancy = VaccancyPost::where('slug','=',$slug)->first();
        if(!$vaccancy)
        {
            abort(404);
        }
        return view('front.careers.applyform',compact('vaccancy'));

    }

    public function saveApplicant($slug, Request $request)
    {
        $vaccancy = VaccancyPost::where('slug','=',$slug)->first();
        if(!$vaccancy)
        {
            abort(404);
        }

        $request->validate([
            "post_name" => "required|string",
            "applicant_name" => "required|string",
            "email" => "required|email",
            "contact" => "required|numeric|digits:10",
            "qualification" => "required|string",
            "photo" => "image|nullable",
            "applicant_cv" => "required",
        ]);

        $photo = '';
        if(isset($request->photo))
        {
            $photo = $request->photo->store('uploads','public');
        }

        $cv = '';
        if(isset($request->applicant_cv))
        {
            $cv = $request->applicant_cv->store('uploads/files','public');
        }

        $vaccancy->applicants()->create([
            'post_name' => $request->post_name,
            'name' => $request->applicant_name,
            'email' => $request->email,
            'contact' => $request->contact,
            'qualification' => $request->qualification,
            'photo' => $photo,
            'cv' => $cv,
        ]);

        return back()->with('successMessage','Your Applicaton is Submitted. You will be Notified once Reviewed.');
    }
}
