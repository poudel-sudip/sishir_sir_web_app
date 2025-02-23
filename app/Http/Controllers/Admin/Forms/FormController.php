<?php

namespace App\Http\Controllers\Admin\Forms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Forms\FormApplicantExport;
use App\Exports\Forms\FormFilteredApplicantExport;
use App\Models\Forms\DynamicForm;
use App\Models\Forms\DynamicFormGroup;
use App\Models\Forms\DynamicFormApplicant;

class FormController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function formLists()
    {
        $forms = DynamicForm::all();
        return view('admin.dynamicform.index',compact('forms'));
    }

    public function createForm()
    {
        $groups = DynamicFormGroup::all();
        return view('admin.dynamicform.create',compact('groups'));
    }

    public function saveForm(Request $request)
    {
        $data = $request->validate([
            'group'=>'numeric|nullable',
            'form_title' => 'string | required',
            'banner' => 'image | nullable',
            'status'=>'required|min:1',
            'sub_categories' => 'string|nullable',
            'element_name' => 'string | nullable',
            'element_email' => 'string | nullable',
            'element_contact' => 'string | nullable',
            'element_message' => 'string | nullable',
        ]);

        $name = false;
        $email = false;
        $contact = false;
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

        if(isset($data['element_message']) && $data['element_message']=='on')
        {
            $message = true;
        }

        $banner = null;
        if(isset($data['banner']))
        {
            $banner = $data['banner']->store('uploads','public');
        }

        DynamicForm::create([
            'group_id' => $data['group'],
            'title' => ucwords($data['form_title']),
            'banner' => $banner,
            'status'=>$data['status'],
            'sub_categories'=>$data['sub_categories'],
            'name' => $name,
            'email' => $email,
            'contact' => $contact,
            'message' => $message,
        ]);

        $redurl = '';
        if(isset($request->group) && $request->group != '')
        {
            $redurl = '/admin/dynamic-forms/groups/'.$request->group.'/forms';
        }
        else
        {
            $redurl = '/admin/dynamic-forms';
        }
        return redirect($redurl);
    }

    public function showForm(DynamicForm $vform)
    {
        return view('admin.dynamicform.show',compact('vform'));
    }

    public function editForm(DynamicForm $vform)
    {
        $groups = DynamicFormGroup::all();
        return view('admin.dynamicform.edit',compact('vform','groups'));
    }

    public function updateForm(DynamicForm $vform, Request $request)
    {
        $data = $request->validate([
            'group'=>'numeric|nullable',
            'status'=>'required:min:1',
            'form_title' => 'string | required',
            'old_banner' => 'string | nullable',
            'banner' => 'image | nullable',
            'sub_categories' => 'string | nullable',
            'element_name' => 'string | nullable',
            'element_email' => 'string | nullable',
            'element_contact' => 'string | nullable',
            'element_message' => 'string | nullable',
        ]);
        
        $name = false;
        $email = false;
        $contact = false;
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
            'message' => $message,
        ]);

        $redurl = '';
        if(isset($request->group) && $request->group != '')
        {
            $redurl = '/admin/dynamic-forms/groups/'.$request->group.'/forms';
        }
        else
        {
            $redurl = '/admin/dynamic-forms';
        }
        return redirect($redurl);
    }
    
    public function destroyForm(DynamicForm $vform)
    {
        $vform->applicants()->delete();
        $vform->delete();
        return redirect('/admin/dynamic-forms');
    }

    public function resetForm(DynamicForm $vform)
    {
        $vform->applicants()->delete();
        return redirect('/admin/dynamic-forms');
    }

    public function applicantLists(DynamicForm $vform)
    {
        $applicants = $vform->applicants;
        // dd($vform,$applicants);
        return view('admin.dynamicform.applicants.index',compact('vform','applicants'));
    }

    public function destroyApplicant(DynamicForm $vform, DynamicFormApplicant $applicant)
    {
        // dd($vform,$applicant);
        $applicant->delete();
        return redirect('/admin/dynamic-forms/'.$vform->id.'/applicants');
    }

    public function showApplicant(DynamicForm $vform, DynamicFormApplicant $applicant)
    {
        // dd($vform,$applicant);
        return view('admin.dynamicform.applicants.show',compact('vform','applicant'));
    }

    public function updateApplicant(DynamicForm $vform, DynamicFormApplicant $applicant, Request $request)
    {
        // dd($vform,$applicant,$request->all());
        $request->validate([
            'remarks' => 'string|nullable|min:2',
            'message' => 'string|nullable|min:2',
            'sub_category' => 'string|nullable|min:2',
        ]);
        
        if(isset($request->remarks))
        {
            $applicant->update([
                'remarks' => $request->remarks,
            ]);
        }

        if(isset($request->message))
        {
            $applicant->update([
                'message' => $request->message,
            ]);
        }

        if(isset($request->sub_category))
        {
            $applicant->update([
                'sub_category' => $request->sub_category,
            ]);
        }

        return redirect('/admin/dynamic-forms/'.$vform->id.'/applicants');
    }

    public function filteredApplicantLists(DynamicForm $vform, Request $request)
    {
        $request->validate(['sub_course' => 'required|string']);
        $str = trim(ucwords($request->sub_course));
        $applicants = $vform->applicants()->where('sub_category','=',$str)->get();
        // dd($vform,$applicants);
        return view('admin.dynamicform.applicants.filter',compact('vform','applicants','str'));
    }

    public function exportApplicantLists(DynamicForm $vform): BinaryFileResponse
    {
        // $fname = $vform->title.'.xlsx';
        $fname = preg_replace('/[^a-zA-Z0-9]/', '_', $vform->title).'.xlsx';
        // dd($vform,$fname);
        return Excel::download(new FormApplicantExport($vform), $fname);
    }

    public function exportFilteredApplicantLists(DynamicForm $vform,$query): BinaryFileResponse
    {
        // $fname = $vform->title.' - '.$query.'.xlsx';
        $fname = preg_replace('/[^a-zA-Z0-9]/', '_', $vform->title).'_'.$query.'.xlsx';
        // dd($vform,$fname);
        return Excel::download(new FormFilteredApplicantExport($vform,$query), $fname);
    }

    public function uploadApplicantListForm(DynamicForm $vform)
    {
        abort(404);
        // return view('admin.dynamicform.applicants.upload',compact('vform'));
    }

    public function importApplicantLists(DynamicForm $vform, Request $request)
    {
        abort(404);
        // // dd($vform,$request->all());
        // $request->validate([
        //     'file'=>'required',
        // ]);
        // Excel::import(new FormApplicantImport($vform),request()->file('file'));
        // return redirect('/admin/dynamic-forms/'.$vform->id.'/applicants');
    }
}
