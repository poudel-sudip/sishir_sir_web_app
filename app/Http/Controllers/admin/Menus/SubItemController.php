<?php

namespace App\Http\Controllers\Admin\Menus;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu\MenuGroup;
use App\Models\Menu\MenuSubGroup;
use App\Models\Menu\MenuItemCategory;
use App\Models\Menu\MenuItem;
use App\Models\Menu\MenuSubItem;

class SubItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(MenuGroup $group, MenuSubGroup $subgroup, MenuItemCategory $category, MenuItem $item)
    {
        $data = [];
        $data['group'] = $group;
        $data['subgroup'] = $subgroup;
        $data['category'] = $category;
        $data['item'] = $item;
        $data['subItems'] = $item->subItems;
        // dd($data);
        return view('admin.menus.subitems.index',$data);
    }

    public function create(MenuGroup $group, MenuSubGroup $subgroup, MenuItemCategory $category, MenuItem $item)
    {
        $data = [];
        $data['group'] = $group;
        $data['subgroup'] = $subgroup;
        $data['category'] = $category;
        $data['item'] = $item;
        return view('admin.menus.subitems.create',$data);
    }

    public function store(Menugroup $group, MenuSubGroup $subgroup, MenuItemCategory $category, MenuItem $item, Request $request)
    {
        // dd($request->all());
        $data = $request->validate([
            'name' => 'string|required',
            'order' => 'numeric|required',
            'status' => 'string|required',
            'type' => 'string|required',
            'thumbnail' => 'image|nullable',
            'search_tags' => 'string|nullable',
        ]);

        if($data['type'] == 'text' || $data['type'] == 'Text')
        {
            $request->validate(['description' => 'string|required|min:5']);
            $data['description'] = $request->description;
        }
        elseif($data['type'] == 'file' || $data['type'] == 'File')
        {
            $request->validate([ 
                'file' => 'required|file|mimes:pdf',
                'can_download' => 'required|boolean',
            ]);
            $data['download'] = $request->can_download;
            $data['filename'] = $request->file->getClientOriginalName();
            $data['fileurl'] = $request->file->storeAs('uploads',$data['filename'],'public');
            $data['description'] = $request->description;
        }

        if(isset($request->thumbnail))
        {
            $data['thumbnail'] = $request->thumbnail->store('uploads','public');
        }

        $item->subItems()->create($data);
        return redirect('/admin/menus/'.$group->id.'/sub-groups/'.$subgroup->id.'/categories/'.$category->id.'/items/'.$item->id.'/sub-items');
    }

    public function edit(Menugroup $group, MenuSubGroup $subgroup, MenuItemCategory $category, MenuItem $item, MenuSubItem $subitem)
    {
        $data = [];
        $data['group'] = $group;
        $data['subgroup'] = $subgroup;
        $data['category'] = $category;
        $data['item'] = $item;
        $data['subitem'] = $subitem;
        return view('admin.menus.subitems.edit',$data);
    }

    public function update(Menugroup $group, MenuSubGroup $subgroup, MenuItemCategory $category, MenuItem $item, MenuSubItem $subitem, Request $request)
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
            'can_download' => 'required|boolean',
            'search_tags' => 'string|nullable',
        ]);

        $data = $request->only(['name','order','status','type','search_tags']);
        
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
            $data['description'] = $request->description;
            $data['download'] = $request->can_download;
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

        // dd($request->all(),$data);
        $subitem->update($data);
        return redirect('/admin/menus/'.$group->id.'/sub-groups/'.$subgroup->id.'/categories/'.$category->id.'/items/'.$item->id.'/sub-items');
    }

    public function show(Menugroup $group, MenuSubGroup $subgroup, MenuItemCategory $category, MenuItem $item, MenuSubItem $subitem)
    {
        $data = [];
        $data['group'] = $group;
        $data['subgroup'] = $subgroup;
        $data['category'] = $category;
        $data['item'] = $item;
        $data['subitem'] = $subitem;
        return view('admin.menus.subitems.show',$data);
    }

    public function destroy(Menugroup $group, MenuSubGroup $subgroup, MenuItemCategory $category, MenuItem $item, MenuSubItem $subitem)
    {
        $subitem->delete();
        return redirect('/admin/menus/'.$group->id.'/sub-groups/'.$subgroup->id.'/categories/'.$category->id.'/items/'.$item->id.'/sub-items');
    }
}
