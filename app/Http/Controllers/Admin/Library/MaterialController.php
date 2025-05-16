<?php

namespace App\Http\Controllers\Admin\Library;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Library\LibraryCategory;
use App\Models\Library\LibraryMaterial;
use Spatie\PdfToImage\Pdf as PdfToImage;
use Imagick;

class MaterialController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(LibraryCategory $category)
    {
        $data = [];
        $data['category'] = $category;
        $data['materials'] = $category->materials;
        
        // dd($data,$category->childs,$category->parent);
        return view('admin.library.materials.index',$data);
    }

    public function create(LibraryCategory $category)
    {
        return view('admin.library.materials.create',compact('category'));
    }

    public function store(LibraryCategory $category, Request $request)
    {
        $data = $request->validate([
            'name' => 'string|required',
            // 'order' => 'numeric|required',
            'status' => 'string|required',
            'type' => 'string|required',
            'thumbnail' => 'image|nullable',
            'search_tags' => 'nullable|string',
            'description' => 'nullable|string',
            'author' => 'nullable|string',
            'published_year' => 'nullable|string',
            'pages' => 'nullable|string',
            'source' => 'nullable|string',
        ]);

        if($data['type'] == 'text' || $data['type'] == 'Text')
        {
            $request->validate(['description' => 'string|required|min:5']);
            $data['description'] = $request->description;
        }
        elseif($data['type'] == 'file' || $data['type'] == 'File')
        {
            $request->validate([ 
                // 'file' => 'required|file|mimes:pdf',
                'file' => 'required|file',
                'can_download' => 'required|boolean',
            ]);
            $data['download'] = $request->can_download;
            $data['filename'] = $request->file->getClientOriginalName();
            $data['fileurl'] = $request->file->storeAs('uploads/library/files',$data['filename'],'public');
        }

        if(isset($request->thumbnail))
        {
            $data['thumbnail'] = $request->thumbnail->store('uploads/library/thumbnails','public');
        }

        if(!isset($data['thumbnail']) || !$data['thumbnail'] || !file_exists(public_path('/storage/'.$data['thumbnail'])))
        {
            $pdfPath = public_path('/storage/'.$data['fileurl']); 
            $imagePath = '/uploads/library/thumbnails/pdf/'.date('Y-m-d').'-'.time().'.jpg';

            if($this->pdfToImage($pdfPath, $imagePath))
            {
                $data['thumbnail'] = $imagePath;
            }           
        }
        
        $category->materials()->create($data);

        // return redirect('/admin/library/'.$category->id.'/materials');
        return redirect('/admin/library/'.$category->id.'/directories');
    }

    public function show(LibraryCategory $category, LibraryMaterial $material)
    {
        $data[] = [];
        $data['category'] = $category;
        $data['material'] = $material;
        return view('admin.library.materials.show',$data);
    }

    public function edit(LibraryCategory $category, LibraryMaterial $material)
    {
        $data[] = [];
        $data['category'] = $category;
        $data['material'] = $material;
        return view('admin.library.materials.edit',$data);
    }

    public function update(LibraryCategory $category, LibraryMaterial $material, Request $request)
    {        
        // dd($material,$request->all());
        $request->validate([
            'name' => 'string|required',
            // 'order' => 'numeric|required',
            'status' => 'string|required',
            // 'file' => 'nullable|file|mimes:pdf',
            'file' => 'nullable|file',
            'old_file' => 'nullable|string',
            'filename' => 'nullable|string',
            // 'description' => 'string|nullable',
            'type' => 'string|required',
            'thumbnail' => 'image|nullable',
            'old_thumbnail' => 'string|nullable',
            'can_download' => 'required|boolean',
            'search_tags' => 'nullable|string',
            'description' => 'nullable|string',
            'author' => 'nullable|string',
            'published_year' => 'nullable|string',
            'pages' => 'nullable|string',
            'source' => 'nullable|string',
        ]);
        
        $data = $request->only(['name','order','status','type','search_tags','description','author','published_year','pages','source']);

        if($data['type'] == 'text' || $data['type'] == 'Text')
        {
            $request->validate(['description' => 'string|required|min:5']);
            $data['filename'] = '';
            $data['fileurl'] = '';
            $data['description'] = $request->description;
        }
        elseif($data['type'] == 'file' || $data['type'] == 'File')
        {
            $data['download'] = $request->can_download;
            if($request->old_file == '' && !isset($request->file))
            {
                // return back()->withInput()->withErrors(['file' => 'Please select a pdf file']);
                return back()->withInput()->withErrors(['file' => 'Please select a file']);
            }
            elseif(isset($request->file))
            {
                $data['filename'] = $request->file->getClientOriginalName();
                $data['fileurl'] = $request->file->storeAs('uploads/library/files',$data['filename'],'public');
            }
            else
            {
                $data['fileurl'] = $request->old_file;
                $data['filename'] = $request->filename;
            }
        }
        else {}

        $data['thumbnail'] = $request->old_thumbnail;
        if(isset($request->thumbnail))
        {
            $data['thumbnail'] = $request->thumbnail->store('uploads/library/thumbnails','public');
        }

        if(!$data['thumbnail'] || !file_exists(public_path('/storage/'.$data['thumbnail'])))
        {
            $pdfPath = public_path('/storage/'.$data['fileurl']); 
            $imagePath = '/uploads/library/thumbnails/pdf/'.date('Y-m-d').'-'.time().'.jpg';

            if($this->pdfToImage($pdfPath, $imagePath))
            {
                $data['thumbnail'] = $imagePath;
            }           
        }
        
        $material->update($data);
        // return redirect('/admin/library/'.$category->id.'/materials');
        return redirect('/admin/library/'.$category->id.'/directories');
    }

    public function destroy(LibraryCategory $category, LibraryMaterial $material, Request $request)
    {
        $material->delete();
        // return redirect('/admin/library/'.$category->id.'/materials');
        return redirect('/admin/library/'.$category->id.'/directories');
    }

    public function importForm(LibraryCategory $category)
    {
        $data['category'] = $category;
        $data['libraries'] = LibraryCategory::where('parent_id','=',null)
        ->where('id','!=',$category->id)
        ->orderBy('name')
        ->get(['id','name','parent_id'])
        ->groupBy(function ($item) {
            return strtoupper(substr($item->name, 0, 1));
        })->toJson();

        $data['libraries'] = json_decode($data['libraries']);
        // dd($data);
        return view('admin.library.materials.import',$data);
    }

    public function importFile(LibraryCategory $category, Request $request)
    {
        // dd($category,$request->all());
        $request->validate([
            'library_group' => 'required|string',
            'main_library' => 'required|numeric',
            'sub_library' => 'nullable|numeric',
            'pdf_files' => 'required|array',
        ]);

        $pdf_files = LibraryMaterial::find($request->pdf_files);
        foreach ($pdf_files as $pdf) 
        {
            unset($pdf->id,$pdf->category_id,$pdf->slug,$pdf->created_at,$pdf->updated_at);
            $pdf = $pdf->toArray();
            $category->materials()->create($pdf);
        }

        return redirect('/admin/library/'.$category->id.'/materials');
    }

    private function pdfToImage($pdfPath, $imagePath)
    {
        if(file_exists($pdfPath))
        {
            try 
            {
                if(!file_exists(storage_path('app/public/uploads/library/thumbnails/pdf')))
                {
                    mkdir(storage_path('app/public/uploads/library/thumbnails/pdf'), 0777, true);
                }
                $pdf = new PdfToImage($pdfPath);
                $pdf->setPage(1)
                    ->setResolution(150) // Set quality (default: 300)
                    ->saveImage(storage_path('app/public/'.$imagePath));
                    
                // Apply white background using Imagick
                $imagick = new Imagick(storage_path('app/public/'.$imagePath));
                $imagick->setImageBackgroundColor('#fff');
                $imagick = $imagick->mergeImageLayers(Imagick::LAYERMETHOD_FLATTEN);
                $imagick->writeImage(storage_path('app/public/'.$imagePath));               
                
                return 1;
                
            } 
            catch (\Throwable $th) {
                return 0;
                //throw $th;
            }                                
        } 

        return 0;
    }
    
}
