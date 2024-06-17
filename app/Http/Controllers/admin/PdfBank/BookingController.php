<?php

namespace App\Http\Controllers\Admin\PdfBank;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Ebook\Ebook as PDFGroup;
use App\Models\Ebook\EbookBooking as Booking;

class BookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $bookings = Booking::orderByDesc('id')->take(300)->get();
        return view('admin.pdf_bank.booking.index',compact('bookings'));
    }

    public function allBookings()
    {
        $bookings = Booking::all();
        return view('admin.pdf_bank.booking.allbooking',compact('bookings'));
    }

    public function create()
    {
        $groups = PDFGroup::where('status','=','Active')->get();
        return view('admin.pdf_bank.booking.create',compact('groups'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            "group_name" => "numeric|required",
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
        $group = PDFGroup::find($request->group_name);
        if(!$group)
        {
            return back()->withInput()->withErrors(['group_name'=>'PDF Bank Group Not Found. Please Check Again.']);
        } 

        $search = Booking::where([
            ['book_id','=',$group->id],
            ['user_id','=',$user->id],
            ])->count();
        if($search){
            return back()->withInput()->withErrors(['group_name'=>'This PDf Bank Group is Already Booked by the Given User. Please Check Again !!!']);
        }

        $due = (integer)(($group->price - $group->discount) - ($request->paymentAmount + $request->discount));
        $img = '';
        if(isset($request->verificationDocument))
        {
            $img = request('verificationDocument')->store('uploads','public');
        }

        Booking::create([
            'book_id' => $group->id,
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

        return redirect('/admin/pdf-bank-bookings');
    }

    public function show(Booking $booking)
    {
        return view('admin.pdf_bank.booking.show',compact('booking'));
    }

    public function edit(Booking $booking)
    {
        $groups = PDFGroup::where('status','=','Active')->get();
        return view('admin.pdf_bank.booking.edit',compact('booking','groups'));
    }

    public function update(Request $request, Booking $booking)
    {
        // dd($request->all());
        $request->validate([
            "group_name" => "numeric|required",
            "verificationMode" => "string|required",
            "paymentAmount" => "numeric|required",
            "discount" => "numeric|nullable",
            "remarks" => "string|nullable",
            "status" => "string|required",
            "uploadDocument" => "image|nullable",
            "oldDocument" => "string|nullable",
        ]);

        $group = PDFGroup::find($request->group_name);
        if(!$group)
        {
            return back()->withInput()->withErrors(['group_name'=>'PDF Bank Group Not Found. Please Check Again.']);
        }

        $due = (integer)(($group->price - $group->discount) - ($request->paymentAmount + $request->discount));
        $img=$request->oldDocument;
        if(isset($request->uploadDocument))
        {
            $img=request('uploadDocument')->store('uploads','public');
        }

        $booking->update([
            'book_id' => $group->id,
            'status' => $request->status,
            'updatedBy' => auth()->user()->name,
            'verificationMode' => $request->verificationMode,
            'paymentAmount' => $request->paymentAmount,
            'discount' => $request->discount ?? 0,
            'dueAmount' => $due,
            'verificationDocument' => $img,
            'remarks' => $request->remarks,
        ]);

        return redirect('/admin/pdf-bank-bookings');
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();
        return redirect('/admin/pdf-bank-bookings');
    }
}
