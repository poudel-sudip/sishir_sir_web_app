<?php

namespace App\Http\Controllers\Admin\PdfBank;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ebook\Ebook as PDFGroup;
use App\Models\Ebook\EbookCategory as Category;

class GroupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $groups = PDFGroup::all();
        return view('admin.pdf_bank.group.index',compact('groups'));
    }

    public  function create()
    {
        $categories = Category::where('status','=','Active')->get();
        return view('admin.pdf_bank.group.create',compact('categories'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            "category" => "numeric|required|min:1",
            "name" => "string|required",
            "author" => "string|nullable",
            "price" => "numeric|required",
            "discount" => "numeric|nullable",
            "description" => "string|required",
            "status" => "string|required",
            "thumbnail" => "image|required",
        ]);
        $img = request('thumbnail')->store('uploads','public');
        $group = PDFGroup::create([
            'category_id' => $request->category,
            'title' => $request->name,
            'author' => $request->author ?? auth()->user()->name,
            'thumbnail' => $img,
            'price' => $request->price,
            'discount' => $request->discount ?? 0,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        return redirect('/admin/pdf-bank/categories/'.$group->category_id.'/groups');
    }

    public function show(PDFGroup $group)
    {
        return view('admin.pdf_bank.group.show',compact('group'));
    }

    public function edit(PDFGroup $group)
    {
        $categories = Category::where('status','=','Active')->get();
        return view('admin.pdf_bank.group.edit',compact('group','categories'));
    }

    public function update(Request $request, PDFGroup $group)
    {
        // dd($request->all());
        $request->validate([
            "category" => "numeric|required|min:1",
            "name" => "string|required",
            "author" => "string|required",
            "price" => "numeric|required",
            "discount" => "numeric|nullable",
            "description" => "string|required",
            "status" => "string|required",
            "thumbnail" => "image|nullable",
            "oldThumbnail" => "string|nullable",
            "isPinned" => "string|required",
        ]);
        $img = $request->oldThumbnail;
        if(isset($request->thumbnail))
        {
            $img = request('thumbnail')->store('uploads','public');
        }

        $group->update([
            'category_id' => $request->category,
            'title' => $request->name,
            'author' => $request->author,
            'thumbnail' => $img,
            'price' => $request->price,
            'discount' => $request->discount ?? 0,
            'description' => $request->description,
            'status' => $request->status,
            'isPinned' => $request->isPinned, 
        ]);
        
        return redirect('/admin/pdf-bank/categories/'.$group->category_id.'/groups');
    }

    public function destroy(PDFGroup $group)
    {
        $group->chapters()->delete();
        $group->bookings()->delete();
        $group->delete();
        return redirect('/admin/pdf-bank/pdf-groups');
    }

    public function bookings(PDFGroup $group)
    {
        $bookings = $group->bookings;
        return view('admin.pdf_bank.group.bookings',compact('group','bookings'));
    }
}
