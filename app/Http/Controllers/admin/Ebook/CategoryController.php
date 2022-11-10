<?php

namespace App\Http\Controllers\admin\Ebook;

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
        $categories = EbookCategory::all();
        return view('admin.ebook.category.index',compact('categories'));
    }

    public function create()
    {
        return view('admin.ebook.category.create');
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

        return redirect('/admin/ebook/categories');
    }

    public function edit(EbookCategory $category)
    {
        return view('admin.ebook.category.edit',compact('category'));
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
        return redirect('/admin/ebook/categories');
    }

    public function destroy(EbookCategory $category)
    {
        $category->delete();
        return redirect('/admin/ebook/categories');
    }

    public function ebooks(EbookCategory $category)
    {
        $books = $category->ebooks;
        // dd($books);
        return view('admin.ebook.category.books',compact('category','books'));
    }
}
