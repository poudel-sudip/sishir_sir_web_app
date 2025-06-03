<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categories as Faq;

class FaqController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $faqs = Faq::where('type','=','faq')->get();
        return view('admin.faq.index', compact('faqs'));
    }

    public function create()
    {
        return view('admin.faq.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:active,inactive',
        ]);

        Faq::create([
            'name' => $request->title,
            'description' => $request->description,
            'type' => 'faq',
            'status' => $request->status,
        ]);

        return redirect('/admin/faqs')->with('success', 'FAQ created successfully.');
    }

    public function edit(Faq $faq)
    {
        return view('admin.faq.edit', compact('faq'));
    }

    public function update(Request $request, Faq $faq)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:active,inactive',
        ]);

        $faq->update([
            'name' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        return redirect('/admin/faqs')->with('success', 'FAQ updated successfully.');
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();

        return redirect('/admin/faqs')->with('success', 'FAQ deleted successfully.');
    }

    public function show(Faq $faq)
    {
        return view('admin.faq.show', compact('faq'));
    }

}
