<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ImageGallery;

class ImageGalleryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data['images']=ImageGallery::orderByDesc('id')->paginate(50);
        return view('admin.img_gallery.index',$data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'image'=>'image|required',
            'caption'=>'string|nullable|max:250',
        ]);

        $img = $request->image->store('uploads/img_gallery','public');
        
        ImageGallery::create([
            'image' => $img,
            'caption' => $request->caption,
        ]);

        return redirect('/admin/image-gallery');

    }

    public function update(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'image_id'=>'numeric|required',
            'image_caption'=>'string|required|max:250',
        ]);

        $img = ImageGallery::find($request->image_id);
        if($img)
        {
            $img->update(['caption' => $request->image_caption]);
        }
        
        

    }

    public function destroy(ImageGallery $img)
    {
        $img->delete();
        return redirect('/admin/image-gallery');

    }
}
