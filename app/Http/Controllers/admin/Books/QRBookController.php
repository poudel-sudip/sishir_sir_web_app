<?php

namespace App\Http\Controllers\Admin\Books;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Books\QRBook as Book; 
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Books\QRBookMemberExport;

class QRBookController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = [];
        $data['books'] = Book::all();
        return view('admin.qr_books.index',$data);
    }

    public function create()
    {
        $data = [];
        return view('admin.qr_books.create',$data);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'category' => 'string|required',
            'publisher' => 'string|required',
            "title" => "string|required",
            "author" => "string|nullable",
            "edition" => "string|nullable",
            "isbn" => "string|nullable",
            "published_year" => "string|nullable",
            "pages" => "string|nullable",
            // "availability" => "string|required",
            "price" => "numeric|required",
            "discount" => "numeric|nullable|lte:100|gte:0",
            "quantity" => "numeric|required|gte:0",
            // "purchase_link" => "string|nullable",
            "description" => "string|required",
            // "status" => "string|required",
            "thumbnail" => "image|required",
        ]);

        $data = $request->only(['publisher','category','title','author','edition','isbn','published_year','pages','price','discount','quantity','description']);
        
        $data['thumbnail'] = '';
        if(isset($request->thumbnail))
        {
            $data['thumbnail'] = $request->thumbnail->store('uploads','public');
        }
      
        $book = Book::create($data);

        if($book->quantity > 0)
        {
            for ($i=1; $i <= $book->quantity; $i++) { 
                $book->scanMembers()->create([
                    'book_link' => url('/qr-book-scans/'.$book->slug.'/sn-'.$i),
                ]);
            }
        }
        

        return redirect('/admin/qr-books');
    }

    public function show(Book $book)
    {
        return view('admin.qr_books.show',compact('book'));
    }

    public function edit(Book $book)
    {
        return view('admin.qr_books.edit',compact('book'));
    }

    public function update(Book $book, Request $request)
    {
        // dd($request->all());
        $request->validate([
            'category' => 'string|required',
            'publisher' => 'string|required',
            "title" => "string|required",
            "author" => "string|nullable",
            "edition" => "string|nullable",
            "isbn" => "string|nullable",
            "published_year" => "string|nullable",
            "pages" => "string|nullable",
            // "availability" => "string|required",
            "price" => "numeric|required",
            "discount" => "numeric|nullable|lte:100|gte:0",
            "quantity" => "numeric|required|gte:0",
            "description" => "string|required",
            // "status" => "string|required",
            "thumbnail" => "image|nullable",
            "old_thumbnail" => "string|nullable",
        ]);
        $data = $request->only(['category','publisher','title','author','edition','isbn','published_year','pages','price','discount','quantity','description']);
        
        if($data['quantity'] < $book->quantity)
        {
            return back()->withInput()->withErrors(['quantity'=>'The New Published Quantity Should  Be Greater Than Previous Quantity.']);
        }

        $data['thumbnail'] = $request->old_thumbnail;
        if(isset($request->thumbnail))
        {
            $data['thumbnail'] = $request->thumbnail->store('uploads','public');
        }
        
        $prev = $book->quantity;
        $new = $data['quantity'];

        if($new > $prev)
        {
            for ($i=$prev+1; $i <= $new; $i++) { 
                $book->scanMembers()->create([
                    'book_link' => url('/qr-book-scans/'.$book->slug.'/sn-'.$i),
                ]);
            }
        }

        $book->update($data);      

        return redirect('/admin/qr-books');
    }

    public function destroy(Book $book)
    {

        $book->delete();

        return redirect('/admin/qr-books');
    }

    public function scanMembers(Book $book)
    {
        $members = $book->scanMembers()->orderBy('id')->get();
        return view('admin.qr_books.members',compact('book','members'));
    }

    public function scanMembersExport(Book $book): BinaryFileResponse
    {
        $fileName = $book->title.' - QR Scan Members.xlsx';
        return Excel::download(new QRBookMemberExport($book), $fileName);
    }
    
}
