<?php

namespace App\Http\Controllers\admin\Forms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\FormApplicantImport;
use App\Exports\Forms\FormApplicantExport;
use App\Exports\Forms\FormApplicantFilteredExport;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use App\Models\Forms\DynamicFormCategory;
use App\Models\Forms\FormApplicant;

class ApplicantController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(DynamicFormCategory $category)
    {
        $applicants = $category->applicants;
        // dd($category,$applicants);
        return view('admin.dynamicforms.applicants.index',compact('category','applicants'));
    }

    public function destroy(DynamicFormCategory $category, FormApplicant $applicant)
    {
        // dd($category,$applicant);
        $applicant->delete();
        return redirect('/admin/dynamic-forms/categories/'.$category->id.'/applicants');
    }

    public function show(DynamicFormCategory $category, FormApplicant $applicant)
    {
        // dd($category,$applicant);
        return view('admin.dynamicforms.applicants.show',compact('category','applicant'));
    }

    public function update(DynamicFormCategory $category, FormApplicant $applicant, Request $request)
    {
        // dd($category,$applicant,$request->all());
        $request->validate(['remarks' => 'string|required|min:2']);
        $applicant->update([
            'remarks' => $request->remarks,
        ]);
        return redirect('/admin/dynamic-forms/categories/'.$category->id.'/applicants');
    }

    public function uploadForm(DynamicFormCategory $category)
    {
        return view('admin.dynamicforms.applicants.upload',compact('category'));
    }

    public function importApplicants(DynamicFormCategory $category, Request $request)
    {
        // dd($category,$request->all());
        $request->validate([
            'file'=>'required',
        ]);
        Excel::import(new FormApplicantImport($category),request()->file('file'));
        return redirect('/admin/dynamic-forms/categories/'.$category->id.'/applicants');
    }

    public function exportApplicants(DynamicFormCategory $category): BinaryFileResponse
    {
        $fname = $category->name.'.xlsx';
        // dd($category,$fname);
        return Excel::download(new FormApplicantExport($category), $fname);
    }

    public function filterApplicants(DynamicFormCategory $category,Request $request)
    {
        $request->validate(['sub_course' => 'required|string']);
        $str = trim(ucwords($request->sub_course));
        $applicants = $category->applicants()->where('sub_category','=',$str)->get();
        // dd($request->all(),$category,$applicants);
        return view('admin.dynamicforms.applicants.filter',compact('category','applicants','str'));
    }

    public function exportFilteredApplicants(DynamicFormCategory $category,$query): BinaryFileResponse
    {
        $fname = $category->name.' - '.$query.'.xlsx';
        // dd($query,$category,$fname);
        return Excel::download(new FormApplicantFilteredExport($category,$query), $fname);
    }

}
