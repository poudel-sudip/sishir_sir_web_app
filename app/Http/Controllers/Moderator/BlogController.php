<?php

namespace App\Http\Controllers\Moderator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Blog;
use App\Models\Comment;

class BlogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();
        $data['blogs'] = Blog::where('user_id','=',$user->id)->orderByDesc('id')->get(['id','title','author','status','created_at']);
        // dd($data);
        return view('moderator.blog.index',$data);
    }

    public function create()
    {
        return view('moderator.blog.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'=>['required','string'],
            'description'=>['required'],
            'status'=>['required'],
            'image'=>['image'],
            'author'=>['nullable'],
            'search_tags'=>['nullable'],
        ]);

        $img = $request->image->store('uploads','public');

        Blog::create([
            'title'=>$request->title,
            'description'=>$request->description,
            'status'=>$request->status,
            'image'=>$img,
            'search_tags' => $request->search_tags,
            'author'=>$request->author ?? auth()->user()->name,
            'user_id'=>auth()->user()->id,
        ]);

        return redirect('/moderator/newsroom');
    }

    public function show(Blog $blog)
    {
        return view('moderator.blog.show',compact('blog'));
    }

    public function edit(Blog $blog)
    {
        return view('moderator.blog.edit',compact('blog'));
    }

    public function update(Blog $blog,Request $request)
    {
        $request->validate([
            'title' =>['required','string'],
            'description' => ['required','string'],
            'old_image' => '',
            'status' => 'min:1',
            'image'=>'',
            'author' => '',
            'search_tags' => '',
        ]);
        $img=$request->old_image;
        if(isset($request->image))
        {
            $img=$request->image->store('uploads','public');
        }
        $blog->update([
            'title'=>$request->title,
            'description'=>$request->description,
            'image'=>$img,
            'status'=>$request->status,
            'author'=>$request->author ?? auth()->user()->name,
            'search_tags'=>$request->search_tags,
        ]);
        return redirect('/moderator/newsroom');
    }

    public function destroy(Blog $blog)
    {
        $blog->comments()->delete();
        $blog->delete();

        return redirect('/moderator/newsroom');
    }

    public function indexComment(Blog $blog)
    {
        return view('moderator.blog.comments',compact('blog'));
    }

    public function updateComment(Blog $blog,Comment $comment,$status)
    {
        $comment->update(['status'=>$status]);
        return redirect('/moderator/newsroom/'.$blog->id.'/comments');
    }

    public function destroyComment(Blog $blog,Comment $comment)
    {
        $comment->delete();
        return redirect('/moderator/newsroom/'.$blog->id.'/comments');
    }
}
