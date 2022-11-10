<?php

namespace App\Http\Controllers\admin\Provience;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Provience\Provience;
use App\Models\Provience\DistrictCity;

class DistrictCityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Provience $provience)
    {
        $cities = $provience->cities;
        return view('admin.provience.district.citylist',compact('provience','cities'));
    }

    public function create(Provience $provience)
    {
        return view('admin.provience.district.create',compact('provience'));
    }

    public function store(Request $request, Provience $provience)
    {
        $request->validate(["name"=>"string|required"]);
        $provience->cities()->create(["name"=>ucwords($request->name)]);
        return redirect('/admin/provience/'.$provience->id.'/district-city');
    }

    public function destroy(Provience $provience, DistrictCity $city)
    {
        $city->delete();
        return redirect('/admin/provience/'.$provience->id.'/district-city');
    }
}
