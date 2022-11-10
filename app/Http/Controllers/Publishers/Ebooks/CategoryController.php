<?php

namespace App\Http\Controllers\Publishers\Ebooks;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ebook\EbookCategory;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $publisher = auth()->user()->publisher;
        $categories = EbookCategory::all();
        
        return view('publishers.ebooks.category.index',compact('publisher','categories'));
    }

    public function create()
    {
        return view('publishers.ebooks.category.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'string | required',
            'order' => 'numeric | required',
            'status' => 'string | required | min:1',
        ]);

        EbookCategory::create([
            'name' => $request->name,
            'order' => $request->order,
            'status' => $request->status,
        ]);

        return redirect('/publisher/ebooks/categories');
    }

    public function edit(EbookCategory $category)
    {
        return view('publishers.ebooks.category.edit',compact('category'));   
    }

    public function update(Request $request, EbookCategory $category)
    {
        $request->validate([
            'name' => 'string | required',
            'order' => 'numeric | required',
            'status' => 'string | required | min:1',
        ]);

        $category->update([
            'name' => $request->name,
            'order' => $request->order,
            'status' => $request->status,
        ]);
        return redirect('/publisher/ebooks/categories');
    }

    public function ebooks(EbookCategory $category)
    {
        $publisher = auth()->user()->publisher;
        $books = $category->pub_books;
        return view('publishers.ebooks.category.books',compact('category','books'));   
    }
}
