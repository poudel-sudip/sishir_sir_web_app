<?php

namespace App\Http\Controllers\admin\Ebook;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ebook\Ebook;
use App\Models\Ebook\EbookCategory;

class BookController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $books = Ebook::all();
        return view('admin.ebook.book.index',compact('books'));
    }

    public  function create()
    {
        $categories = EbookCategory::where('status','=','Active')->get();
        return view('admin.ebook.book.create',compact('categories'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
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

        return redirect('/admin/ebook/categories/'.$book->category_id.'/books');
        // return redirect('/admin/ebook/books');
    }

    public function show(Ebook $book)
    {
        return view('admin.ebook.book.show',compact('book'));
    }

    public function edit(Ebook $book)
    {
        $categories = EbookCategory::where('status','=','Active')->get();
        return view('admin.ebook.book.edit',compact('book','categories'));
    }

    public function update(Request $request, Ebook $book)
    {
        // dd($request->all());
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
            "isPinned" => "string|required",
        ]);
        $img = $request->oldThumbnail;
        if(isset($request->thumbnail))
        {
            $img = request('thumbnail')->store('uploads','public');
        }

        $book->update([
            'category_id' => $request->category,
            'title' => $request->name,
            'author' => $request->author,
            'thumbnail' => $img,
            'price' => $request->price,
            'discount' => $request->discount ?? 0,
            'description' => $request->description,
            'status' => $request->status,
            'isPinned' => $request->isPinned, 
        ]);
        
        return redirect('/admin/ebook/categories/'.$book->category_id.'/books');
        // return redirect('/admin/ebook/books');
    }

    public function destroy(Ebook $book)
    {
        $book->chapters()->delete();
        $book->bookings()->delete();
        $book->delete();
        return redirect('/admin/ebook/books');
    }

    public function bookings(Ebook $book)
    {
        $bookings = $book->bookings;
        return view('admin.ebook.book.bookings',compact('book','bookings'));
    }
}
