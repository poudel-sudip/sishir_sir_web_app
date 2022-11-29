<?php

namespace App\Http\Controllers\Leads;

use App\Http\Controllers\Controller;
use App\Models\StudentEnquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\EnquiryForm;
use App\Models\Course;

class EnquiryController extends Controller
{

    public function index()
    {
        $enquiries=StudentEnquiry::all()->sortByDesc('id');
        return view('admin.leads.index',compact('enquiries'));
    }

    public function edit(StudentEnquiry $enquiry)
    {
        return view('admin.leads.edit',compact('enquiry'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name'=>'string',
            'email'=>'email',
            'contact'=>'numeric| digits:10',
            'course'=>'min:1',
            'message'=>'string',
            'provience'=>'string|nullable',
            'district'=>'string|nullable',
            
        ]);
      StudentEnquiry::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'contact'=>$request->contact,
            'course_id'=>$request->course,
            'message'=>$request->message,
            'provience'=>$request->provience ?? '',
            'district'=>$request->district ?? '',
        ]);

        return back()->with('successMessage','Your Query Has Been Submitted');
    }

    public function update(StudentEnquiry $enquiry,Request $request)
    {
        $request->validate([
            'remarks'=>'string',
        ]);

         $enquiry->update([
            'remarks'=>$request->remarks,
        ]);

        // return redirect('/leads/enquiries');
        return redirect('/leads/enquiries/filter');
    }

    public function destroy(StudentEnquiry $enquiry)
    {
        $enquiry->delete();
        return redirect('/leads/enquiries');
    }

    public function getEnquiryFormList()
    {
        $enquiryforms = EnquiryForm::all();
        $courses = Course::all();
        return view('admin.leads.forms',compact('enquiryforms','courses'));
    }

    public function saveEnquiryForm(Request $request)
    {
        $request->validate(['course'=>'numeric|required']);
        $course = Course::find($request->course);
        EnquiryForm::create([
            'course_id'=>$course->id,
            'course_name'=>$course->name,
            'enquiry_link'=>'/enquiry/'.$course->slug,
        ]);

        return redirect('/admin/enquiry-form');
    }

    public function deleteEnquiryForm(EnquiryForm $form)
    {
        $form->delete();
        return redirect('/admin/enquiry-form');
    }

    public function filterFormShow()
    {
        $enquiries = [];
        $courses = Course::all();
        return view('admin.leads.filter',compact('enquiries','courses'));
    }

    public function filterResults(Request $request)
    {
        $request->validate([
            'course'=>'numeric|required',
        ]);

        $enquiries = [];
        $courses = Course::all();
        $filterValue = Course::find($request->course)->name ?? '';
        $enquiries = StudentEnquiry::where('course_id','=',$request->course)->get();

        return view('admin.leads.filter',compact('enquiries','courses','filterValue'));
    }
}
