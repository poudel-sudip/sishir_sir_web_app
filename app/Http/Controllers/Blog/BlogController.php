<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Categories;
use Illuminate\Http\Request;
use function Symfony\Component\String\b;
use App\Helpers\Helper;
use App\Models\Advertisement;

class BlogController extends Controller
{
   public function index()
   {
        // $headercategories=Categories::all()->where('status','=','Active');
        // $last_blog=Blog::where('status','=','Published')->orderByDesc('created_at')->first();
        $data['blog_categories'] = Categories::where('type', '=', 'blog-category')->whereHas('blogs')->orderBy('order')->get(['id','name']);
        $data['blogs'] = Blog::where('status','=','Published')->orderByDesc('id')->paginate(6);
       return view('front.blogs.index',$data);
   }

    public function categoryBlogs($category, Request $request)
    {   
        $category = Categories::where('type','=','blog-category')->find($category);
        if(!$category)
        {
            abort(404,'Blog Category not found');
        }

        $data['selected_category'] = $category;
        $data['blog_categories'] = Categories::where('type', '=', 'blog-category')->whereHas('blogs')->orderBy('order')->get(['id','name']);
        $data['blogs'] = $category->blogs()->where('status','=','Published')->orderByDesc('id')->paginate(6);
        return view('front.blogs.category-wise',$data);
    }

    public function authorBlogs($author, Request $request)
    {   
        $author = Blog::where('author','=',$author)
        ->orWhere('author','LIKE','%'.$author.'%')
        ->first(['author']);
        if(!$author)
        {
            return redirect('/newsroom');
        }

        $author = $author->author;

        $data['selected_author'] = $author;
        $data['blogs'] = Blog::where('author','=',$author)
        ->orWhere('author','LIKE','%'.$author.'%')
        ->where('status','=','Published')
        ->orderByDesc('id')
        ->paginate(6);

        return view('front.blogs.author-wise',$data);
    }

    public function show($bid)
    {
        $lateat_blogs=Blog::where('status','=','Published')->orderByDesc('id')->take(10)->get();
        $blog=Blog::where('id',$bid)->first();
        if(!$blog)
        {
            abort(404);
        }
        //    $headercategories=Categories::all()->where('status','=','Active');
        $pgurl = strtok($_SERVER['REQUEST_URI'], '?');
        // $pgurl = "//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
        $pgtype = 'article';
        $counterData = Helper::pageCounterCounts($blog->title,$pgurl,$pgtype);

        $sidebar_ad = Advertisement::where('status','Active')->where('position','page_sidebar_ad')->first();
        // dd($pgurl,$counterData);
        return view('front.blogs.show',compact('blog', 'lateat_blogs','counterData','sidebar_ad'));
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

      return redirect('/newsroom/'.$blog->id);
   }
}
