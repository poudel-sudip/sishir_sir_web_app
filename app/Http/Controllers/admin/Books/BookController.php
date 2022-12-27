<?php

namespace App\Http\Controllers\Admin\Books;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Books\Book;

class BookController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = [];
        $data['books'] = Book::all();
        return view('admin.books.index',$data);
    }

    public function create()
    {
        return view('admin.books.create');
    }
    
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            "title" => "string|required",
            "order" => "numeric|required",
            "author" => "string|nullable",
            "price" => "numeric|required",
            "discount" => "numeric|nullable",
            "description" => "string|required",
            "status" => "string|required",
            "thumbnail" => "image|required",
        ]);

        $data = $request->only(['title','order','author','price','discount','status','description']);
        $data['thumbnail'] = '';
        if(isset($request->thumbnail))
        {
            $data['thumbnail'] = $request->thumbnail->store('uploads','public');
        }

        Book::create($data);
        return redirect('/admin/books');
    }

    public function show(Book $book)
    {
        return view('admin.books.show',compact('book'));
    }

    public function edit(Book $book)
    {
        return view('admin.books.edit',compact('book'));
    }

    public function update(Book $book, Request $request)
    {
        // dd($request->all());
        $request->validate([
            "title" => "string|required",
            "order" => "numeric|required",
            "author" => "string|nullable",
            "price" => "numeric|required",
            "discount" => "numeric|nullable",
            "description" => "string|required",
            "status" => "string|required",
            "thumbnail" => "image|nullable",
            "old_thumbnail" => "string|nullable",
        ]);
        $data = $request->only(['title','order','author','price','discount','status','description']);
        $data['thumbnail'] = $request->old_thumbnail;
        if(isset($request->thumbnail))
        {
            $data['thumbnail'] = $request->thumbnail->store('uploads','public');
        }
        $book->update($data);
        return redirect('/admin/books');
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect('/admin/books');
    }

}
