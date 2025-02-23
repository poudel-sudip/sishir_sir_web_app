<?php

namespace App\Http\Controllers\Admin\Blog;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Blog $blog)
    {
        return view('admin.blog.comments',compact('blog'));
    }

    public function update(Blog $blog,Comment $comment,$status)
    {
        $comment->update(['status'=>$status]);
        return redirect('/admin/blogs/'.$blog->id.'/comments');
    }

    public function destroy(Blog $blog,Comment $comment)
    {
        $comment->delete();
        return redirect('/admin/blogs/'.$blog->id.'/comments');
    }


}
