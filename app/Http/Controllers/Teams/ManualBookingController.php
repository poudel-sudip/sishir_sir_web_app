<?php

namespace App\Http\Controllers\Teams;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\ManualBooking;
use App\Models\User;
use App\Models\Vendors\VendorUser;

class ManualBookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $team = auth()->user()->team;
        $manualBookings = $team->manualBookings;
        // dd($manualBookings);
        return view('teams.bookings.manual.index',compact('manualBookings'));
    }

    public function edit(ManualBooking $booking)
    {
        return view('teams.bookings.manual.edit',compact('booking'));
    }

    public function update(ManualBooking $booking, Request $request)
    {
        // dd($request->all());
        $request->validate([
            'status'=>'string | required',
            'email'=>'string | required',
            'mobile'=>'string | required',
            "create_user" => "string|nullable",
        ]);
        $userID = '';

        if(isset($request->create_user))
        {
            $user = User::where('email','=',$booking->email)->first();
            if(!$user)
            {
                //create user here
                $user = User::create([
                    'name' => ucwords($booking->name),
                    'email' => $booking->email,
                    'contact'=>$booking->mobile ?? '',
                    'password' => Hash::make($booking->mobile),
                    'district_city'=>ucwords($booking->district ?? ''),
                    'provience'=>ucwords($booking->provience ?? ''),
                    'role' => 'Student',
                ]);

                VendorUser::create([
                    'vendor_id'=>auth()->user()->team->vendor_id ?? '',
                    'team_id' => auth()->user()->team->id,
                    'user_id' => $user->id,
                ]);

                $userID = $user->id;
            }
            else{
                $userID = $user->id;
            }
        }
        
        $booking->update([
            'status'=>$request['status'],
            'user_id' => $userID,
        ]);

        return redirect('/team/manual-bookings');
    }

    public function destroy(ManualBooking $booking)
    {
        $booking->delete();
        return redirect('/team/manual-bookings');
    }
}
