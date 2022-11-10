<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TutorPost;

class FrontTutorPostController extends Controller
{
    public function post($slug)
    {
        $post=TutorPost::where('slug',$slug)->first();
        if(!$post)
        {
            abort(404);
        }
        // dd($post->likes()->count());
        $post->incrementReadCount();
        return view('front.tutorposts.post',compact('post'));
    }
    
}
