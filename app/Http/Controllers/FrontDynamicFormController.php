<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Forms\DynamicFormCategory;
use App\Models\Forms\VendorForm;
use App\Models\Provience\Provience;

class FrontDynamicFormController extends Controller
{
    
    public function formList()
    {
        $forms = DynamicFormCategory::where('status','=','Active')->get()->sortByDesc('id');
        return view('front.forms.formlist',compact('forms'));
    }

    public function showForm($slug)
    {
        $category = DynamicFormCategory::where('slug','=',$slug)->first();
        if(!$category)
        {
            abort(404);
        }

        // if($category->status != 'Active')
        // {
        //     abort(403,'This Form is not Active');
        // }

        if(!$category->form)
        {
            abort(403,'This Form Already Deleted.');
        }

        // dd($category->form);
        $proviences = Provience::all();
        return view('front.forms.showform',compact('category','proviences'));
    }

    public function saveApplicant($slug, Request $request)
    {
        $category = DynamicFormCategory::where('slug','=',$slug)->first();
        if(!$category)
        {
            abort(404);
        }

        // if($category->status != 'Active')
        // {
        //     abort(403,'This Form is not Active');
        // }

        if(!$category->form)
        {
            abort(403,'This Form Already Deleted.');
        }

        $request->validate([
            'sub_course' => 'string|nullable',
            'element_name' => 'string',
            'element_email' => 'email|nullable',
            'element_contact' => 'numeric|nullable',
            'provience' => 'string|nullable',
            'district' => 'string|nullable',
            'element_message' => 'string|nullable',
            'element_photo' => 'image|max:3072|nullable',
            'element_file' => 'mimes:png,jpg,pdf|max:5120|nullable',
        ]);
        $data = array_merge(([
            'sub_course' => null,
            'element_name' => null,
            'element_email' => null,
            'element_contact' => null,
            'provience' => null,
            'district' => null,
            'element_message' => null,
            'element_photo' => null,
            'element_file' => null,
        ]),$request->all()); 

        if(isset($data['element_photo']))
        {
            $data['element_photo'] = $data['element_photo']->store('uploads','public');
        }

        if(isset($data['element_file']))
        {
            $data['element_file'] = $data['element_file']->store('uploads','public');
        }

        // dd($data,$category->applicants);

        $category->applicants()->create([
            'form_id' => $category->form->id,
            'sub_category' => $data['sub_course'],
            'name' => $data['element_name'],
            'email' => $data['element_email'],
            'contact' => $data['element_contact'],
            'provience' => $data['provience'],
            'district' => $data['district'],
            'photo' => $data['element_photo'],
            'file' => $data['element_file'],
            'message' => $data['element_message'],
        ]);

        return back()->with('successMessage','Your Request Has Been Submitted');

    }

    public function showVendorForm($slug)
    {
        $vform = VendorForm::where('slug','=',$slug)->first();
        if(!$vform)
        {
            abort(404);
        }

        // if($vform->status != 'Active')
        // {
        //     abort(403,'This Form is not Active');
        // }

        $proviences = Provience::all();
        return view('front.forms.showvendorform',compact('vform','proviences'));
    }

    public function saveVendorFormApplicant($slug, Request $request)
    {
        $vform = VendorForm::where('slug','=',$slug)->first();
        if(!$vform)
        {
            abort(404);
        }

        // if($vform->status != 'Active')
        // {
        //     abort(403,'This Form is not Active');
        // }

        // dd($request->all());
        $request->validate([
            'sub_course' => 'string|nullable',
            'element_name' => 'string',
            'element_email' => 'email|nullable',
            'element_contact' => 'numeric|nullable',
            'provience' => 'string|nullable',
            'district' => 'string|nullable',
            'element_message' => 'string|nullable',
            'element_photo' => 'image|max:3072|nullable',
            'element_file' => 'mimes:png,jpg,pdf|max:5120|nullable',
        ]);
        $data = array_merge(([
            'sub_course' => null,
            'element_name' => null,
            'element_email' => null,
            'element_contact' => null,
            'provience' => null,
            'district' => null,
            'element_message' => null,
            'element_photo' => null,
            'element_file' => null,
        ]),$request->all()); 

        if(isset($data['element_photo']))
        {
            $data['element_photo'] = $data['element_photo']->store('uploads','public');
        }

        if(isset($data['element_file']))
        {
            $data['element_file'] = $data['element_file']->store('uploads','public');
        }

        // dd($data,$vform);

        $vform->applicants()->create([
            'vendor_id' => $vform->vendor_id,
            'sub_category' => $data['sub_course'],
            'name' => $data['element_name'],
            'email' => $data['element_email'],
            'contact' => $data['element_contact'],
            'provience' => $data['provience'],
            'district' => $data['district'],
            'photo' => $data['element_photo'],
            'file' => $data['element_file'],
            'message' => $data['element_message'],
        ]);

        return back()->with('successMessage','Your Request Has Been Submitted');

    }

}
