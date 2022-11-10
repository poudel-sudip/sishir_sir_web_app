<?php

namespace App\Http\Controllers\Vendors;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Forms\VendorForm;
use App\Models\Forms\VendorFormApplicant;
use App\Models\Teams\Team;
use App\Models\Teams\TeamAssignVendorForm;

class FormTeamAssignController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(VendorForm $vform)
    {
        $assigns = $vform->assignedTeams;
        // dd($assigns,$vform);
        return view('vendors.vendorforms.teamassign.index',compact('vform','assigns'));
    }

    public function create(VendorForm $vform)
    {
        $vendor = auth()->user()->vendor;
        $teams = Team::where('vendor_id','=',$vendor->id)->get();
        // dd($teams);
        return view('vendors.vendorforms.teamassign.create',compact('vform','teams'));
    }

    public function store(VendorForm $vform, Request $request)
    {
        // dd($request->all(),$vform);
        $request->validate([
            'sub_category' => 'string|nullable',
            'team' => 'numeric|required|min:1',
            'start_id' => 'numeric|required|min:1',
            'end_id' => 'numeric|nullable',
        ]);
        $applicants = null;
        $start_at = $request->start_id;
        $end_at = $request->end_id;
        if(!$end_at)
        {
            $end_at = $start_at;
        }

        if(isset($request->sub_category) && trim($request->sub_category) != '')
        {
            $applicants = $vform->applicants()->whereBetween('id',[$start_at,$end_at])->where('sub_category','=',$request->sub_category)->count();
        }
        else
        {
            $applicants = $vform->applicants()->whereBetween('id',[$start_at,$end_at])->count();
        }

        if(!$applicants)
        {
            return back()->withInput()->withErrors(['sub_category'=>'There are no any Applicants to Assign.']);
        }
      
        // dd($end_at,$applicants);
        TeamAssignVendorForm::create([
            'vendor_id' => auth()->user()->vendor->id ?? '',
            'team_id' => $request->team,
            'form_id' => $vform->id ?? '',
            'sub_category' => $request->sub_category,
            'start_id' => $start_at,
            'end_id' => $end_at,
            'total' => $applicants,
        ]);

        return redirect('/vendor/vendor-dynamic-forms/'.$vform->id.'/team-assign');
    }

    public function destroy(VendorForm $vform, TeamAssignVendorForm $assign)
    {
        // dd($vform,$assign);
        // $followups = TeamFollowupVendorForm::where([
        //     ['form_id','=',$assign->form_id],
        //     ['team_id','=',$assign->team_id]
        // ])->whereBetween('applicant_id',[$assign->start_id,$assign->end_id])->delete();

        $assign->delete();
        return redirect('/vendor/vendor-dynamic-forms/'.$vform->id.'/team-assign');
    }
}
