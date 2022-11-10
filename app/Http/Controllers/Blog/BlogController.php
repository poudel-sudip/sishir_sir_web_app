<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Categories;
use Illuminate\Http\Request;
use function Symfony\Component\String\b;

class BlogController extends Controller
{
   public function index()
   {
    $headercategories=Categories::all()->where('status','=','Active');
    $last_blog=Blog::where('status','=','Published')->orderByDesc('created_at')->first();
    $blogs=Blog::where('status','=','Published')->orderByDesc('created_at')->get();
       return view('front.blogs.index',compact('headercategories','blogs','last_blog',));
   }

   public function show($slug)
   {
       $blog=Blog::where('slug',$slug)->first();
       if(!$blog)
       {
           abort(404);
       }
       $headercategories=Categories::all()->where('status','=','Active');

       return view('front.blogs.show',compact('blog','headercategories'));
   }

   public function addComments(Blog $blog,Request $request)
   {
      $request->validate([
          'name'=>['required','string'],
          'email'=>['required','email'],
          'contact'=>['required','numeric','digits:10'],
          'message'=>['required','string'],
      ]);

      $blog->comments()->create([
        'blog_id'=>$blog->id,
        'name'=>$request->name,
        'email'=>$request->email,
        'contact'=>$request->contact,
        'message'=>$request->message,
        'status'=>'Unpublished',
      ]);

      return redirect('/blogs/'.$blog->slug);
   }
}
