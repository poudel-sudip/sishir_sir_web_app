<?php

namespace App\Http\Controllers\Publishers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class PublisherHomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $publisher = auth()->user()->publisher;
        $data = (object)[
            
        ];
        return view('publishers.home',compact('data'));
    }
}
