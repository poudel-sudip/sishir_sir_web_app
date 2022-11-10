<?php

namespace App\Http\Controllers\Tutors;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\TutorPost;
use App\Models\TutorPostComment;

class TutorPostController extends Controller
{
    
    public function index()
    {
       $posts=auth()->user()->tutorProfile->posts;
       return view('tutors.posts.index',compact('posts'));
    }

    public function create()
    {
       return view('tutors.posts.create');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'title'=>'string|required',
            'description'=>'required|string',
            'image'=>'nullable|image',
        ]);
        $img='';
        if(isset($request->image))
        {
            $img=$request->image->store('uploads','public');
        }
        $slug = Str::slug($request->title);   

        $post=auth()->user()->tutorProfile->posts()->create([
            'title'=>$request->title,
            'slug'=>$slug,
            'description'=>$request->description,
            'thumbnail'=>$img,
            'status'=>'Published',
        ]);

        return redirect('/tutor/posts');
    }

    public function show(TutorPost $post)
    {
        return view('tutors.posts.show',compact('post'));
    }

    public function edit(TutorPost $post)
    {
        return view('tutors.posts.edit',compact('post'));
    }

    public function update(Request $request, TutorPost $post)
    {
        // dd($post,$request->all());
        $request->validate([
            'title' =>['required','string'],
            'description' => ['required','string'],
            'old_image' => '',
            'status' => 'min:1',
            'image'=>'',
        ]);
        $img=$request->old_image;
        if(isset($request->image))
        {
            $img=$request->image->store('uploads','public');
        }
        $slug = Str::slug($request->title);
        $post->update([
            'title'=>$request->title,
            'slug'=>$slug,
            'description'=>$request->description,
            'thumbnail'=>$img,
            'status'=>$request->status,
        ]);
        return redirect('/tutor/posts');
    }

    public function destroy(TutorPost $post)
    {
        $post->delete();
        return redirect('/tutor/posts');
    }

    public function comments(TutorPost $post)
    {
        return view('tutors.posts.comments',compact('post'));
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
 
         return redirect('/tutor/posts');
    }


    public function deleteComment(TutorPost $post,TutorPostComment $comment)
    {
        $comment->delete();
        return redirect('/tutor/posts');
    }
}
