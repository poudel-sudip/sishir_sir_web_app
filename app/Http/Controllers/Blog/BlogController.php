<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Categories;
use Illuminate\Http\Request;
use function Symfony\Component\String\b;
use App\Helpers\Helper;

class BlogController extends Controller
{
   public function index()
   {
        // $headercategories=Categories::all()->where('status','=','Active');
        // $last_blog=Blog::where('status','=','Published')->orderByDesc('created_at')->first();
        $blogs = Blog::where('status','=','Published')->orderByDesc('id')->paginate(12);
       return view('front.blogs.index',compact('blogs'));
   }

    public function show($slug)
    {
        $lateat_blogs=Blog::where('status','=','Published')->orderByDesc('id')->take(10)->get();
        $blog=Blog::where('slug',$slug)->first();
        if(!$blog)
        {
            abort(404);
        }
        //    $headercategories=Categories::all()->where('status','=','Active');
        $pgurl = strtok($_SERVER['REQUEST_URI'], '?');
        // $pgurl = "//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
        $pgtype = 'article';
        $counterData = Helper::pageCounterCounts($blog->title,$pgurl,$pgtype);

        // dd($pgurl,$counterData);
        return view('front.blogs.show',compact('blog', 'lateat_blogs','counterData'));
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
