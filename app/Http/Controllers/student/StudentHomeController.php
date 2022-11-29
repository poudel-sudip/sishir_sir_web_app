<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Categories;
use App\Models\Exams\BatchExam;
use App\Models\TutorPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Orientation;

class StudentHomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user=auth()->user();

        $totalBookings=auth()->user()->bookings()->count();
        $approved=auth()->user()->bookings()->where('status','=','Verified')->get();
        $approvedBookings=$approved->count();
        $suspendedBooking=auth()->user()->bookings()->where([['status','=','Verified'],['suspended','=',true]])->count();
        $batches=[];
        foreach ($approved as $booking) {
            $batches[]= $booking['batch_id'];
        }
        $batches=array_unique($batches);
        $myexams=BatchExam::whereIn('batch_id',$batches)->count();
        $exam_hall=auth()->user()->exam_bookings()->count();
        // $video_bookings = auth()->user()->video_bookings()->count();
        $ebook_bookings = auth()->user()->ebook_bookings()->count();
        $count= (object) [
            'bookings'=> (object) [
                'total'=>$totalBookings,
                'approved'=>$approvedBookings,
                'pending'=>$totalBookings-$approvedBookings,
                'classroom'=>$approvedBookings-$suspendedBooking,
                'suspended'=>$suspendedBooking,
                'exams'=>$myexams,
                'exam_hall'=>$exam_hall,
                // 'video_booking'=>$video_bookings,
                'ebook_booking'=>$ebook_bookings,
            ],
            'orientations' => Orientation::whereDate('date','>=',date("Y-m-d"))->where('status','=','Active')->count(),
        ];
        $post=TutorPost::all()->where('status','=','Published')->sortByDesc('id')->take(25);
        // dd($approved,$myexams);
        $headercategories=Categories::all()->where('status','=','Active');
        return view('student.home',compact('user','count','headercategories','post'));
    }

    public function addComments(TutorPost $post,Request $request)
    {
         // dd($request->all());
         $request->validate([
             'name'=>['required','string'],
             'email'=>['required','email'],
             'contact'=>['required','numeric','digits:10'],
             'message'=>['required','string'],
         ]);
 
         $post->comments()->create([
             'post_id'=>$post->id,
             'name'=>$request->name,
             'email'=>$request->email,
             'contact'=>$request->contact,
             'message'=>$request->message,
             'status'=>'Published',
         ]);
 
         return redirect('/student/home');
    }

    public function enroll()
    {
        $headercategories=Categories::all()->where('status','=','Active');
        return view('student.enrolled',[
            'bookings'=>auth()->user()->bookings()->get(),
            'headercategories'=>$headercategories,
        ]);
    }

    public function pending()
    {
        return view('student.enrolled',[
            'bookings'=>auth()->user()->bookings()->where('status','!=','Verified')->get(),
            'headercategories'=>Categories::all()->where('status','=','Active'),
        ]);
    }

    public function approved()
    {
        return view('student.enrolled',[
            'bookings'=>auth()->user()->bookings()->where('status','=','Verified')->get(),
            'headercategories'=>Categories::all()->where('status','=','Active'),
        ]);
    }

    
    public function suspended()
    {
        return view('student.enrolled',[
            'bookings'=>auth()->user()->bookings()->where('suspended','=',true)->get(),
            'headercategories'=>Categories::all()->where('status','=','Active'),
        ]);
    }

    public function classroom()
    {
        return view('student.classroom',[
            'bookings'=>auth()->user()->bookings()->where('status','=','Verified')->where('suspended','=',false)->orderBy('id','DESC')->get(),
            'headercategories'=>Categories::all()->where('status','=','Active'),
        ]);
    }

    public function orientations()
    {
        $orientations = Orientation::whereDate('date','>=',date("Y-m-d"))->where('status','=','Active')->get();
        // dd($orientations);
        return view('student.orientations.index',compact('orientations'));
    }

}
