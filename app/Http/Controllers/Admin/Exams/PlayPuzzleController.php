<?php

namespace App\Http\Controllers\Admin\Exams;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exams\PlayPuzzle;

class PlayPuzzleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function indexTextPuzzle(Request $request)
    {
        $data['questions'] = PlayPuzzle::where('type','=','text')->orderByDesc('id')->paginate(100);
        return view('admin.exams.text-puzzle.index',$data);
    }

    public function createTextPuzzle(Request $request)
    {
        return view('admin.exams.text-puzzle.create',$data=[]);
    }

    public function storeTextPuzzle(Request $request)
    {
        $request->validate([
            'question'=>'required|string|min:5',
            'answer'=>'required|string',
            'rationale'=>'string|nullable',
        ]);

        
        PlayPuzzle::create([
            'question'=>$request->question,
            'answer'=>$request->answer,
            'type'=>'text',
            'rationale'=>$request->rationale,
        ]);

        return redirect('/admin/play-puzzle/text')->with('success','Data Saved Successfully');
    }

    public function showTextPuzzle(PlayPuzzle $question)
    {
        $data['question'] = $question;
        return view('admin.exams.text-puzzle.show',$data);
    }

    public function editTextPuzzle(PlayPuzzle $question)
    {
        $data['question'] = $question;
        return view('admin.exams.text-puzzle.edit',$data);
    }

    public function updateTextPuzzle(Request $request, PlayPuzzle $question)
    {
        $request->validate([
            'question'=>'required|string|min:5',
            'answer'=>'required|string',
            'rationale'=>'string|nullable',
        ]);

        $question->update([
            'question'=>$request->question,
            'answer'=>$request->answer,
            'rationale'=>$request->rationale,
        ]);

        return redirect('/admin/play-puzzle/text')->with('success','Data Updated Successfully');
    }

    public function destroyTextPuzzle(Request $request, PlayPuzzle $question)
    {
        $question->delete();

        return redirect('/admin/play-puzzle/text')->with('success','Data Deleted Successfully');
    }

    public function indexImagePuzzle(Request $request)
    {
        $data['questions'] = PlayPuzzle::where('type','=','image')->orderByDesc('id')->paginate(100);
        return view('admin.exams.image-puzzle.index',$data);
    }

    public function createImagePuzzle(Request $request)
    {
        return view('admin.exams.image-puzzle.create',$data=[]);
    }

    public function storeImagePuzzle(Request $request)
    {
        $request->validate([
            'question'=>'image|required',
            'answer'=>'required|string',
            'rationale'=>'string|nullable',
        ]);

        $image = $request->file('question')->store('uploads/play-puzzles','public');
        
        PlayPuzzle::create([
            'question'=>$image,
            'answer'=>$request->answer,
            'type'=>'image',
            'rationale'=>$request->rationale,
        ]);

        return redirect('/admin/play-puzzle/image')->with('success','Data Saved Successfully');
    }

    public function showImagePuzzle(PlayPuzzle $question)
    {
        $data['question'] = $question;
        return view('admin.exams.image-puzzle.show',$data);
    }

    public function editImagePuzzle(PlayPuzzle $question)
    {
        $data['question'] = $question;
        return view('admin.exams.image-puzzle.edit',$data);
    }

    public function updateImagePuzzle(Request $request, PlayPuzzle $question)
    {
        $request->validate([
            'question'=>'image|nullable',
            'answer'=>'required|string',
            'rationale'=>'string|nullable',
        ]);

        $image = $request->file('question');
        if($image){
            $image = $image->store('uploads/play-puzzles','public');
        }
        else{
            $image = $question->question;
        }

        $question->update([
            'question'=>$image,
            'answer'=>$request->answer,
            'rationale'=>$request->rationale,
        ]);

        return redirect('/admin/play-puzzle/image')->with('success','Data Updated Successfully');
    }

    public function destroyImagePuzzle(Request $request, PlayPuzzle $question)
    {
        $question->delete();

        return redirect('/admin/play-puzzle/image')->with('success','Data Deleted Successfully');
    }
}
