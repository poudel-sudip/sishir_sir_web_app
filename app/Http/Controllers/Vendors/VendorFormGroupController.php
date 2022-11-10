<?php

namespace App\Http\Controllers\Vendors;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Forms\VendorFormGroup;

class VendorFormGroupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $vendor = auth()->user()->vendor;
        $groups = $vendor->formGroups;
        // dd($groups);
        return view('vendors.vendorforms.group.index',compact('groups'));
    }

    public function store(Request $request)
    {
        $vendor = auth()->user()->vendor;
        $request->validate(['group'=> 'string|required|min:2']);
        $vendor->formGroups()->create(['name'=>ucwords($request->group)]);
        return redirect('/vendor/vendor-dynamic-forms/groups');
    }

    public function update(Request $request)
    {
        $request->validate([
            'group_id' => 'numeric|required|min:1',
            'group_name' => 'string|required',
        ]);
        VendorFormGroup::find($request->group_id)->update(['name'=>$request->group_name]);
        return redirect('/vendor/vendor-dynamic-forms/groups');
    }

    public function destroy(VendorFormGroup $group)
    {
        $group->delete();
        return redirect('/vendor/vendor-dynamic-forms/groups');
    }

    public function forms(VendorFormGroup $group)
    {
        $forms = $group->forms;
        return view('vendors.vendorforms.group.forms',compact('group','forms'));
    }
}
