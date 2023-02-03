<?php

namespace App\Http\Controllers\Admin\Menus;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu\MenuGroup;
use App\Models\Menu\MenuSubGroup;

class SubGroupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(MenuGroup $group)
    {
        $data = [];
        $data['group'] = $group;
        $data['subgroups'] = $group->subGroups;
        return view('admin.menus.subgroup.index',$data);
    }

    public function create(MenuGroup $group)
    {
        return view('admin.menus.subgroup.create',compact('group'));
    }

    public function store(MenuGroup $group, Request $request)
    {
        $data = $request->validate([
            'name' => 'string|required',
            'order' => 'numeric|required',
            'status' => 'string|required',
            'type' => 'string|required',
            'thumbnail' => 'image|nullable',
        ]);

        if($data['type'] == 'text' || $data['type'] == 'Text')
        {
            $request->validate(['description' => 'string|required|min:5']);
            $data['description'] = $request->description;
        }
        elseif($data['type'] == 'file' || $data['type'] == 'File')
        {
            $request->validate([ 'file' => 'required|file|mimes:pdf' ]);
            $data['filename'] = $request->file->getClientOriginalName();
            $data['fileurl'] = $request->file->storeAs('uploads',$data['filename'],'public');
        }

        if(isset($request->thumbnail))
        {
            $data['thumbnail'] = $request->thumbnail->store('uploads','public');
        }

        $group->subGroups()->create($data);

        return redirect('/admin/menus/'.$group->id.'/sub-groups');
    }

    public function show(MenuGroup $group, MenuSubGroup $subgroup)
    {
        $data[] = [];
        $data['group'] = $group;
        $data['subgroup'] = $subgroup;
        return view('admin.menus.subgroup.show',$data);
    }

    public function edit(MenuGroup $group, MenuSubGroup $subgroup)
    {
        $data[] = [];
        $data['group'] = $group;
        $data['subgroup'] = $subgroup;
        return view('admin.menus.subgroup.edit',$data);
    }

    public function update(MenuGroup $group, MenuSubGroup $subgroup, Request $request)
    {
        $request->validate([
            'name' => 'string|required',
            'order' => 'numeric|required',
            'status' => 'string|required',
            'file' => 'nullable|file|mimes:pdf',
            'old_file' => 'nullable|string',
            'filename' => 'nullable|string',
            'description' => 'string|nullable',
            'type' => 'string|required',
            'thumbnail' => 'image|nullable',
            'old_thumbnail' => 'string|nullable',
        ]);
        
        $data = $request->only(['name','order','status','type']);

        if($data['type'] == 'heading' || $data['type'] == 'Heading')
        {
            $data['filename'] = '';
            $data['fileurl'] = '';
            $data['description'] = '';
        }
        elseif($data['type'] == 'text' || $data['type'] == 'Text')
        {
            $request->validate(['description' => 'string|required|min:5']);
            $data['filename'] = '';
            $data['fileurl'] = '';
            $data['description'] = $request->description;
        }
        elseif($data['type'] == 'file' || $data['type'] == 'File')
        {
            $data['description'] = '';

            if($request->old_file == '' && !isset($request->file))
            {
                return back()->withInput()->withErrors(['file' => 'Please select a pdf file']);
            }
            elseif(isset($request->file))
            {
                $data['filename'] = $request->file->getClientOriginalName();
                $data['fileurl'] = $request->file->storeAs('uploads',$data['filename'],'public');
            }
            else
            {
                $data['fileurl'] = $request->old_file;
                $data['filename'] = $request->filename;
            }
        }
        else {}

        $data['thumbnail'] = $request->old_thumbnail;
        if(isset($request->thumbnail))
        {
            $data['thumbnail'] = $request->thumbnail->store('uploads','public');
        }

        $subgroup->update($data);
        return redirect('/admin/menus/'.$group->id.'/sub-groups');
    }

    public function destroy(MenuGroup $group, MenuSubGroup $subgroup, Request $request)
    {
        $subgroup->items()->delete();
        $subgroup->categories()->delete();
        $subgroup->delete();
        return redirect('/admin/menus/'.$group->id.'/sub-groups');
    }
}
