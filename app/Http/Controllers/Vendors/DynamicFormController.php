<?php

namespace App\Http\Controllers\Vendors;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Forms\DynamicFormCategory;
use App\Models\Forms\FormApplicant;

class DynamicFormController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function formLists()
    {
        $vendor = auth()->user()->vendor;
        if(ucwords($vendor->enquiry_access) != 'Yes' )
        {
            return redirect('/vendor/home');
        }
        $categories = DynamicFormCategory::where('status','=','Active')->get();
        // dd($forms);
        return view('vendors.dynamicforms.formlists',compact('vendor','categories'));
    }

    public function applicantLists(DynamicFormCategory $category) 
    {
        $vendor = auth()->user()->vendor;
        if(ucwords($vendor->enquiry_access) != 'Yes' )
        {
            return redirect('/vendor/home');
        }
        $applicants = [];
        $coverageArea = '';
        if($vendor->coverage_type=='district')
        {
            $coverageArea = $vendor->district_city;
            $cities =array_map("trim",explode(",",$coverageArea));
            $applicants = $coverageArea!='' ? $category->applicants()->whereIn('district',$cities)->get() : [];
        }
        elseif($vendor->coverage_type=='provience')
        {
            $coverageArea = $vendor->provience;
            $proviences =array_map("trim",explode(",",$coverageArea));
            $applicants = $coverageArea!='' ? $category->applicants()->whereIn('provience',$proviences)->get() : [];
        }
        else{}

        // dd($category,$applicants);
        return view('vendors.dynamicforms.applicants.index',compact('vendor','coverageArea','category','applicants'));

    }

    public function showApplicant(DynamicFormCategory $category, FormApplicant $applicant)
    {
        // dd($category,$applicant);
        return view('vendors.dynamicforms.applicants.show',compact('category','applicant'));

    }

    public function updateApplicant(DynamicFormCategory $category, FormApplicant $applicant, Request $request)
    {
        // dd($category,$applicant);
        $request->validate(['remarks' => 'string|required']);
        $applicant->update([
            'remarks' => $request->remarks,
            'uploaded_by' => ucwords(auth()->user()->name),
        ]);
        return redirect('/vendor/dynamic-forms/'.$category->id.'/applicants');
    }

    public function destroyApplicant(DynamicFormCategory $category, FormApplicant $applicant)
    {
        // dd($category,$applicant);
        $applicant->delete();
        return redirect('/vendor/dynamic-forms/'.$category->id.'/applicants');
    }
}
