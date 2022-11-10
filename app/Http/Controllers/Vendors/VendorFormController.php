<?php

namespace App\Http\Controllers\Vendors;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\VendorFormApplicantImport;
use App\Exports\Forms\VendorFormApplicantExport;
use App\Exports\Forms\VendorFormFilteredApplicantExport;
use App\Models\Forms\VendorForm;
use App\Models\Forms\VendorFormApplicant;

class VendorFormController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function formLists()
    {
        $vendor = auth()->user()->vendor;
        $forms = $vendor->forms;
        // dd($forms);
        return view('vendors.vendorforms.index',compact('forms'));
    }

    public function createForm()
    {
        $vendor = auth()->user()->vendor;
        $groups = $vendor->formGroups;
        return view('vendors.vendorforms.create',compact('vendor','groups'));
    }

    public function saveForm(Request $request)
    {
        $vendor = auth()->user()->vendor;
        // dd($request->all());
        $data=$request->validate([
            'group'=>'numeric|nullable',
            'form_title' => 'string | required',
            'banner' => 'image | nullable',
            'status'=>'required|min:1',
            'sub_categories' => 'string|nullable',
            'element_name' => 'string | nullable',
            'element_email' => 'string | nullable',
            'element_contact' => 'string | nullable',
            'element_provience' => 'string | nullable',
            'element_photo' => 'string | nullable',
            'element_file' => 'string | nullable',
            'element_message' => 'string | nullable',
        ]);

        $name = false;
        $email = false;
        $contact = false;
        $provience = false;
        $photo = false;
        $file = false;
        $message = false;
        
        if(isset($data['element_name']) && $data['element_name']=='on')
        {
            $name = true;
        }

        if(isset($data['element_email']) && $data['element_email']=='on')
        {
            $email = true;
        }

        if(isset($data['element_contact']) && $data['element_contact']=='on')
        {
            $contact = true;
        }

        if(isset($data['element_provience']) && $data['element_provience']=='on')
        {
            $provience = true;
        }

        if(isset($data['element_photo']) && $data['element_photo']=='on')
        {
            $photo = true;
        }

        if(isset($data['element_file']) && $data['element_file']=='on')
        {
            $file = true;
        }

        if(isset($data['element_message']) && $data['element_message']=='on')
        {
            $message = true;
        }

        $banner = null;
        if(isset($data['banner']))
        {
            $banner = $data['banner']->store('uploads','public');
        }

        $vendor->forms()->create([
            'group_id' => $data['group'],
            'title' => ucwords($data['form_title']),
            'banner' => $banner,
            'status'=>$data['status'],
            'sub_categories'=>$data['sub_categories'],
            'name' => $name,
            'email' => $email,
            'contact' => $contact,
            'provience' => $provience,
            'photo' => $photo,
            'file' => $file,
            'message' => $message,
            
        ]);

        $redurl = '';
        if(isset($request->group) && $request->group != '')
        {
            $redurl = '/vendor/vendor-dynamic-forms/groups/'.$request->group.'/forms';
        }
        else
        {
            $redurl = '/vendor/vendor-dynamic-forms';
        }
        return redirect($redurl);
    }

    public function showForm(VendorForm $vform)
    {
        return view('vendors.vendorforms.show',compact('vform'));
    }

    public function editForm(VendorForm $vform)
    {
        $vendor = auth()->user()->vendor;
        $groups = $vendor->formGroups;
        return view('vendors.vendorforms.edit',compact('vform','groups'));
    }

    public function updateForm(VendorForm $vform, Request $request)
    {
        // dd($request->all());
        $data=$request->validate([
            'group'=>'numeric|nullable',
            'status'=>'required:min:1',
            'form_title' => 'string | required',
            'old_banner' => 'string | nullable',
            'banner' => 'image | nullable',
            'sub_categories' => 'string | nullable',
            'element_name' => 'string | nullable',
            'element_email' => 'string | nullable',
            'element_contact' => 'string | nullable',
            'element_provience' => 'string | nullable',
            'element_photo' => 'string | nullable',
            'element_file' => 'string | nullable',
            'element_message' => 'string | nullable',
        ]);
        
        $name = false;
        $email = false;
        $contact = false;
        $provience = false;
        $photo = false;
        $file = false;
        $message = false;
        
        if(isset($data['element_name']) && $data['element_name']=='on')
        {
            $name = true;
        }

        if(isset($data['element_email']) && $data['element_email']=='on')
        {
            $email = true;
        }

        if(isset($data['element_contact']) && $data['element_contact']=='on')
        {
            $contact = true;
        }

        if(isset($data['element_provience']) && $data['element_provience']=='on')
        {
            $provience = true;
        }

        if(isset($data['element_photo']) && $data['element_photo']=='on')
        {
            $photo = true;
        }

        if(isset($data['element_file']) && $data['element_file']=='on')
        {
            $file = true;
        }

        if(isset($data['element_message']) && $data['element_message']=='on')
        {
            $message = true;
        }

        $banner = $data['old_banner'] ?? null;
        if(isset($data['banner']))
        {
            $banner = $data['banner']->store('uploads','public');
        }

        $vform->update([
            'group_id' => $data['group'],
            'title' => ucwords($data['form_title']),
            'banner' => $banner,
            'status'=>$data['status'],
            'sub_categories'=>$data['sub_categories'],
            'name' => $name,
            'email' => $email,
            'contact' => $contact,
            'provience' => $provience,
            'photo' => $photo,
            'file' => $file,
            'message' => $message,
        ]);

        $redurl = '';
        if(isset($request->group) && $request->group != '')
        {
            $redurl = '/vendor/vendor-dynamic-forms/groups/'.$request->group.'/forms';
        }
        else
        {
            $redurl = '/vendor/vendor-dynamic-forms';
        }
        return redirect($redurl);
    }
    
    public function destroyForm(VendorForm $vform)
    {
        // dd($vform);
        $vform->applicants()->delete();
        $vform->delete();
        return redirect('/vendor/vendor-dynamic-forms');
    }

    public function resetForm(VendorForm $vform)
    {
        // dd($vform);
        $vform->applicants()->delete();
        return redirect('/vendor/vendor-dynamic-forms');
    }

    public function applicantLists(VendorForm $vform)
    {
        $applicants = $vform->applicants;
        // dd($vform,$applicants);
        return view('vendors.vendorforms.applicants.index',compact('vform','applicants'));
    }

    public function destroyApplicant(VendorForm $vform, VendorFormApplicant $applicant)
    {
        // dd($vform,$applicant);
        $applicant->delete();
        return redirect('/vendor/vendor-dynamic-forms/'.$vform->id.'/applicants');
    }

    public function showApplicant(VendorForm $vform, VendorFormApplicant $applicant)
    {
        // dd($vform,$applicant);
        return view('vendors.vendorforms.applicants.show',compact('vform','applicant'));
    }

    public function updateApplicant(VendorForm $vform, VendorFormApplicant $applicant, Request $request)
    {
        // dd($vform,$applicant,$request->all());
        $request->validate(['remarks' => 'required|string|min:2']);
        $applicant->update([
            'remarks' => $request->remarks,
            'uploaded_by' => ucwords(auth()->user()->name),
        ]);

        return redirect('/vendor/vendor-dynamic-forms/'.$vform->id.'/applicants');
    }

    public function filteredApplicantLists(VendorForm $vform, Request $request)
    {
        $request->validate(['sub_course' => 'required|string']);
        $str = trim(ucwords($request->sub_course));
        $applicants = $vform->applicants()->where('sub_category','=',$str)->get();
        // dd($vform,$applicants);
        return view('vendors.vendorforms.applicants.filter',compact('vform','applicants','str'));
    }

    public function exportApplicantLists(VendorForm $vform): BinaryFileResponse
    {
        $fname = $vform->title.'.xlsx';
        // dd($vform,$fname);
        return Excel::download(new VendorFormApplicantExport($vform), $fname);
    }

    public function exportFilteredApplicantLists(VendorForm $vform,$query): BinaryFileResponse
    {
        $fname = $vform->title.' - '.$query.'.xlsx';
        // dd($vform,$fname);
        return Excel::download(new VendorFormFilteredApplicantExport($vform,$query), $fname);
    }

    public function uploadApplicantListForm(VendorForm $vform)
    {
        return view('vendors.vendorforms.applicants.upload',compact('vform'));
    }

    public function importApplicantLists(VendorForm $vform, Request $request)
    {
        // dd($vform,$request->all());
        $request->validate([
            'file'=>'required',
        ]);
        Excel::import(new VendorFormApplicantImport($vform),request()->file('file'));
        return redirect('/vendor/vendor-dynamic-forms/'.$vform->id.'/applicants');
    }
}
