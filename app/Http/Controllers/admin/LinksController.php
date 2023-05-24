<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ImportantLink;
use App\Models\Categories;

class LinksController extends Controller
{
    public function categoryIndex()
    {  
        $data['categories'] = Categories::where('type','=','imp_link')->get();
        return view('admin.imp_links.category_index',$data);
    }

    public function categoryCreate()
    {
        return view('admin.imp_links.category_create');
    }

    public function categoryStore()
    {
        $data = request()->validate([
            'name'=>'required | string',
            'status'=>'required',
        ]);
        Categories::create([
            'type' => 'imp_link',
            'name'=>$data['name'],
            'status'=>$data['status'],
        ]);
        return redirect('/admin/imp-links');
    }  

    public function categoryEdit(Categories $category)
    {
        $data['category'] = $category;
        return view('admin.imp_links.category_edit',$data);
    }

    public function categoryUpdate(Categories $category, Request $request)
    {
       $data = $request->validate([
            'name'=>'required | string',
            'status'=>'required',
        ]);
        $category->update([
            'name'=>$data['name'],
            'status'=>$data['status'],
        ]);
        return redirect('/admin/imp-links');
    }

    public function categoryDestroy(Categories $category)
    {
        $category->delete();
        $category->imp_links()->delete();
        return redirect('/admin/imp-links');
    }

    public function index(Categories $category)
    {
        $data['category'] = $category;
        $data['links'] = $category->imp_links;
        return view('admin.imp_links.index',$data);
    }

    public function create(Categories $category)
    {
        $data = [];
        $data['category'] = $category;
        return view('admin.imp_links.create',$data);
    }

    public function edit(Categories $category, ImportantLink $link)
    {
        $data['category'] = $category;
        $data['link'] = $link;
        return view('admin.imp_links.edit',$data);
    }

    public function destroy(Categories $category, ImportantLink $link)
    {
        $link->delete();
        return redirect('/admin/imp-links/'.$category->id.'/links');
    }

    public function store(Categories $category, Request $request)
    {
        $request->validate([
            'link_title' => 'required|string',
            'link_url' => 'required|string',
            'link_order' => 'nullable|numeric',
        ]);

        $category->imp_links()->create([
            'link_title' => $request->link_title,
            'link_url' => $request->link_url,
            'link_order' => $request->link_order ?? 1,
        ]);

        return redirect('/admin/imp-links/'.$category->id.'/links');
    }

    public function update(Categories $category, ImportantLink $link, Request $request)
    {
        $request->validate([
            'link_title' => 'required|string',
            'link_url' => 'required|string',
            'link_order' => 'nullable|numeric',
        ]);

        $link->update([
            'link_title' => $request->link_title,
            'link_url' => $request->link_url,
            'link_order' => $request->link_order ?? 1,
        ]);

        return redirect('/admin/imp-links/'.$category->id.'/links');
    }
}
