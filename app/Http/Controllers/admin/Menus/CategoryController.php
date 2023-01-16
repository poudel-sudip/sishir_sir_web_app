<?php

namespace App\Http\Controllers\Admin\Menus;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu\MenuGroup;
use App\Models\Menu\MenuSubGroup;
use App\Models\Menu\MenuItemCategory;

class CategoryController extends Controller
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
        $data['categories'] = $subgroup->categories;
        // dd($data);
        return view('admin.menus.category.index',$data);
    }

    public function create(MenuGroup $group, MenuSubGroup $subgroup)
    {
        $data = [];
        $data['group'] = $group;
        $data['subgroup'] = $subgroup;
        return view('admin.menus.category.create',$data);
    }

    public function store(Menugroup $group, MenuSubGroup $subgroup, Request $request)
    {
        $data = $request->validate([
            'name' => 'string|required',
            'order' => 'numeric|required',
            'status' => 'string|required',
        ]);

        $subgroup->categories()->create($data);
        return redirect('/admin/menus/'.$group->id.'/sub-groups/'.$subgroup->id.'/categories');
    }

    public function edit(Menugroup $group, MenuSubGroup $subgroup, MenuItemCategory $category)
    {
        $data = [];
        $data['group'] = $group;
        $data['subgroup'] = $subgroup;
        $data['category'] = $category;
        // dd($data);
        return view('admin.menus.category.edit',$data);
    }

    public function update(Menugroup $group, MenuSubGroup $subgroup, MenuItemCategory $category, Request $request)
    {
        $data = $request->validate([
            'name' => 'string|required',
            'order' => 'numeric|required',
            'status' => 'string|required',
        ]);

        $category->update($data);
        return redirect('/admin/menus/'.$group->id.'/sub-groups/'.$subgroup->id.'/categories');
    }

    public function destroy(Menugroup $group, MenuSubGroup $subgroup, MenuItemCategory $category, Request $request)
    {
        $category->items()->delete();
        $category->delete();
        return redirect('/admin/menus/'.$group->id.'/sub-groups/'.$subgroup->id.'/categories');
    }

}
