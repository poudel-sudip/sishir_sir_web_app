<?php

namespace App\Http\Controllers\Admin\PdfBank;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Ebook\Ebook as PDFGroup;
use App\Models\Ebook\EbookBooking as Booking;
use Carbon\Carbon;

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

    public function create(Request $request)
    {
        $page_type = $request->page_type ?? null;
        $groups = PDFGroup::where('status','=','Active')->get();
        return view('admin.pdf_bank.booking.create',compact('groups', 'page_type'));
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

        $booking = Booking::create([
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

        $expiry = null;
        if(!$booking->expiry_date)
        {
            if($booking->status == 'Expired')
            {
                $expiry = Carbon::now();
            }
            elseif($booking->status == 'Verified')
            {
                $expiry = Carbon::now()->addDays($group->expiry_days);
            }
            else 
            {
                $expiry = null;
            }

            $booking->update([
                'expiry_date' => $expiry,
            ]);
        }

        if(!$booking->payment_invoices()->exists())
        {
            $booking->payment_invoices()->create([
                'user_id' => $booking->user_id,
                'type' => 'ebook',
                'booking_id' => $booking->id,
                'payment_mode' => $request->verificationMode,
                'reference_code' => '',
                'payment_amount' => $request->paymentAmount ?? '0',
                'payment_remarks' => 'New Ebook booking of '.($booking->book->title ?? 'Unknown Ebook'),
                'discount_amount' => $request->discount ?? '0',
                'due_amount' => 0,
                'verified_by' => auth()->user()->name,
                'expiry_date' => $expiry,
                'paid' => 1,
                'informed' => 0,
            ]);
        }

        $category_id = null;
        $type = null;
        if($request->has('page_type') && $request->page_type == 'group')
        {
            $category_id = $booking->book->id ?? null;
            $type = $booking->book->type ?? null;
        }


        if($category_id && $type)
        {
            if($type == 'set')
            {
                return redirect('/admin/pdf-bank/pdf-groups/'.$category_id.'/bookings');
            }
            else if($type == 'single')
            {
                return redirect('/admin/pdf-bank/pdf-singles/'.$category_id.'/bookings');
            }

        }
        
        return redirect('/admin/pdf-bank-bookings');
    }

    public function show(Booking $booking)
    {
        return view('admin.pdf_bank.booking.show',compact('booking'));
    }

    public function edit(Request $request, Booking $booking)
    {
        $page_type = $request->page_type ?? null;
        $groups = PDFGroup::where('status','=','Active')->get();
        return view('admin.pdf_bank.booking.edit',compact('booking','groups', 'page_type'));
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
            'expiry_date' => 'date|nullable',
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
            'expiry_date' => $request->expiry_date,
        ]);

        if(!$booking->expiry_date)
        {
            if($booking->status == 'Expired')
            {
                $expiry = Carbon::now();
            }
            elseif($booking->status == 'Verified')
            {
                $expiry = Carbon::now()->addDays($group->expiry_days);
            }
            else 
            {
                $expiry = null;
            }

            $booking->update([
                'expiry_date' => $expiry,
            ]);
        }

        $category_id = null;
        $type = null;
        if($request->has('page_type') && $request->page_type == 'group')
        {
            $category_id = $booking->book->id ?? null;
            $type = $booking->book->type ?? null;
        }

        
        if($category_id && $type)
        {
            if($type == 'set')
            {
                return redirect('/admin/pdf-bank/pdf-groups/'.$category_id.'/bookings');
            }
            else if($type == 'single')
            {
                return redirect('/admin/pdf-bank/pdf-singles/'.$category_id.'/bookings');
            }

        }

        return redirect('/admin/pdf-bank-bookings');
    }

    public function destroy(Request $request, Booking $booking)
    {
        
        $category_id = null;
        $type = null;
        if($request->has('page_type') && $request->page_type == 'group')
        {
            $category_id = $booking->book->id ?? null;
            $type = $booking->book->type ?? null;
        }

        $booking->delete();

        if($category_id && $type)
        {
            if($type == 'set')
            {
                return redirect('/admin/pdf-bank/pdf-groups/'.$category_id.'/bookings');
            }
            else if($type == 'single')
            {
                return redirect('/admin/pdf-bank/pdf-singles/'.$category_id.'/bookings');
            }

        }

        return redirect('/admin/pdf-bank-bookings');
    }
}
