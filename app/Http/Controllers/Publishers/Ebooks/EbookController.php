<?php

namespace App\Http\Controllers\Publishers\Ebooks;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ebook\EbookCategory;
use App\Models\Ebook\Ebook;
use App\Models\Ebook\PublisherEbook;

class EbookController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $publisher = auth()->user()->publisher;
        $books = $publisher->ebooks;
        return view('publishers.ebooks.book.allebooks',compact('publisher','books'));
    }

    public function create()
    {
        $categories = EbookCategory::where('status','=','Active')->get();
        return view('publishers.ebooks.book.create',compact('categories'));
    }

    public function store(Request $request)
    {
        $publisher = auth()->user()->publisher;

        $request->validate([
            "category" => "numeric|required|min:1",
            "name" => "string|required",
            "author" => "string|nullable",
            "price" => "numeric|required",
            "discount" => "numeric|nullable",
            "description" => "string|required",
            "status" => "string|required",
            "thumbnail" => "image|required",
        ]);
        $img = request('thumbnail')->store('uploads','public');
        $book = Ebook::create([
            'category_id' => $request->category,
            'title' => $request->name,
            'author' => $request->author ?? auth()->user()->name,
            'thumbnail' => $img,
            'price' => $request->price,
            'discount' => $request->discount ?? 0,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        $publisher->ebooks()->create(['book_id' => $book->id]);

        return redirect('/publisher/ebooks/categories/'.$book->category_id.'/books');
        // return redirect('/publisher/ebooks/all');
    }

    public function show(PublisherEbook $ebook)
    {
        $book = $ebook->ebook;
        if(!$book)
        {
            abort(404);
        }
        return view('publishers.ebooks.book.show',compact('book'));
    }

    public function edit(PublisherEbook $ebook)
    {
        $book = $ebook->ebook;
        if(!$book)
        {
            abort(404);
        }
        $categories = EbookCategory::where('status','=','Active')->get();
        return view('publishers.ebooks.book.edit',compact('ebook','book','categories'));
    }

    public function update(Request $request, PublisherEbook $ebook)
    {
        $book = $ebook->ebook;
        if(!$book)
        {
            abort(404);
        }

        $request->validate([
            "category" => "numeric|required|min:1",
            "name" => "string|required",
            "author" => "string|required",
            "price" => "numeric|required",
            "discount" => "numeric|nullable",
            "description" => "string|required",
            "status" => "string|required",
            "thumbnail" => "image|nullable",
            "oldThumbnail" => "string|nullable",
        ]);
        $img = $request->oldThumbnail;
        if(isset($request->thumbnail))
        {
            $img = request('thumbnail')->store('uploads','public');
        }

        $book->update([
            "category_id" => $request->category,
            'title' => $request->name,
            'author' => $request->author,
            'thumbnail' => $img,
            'price' => $request->price,
            'discount' => $request->discount ?? 0,
            'description' => $request->description,
            'status' => $request->status,
        ]);
        return redirect('/publisher/ebooks/categories/'.$book->category_id.'/books');
        // return redirect('/publisher/ebooks/all');
    }

    public function destroy(PublisherEbook $ebook)
    {
        $ebook->delete();
        return redirect('/publisher/ebooks/all');
    }

}
