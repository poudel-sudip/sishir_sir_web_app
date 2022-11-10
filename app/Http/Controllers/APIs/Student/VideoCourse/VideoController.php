<?php

namespace App\Http\Controllers\APIs\Student\VideoCourse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\VideoCourse\VideoBooking;
use App\Models\VideoCourse\VideoChapter;
use App\Models\VideoCourse\VideoPost;

class VideoController extends Controller
{
    protected $user; 

    protected function guard()
    {
        return Auth::guard('api');
    }

    public function __construct()
    {
        $this->middleware('auth:api');
        $this->user=$this->guard()->user();
    }

    public function chapterList($bookingID)
    {
        $booking = VideoBooking::find($bookingID);
        if(!$booking)
        {
            return response()->json(['error'=>'Booking Not Found'], 404);
        }

        if($booking->status != 'Verified')
        {
            return response()->json(['error'=>'This Booking is not Verified. Please Contact Administrator.'], 403);
        }

        $course = $booking->course;
        if(!$course)
        {
            return response()->json(['error'=>'Booked Course Not Found'], 404);
        }

        $chapters = $course->chapters()->where('status','=','Active')->get()->map(function($ch){
            return [
                'id' => $ch->id,
                'sn' => $ch->sn,
                'name' => $ch->name,
                'slug' => $ch->slug,
                'status' => $ch->status,
                'created_at' => $ch->created_at,
                'video_count' => $ch->videos->count(),
            ];
        });

        return response()->json([
            'booking_id' => $booking->id,
            'course_id' => $course->id,
            'course_name' => $course->name,
            'course_slug' => $course->slug,
            'course_thumbnail' => $course->thumbnail,
            'course_category' => $course->category->name ?? '',
            'chapters' => $chapters,
            
        ]);
    }

    public function videoList($bookingID, $chapterID)
    {
        $booking = VideoBooking::find($bookingID);
        if(!$booking)
        {
            return response()->json(['error'=>'Booking Not Found'], 404);
        }

        if($booking->status != 'Verified')
        {
            return response()->json(['error'=>'This Booking is not Verified. Please Contact Administrator.'], 403);
        }

        $course = $booking->course;
        if(!$course)
        {
            return response()->json(['error'=>'Booked Course Not Found'], 404);
        }

        $chapter = VideoChapter::find($chapterID);

        return response()->json([
            'booking_id' => $booking->id,
            'course_id' => $course->id,
            'course_name' => $course->name,
            'course_slug' => $course->slug,
            'course_thumbnail' => $course->thumbnail,
            'course_category' => $course->category->name ?? '',
            'chapter_id' => $chapter->id,
            'chapter_sn' => $chapter->sn,
            'chapter_name' => $chapter->name,
            'chapter_slug' => $chapter->slug,
            'videos' => $chapter->videos()->get(['id','title','slug','link','content','created_at']),
        ]);
    }

    public function getVideo($bookingID, $chapterID, $videoID)
    {
        $booking = VideoBooking::find($bookingID);
        if(!$booking)
        {
            return response()->json(['error'=>'Booking Not Found'], 404);
        }

        if($booking->status != 'Verified')
        {
            return response()->json(['error'=>'This Booking is not Verified. Please Contact Administrator.'], 403);
        }

        $course = $booking->course;
        if(!$course)
        {
            return response()->json(['error'=>'Booked Course Not Found'], 404);
        }

        $chapter = VideoChapter::find($chapterID);
        if(!$chapter)
        {
            return response()->json(['error'=>'Chapter Not Found'], 404);
        }

        $video = VideoPost::find($videoID);
        if(!$video)
        {
            return response()->json(['error'=>'Video Post Not Found'], 404);
        }

        return response()->json([
            'booking_id' => $booking->id,
            'course' => [
                'id' => $course->id,
                'name' => $course->name,
                'slug' => $course->slug,
                'thumbnail' => $course->thumbnail,
                'category' => $course->category->name ?? '',
            ],
            'chapter' => [
                'id' => $chapter->id,
                'sn' => $chapter->sn,
                'name' => $chapter->name,
                'slug' => $chapter->slug,
            ],
            
            'video' => $video,
        ]);
    }
}
