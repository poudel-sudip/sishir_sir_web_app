<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ImportantLink;

class LinksController extends Controller
{
    public function index()
    {
        $data['links'] = ImportantLink::all();
        return view('admin.imp_links.index',$data);
    }

    public function create()
    {
        $data = [];
        return view('admin.imp_links.create',$data);
    }

    public function edit(ImportantLink $link)
    {
        $data['link'] = $link;
        return view('admin.imp_links.edit',$data);
    }

    public function destroy(ImportantLink $link)
    {
        $link->delete();
        return redirect('/admin/imp-links');
    }

    public function store(Request $request)
    {
        $request->validate([
            'link_title' => 'required|string',
            'link_url' => 'required|string',
            'link_category' => 'nullable|string',
            'link_order' => 'nullable|numeric',
        ]);

        ImportantLink::create([
            'link_title' => $request->link_title,
            'link_url' => $request->link_url,
            'link_category' => trim($request->link_category ?? ''),
            'link_order' => $request->link_order ?? 1,
        ]);

        return redirect('/admin/imp-links');
    }

    public function update(ImportantLink $link, Request $request)
    {
        $request->validate([
            'link_title' => 'required|string',
            'link_url' => 'required|string',
            'link_category' => 'nullable|string',
            'link_order' => 'nullable|numeric',
        ]);

        $link->update([
            'link_title' => $request->link_title,
            'link_url' => $request->link_url,
            'link_category' => trim($request->link_category ?? ''),
            'link_order' => $request->link_order ?? 1,
        ]);

        return redirect('/admin/imp-links');
    }
}
