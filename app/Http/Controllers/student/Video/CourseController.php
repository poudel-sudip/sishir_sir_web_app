<?php

namespace App\Http\Controllers\student\Video;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VideoCourse\VideoBooking;
use App\Models\VideoCourse\VideoChapter;
use App\Models\VideoCourse\VideoPost;

class CourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function chapters(VideoBooking $booking)
    {
        $course = $booking->course;
        $chapters = $course->chapters->sortBy('sn');
        // dd($booking,$course,$chapters);
        return view('student.videocourse.chapter.chapters',compact('booking','course','chapters'));
    }

    public function videos(VideoBooking $booking, VideoChapter $chapter)
    {
        $videos = $chapter->videos;
        // dd($booking,$chapter,$videos);
        return view('student.videocourse.chapter.videos',compact('booking','chapter','videos'));
    }

    public function show(VideoBooking $booking, VideoChapter $chapter, VideoPost $video)
    {
        // dd($booking,$chapter,$video);
        $videourl = $video->link;
        $videoplayer= "";
        if(strpos($videourl, "youtube"))
        {
            $result=substr($videourl,strpos($videourl,"?v=")+3,strlen($videourl));
            $videoplayer = '<iframe class="embed-responsive-item" src="https://www.youtube.com/embed/'.$result.'?autohide=1&controls=1&showinfo=1" frameborder="0" width="100%" allowfullscreen style="min-width: 30vw;min-height: 50vh;">  </iframe>';
        }
        else{
            if($videourl)
            {
                $videoplayer = '<video class="embed-responsive-item" width="100%" height="100%" src="'.$videourl.'" allowfullscreen controls allowseeking nodownload poster=""> </video>';
            }
        }
        return view('student.videocourse.chapter.showvideo',compact('booking','chapter','video','videoplayer'));
    }
}
