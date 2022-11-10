<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ebook\Ebook;

class FrontEbookController extends Controller
{
    public function ebookList()
    {
        $books = Ebook::where('status','=','Active')->get();
        return view('front.ebook.ebooklist',compact('books'));
    }

    public function ebookShow($slug)
    {
        $book = Ebook::where('slug','=',$slug)->first();
        if(!$book)
        {
            abort(404);
        }
        return view('front.ebook.ebookshow',compact('book'));
    }
}
