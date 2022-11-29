<?php

namespace App\Http\Controllers\Admin\Provience;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Provience\Provience;

class ProvienceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function provienceList()
    {
        $proviences = Provience::all();
        return view('admin.provience.proviencelist',compact('proviences'));
    }

    public function createProvience()
    {
        return view('admin.provience.createprovience');
    }

    public function saveProvience(Request $request)
    {
        $request->validate(["name"=>"string|required"]);
        Provience::create(["name"=>ucwords($request->name)]);
        return redirect('/admin/provience');
    }

    public function destroyProvience(Provience $provience)
    {
        $provience->delete();
        return redirect('/admin/provience');  
    }

    public function editProvience(Provience $provience)
    {
        return view('admin.provience.editprovience',compact('provience'));
    }


    public function updateProvience(Request $request, Provience $provience)
    {
        $request->validate(["name"=>"string|required"]);
        $provience->update(["name"=>ucwords($request->name)]);
        return redirect('/admin/provience');
    }

}
