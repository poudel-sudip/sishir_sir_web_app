<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }


    public function counterFix()
    {
        $duplicateUrls = \App\Models\PostViewCounter::select('url')
        ->groupBy('url')
        ->havingRaw('COUNT(*) > 1')
        ->pluck('url');

        $posts = \App\Models\PostViewCounter::whereIn('url', $duplicateUrls)->get();
        dd('counter fix',$posts);
    }
}
