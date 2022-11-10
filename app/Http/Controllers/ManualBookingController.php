<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Course;
use App\Models\ManualBooking;
use App\Models\Provience\Provience;
use App\Models\Teams\Team;
use Illuminate\Support\Facades\Hash;

class ManualBookingController extends Controller
{
    public function index()
    {
        $bookings=ManualBooking::all();
        return view('admin.manualBooking.index',compact('bookings'));
    }
    public function create()
    {
        $proviences = Provience::all()->sortBy('name');
        $courses=Course::where('status','=','Active')->get()->sortBy('order');
        return view('front.manualBooking',compact('courses','proviences'));
    }
    public function store()
    {
        $data=request()->validate([
            'course'=>'required|numeric',
            'name'=>'required|string',
            'email'=>'required|email',
            'mobile'=>'required|numeric|digits:10',
            'provience'=>'required|string',
            'district'=>'nullable',
            'remarks'=>'nullable',
            'payment_slip'=>'required | image',
        ]);
        $imagePath=request('payment_slip')->store('uploads','public');
        $booking=ManualBooking::create([
            'course_id'=>$data['course'],
            'name'=>$data['name'],
            'email'=>$data['email'],
            'mobile'=>$data['mobile'],
            'provience'=>ucwords($data['provience'] ?? ''),
            'district'=>ucwords($data['district'] ?? ''),
            'remarks'=>$data['remarks'],
            'payment_slip'=>$imagePath,
            'status'=>'Unverified',
        ]);
        return redirect('/manual-booking')->with('success','Your manual booking has been submited');
    }

    public function edit(ManualBooking $mbooking)
    {
        return view('admin.manualBooking.update',compact('mbooking'));
    }
    public function update(Request $request, ManualBooking $mbooking)
    {
        $request->validate([
            'status'=>'string | required',
            'email'=>'string | required',
            'mobile'=>'string | required',
            "create_user" => "string|nullable",
        ]);

        $userID = '';
        if(isset($request->create_user))
        {
            $user = User::where('email','=',$mbooking->email)->first();
            if(!$user)
            {
                //create user here
                $user = User::create([
                    'name' => ucwords($mbooking->name),
                    'email' => $mbooking->email,
                    'contact'=>$mbooking->mobile ?? '',
                    'password' => Hash::make($mbooking->mobile),
                    'district_city'=>ucwords($mbooking->district ?? ''),
                    'provience'=>ucwords($mbooking->provience ?? ''),
                    'role' => 'Student',
                ]);
                $userID = $user->id;
            }
            else{
                $userID = $user->id;
            }
        }
         
        $mbooking->update([
            'status'=>$request['status'],
            'user_id' => $userID,
        ]);

        return redirect('admin/manual-booking');
    }

    public function view($id)
    {
        return ManualBooking::find($id);
    }
    
    public function destroy(ManualBooking $mbooking)
    {
        $mbooking->delete();
        return redirect('admin/manual-booking');
    }

    public function teamCreate($id)
    {
        $team = Team::find($id);
        if(!$team)
        {
            abort(404);
        }
        $proviences = Provience::all()->sortBy('name');
        $courses = Course::where('status','=','Active')->get()->sortBy('order');
        return view('front.teamManualBooking',compact('team','courses','proviences'));
    }

    public function teamStore($id)
    {
        $team = Team::find($id);
        if(!$team)
        {
            abort(404);
        }
        $data=request()->validate([
            'course'=>'required|numeric',
            'name'=>'required|string',
            'email'=>'required|email',
            'mobile'=>'required|numeric|digits:10',
            'provience'=>'required|string',
            'district'=>'nullable',
            'remarks'=>'nullable',
            'payment_slip'=>'required | image',
        ]);
        $imagePath=request('payment_slip')->store('uploads','public');
        $booking=ManualBooking::create([
            'course_id'=>$data['course'],
            'name'=>$data['name'],
            'email'=>$data['email'],
            'mobile'=>$data['mobile'],
            'provience'=>ucwords($data['provience']),
            'district'=>ucwords($data['district'] ?? ''),
            'remarks'=>$data['remarks'],
            'payment_slip'=>$imagePath,
            'status'=>'Unverified',
            'team_id' => $team->id ?? '',
        ]);
        return redirect('/'.$team->id.'/manual-booking')->with('success','Your manual booking has been submited');
    }
}
