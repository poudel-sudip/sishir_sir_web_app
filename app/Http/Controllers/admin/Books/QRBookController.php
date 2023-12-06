<?php

namespace App\Http\Controllers\Admin\Books;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Books\QRBook; 
use App\Models\Books\Book; 
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
        $data['books'] = QRBook::all();
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
            'book_id' => 'numeric|required',
            "quantity" => "numeric|required|gte:0",
        ]);
                
        $data = $request->only(['book_id','quantity']);
        $sbook = Book::find($data['book_id']);
        if(!$sbook)
        {
            return back()->withInput()->withErrors(['book_id'=>'Invalid Book ID. This Book ID is not Present in My Books.']);
        }

        $data['slug'] = $sbook->slug;
        
        $book = QRBook::create($data);

        if($book->quantity > 0)
        {
            for ($i=1; $i <= $book->quantity; $i++) { 
                $book->scanMembers()->create([
                    'book_link' => url('/qr-book-scans/'.$book->slug.'/sn-'.$i),
                    'is_main' => true,
                ]);
            }
        }
        

        return redirect('/admin/qr-books');
    }

    public function show(QRBook $book)
    {
        // return view('admin.qr_books.show',compact('book'));
    }

    public function edit(QRBook $book)
    {
        return view('admin.qr_books.edit',compact('book'));
    }

    public function update(QRBook $book, Request $request)
    {
        // dd($request->all());
        $request->validate([
            "book_id" => "numeric|required|gte:0",
            "quantity" => "numeric|required|gte:0",
        ]);
        
        if($request['quantity'] < $book->quantity)
        {
            return back()->withInput()->withErrors(['quantity'=>'The New Published Quantity Should  Be Greater Than Previous Quantity.']);
        }

        
        $prev = $book->quantity;
        $new = $request['quantity'];

        if($new > $prev)
        {
            for ($i=$prev+1; $i <= $new; $i++) { 
                $book->scanMembers()->create([
                    'book_link' => url('/qr-book-scans/'.$book->slug.'/sn-'.$i),
                    'is_main' => true,
                ]);
            }
        }

        $book->update([
            'quantity' => $request->quantity,
        ]);      

        return redirect('/admin/qr-books');
    }

    public function destroy(QRBook $book)
    {

        $book->delete();

        return redirect('/admin/qr-books');
    }

    public function scanMembers(QRBook $book)
    {
        $members = $book->scanMembers()->orderBy('id')->get();
        return view('admin.qr_books.members',compact('book','members'));
    }

    public function scanMembersExport(QRBook $book): BinaryFileResponse
    {
        $fileName = ($book->book->title ?? 'Book ').' - QR Scan Members.xlsx';
        return Excel::download(new QRBookMemberExport($book), $fileName);
    }
    
    public function winnerMembers(QRBook $book)
    {
        $members = $book->winners()->orderBy('id')->get();
        return view('admin.qr_books.winners',compact('book','members'));
    }

    public function winnerCreate(QRBook $book)
    {
        return view('admin.qr_books.winners_create',compact('book'));
    }

    public function winnerStore(QRBook $book, Request $request)
    {
        // dd($request->all());
        $request->validate([
            'book_link' => 'required|string',
            'winner_type' => 'required|string',
        ]);

        $winner = $book->scanMembers()->where('book_link','=',trim($request->book_link))->where('is_main','=',true)->first();

        if(!$winner)
        {
            return back()->withInput()->withErrors(['book_link'=>'This Book Link is not Available For the Given Book.']);
        }

        $winner->update([
            'is_winner' => true,
            'winner_remarks' => ucwords($request->winner_type),
        ]);

        return redirect('/admin/qr-books/'.$book->id.'/winners');
    }
}
