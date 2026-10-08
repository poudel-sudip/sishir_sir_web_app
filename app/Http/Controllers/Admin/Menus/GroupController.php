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
        $group->subGroups()->delete();
        $group->delete();
        return redirect('/admin/menus');
    }


    public function getMenuGroupFilesJson(MenuGroup $group, Request $request)
    {      
        $sub_groups = [];
        $menu_categories = [];
        $menu_items = [];
        $pdf_files = [];
        
        if($group->subGroups()->count())  
        {
            $sub_groups = $group->subGroups()->where('status','=','Active')->where('type','=','heading')->get(['id','name']);
            $pdf_files = $group->subGroups()->where('status','=','Active')->where('type','=','file')->get(['id','name','filename','fileurl','status']);
        }
        
        return response()->json(
            [
                'source' => 'sub_group',
                'sub_groups' => $sub_groups,
                'menu_categories' => $menu_categories,
                'menu_items' => $menu_items,
                'pdf_files' => $pdf_files,
            ]
        , 200);
    }
}
