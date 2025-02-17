<?php

namespace App\Http\Controllers\Admin\PdfBank;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ebook\Ebook as PDFSingle;
use App\Models\Ebook\EbookCategory as Category;
use App\Models\Library\LibraryCategory;
use App\Models\Library\LibraryMaterial;

class SingleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $singles = PDFSingle::where('type','=','single')->orderByDesc('id')->paginate(50);
        return view('admin.pdf_bank.single.index',compact('singles'));
    }

    public function show(PDFSingle $single)
    {
        return view('admin.pdf_bank.single.show',compact('single'));
    }

    public function bookings(PDFSingle $single)
    {
        $bookings = $single->bookings;
        return view('admin.pdf_bank.single.bookings',compact('single','bookings'));
    }

    public function destroy(PDFSingle $single)
    {
        $single->chapters()->delete();
        $single->bookings()->delete();
        $single->delete();
        return redirect('/admin/pdf-bank/pdf-singles');
    }

    public  function create()
    {
        $categories = Category::where('status','=','Active')->get();
        return view('admin.pdf_bank.single.create',compact('categories'));
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
            "pdf_file" => "file|required|mimes:pdf",
            "pages" => "string|nullable",
            "paper" => "string|nullable",
            "video_file" => "string|nullable",
            "can_download" => "boolean|required",

        ]);

        $img = request('thumbnail')->store('uploads','public');
        $pdf_file = request('pdf_file')->store('uploads/pdf_bank','public');

        $single = PDFSingle::create([
            'category_id' => $request->category,
            'title' => $request->name,
            'author' => $request->author ?? auth()->user()->name,
            'thumbnail' => $img,
            'pdf_file' => $pdf_file,
            'price' => $request->price,
            'discount' => $request->discount ?? 0,
            'description' => $request->description,
            'status' => $request->status,
            'pages' => $request->pages,
            'paper' => $request->paper,
            'video_file' => $request->video_file,
            'download' => $request->can_download ?? 0,
            'type' => 'single',
        ]);

        // return redirect('/admin/pdf-bank/categories/'.$single->category_id.'/singles');
        return redirect('/admin/pdf-bank/pdf-singles');
    }

    public function edit(PDFSingle $single)
    {
        $categories = Category::where('status','=','Active')->get();
        return view('admin.pdf_bank.single.edit',compact('single','categories'));
    }

    public function update(Request $request, PDFSingle $single)
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
            "pages" => "string|nullable",
            "paper" => "string|nullable",
            "old_pdf_file" => "string|nullable",
            "pdf_file" => "file|nullable|mimes:pdf",
            "can_download" => "boolean|required",
            "video_file" => "string|nullable",
        ]);

        $img = $request->oldThumbnail;
        if(isset($request->thumbnail))
        {
            $img = request('thumbnail')->store('uploads','public');
        }

        $pdf_file = $request->old_pdf_file;
        if(isset($request->pdf_file))
        {
            $pdf_file = request('pdf_file')->store('uploads/pdf_bank','public');
        }

        $single->update([
            'category_id' => $request->category,
            'title' => $request->name,
            'author' => $request->author,
            'thumbnail' => $img,
            'price' => $request->price,
            'discount' => $request->discount ?? 0,
            'description' => $request->description,
            'status' => $request->status,
            'isPinned' => $request->isPinned, 
            'pages' => $request->pages,
            'paper' => $request->paper,
            'pdf_file' => $pdf_file,
            'download' => $request->can_download ?? 0,
            'video_file' => $request->video_file,
        ]);
        
        // return redirect('/admin/pdf-bank/categories/'.$single->category_id.'/singles');
        return redirect('/admin/pdf-bank/pdf-singles');
    }

    public function importForm()
    {        
        $libraries = LibraryCategory::where('parent_id','=',null)->orderBy('name')->get();
        $categories = Category::where('status','=','Active')->get();
        // dd($libraries);
        $data = [];
        $data['categories'] = $categories;
        $data['libraries'] = $libraries;
        return view('admin.pdf_bank.single.import',$data);
    }


    public function copyPdfFromLibrary(Request $request)
    {    
        // dd($request->all());
        $request->validate([
            "category" => "numeric|required|min:1",
            'main_library' => 'required|numeric',
            'sub_library' => 'nullable|numeric',
            'pdf_files' => 'required|numeric',
            'price' => 'required|numeric|gte:0',
            'discount' => 'nullable|numeric',
        ]);
        
        $pdf = LibraryMaterial::find($request->pdf_files);
        
        if($pdf)
        {
            PDFSingle::create([
                'type' => 'single',
                'category_id' => $request->category,
                'title' => $pdf->name,
                'author'=>$pdf->author,
                'thumbnail' => $pdf->thumbnail,
                'price' => $request->price,
                'discount' => $request->discount ?? 0,
                'description' => $pdf->description,
                'pdf_file' => $pdf->fileurl,
                'pages' => $pdf->pages,
                'download'=> $pdf->download,
                'status' => 'Active',               
                
            ]);
        }

        return redirect('/admin/pdf-bank/pdf-singles');
    }

}
