<?php

namespace App\Http\Controllers\Admin\Menus;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu\MenuGroup;

class GroupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = [];
        $data['groups'] = MenuGroup::all();
        return view('admin.menus.group.index',$data);
    }

    public function create()
    {
        return view('admin.menus.group.create');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $data = $request->validate([
            'name' => 'string|required',
            'order' => 'numeric|required',
            'status' => 'string|required',
        ]);

        MenuGroup::create($data);

        return redirect('/admin/menus');
    }

    public function edit(MenuGroup $group)
    {
        $data[] = [];
        $data['group'] = $group;
        return view('admin.menus.group.edit',$data);
    }

    public function update(MenuGroup $group, Request $request)
    {
        $data = $request->validate([
            'name' => 'string|required',
            'order' => 'numeric|required',
            'status' => 'string|required',
        ]);

        $group->update($data);
        return redirect('/admin/menus');
    }

    public function destroy(MenuGroup $group, Request $request)
    {
        $group->items()->delete();
        $group->subGroups()->delete();
        $group->delete();
        return redirect('/admin/menus');
    }
}
