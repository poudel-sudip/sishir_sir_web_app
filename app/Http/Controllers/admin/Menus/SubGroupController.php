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
        // dd($request->all());
        $data = $request->validate([
            'name' => 'string|required',
            'order' => 'numeric|required',
            'status' => 'string|required',
        ]);

        $group->subGroups()->create($data);

        return redirect('/admin/menus/'.$group->id.'/sub-groups');
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
        $data = $request->validate([
            'name' => 'string|required',
            'order' => 'numeric|required',
            'status' => 'string|required',
        ]);

        $subgroup->update($data);
        return redirect('/admin/menus/'.$group->id.'/sub-groups');
    }

    public function destroy(MenuGroup $group, MenuSubGroup $subgroup, Request $request)
    {
        $subgroup->items()->delete();
        $subgroup->delete();
        return redirect('/admin/menus/'.$group->id.'/sub-groups');
    }
}
