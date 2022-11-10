<?php

namespace App\Http\Controllers\admin\tutors;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Batch;
use App\Models\Tutor;
use App\Models\TutorReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class TutorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $tutors=Tutor::all();
        return view('admin.tutors.index',compact('tutors'));
    }

    public function show(Tutor $tutor)
    {
        return view('admin.tutors.show',compact('tutor'));
    }

    public function create()
    {
        Gate::authorize('permission','tutor');
        $batches=Batch::all()->where('status','!=','Closed');
        return view('admin.tutors.create',compact('batches'));
    }

    public function store()
    {
        Gate::authorize('permission','tutor');
        $data=request()->validate([
            'courses' => 'required',
            'name' => 'required | String',
            'qualification' =>'',
            'experience' => '',
            'description' => '',
            'image' => '',
            'email'=>'email | unique:users',
            'contact'=>'integer | min:10',
            'password'=>'required|string|min:4',
        ]);
        $imgpath='';
        if(isset($data['image']))
        {
            $imgpath=request('image')->store('uploads','public');
        }

        $user=User::create([
            'name'=>$data['name'],
            'email'=>$data['email'],
            'contact'=>$data['contact'],
            'photo'=>$imgpath,
            'role'=>'Tutor',
            'password'=>Hash::make($data['password']),
        ]);

        $tutor=Tutor::create([
            'user_id'=>$user->id,
            'name'=>$data['name'],
            'experience'=>$data['experience'],
            'qualification'=>$data['qualification'],
            'description'=>$data['description'],
            'status' => 'Active',
        ]);

        $batches=Batch::find($data['courses']);
        $tutor->batches()->attach($batches);
        return redirect('/admin/tutors');
    }

    public function edit(Tutor $tutor)
    {
        Gate::authorize('permission','tutor');
        $batches=Batch::all()->where('status','!=','Closed');
        return view('admin.tutors.edit',compact('tutor','batches'));
    }

    public function update(Tutor $tutor)
    {
        // dd(request()->all());
        Gate::authorize('permission','tutor');
        $data=request()->validate([
            'courses' => 'required',
            'name' => 'required | String',
            'qualification' =>'',
            'experience' => '',
            'description' => '',
            'oldImage'=>'',
            'image' => '',
            'email'=>'email',
            'contact'=>'integer | min:10',
            'password'=>'required',
            'old_password'=>'',
            'status' =>'string|required|min:1',
        ]);
        $imgpath=$data['oldImage'];

        if(isset($data['image']))
        {
            $imgpath=request('image')->store('uploads','public');
        }

        if($data['password']==$data['old_password'])
        {
            $password=$data['password'];
        }
        else
        {
            $password=Hash::make($data['password']);
        }
        $tutor->user()->update([
            'name'=>$data['name'],
            'photo'=>$imgpath,
            'email'=>$data['email'],
            'contact'=>$data['contact'],
            'password'=>$password,
            'status' => $data['status'],
        ]);

        $tutor->update([
            'name'=>$data['name'],
            'experience'=>$data['experience'],
            'qualification'=>$data['qualification'],
            'description'=>$data['description'],
            'status'=>$data['status'],
            'savecount'=>DB::raw('savecount+1'),
        ]);
        $batches=Batch::find($data['courses']);
        $tutor->batches()->sync($batches);
        return redirect('/admin/tutors');
    }

    public function destroy(Tutor $tutor)
    {
        Gate::authorize('permission','tutor');
        $tutor->batches()->detach();
        $tutor->user()->delete();
        $tutor->videoCourses()->delete();
        $tutor->delete();
        return redirect('/admin/tutors');
    }

    

    public function getReviews(Tutor $tutor)
    {
        return view('admin.tutors.reviews',compact('tutor'));
    }

    public function updateReviews(Tutor $tutor, TutorReview $review,$status)
    {
        Gate::authorize('permission','tutor');
        $review->update(['status'=>$status]);
        $rev=$tutor->reviews()->where('status','Published')->avg('rating') ?? 0;
        $tutor->update(['rating'=>$rev]);
        return redirect('/admin/tutors/'.$tutor->id.'/reviews');
    }

    public function destroyReview(Tutor $tutor, TutorReview $review)
    {
        Gate::authorize('permission','tutor');
        $review->delete();
        return redirect('/admin/tutors/'.$tutor->id.'/reviews');
    }

}
