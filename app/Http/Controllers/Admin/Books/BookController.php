<?php

namespace App\Http\Controllers\Admin\Books;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Books\Book;
use App\Models\Books\BookReview;
use App\Models\Categories;

class BookController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
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
        $category->pub_categories()->delete();
        $category->delete();
        return redirect('/admin/books/publishers');
    }

    public function publisherCategories(Categories $publisher)
    {
        $data['categories'] = $publisher->pub_categories;
        $data['publisher'] = $publisher;
        return view('admin.books.category.index',$data);
    }

    public function categoryCreate(Categories $publisher)
    {
        $data['publisher'] = $publisher;
        return view('admin.books.category.create',$data);
    }

    
    public function categoryStore(Categories $publisher, Request $request)
    {
        $data = $request->validate([
            'category_name'=>'required | string',
            'order'=>'required | numeric',
            'status'=>'required | string',
            // 'image' => 'nullable | image',
            // 'description' => 'nullable | string',
        ]);

        $image = null;
        // if(isset($data['image']))
        // {
        //     $image = $request->image->store('uploads','public');
        // }

        $publisher->pub_categories()->create([
            'type' => 'book_category',
            'name' => $data['category_name'],
            'status' => $data['status'],
            'order' => $data['order'],
            // 'description' => $data['description'],
            'image' => $image,
        ]);
        
        return redirect('/admin/books/publishers/'.$publisher->id.'/categories');
    } 

    public function categoryShow(Categories $publisher, Categories $category)
    {
        $data['publisher'] = $publisher;
        $data['category'] = $category;
        return view('admin.books.category.show',$data);
    }

    public function categoryEdit(Categories $publisher, Categories $category)
    {
        $data['publisher'] = $publisher;
        $data['category'] = $category;
        return view('admin.books.category.edit',$data);
    }

    public function categoryUpdate(Categories $publisher, Categories $category, Request $request)
    {
        $data = $request->validate([
            'category_name'=>'required | string',
            'order'=>'required | numeric',
            'status'=>'required | string',
            // 'old_image' => 'required | string',
            // 'image' => 'nullable | image',
        ]);

        $image = null;
        // $image = $data['old_image'];
        // if(isset($data['image']))
        // {
        //     $image = $request->image->store('uploads','public');
        // }
        

        $category->update([
            'name' => $data['category_name'],
            'status' => $data['status'],
            'order' => $data['order'],
            'image' => $image,
        ]);

        return redirect('/admin/books/publishers/'.$publisher->id.'/categories');
    }
    

    public function categoryDestroy(Categories $publisher, Categories $category)
    {
        $category->delete();
        return redirect('/admin/books/publishers/'.$publisher->id.'/categories');
    }

    public function categoryBooks(Categories $publisher, Categories $category)
    {
        $data['publisher'] = $publisher;
        $data['category'] = $category;
        $data['books'] = $category->cat_books;
        return view('admin.books.category.books',$data);
    }

    // public function publisherBooks(Categories $publisher)
    // {
    //     $data['publisher'] = $publisher;
    //     $data['books'] = $publisher->pub_books;
    //     return view('admin.books.publisher.books',$data);
    // }

    
    public function create(Categories $publisher, Categories $category)
    {
        $data['publisher'] = $publisher;
        $data['category'] = $category;

        $latest_edition = $category->cat_books()
        ->orderByDesc('order')
        ->first();

        if($latest_edition)
        {
            $data['latest_edition'] = $latest_edition;
        }
            
        // dd($data);
        return view('admin.books.create',$data);
    }
    
    public function store(Categories $publisher, Categories $category, Request $request)
    {
        // dd($request->all());
        $request->validate([
            'category' => 'string|required',
            'publisher' => 'string|required',
            "title" => "string|required",
            "order" => "numeric|required",
            "author" => "string|nullable",
            "edition" => "string|nullable",
            "isbn" => "string|nullable",
            "published_year" => "string|nullable",
            "pages" => "string|nullable",
            "availability" => "string|required",
            "price" => "numeric|required",
            "discount" => "numeric|nullable|lte:100|gte:0",
            "purchase_link" => "string|nullable",
            "description" => "string|required",
            "status" => "string|required",
            "thumbnail" => "image|required",
            "image3d" => "image|nullable",
            "content_pdf" => "file|mimes:pdf|nullable",
            'search_tags' => 'string|nullable',
            'order_contact' => 'string|nullable',
        ]);

        $data = $request->only(['title','order','author','edition','isbn','published_year','pages','availability','price','discount','purchase_link','status','search_tags','description','order_contact']);
        
        $data['publisher_id'] = $publisher->id;
        $data['category_id'] = $category->id;
        $data['thumbnail'] = '';
        $data['image3d'] = '';

        if(isset($request->thumbnail))
        {
            $data['thumbnail'] = $request->thumbnail->store('uploads','public');
        }
      
        if(isset($request->image3d))
        {
            $data['image3d'] = $request->image3d->store('uploads','public');
        }

        if(isset($request->content_pdf))
        {
            $data['content_pdf'] = $request->content_pdf->store('uploads/books/pdf','public');
        }

        $book = Book::create($data);

        if($book->category && $book->publisher)
        {
            return redirect('/admin/books/publishers/'.$book->publisher_id.'/categories/'.$book->category_id.'/books');
        }

        return redirect('/admin/books');
    }

    public function index()
    {
        $data = [];
        $data['books'] = Book::all();
        return view('admin.books.index',$data);
    }

    public function show(Book $book)
    {
        return view('admin.books.show',compact('book'));
    }

    public function edit(Book $book)
    {
        // $data['categories'] = Categories::where([['type','=','book_category'],['status','=','Active']])->get();
        // $data['publishers'] = Categories::where([['type','=','book_publisher'],['status','=','Active']])->get();
        $data['book'] = $book;
        return view('admin.books.edit',$data);
    }

    public function update(Book $book, Request $request)
    {
        // dd($request->all());
        $request->validate([
            'category' => 'string|nullable',
            'publisher' => 'string|nullable',
            "title" => "string|required",
            "order" => "numeric|required",
            "author" => "string|nullable",
            "edition" => "string|nullable",
            "isbn" => "string|nullable",
            "published_year" => "string|nullable",
            "pages" => "string|nullable",
            "availability" => "string|required",
            "price" => "numeric|required",
            "discount" => "numeric|nullable|lte:100|gte:0",
            "purchase_link" => "string|nullable",
            "description" => "string|required",
            "status" => "string|required",
            "thumbnail" => "image|nullable",
            "old_thumbnail" => "string|nullable",
            "image3d" => "image|nullable",
            "old_content_pdf" => "string|nullable",
            "content_pdf" => "file|mimes:pdf|nullable",
            'search_tags' => 'string|nullable',
            'order_contact' => 'string|nullable',
        ]);
        $data = $request->only(['title','order','author','edition','isbn','published_year','pages','availability','price','discount','purchase_link','status','search_tags','description','order_contact']);
        
        $data['thumbnail'] = $request->old_thumbnail;
        if(isset($request->thumbnail))
        {
            $data['thumbnail'] = $request->thumbnail->store('uploads','public');
        }

        $data['image3d'] = $book->image3d;
        if(isset($request->image3d))
        {
            $data['image3d'] = $request->image3d->store('uploads','public');
        }
        
        $data['content_pdf'] = $request->old_content_pdf;
        if(isset($request->content_pdf))
        {
            $data['content_pdf'] = $request->content_pdf->store('uploads/books/pdf','public');
        }

        $book->update($data);


        if($book->category && $book->publisher)
        {
            return redirect('/admin/books/publishers/'.$book->publisher_id.'/categories/'.$book->category_id.'/books');
        }

        return redirect('/admin/books');
    }

    public function destroy(Book $book)
    {
        $category = $book->category;
        $publisher = $book->publisher;

        $book->delete();

        if($category && $publisher)
        {
            return redirect('/admin/books/publishers/'.$publisher->id.'/categories/'.$category->id.'/books');
        }

        return redirect('/admin/books');
    }

    public function reviewList(Book $book)
    {
        $reviews = $book->reviews()->orderByDesc('id')->get();
        return view('admin.books.reviews',compact('book','reviews'));
    }

    public function reviewDestroy(Book $book, BookReview $review)
    {
        $review->delete();
        return redirect('/admin/books/'.$book->id.'/reviews');
    }

}
