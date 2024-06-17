<?php

namespace App\Http\Controllers\Admin\PdfBank;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ebook\EbookChapter as PDFContent;
use App\Models\Ebook\Ebook as PDFGroup;
use App\Models\Ebook\EbookCategory as Category;

class ContentFileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(PDFGroup $group)
    {
        $contents = $group->chapters;
        return view('admin.pdf_bank.content.index',compact('group','contents'));
    }

    public function create(PDFGroup $group)
    {
        return view('admin.pdf_bank.content.create',compact('group'));
    }

    public function store(Request $request, PDFGroup $group)
    {
        // dd($request->all());
        $request->validate([
            // "name" => "string|required",
            "title" => "string|required",
            "status" => "string|required",
            "pdf_file" => "file|required|mimes:pdf",
        ]);

        $pdf="";
        if(isset($request['pdf_file']))
        {
            $pdf=request('pdf_file')->store('uploads/pdf_bank','public');
        }     

        $group->chapters()->create([
            'name' => ucwords($request->title),
            'title' => ucwords($request->title),
            'pdf_file' => $pdf,
            'status' => $request->status,
        ]);

        return redirect('/admin/pdf-bank/pdf-groups/'.$group->id.'/pdf-files');
    }

    public function show(PDFGroup $group, PDFContent $content)
    {
        // dd($book,$chapter);
        return view('admin.pdf_bank.content.show',compact('group','content'));
    }

    public function edit(PDFGroup $group, PDFContent $content)
    {
        return view('admin.pdf_bank.content.edit',compact('group','content'));
    }

    public function update(Request $request, PDFGroup $group, PDFContent $content)
    {
        // dd($request->all());
        $request->validate([
            // "name" => "string|required",
            "title" => "string|required",
            "status" => "string|required",
            "pdf_file" => "file|nullable|mimes:pdf",
            "old_file" => "string|nullable",
        ]);

        $pdf = $request->old_file;
        if(isset($request->pdf_file))
        {
            $pdf = request('pdf_file')->store('uploads/pdf_bank','public');
        }

        $content->update([
            'name' => ucwords($request->title),
            'title' => ucwords($request->title),
            'pdf_file' => $pdf,
            'status' => $request->status,
        ]);

        return redirect('/admin/pdf-bank/pdf-groups/'.$group->id.'/pdf-files');
    }

    public function destroy(PDFGroup $group, PDFContent $content)
    {
        $content->delete();
        return redirect('/admin/pdf-bank/pdf-groups/'.$group->id.'/pdf-files');
    }
}
