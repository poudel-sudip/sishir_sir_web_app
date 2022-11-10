<?php

namespace App\Http\Controllers\Teams;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Ebook\Ebook;
use App\Models\Ebook\EbookBooking;
use App\Models\Vendors\VendorEbookBooking;

class EbookBookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function allBookings()
    {
        $team = auth()->user()->team;
        $vendor = $team->vendor;
        $bookings = [];
        if($vendor)
        {
            $bookings = $vendor->ebookBookings()->where('team_id','=',$team->id)->get();
        }
        // dd($bookings);
        return view('teams.bookings.ebook.allbookings',compact('bookings'));
    }

    public function index()
    {
        $team = auth()->user()->team;
        $vendor = $team->vendor;
        $bookings = [];
        if($vendor)
        {
            $bookings = $vendor->ebookBookings()->where('team_id','=',$team->id)->get()->sortByDesc('id')->take(300);
        }
        // dd($bookings);
        return view('teams.bookings.ebook.index',compact('bookings'));
    }

    public function create()
    {
        $books = Ebook::where('status','=','Active')->get();
        return view('teams.bookings.ebook.create',compact('books'));
    }

    public function store(Request $request)
    {
        $team = auth()->user()->team;
        $vendor = $team->vendor;
        if(!$vendor)
        {
            dd("YOU ARE NOT ASSOCIATED WITH A VENDOR OR A BRANCH. PLEASE CONTACT ADMINISTRATOR.");
        }

        $request->validate([
            "book" => "numeric | required| min:1",
            "userID" => "numeric | required| min:1",
            "paymentAmount" => "numeric | required | min:1",
            "discount" => "numeric | nullable",
            "remarks" => "string | nullable",
            "verificationDocument" => "image | nullable",
        ]);

        $user = User::find($request['userID']);
        if(!$user)
        {
            return back()->withInput()->withErrors(['userID'=>'Given User ID is Incorrect. Please Check Again !!!']);   
        }

        $book = Ebook::find($request['book']);
        if(!$book)
        {
            return back()->withInput()->withErrors(['book'=>'E-Book Mismatch. Please Check Again !!!']);   
        }

        $search = EbookBooking::where([
            ['book_id','=',$book->id],
            ['user_id','=',$user->id],
            ])->count();
        if($search){
            return back()->withInput()->withErrors(['book'=>'This E-Book is Already Booked by the Given User. Please Check Again !!!']);
        }

        $due=(integer)($book->price - $book->discount  - $request->paymentAmount - $request->discount);
        $img = "";
        if(isset($request['verificationDocument']))
        {
            $img = request('verificationDocument')->store('uploads','public');
        } 

        $booking = EbookBooking::create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'user_name' => $user->name,
            'status' => 'Processing',
            'remarks' => $request->remarks,
            'updatedBy' =>auth()->user()->name,
            'verificationMode' => 'Manual',
            'paymentAmount' => $request['paymentAmount'],
            'discount' => $request['discount'],
            'dueAmount' => $due,
            'verificationDocument'=>$img,
        ]);

        $vendor->ebookBookings()->create([
            'booking_id'=>$booking->id,
            'Amount' => $request['paymentAmount'],
            'verificationDocument' => $img,
            'team_id' => $team->id,
        ]);

        return redirect('/team/ebook-bookings')->with('success_message', 'E-Book Booking of User with ID '.$user->id.' Created Succesfully.');
    }

    public function show(VendorEbookBooking $vbooking)
    {
        $booking = $vbooking->booking;
        return view('teams.bookings.ebook.show',compact('booking'));
    }

    public function edit(VendorEbookBooking $vbooking)
    {
        $booking = $vbooking->booking;
        $books = Ebook::where('status','=','Active')->get();
        return view('teams.bookings.ebook.edit',compact('vbooking','booking','books'));
    }

    public function update(VendorEbookBooking $vbooking, Request $request)
    {
        // dd($request->all(),$vbooking);
        $request->validate([
            "verificationMode" => "required|string",
            "status" => "required|string",
            "remarks" => "nullable|string",
        ]);

        $vbooking->booking()->update([
            'status'=>$request['status'],
            'updatedBy'=>auth()->user()->name,
            'verificationMode'=>$request['verificationMode'],
            'remarks'=>$request['remarks'],
        ]);

        return redirect('/team/ebook-bookings')->with('success_message', 'E-Book Booking with ID '.$vbooking->booking_id.' Updated Succesfully.');
    }

    public function destroy(VendorEbookBooking $vbooking)
    {
        $vbooking->booking()->delete();
        $vbooking->delete();
        return redirect('/team/ebook-bookings')->with('success_message', 'E-Book Booking with ID '.$vbooking->booking_id.' Deleted Succesfully.');
    }
}
