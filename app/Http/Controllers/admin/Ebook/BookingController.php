<?php

namespace App\Http\Controllers\Admin\Ebook;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ebook\Ebook;
use App\Models\Ebook\EbookBooking;
use App\Models\User;

class BookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $bookings = EbookBooking::all()->sortByDesc('id')->take(300);
        return view('admin.ebook.booking.index',compact('bookings'));
    }

    public function allBookings()
    {
        $bookings = EbookBooking::all();
        return view('admin.ebook.booking.allbooking',compact('bookings'));
    }

    public function create()
    {
        $books = Ebook::where('status','=','Active')->get();
        return view('admin.ebook.booking.create',compact('books'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            "book_name" => "numeric|required",
            "userid" => "numeric|required",
            "verificationMode" => "string|required",
            "paymentAmount" => "numeric|required",
            "discount" => "numeric|nullable",
            "remarks" => "string|nullable",
            "status" => "string|required",
            "verificationDocument" => "image|nullable",
        ]);

        $user = User::find($request->userid);
        if(!$user)
        {
            return back()->withInput()->withErrors(['userid'=>'User Not Found. Please Check User ID.']);
        } 
        $book = Ebook::find($request->book_name);

        $search=EbookBooking::where([
            ['book_id','=',$request['book_name']],
            ['user_id','=',$request['userid']],
            ])->count();
        if($search){
            return back()->withInput()->withErrors(['book_name'=>'This Ebook is Already Booked by the Given User. Please Check Again !!!']);
        }

        $due = (integer)(($book->price - $book->discount) - ($request->paymentAmount + $request->discount));
        $img = '';
        if(isset($request->verificationDocument))
        {
            $img = request('verificationDocument')->store('uploads','public');
        }

        EbookBooking::create([
            'book_id' => $book->id,
            'user_id' => $user->id,
            'user_name' => $user->name,
            'status' => $request->status,
            'updatedBy' => auth()->user()->name,
            'verificationMode' => $request->verificationMode,
            'paymentAmount' => $request->paymentAmount,
            'discount' => $request->discount ?? 0,
            'dueAmount' => $due,
            'verificationDocument' => $img,
            'remarks' => $request->remarks,
        ]);

        return redirect('/admin/ebook-booking');
    }

    public function show(EbookBooking $booking)
    {
        return view('admin.ebook.booking.show',compact('booking'));
    }

    public function edit(EbookBooking $booking)
    {
        $books = Ebook::where('status','=','Active')->get();
        return view('admin.ebook.booking.edit',compact('booking','books'));
    }

    public function update(Request $request, EbookBooking $booking)
    {
        // dd($request->all());
        $request->validate([
            "book_name" => "numeric|required",
            "verificationMode" => "string|required",
            "paymentAmount" => "numeric|required",
            "discount" => "numeric|nullable",
            "remarks" => "string|nullable",
            "status" => "string|required",
            "uploadDocument" => "image|nullable",
            "oldDocument" => "string|nullable",
            "trans_code" => "string|nullable",
        ]);

        $book = Ebook::find($request->book_name);
        $due = (integer)(($book->price - $book->discount) - ($request->paymentAmount + $request->discount));
        $img=$request->oldDocument;
        if(isset($request->uploadDocument))
        {
            $img=request('uploadDocument')->store('uploads','public');
        }

        $booking->update([
            'book_id' => $book->id,
            'status' => $request->status,
            'updatedBy' => auth()->user()->name,
            'verificationMode' => $request->verificationMode,
            'paymentAmount' => $request->paymentAmount,
            'discount' => $request->discount ?? 0,
            'dueAmount' => $due,
            'verificationDocument' => $img,
            'remarks' => $request->remarks,
            'trans_code' => $request->trans_code,
        ]);

        return redirect('/admin/ebook-booking');
    }

    public function destroy(EbookBooking $booking)
    {
        $booking->vendorBooking()->delete();
        $booking->delete();
        return redirect('/admin/ebook-booking');
    }
}
