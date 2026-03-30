<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;

class SummernoteController extends Controller
{
    public function uploadImage(Request $request)
    {
        $request->validate([
            // 'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image' => 'required|file',
        ]);

        $image = $request->file('image');
        $imageName = time().'.'.$image->extension();
        $imagePath = 'uploads/summernote/'.date('Y/m/d');
        // $image->move(public_path($imagePath), $imageName);
        $turl = $image->storeAs($imagePath,$imageName,'public');

        return response()->json([
            // 'url' => asset($imagePath.'/'.$imageName)
            'url' => Storage::disk('public')->url($turl),
        ]);
    }
} 