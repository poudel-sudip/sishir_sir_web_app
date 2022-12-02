<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Blog;

class StudentHomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user=auth()->user();

        // $totalBookings=auth()->user()->bookings()->count();
        // $approved=auth()->user()->bookings()->where('status','=','Verified')->get();
        // $approvedBookings=$approved->count();
        // $suspendedBooking=auth()->user()->bookings()->where([['status','=','Verified'],['suspended','=',true]])->count();
        // $batches=[];
        // foreach ($approved as $booking) {
        //     $batches[]= $booking['batch_id'];
        // }
        // $batches=array_unique($batches);
        // $myexams=BatchExam::whereIn('batch_id',$batches)->count();
        // $exam_hall=auth()->user()->exam_bookings()->count();
        // $video_bookings = auth()->user()->video_bookings()->count();
        // $ebook_bookings = auth()->user()->ebook_bookings()->count();
        $count= (object) [
        //     'bookings'=> (object) [
        //         'total'=>$totalBookings,
        //         'approved'=>$approvedBookings,
        //         'pending'=>$totalBookings-$approvedBookings,
        //         'classroom'=>$approvedBookings-$suspendedBooking,
        //         'suspended'=>$suspendedBooking,
        //         'exams'=>$myexams,
        //         'exam_hall'=>$exam_hall,
        //         // 'video_booking'=>$video_bookings,
        //         'ebook_booking'=>$ebook_bookings,
        //     ],
        //     'orientations' => Orientation::whereDate('date','>=',date("Y-m-d"))->where('status','=','Active')->count(),
        ];
        $posts=Blog::all()->where('status','=','Published')->sortByDesc('id')->take(25);
        // dd($approved,$myexams);
        // $headercategories=Categories::all()->where('status','=','Active');
        return view('student.home',compact('user','count','posts'));
    }

    public function addComments(Blog $post,Request $request)
    {
         // dd($request->all());
         $request->validate([
             'name'=>['required','string'],
             'email'=>['required','email'],
             'contact'=>['required','numeric','digits:10'],
             'message'=>['required','string'],
         ]);
 
         $post->comments()->create([
             'name'=>$request->name,
             'email'=>$request->email,
             'contact'=>$request->contact,
             'message'=>$request->message,
             'status'=>'Published',
         ]);
 
         return redirect('/student/home');
    }

    

}
