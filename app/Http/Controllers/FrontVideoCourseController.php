<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VideoCourse\VideoCategory;
use App\Models\VideoCourse\VideoCourse;
use App\Models\VideoCourse\VideoPost;

class FrontVideoCourseController extends Controller
{
    public function allCourses()
    {
        $categories = VideoCategory::where('status','=','Active')->get();
        $courses = VideoCourse::where('status','=','Active')->get();
        return view('front.videocourse.allcourses',compact('categories','courses'));
    }

    public function categoryCourses($slug)
    {
        $categories = VideoCategory::where('status','=','Active')->get();
        $category = VideoCategory::where('slug','=',$slug)->first();
        if(!$category)
        {
            abort(404);
        }
        $courses = $category->courses()->where('status','=','Active')->get();
        return view('front.videocourse.categorycourses',compact('categories','category','courses'));
    }

    public function courseShow($slug)
    {
        $course = VideoCourse::where('slug','=',$slug)->first();
        $introvideourl = $course->intro_video;
        $introvideo= "";
        if(strpos($introvideourl, "youtube"))
        {
            $result=substr($introvideourl,strpos($introvideourl,"?v=")+3,strlen($introvideourl));
            $introvideo = '<iframe class="embed-responsive-item" src="https://www.youtube.com/embed/'.$result.'?autohide=1&controls=1&showinfo=1" frameborder="0" width="100%" allowfullscreen style="min-width: 30vw;min-height: 50vh;">  </iframe>';
        }
        else{
            if($introvideourl)
            {
                $introvideo = '<video class="embed-responsive-item" width="100%" height="100%" src="'.$introvideourl.'" allowfullscreen controls allowseeking nodownload poster="/storage/'.$course->thumbnail.'"> </video>';
            }
        }
        // dd($introvideourl,$introvideo);
        return view('front.videocourse.showcourse',compact('course','introvideo'));
    }

    public function videoShow($slug)
    {
        $video = VideoPost::where('slug','=',$slug)->first();
        if(!$video)
        {
            abort(404);
        }
        $course = $video->chapter->course;
        $recommended = $course->publicVideos;

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
                $videoplayer = '<video class="embed-responsive-item" width="100%" height="100%" src="'.$videourl.'" allowfullscreen controls allowseeking nodownload poster="/storage/'.$course->thumbnail.'"> </video>';
            }
        }
        // dd($video,$videourl,$videoplayer);
        return view('front.videocourse.showvideo',compact('video','course','recommended','videoplayer'));
    }
}
