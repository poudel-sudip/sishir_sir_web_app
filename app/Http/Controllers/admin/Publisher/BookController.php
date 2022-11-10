<?php

namespace App\Http\Controllers\admin\Publisher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Publisher;
use App\Models\Ebook\PublisherEbook;

class BookController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Publisher $publisher )
    {
        $books = $publisher->ebooks;
        return view('admin.publishers.books.index',compact('publisher','books'));
    }

    public function show(Publisher $publisher, PublisherEbook $ebook)
    {
        $book = $ebook->ebook;
        if(!$book)
        {
            abort(404);
        }

        return view('admin.publishers.books.show',compact('publisher','book'));
    }

    public function destroy(Publisher $publisher, PublisherEbook $ebook)
    {
        $book = $ebook->ebook;
        if(!$book)
        {
            abort(404);
        }
        $book->delete();
        $ebook->delete();

        return redirect('/admin/publishers/'.$publisher->id.'/books');
    }
}
