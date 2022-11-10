<?php

namespace App\Http\Controllers\admin\Forms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Forms\DynamicFormCategory;
use App\Models\Forms\DynamicFormGroup;
use App\Models\Teams\TeamFollowupAdminForm;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $categories = DynamicFormCategory::all();
        return view('admin.dynamicforms.categories.index',compact('categories'));
    }

    public function show(DynamicFormCategory $category)
    {
        return view('admin.dynamicforms.categories.show',compact('category'));
    }

    public function create()
    {
        $groups = DynamicFormGroup::all();
        return view('admin.dynamicforms.categories.create',compact('groups'));
    }

    public function edit(DynamicFormCategory $category)
    {
        $groups = DynamicFormGroup::all();
        return view('admin.dynamicforms.categories.edit',compact('category','groups'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $data=$request->validate([
            'group'=>'numeric|nullable',
            'name'=>'required | string',
            'status'=>'required',
            'form_title' => 'string | nullable',
            'banner' => 'image | nullable',
            'element_name' => 'string | nullable',
            'element_email' => 'string | nullable',
            'element_contact' => 'string | nullable',
            'element_provience' => 'string | nullable',
            'element_photo' => 'string | nullable',
            'element_file' => 'string | nullable',
            'element_message' => 'string | nullable',
        ]);
        $category = DynamicFormCategory::create([
            'group_id' => $data['group'],
            'name'=>$data['name'],
            'status'=>$data['status'],
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

        // dd($name,$email,$contact,$provience,$photo,$file,$message);

        $banner = null;
        if(isset($data['banner']))
        {
            $banner = $data['banner']->store('uploads','public');
        }

        $category->form()->create([
            'title' => $data['form_title'] ?? $data['name'],
            'banner' => $banner,
            'status'=>$data['status'],
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
            $redurl = '/admin/dynamic-forms/groups/'.$request->group.'/forms';
        }
        else
        {
            $redurl = '/admin/dynamic-forms/categories';
        }
        return redirect($redurl);
    }

   
    public function update(DynamicFormCategory $category, Request $request)
    {
        // dd($request->all());
        $data=$request->validate([
            'group'=>'numeric|nullable',
            'name'=>'required | string',
            'status'=>'required',
            'form_title' => 'string | nullable',
            'old_banner' => 'string | nullable',
            'banner' => 'image | nullable',
            'element_name' => 'string | nullable',
            'element_email' => 'string | nullable',
            'element_contact' => 'string | nullable',
            'element_provience' => 'string | nullable',
            'element_photo' => 'string | nullable',
            'element_file' => 'string | nullable',
            'element_message' => 'string | nullable',
        ]);


        $category->update([
            'group_id' => $data['group'],
            'name'=>$data['name'],
            'status'=>$data['status'],
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

        // dd($name,$email,$contact,$provience,$photo,$file,$message);

        $banner = $data['old_banner'] ?? null;
        if(isset($data['banner']))
        {
            $banner = $data['banner']->store('uploads','public');
        }

        $category->form()->update([
            'title' => $data['form_title'] ?? $data['name'],
            'banner' => $banner,
            'status'=>$data['status'],
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
            $redurl = '/admin/dynamic-forms/groups/'.$request->group.'/forms';
        }
        else
        {
            $redurl = '/admin/dynamic-forms/categories';
        }
        return redirect($redurl);
    }

    public function destroy(DynamicFormCategory $category)
    {
        $category->assignedTeams()->delete();
        $followups = TeamFollowupAdminForm::where('category_id','=',$category->id)->delete();
        $category->subCategories()->delete();
        $category->form()->delete();
        $category->applicants()->delete();
        $category->delete();
        return redirect('/admin/dynamic-forms/categories');
    }

    public function reset(DynamicFormCategory $category)
    {
        $category->assignedTeams()->delete();
        $followups = TeamFollowupAdminForm::where('category_id','=',$category->id)->delete();
        $category->applicants()->delete();
        return redirect('/admin/dynamic-forms/categories');
    }
}
