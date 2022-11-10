<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Blog;

class BlogController extends Controller
{
    public function blogs()
    {
        $blogs=Blog::where('status','=','Published')->get();
        $data=[];
        foreach ($blogs as $blog) {
            $data[]=(array)[
                'id'=>$blog->id,
                'title'=>$blog->title,
                'slug'=>$blog->slug,
                'description'=>$blog->description,
                'image'=>$blog->image,
                'author'=>$blog->author,
                'created_at'=>$blog->created_at,
                'comments'=>$blog->comments()->where('status','=','Published')->get(['id','name','email','contact','message','created_at']),
            ];
        }
        return response()->json($data,200);
    }


    public function singleBlog($slug)
   {
       $blog=Blog::where('slug',$slug)->first();
       if(!$blog)
       {
        return response()->json(['error'=>'Blog Not Found'], 404);
       }

       return response()->json([
        'id'=>$blog->id,
        'title'=>$blog->title,
        'slug'=>$blog->slug,
        'description'=>$blog->description,
        'image'=>$blog->image,
        'author'=>$blog->author,
        'created_at'=>$blog->created_at,
        'comments'=>$blog->comments()->where('status','=','Published')->get(['id','name','email','contact','message','created_at']),
       ],200);
    }

}
