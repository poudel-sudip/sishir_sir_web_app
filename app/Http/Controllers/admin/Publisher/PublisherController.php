<?php

namespace App\Http\Controllers\admin\Publisher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Publisher;

class PublisherController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $publishers=Publisher::all();
        // dd($publishers);
        return view('admin.publishers.index',compact('publishers'));
    }

    public function create()
    {
        return view('admin.publishers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|string",
            "email" => "required|email|unique:users",
            "contact" => "required|numeric",
            "password" => "required|string",
            "partner_mode" => "required|string",
            "parthership_value" => "required|numeric",
            "description" => "required|string",
            "image" => "image|nullable",
        ]);
        $image='';
        if(isset($request->image))
        {
            $image=request('image')->store('uploads','public');
        }

        $user=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'contact'=>$request->contact,
            'photo'=>$image,
            'role'=>'Publisher',
            'password'=>Hash::make($request->password),
        ]);

        $publisher=Publisher::create([
            'user_id' => $user->id,
            'name' => $user->name,
            'partner_mode' => $request->partner_mode,
            'mode_value' => $request->parthership_value,
            'description' => $request->description,
        ]);

        return redirect('/admin/publishers');
    }

    public function show(Publisher $publisher)
    {
        return view('admin.publishers.show',compact('publisher'));
    }

    public function edit(Publisher $publisher)
    {
        return view('admin.publishers.edit',compact('publisher'));
    }

    public function update(Request $request, Publisher $publisher)
    {
        // dd($request->all(),$publisher);
        $request->validate([
            "name" => "required|string",
            "email" => "required|email",
            "contact" => "required|numeric|min:10",
            "password" => "required|string",
            "old_password" => "required|string",
            "partner_mode" => "required|string|min:1",
            "parthership_value" => "required|numeric",
            "description" => "required|string",
            "oldImage" => "string|nullable",
            "image" =>  "image|nullable",
            "status" => "string|required|min:1",
            // "isPinned" => "string|required",
        ]);
       
        $img=$request->oldImage;
        if(isset($request->image))
        {
            $img=request('image')->store('uploads','public');
        }

        if($request->password == $request->old_password)
        {
            $password = $request->password;
        }
        else
        {
            $password=Hash::make($request->password);
        }

        $publisher->user()->update([
            'name'=>$request->name,
            'photo'=>$img,
            'email'=>$request->email,
            'contact'=>$request->contact,
            'password'=>$password,
            'status' => $request->status,
        ]);

        $publisher->update([
            'name'=>$request->name,
            // 'isPinned' => $request->isPinned,
            'description' => $request->description,
            'partner_mode' => $request->partner_mode,
            'mode_value' => $request->parthership_value,
        ]);
        
        return redirect('/admin/publishers');
    }

    public function destroy(Publisher $publisher)
    {
        $publisher->user()->delete();
        $publisher->delete();
        return redirect('/admin/publishers');
    }

}
