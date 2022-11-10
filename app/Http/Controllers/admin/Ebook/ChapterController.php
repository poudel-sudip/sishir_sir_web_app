<?php

namespace App\Http\Controllers\admin\Ebook;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ebook\Ebook;
use App\Models\Ebook\EbookChapter;
use App\Models\Ebook\ChapterFiles;

class ChapterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Ebook $book)
    {
        $chapters = $book->chapters;
        return view('admin.ebook.chapter.index',compact('book','chapters'));
    }

    public function create(Ebook $book)
    {
        return view('admin.ebook.chapter.create',compact('book'));
    }

    public function store(Request $request, Ebook $book)
    {
        // dd($request->all());
        $request->validate([
            "name" => "string|required",
            "title" => "string|required",
            "status" => "string|required",
            "pdf_file" => "file|nullable|mimes:pdf",
        ]);

        $pdf="";
        if(isset($data['pdf_file']))
        {
            $pdf=request('pdf_file')->store('uploads','public');
        }     

        $book->chapters()->create([
            'name' => ucwords($request->name),
            'title' => ucwords($request->title),
            'pdf_file' => $pdf,
            'status' => $request->status,
        ]);

        return redirect('/admin/ebook/books/'.$book->id.'/chapters');
    }

    public function show(Ebook $book, EbookChapter $chapter)
    {
        // dd($book,$chapter);
        return view('admin.ebook.chapter.show',compact('book','chapter'));
    }

    public function edit(Ebook $book, EbookChapter $chapter)
    {
        return view('admin.ebook.chapter.edit',compact('book','chapter'));
    }

    public function update(Request $request, Ebook $book, EbookChapter $chapter)
    {
        // dd($request->all());
        $request->validate([
            "name" => "string|required",
            "title" => "string|required",
            "status" => "string|required",
            "pdf_file" => "file|nullable|mimes:pdf",
            "old_file" => "string|nullable",
        ]);

        $pdf = $request->old_file;
        if(isset($request->pdf_file))
        {
            $pdf = request('pdf_file')->store('uploads','public');
        }

        $chapter->update([
            'name' => ucwords($request->name),
            'title' => ucwords($request->title),
            'pdf_file' => $pdf,
            'status' => $request->status,
        ]);

        return redirect('/admin/ebook/books/'.$book->id.'/chapters');
    }

    public function destroy(Ebook $book, EbookChapter $chapter)
    {
        $chapter->delete();
        return redirect('/admin/ebook/books/'.$book->id.'/chapters');
    }

    // for chapter files
    public function fileindex(Ebook $book, EbookChapter $chapter)
    {
        $chaptersfiles = $chapter->chapterfiles;
        return view('admin.ebook.chapterfile.index',compact('book','chapter','chaptersfiles'));
    }
    public function filecreate(Ebook $book, EbookChapter $chapter)
    {
        return view('admin.ebook.chapterfile.create',compact('book','chapter'));
    }

    public function filestore(Request $request, Ebook $book, EbookChapter $chapter)
    {
        // dd($request->all());
        $request->validate([
            "image" => "file|image",
        ]);

        $img=$request->image->store('uploads','public');
        $chapter->chapterfiles()->create([
            'image' => $img,
        ]);

        return redirect('/admin/ebook/books/'.$book->id.'/chapters/'.$chapter->id.'/files');
    }
    public function filedestroy(Ebook $book, EbookChapter $chapter, ChapterFiles $chapterfiles)
    {
        $chapterfiles->delete();
        return redirect('/admin/ebook/books/'.$book->id.'/chapters/'.$chapter->id.'/files');
    }

}
