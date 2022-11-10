<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Batch;
use App\Models\Booking;
use App\Models\SendSMS;

class SMSController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $messages=SendSMS::all()->take(300);
        return view('admin.sms.index',compact('messages'));
    }

    public function create()
    {
        $batches=Batch::all()->sortBy('created_at');
        return view('admin.sms.create',compact('batches'));
    }

    public function store(Request $request)
    {
        $data=$request->validate([
            'group'=>'required',
            'description'=>'required | string',
        ]);

        $batchids=[];
        $batchgroups=[];
        $batchesGroupString='';
        $mobilenumbers='';
        if(isset($data['group']))
        {
            foreach ($data['group'] as $group)
            {
                $result = json_decode($group);
                $batchids[] = $result->id;
                $batchgroups[] = $result->batch;
            }
            $bookings=Booking::whereIn('batch_id',$batchids)->where('status','Verified')->get();  // get only booking verified users of given batch
            // $bookings=Booking::whereIn('batch_id',$batchids)->get();  //get all booking users of given batch
            foreach ($bookings as $book)
            {
                $mobilenumbers .=$book->user->contact.',';
            }
            $batchesGroupString=implode(' , ',$batchgroups);
        }
        else
        {
            $request->validate(['group'=>'required | min:1']);
        }

        // dd($batchesGroupString,$mobilenumbers,$data['description']);

        $args = http_build_query(array(
            'token' => config('sms.token'),
            'from'  => config('sms.from'),
            'to'    => $mobilenumbers,
            'text'  => $data['description']));
    
        $url = config('sms.url');
    
        # Make the call using API.
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$args);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    
        // Response
        $response = curl_exec($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
    
        if($status_code == 200)
        {
            SendSMS::create([
                'groups'=>$batchesGroupString,
                'message'=>$data['description'],
                'author'=>auth()->user()->name,
            ]);
            return redirect('/admin/sms')->with('success','SMS sent successfully.');
        }
        else
        {
            return redirect('/admin/sms')->with('error','Error while sending SMS. Please try again later.');
        }
    }
}
