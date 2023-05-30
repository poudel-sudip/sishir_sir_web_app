<?php

namespace App\Http\Controllers\Admin\Books;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Books\Book;
use App\Models\Categories;

class BookController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function categoryIndex()
    {  
        $data['categories'] = Categories::where('type','=','book')->get();
        return view('admin.books.category.index',$data);
    }

    public function categoryCreate()
    {
        return view('admin.books.category.create');
    }

    public function categoryStore()
    {
        $data = request()->validate([
            'name'=>'required | string',
            // 'order'=>'required | numeric',
            'status'=>'required',
        ]);
        Categories::create([
            'type' => 'book',
            'name'=>$data['name'],
            'status'=>$data['status'],
            // 'order'=>$data['order'],
        ]);
        return redirect('/admin/books/categories');
    }  

    public function categoryEdit(Categories $category)
    {
        $data['category'] = $category;
        return view('admin.books.category.edit',$data);
    }

    public function categoryUpdate(Categories $category, Request $request)
    {
       $data = $request->validate([
            'name'=>'required | string',
            // 'order'=>'required | numeric',
            'status'=>'required',
        ]);
        $category->update([
            'name'=>$data['name'],
            'status'=>$data['status'],
            // 'order'=>$data['order'],
        ]);
        return redirect('/admin/books/categories');
    }

    public function categoryDestroy(Categories $category)
    {
        $category->delete();
        return redirect('/admin/books/categories');
    }

    public function categoryBooks(Categories $category)
    {
        $data['category'] = $category;
        $data['books'] = $category->books;
        return view('admin.books.category.books',$data);
    }

    public function publisherIndex()
    {  
        $data['categories'] = Categories::where('type','=','book_publisher')->get();
        return view('admin.books.publisher.index',$data);
    }

    public function publisherCreate()
    {
        return view('admin.books.publisher.create');
    }

    public function publisherStore()
    {
        $data = request()->validate([
            'name'=>'required | string',
            'order'=>'required | numeric',
            'status'=>'required',
        ]);
        Categories::create([
            'type' => 'book_publisher',
            'name'=>$data['name'],
            'status'=>$data['status'],
            'order'=>$data['order'],
        ]);
        return redirect('/admin/books/publishers');
    }  

    public function publisherEdit(Categories $category)
    {
        $data['category'] = $category;
        return view('admin.books.publisher.edit',$data);
    }

    public function publisherUpdate(Categories $category, Request $request)
    {
       $data = $request->validate([
            'name'=>'required | string',
            'order'=>'required | numeric',
            'status'=>'required',
        ]);
        $category->update([
            'name'=>$data['name'],
            'status'=>$data['status'],
            'order'=>$data['order'],
        ]);
        return redirect('/admin/books/publishers');
    }

    public function publisherDestroy(Categories $category)
    {
        $category->delete();
        return redirect('/admin/books/publishers');
    }

    public function publisherBooks(Categories $category)
    {
        $data['category'] = $category;
        $data['books'] = $category->books;
        return view('admin.books.publisher.books',$data);
    }

    public function index()
    {
        $data = [];
        $data['books'] = Book::all();
        return view('admin.books.index',$data);
    }

    public function create()
    {
        $data['categories'] = Categories::where(['type'=>'book','status'=>'Active'])->get();
        $data['publishers'] = Categories::where('type','=','book_publisher')->get();
        return view('admin.books.create',$data);
    }
    
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'category' => 'numeric|nullable',
            'publisher' => 'numeric|nullable',
            "title" => "string|required",
            "order" => "numeric|required",
            "author" => "string|nullable",
            "edition" => "string|nullable",
            "published_year" => "string|nullable",
            "pages" => "string|nullable",
            "availability" => "string|required",
            "price" => "numeric|required",
            "discount" => "numeric|nullable",
            "description" => "string|required",
            "status" => "string|required",
            "thumbnail" => "image|required",
        ]);

        $data = $request->only(['title','order','author','edition','published_year','pages','availability','price','discount','status','description']);
        $data['thumbnail'] = '';
        if(isset($request->thumbnail))
        {
            $data['thumbnail'] = $request->thumbnail->store('uploads','public');
        }

        if($request->category)
        {
            $data['category_id'] = $request->category;
        }

        if($request->publisher)
        {
            $data['publisher_id'] = $request->publisher;
        }

        $book = Book::create($data);

        if($book->category)
        {
            return redirect('/admin/books/categories/'.$book->category_id.'/books');
        }
        return redirect('/admin/books');
    }

    public function show(Book $book)
    {
        return view('admin.books.show',compact('book'));
    }

    public function edit(Book $book)
    {
        $data['categories'] = Categories::where(['type'=>'book','status'=>'Active'])->get();
        $data['publishers'] = Categories::where('type','=','book_publisher')->get();
        $data['book'] = $book;
        return view('admin.books.edit',$data);
    }

    public function update(Book $book, Request $request)
    {
        // dd($request->all());
        $request->validate([
            'category' => 'numeric|nullable',
            'publisher' => 'numeric|nullable',
            "title" => "string|required",
            "order" => "numeric|required",
            "author" => "string|nullable",
            "edition" => "string|nullable",
            "published_year" => "string|nullable",
            "pages" => "string|nullable",
            "availability" => "string|required",
            "price" => "numeric|required",
            "discount" => "numeric|nullable",
            "description" => "string|required",
            "status" => "string|required",
            "thumbnail" => "image|nullable",
            "old_thumbnail" => "string|nullable",
        ]);
        $data = $request->only(['title','order','author','edition','published_year','pages','availability','price','discount','status','description']);
        $data['thumbnail'] = $request->old_thumbnail;
        $data['category_id'] = $request->category;
        $data['publisher_id'] = $request->publisher;
        if(isset($request->thumbnail))
        {
            $data['thumbnail'] = $request->thumbnail->store('uploads','public');
        }
        
        $book->update($data);

        if($book->category)
        {
            return redirect('/admin/books/categories/'.$book->category_id.'/books');
        }

        return redirect('/admin/books');
    }

    public function destroy(Book $book)
    {
        $category = $book->category;

        $book->delete();

        if($category)
        {
            return redirect('/admin/books/categories/'.$category->id.'/books');
        }
        return redirect('/admin/books');
    }

}
