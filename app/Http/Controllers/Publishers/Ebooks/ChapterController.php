<?php

namespace App\Http\Controllers\Publishers\Ebooks;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ebook\EbookCategory;
use App\Models\Ebook\Ebook;
use App\Models\Ebook\PublisherEbook;
use App\Models\Ebook\EbookChapter;
use App\Models\Ebook\ChapterFiles;

class ChapterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(PublisherEbook $ebook)
    {
        $book = $ebook->ebook;
        if(!$book)
        {
            abort(404);
        }

        $chapters = $book->chapters;
        return view('publishers.ebooks.chapter.index',compact('ebook','book','chapters'));
    }

    public function create(PublisherEbook $ebook)
    {
        $book = $ebook->ebook;
        if(!$book)
        {
            abort(404);
        }
        return view('publishers.ebooks.chapter.create',compact('ebook','book'));

    }

    public function store(Request $request, PublisherEbook $ebook)
    {
        $book = $ebook->ebook;
        if(!$book)
        {
            abort(404);
        }
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
        // $pdf = request('pdf_file')->store('uploads','public');

        $book->chapters()->create([
            'name' => ucwords($request->name),
            'title' => ucwords($request->title),
            'pdf_file' => $pdf,
            'status' => $request->status,
        ]);

        return redirect('/publisher/ebooks/'.$ebook->id.'/chapters');
    }

    public function edit(PublisherEbook $ebook, EbookChapter $chapter)
    {
        $book = $ebook->ebook;
        if(!$book)
        {
            abort(404);
        }
        return view('publishers.ebooks.chapter.edit',compact('book','chapter','ebook'));
    }

    public function update(Request $request, PublisherEbook $ebook, EbookChapter $chapter)
    {
        $book = $ebook->ebook;
        if(!$book)
        {
            abort(404);
        }
        $request->validate([
            "name" => "string|required",
            "title" => "string|required",
            "status" => "string|required",
            // "pdf_file" => "file|nullable|mimes:pdf",
            // "old_file" => "string|nullable",
        ]);

        // $pdf = $request->old_file;
        // if(isset($request->pdf_file))
        // {
        //     $pdf = request('pdf_file')->store('uploads','public');
        // }

        $chapter->update([
            'name' => ucwords($request->name),
            'title' => ucwords($request->title),
            // 'pdf_file' => $pdf,
            'status' => $request->status,
        ]);

        return redirect('/publisher/ebooks/'.$ebook->id.'/chapters');
    }

    public function destroy(PublisherEbook $ebook, EbookChapter $chapter)
    {
        $book = $ebook->ebook;
        if(!$book)
        {
            abort(404);
        }
        $chapter->delete();
        return redirect('/publisher/ebooks/'.$ebook->id.'/chapters');
    }

    // for chapter files
    public function fileindex(PublisherEbook $ebook, EbookChapter $chapter)
    {
        $book = $ebook->ebook;
        if(!$book)
        {
            abort(404);
        }
        $chaptersfiles = $chapter->chapterfiles;
        return view('publishers.ebooks.chapterfile.index',compact('book','chapter','chaptersfiles','ebook'));
    }

    public function filecreate(PublisherEbook $ebook, EbookChapter $chapter)
    {
        $book = $ebook->ebook;
        if(!$book)
        {
            abort(404);
        }
        return view('publishers.ebooks.chapterfile.create',compact('book','chapter','ebook'));
    }

    public function filestore(Request $request, PublisherEbook $ebook, EbookChapter $chapter)
    {
        $book = $ebook->ebook;
        if(!$book)
        {
            abort(404);
        }
        $request->validate([
            "image" => "file|image",
        ]);

        $img=$request->image->store('uploads','public');
        $chapter->chapterfiles()->create([
            'image' => $img,
        ]);

        return redirect('/publisher/ebooks/'.$ebook->id.'/chapters/'.$chapter->id.'/files');
    }

    public function filedestroy(PublisherEbook $ebook, EbookChapter $chapter, ChapterFiles $chapterfiles)
    {
        $book = $ebook->ebook;
        if(!$book)
        {
            abort(404);
        }
        $chapterfiles->delete();
        return redirect('/publisher/ebooks/'.$ebook->id.'/chapters/'.$chapter->id.'/files');
    }


}
