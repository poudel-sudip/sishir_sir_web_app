<?php

namespace App\Http\Controllers\Admin\Menus;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu\MenuGroup;
use App\Models\Menu\MenuSubGroup;
use App\Models\Menu\MenuItem;

class ItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(MenuGroup $group, MenuSubGroup $subgroup)
    {
        $data = [];
        $data['group'] = $group;
        $data['subgroup'] = $subgroup;
        $data['items'] = $subgroup->items;
        // dd($data);
        return view('admin.menus.items.index',$data);
    }

    public function create(MenuGroup $group, MenuSubGroup $subgroup)
    {
        $data = [];
        $data['group'] = $group;
        $data['subgroup'] = $subgroup;
        return view('admin.menus.items.create',$data);
    }

    public function store(Menugroup $group, MenuSubGroup $subgroup, Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'string|required',
            'order' => 'numeric|required',
            'status' => 'string|required',
            'file' => 'nullable|file|mimes:pdf',
            'description' => 'string|nullable',
            'type' => 'string|required',
        ]);
        $data = $request->only(['name','order','status','description','type']);
        $data['filename'] = '';
        $data['fileurl'] = '';
        if($data['type'] == 'file' && !isset($request->file))
        {
            return back()->withInput()->withErrors(['file' => 'Please select a pdf file']);
        }

        if(isset($request->file))
        {
            $data['filename'] = $request->file->getClientOriginalName();
            $data['fileurl'] = $request->file->storeAs('uploads',$data['filename'],'public');
        }
        $subgroup->items()->create($data);
        return redirect('/admin/menus/'.$group->id.'/sub-groups/'.$subgroup->id.'/items');
    }

    public function edit(Menugroup $group, MenuSubGroup $subgroup, MenuItem $item)
    {
        $data = [];
        $data['group'] = $group;
        $data['subgroup'] = $subgroup;
        $data['item'] = $item;
        return view('admin.menus.items.edit',$data);
    }

    public function update(Menugroup $group, MenuSubGroup $subgroup, MenuItem $item, Request $request)
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
        ]);
        $data = $request->only(['name','order','status','filename','type','description']);
        $data['fileurl'] = $request->old_file;

        if($data['type'] == 'file' && $request->old_file =='')
        {
            return back()->withInput()->withErrors(['file' => 'Please select a pdf file']);
        }
        if(isset($request->file))
        {
            $data['filename'] = $request->file->getClientOriginalName();
            $data['fileurl'] = $request->file->storeAs('uploads',$data['filename'],'public');
        }
        // dd($request->all(),$data);
        $item->update($data);
        return redirect('/admin/menus/'.$group->id.'/sub-groups/'.$subgroup->id.'/items');
    }

    public function show(Menugroup $group, MenuSubGroup $subgroup, MenuItem $item)
    {
        $data = [];
        $data['group'] = $group;
        $data['subgroup'] = $subgroup;
        $data['item'] = $item;
        return view('admin.menus.items.show',$data);
    }

    public function destroy(Menugroup $group, MenuSubGroup $subgroup, MenuItem $item)
    {
        $item->delete();
        return redirect('/admin/menus/'.$group->id.'/sub-groups/'.$subgroup->id.'/items');
    }
}
