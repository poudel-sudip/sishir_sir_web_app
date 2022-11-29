<?php

namespace App\Http\Controllers\Admin\Career;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VaccancyPost;
use App\Models\VaccancyApplicant;

class ApplicantController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(VaccancyPost $vaccancy)
    {
        $applicants = $vaccancy->applicants;
        return view('admin.careers.applicants.index',compact('vaccancy','applicants'));
    }

    public function show(VaccancyPost $vaccancy, VaccancyApplicant $applicant)
    {
        return view('admin.careers.applicants.show',compact('vaccancy','applicant'));
    }

    public function edit(VaccancyPost $vaccancy, VaccancyApplicant $applicant)
    {
        return view('admin.careers.applicants.edit',compact('vaccancy','applicant'));
    }

    public function update(Request $request, VaccancyPost $vaccancy, VaccancyApplicant $applicant)
    {
        $request->validate([
            "post" => "required|string",
            "name" => "required|string",
            "email" => "required|string",
            "contact" => "required|numeric",
            "qualification" => "required|string",
            "remarks" => "string|nullable",
        ]);

        $applicant->update([
            "post_name" => $request->post,
            "name" => $request->name,
            "email" => $request->email,
            "contact" => $request->contact,
            "qualification" => $request->qualification,
            "remarks" => $request->remarks,
        ]);

        return redirect('/admin/careers/'.$vaccancy->id.'/applicants');
    }

    public function destroy(VaccancyPost $vaccancy, VaccancyApplicant $applicant)
    {
        $applicant->delete();
        return redirect('/admin/careers/'.$vaccancy->id.'/applicants');
    }

}
