<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Categories;
use App\Models\Course;
use App\Models\Tutor;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query=$request->input('query');
        $categories=Categories::where('name','Like','%'.$query.'%')->get();
        $courses=Course::where('name','Like','%'.$query.'%')->get();
        $batches=Batch::where('name','Like','%'.$query.'%')->get();
        $tutors=Tutor::where('name','Like','%'.$query.'%')->get();

        return view('front.search',[
            'query'=>$query,
            'headercategories'=>Categories::all()->where('status','=','Active')->sortBy('order'),
            'categories'=>$categories,
            'courses'=>$courses,
            'batches'=>$batches,
            'tutors'=>$tutors,
        ]);
    }
}
