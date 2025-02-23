<?php

namespace App\Http\Controllers\Admin\PdfBank;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ebook\EbookCategory as Category;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $categories = Category::all();
        return view('admin.pdf_bank.category.index',compact('categories'));
    }

    public function create()
    {
        return view('admin.pdf_bank.category.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'string | required',
            'order' => 'numeric | required | gte:0',
            'status' => 'string | required | min:1',
        ]);

        Category::create([
            'name' => $request->name,
            'order' => $request->order,
            'status' => $request->status,
        ]);

        return redirect('/admin/pdf-bank/categories');
    }

    public function edit(Category $category)
    {
        return view('admin.pdf_bank.category.edit',compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'string | required',
            'order' => 'numeric | required | gte:0',
            'status' => 'string | required | min:1',
        ]);

        $category->update([
            'name' => $request->name,
            'order' => $request->order,
            'status' => $request->status,
        ]);
        return redirect('/admin/pdf-bank/categories');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect('/admin/pdf-bank/categories');
    }

    public function groups(Category $category)
    {
        $groups = $category->ebooks()->where('type','=','set')->orderByDesc('id')->get();
        // dd($books);
        return view('admin.pdf_bank.category.groups',compact('category','groups'));
    }

    public function singles(Category $category)
    {
        $singles = $category->ebooks()->where('type','=','single')->orderByDesc('id')->get();
        // dd($books);
        return view('admin.pdf_bank.category.singles',compact('category','singles'));
    }
}
