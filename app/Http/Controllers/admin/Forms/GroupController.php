<?php

namespace App\Http\Controllers\admin\Forms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Forms\DynamicFormGroup;

class GroupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $groups = DynamicFormGroup::all();
        return view('admin.dynamicforms.group.index',compact('groups'));
    }

    public function store(Request $request)
    {
        $request->validate(['group'=> 'string|required|min:2']);
        DynamicFormGroup::create(['name'=>ucwords($request->group)]);
        return redirect('/admin/dynamic-forms/groups');
    }

    public function update(Request $request)
    {
        $request->validate([
            'group_id' => 'numeric|required|min:1',
            'group_name' => 'string|required',
        ]);
        DynamicFormGroup::find($request->group_id)->update(['name'=>$request->group_name]);
        return redirect('/admin/dynamic-forms/groups');
    }

    public function destroy(DynamicFormGroup $group)
    {
        $group->delete();
        return redirect('/admin/dynamic-forms/groups');
    }

    public function forms(DynamicFormGroup $group)
    {
        $categories = $group->categories;
        return view('admin.dynamicforms.group.categories',compact('group','categories'));
    }

    public function applicants(DynamicFormGroup $group)
    {
        $applicants = $group->applicants;
        return view('admin.dynamicforms.group.applicants',compact('group','applicants'));
    }
}
