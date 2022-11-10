<?php

namespace App\Http\Controllers\Vendors;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StudentEnquiry;
use App\Models\Course;

class EnquiryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $vendor = auth()->user()->vendor;
        if(ucwords($vendor->enquiry_access) != 'Yes' )
        {
            return redirect('/vendor/home');
        }
        $enquiries = [];
        $coverageArea = '';
        if($vendor->coverage_type=='district')
        {
            $coverageArea = $vendor->district_city;
            $cities =array_map("trim",explode(",",$coverageArea));
            $enquiries = $coverageArea!='' ? StudentEnquiry::whereIn('district',$cities)->get() : [];
        }
        elseif($vendor->coverage_type=='provience')
        {
            $coverageArea = $vendor->provience;
            $proviences =array_map("trim",explode(",",$coverageArea));
            $enquiries = $coverageArea!='' ? StudentEnquiry::whereIn('provience',$proviences)->get() : [];
        }
        else{}

        // dd($vendor,$enquiries,$coverageArea);
        return view('vendors.enquiries.index',compact('vendor','coverageArea','enquiries'));
    }

    public function edit(StudentEnquiry $enquiry)
    {
        return view('vendors.enquiries.edit',compact('enquiry'));
    }

    public function update(StudentEnquiry $enquiry,Request $request)
    {
        $request->validate([
            'remarks'=>'string|nullable',
        ]);

         $enquiry->update([
            'remarks'=>$request->remarks,
        ]);

        return redirect('/vendor/enquiries');
    }

    public function destroy(StudentEnquiry $enquiry)
    {
        $enquiry->delete();
        return redirect('/vendor/enquiries');
    }

    public function filterFormShow()
    {
        $vendor = auth()->user()->vendor;
        if(ucwords($vendor->enquiry_access) != 'Yes' )
        {
            return redirect('/vendor/home');
        }
        $enquiries = [];
        $coverageArea = '';
        $courses = Course::all();
        return view('vendors.enquiries.filter',compact('vendor','coverageArea','enquiries','courses'));
    }

    public function filterResults(Request $request)
    {
        $request->validate([
            'course'=>'numeric|required',
        ]);

        $vendor = auth()->user()->vendor;
        if(ucwords($vendor->enquiry_access) != 'Yes' )
        {
            return redirect('/vendor/home');
        }
        $enquiries = [];
        $coverageArea = '';
        $courses = Course::all();
        $filterValue = Course::find($request->course)->name ?? '';
        if($vendor->coverage_type=='district')
        {
            $coverageArea = $vendor->district_city;
            $cities =array_map("trim",explode(",",$coverageArea));
            $enquiries = $coverageArea!='' ? StudentEnquiry::where('course_id','=',$request->course)->whereIn('district',$cities)->get() : [];
        }
        elseif($vendor->coverage_type=='provience')
        {
            $coverageArea = $vendor->provience;
            $proviences =array_map("trim",explode(",",$coverageArea));
            $enquiries = $coverageArea!='' ? StudentEnquiry::where('course_id','=',$request->course)->whereIn('provience',$proviences)->get() : [];
        }
        else{}

        return view('vendors.enquiries.filter',compact('vendor','coverageArea','enquiries','courses','filterValue'));
    }
}
