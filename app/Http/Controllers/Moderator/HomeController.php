<?php

namespace App\Http\Controllers\Moderator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Exams\Exam;
use App\Models\ExamHall\ExamHallCategories;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();
        $counters = [];
        $counters['blog_count'] = Blog::where('user_id','=',$user->id)->count();
        $counters['mcq_count'] = Exam::where('user_id','=',$user->id)->count();
        $counters['examhall_count'] = ExamHallCategories::where('user_id','=',$user->id)->count();

        $data['data'] = (object)$counters;
        // dd($data);
        return view('moderator.home',$data);
    }
}
