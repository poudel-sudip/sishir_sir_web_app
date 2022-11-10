<?php

namespace App\Http\Controllers\Teams;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Forms\VendorFormApplicant;
use App\Models\Teams\TeamAssignVendorForm;
use App\Models\Teams\TeamFollowupVendorForm;

class FollowupVendorFormController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function pendingFollowupList()
    {
        $team = auth()->user()->team;
        $followups = $team->assignedVendorForms;
        // dd('Followup Vendor Form pendings',$followups);
        return view('teams.followup.pending.vendorforms',compact('followups'));
    }

    public function pendingFollowupApplicantList($assignId)
    {
        $assign = TeamAssignVendorForm::find($assignId);
        if(!$assign)
        {
            abort(404);
        }

        if(!$assign->form)
        {
            abort(404);
        }

        $team = auth()->user()->team;
        $fusers = $team->followupVendorForms->where('form_id','=',$assign->form_id)->map(function($user){return $user->applicant_id;})->toArray();
        if(trim($assign->sub_category) !='')
        {
            $followups = $assign->form->applicants()->whereBetween('id',[$assign->start_id,$assign->end_id])->where('sub_category','=',trim($assign->sub_category))->whereNotIn('id',$fusers)->get();
        }
        else
        {
            $followups = $assign->form->applicants()->whereBetween('id',[$assign->start_id,$assign->end_id])->whereNotIn('id',$fusers)->get();
        }

        // dd($fusers,$followups);
        return view('teams.followup.pending.vendorformapplicants',compact('followups','assign'));
    }

    public function addPendingFollowupApplicant($assignId, Request $request)
    {
        $assign = TeamAssignVendorForm::find($assignId);
        if(!$assign)
        {
            abort(404);
        }

        // dd($request->all(),$assign);

        $request->validate([
            "user_id" => "numeric|required",
            "user_name" => "string|required",
            "user_contact" => "numeric|required",
            "status" => "string|required|min:1",
            "remarks" => "string|required|min:2",
        ]);

        $remarks = '{"date":"'.date('Y-m-d G:i:s').'", "rem":"'.$request->remarks.'", "status":"'.$request->status.'"}';

        $remarks = array($remarks);
        $remarks = json_encode($remarks);
        $team = auth()->user()->team;
        $team->followupVendorForms()->create([
            'applicant_id' => $request->user_id,
            'form_id' => $assign->form_id,
            'vendor_id' => $team->vendor_id,
            'status' => $request->status,
            'remarks' => $remarks,
        ]);

        VendorFormApplicant::where('id','=',$request->user_id)->update([
            'remarks' => ucwords($request->remarks),
            'uploaded_by' => ucwords(auth()->user()->name),
        ]);

        return redirect('/team/followup/pending/vendor-forms/'.$assign->id.'/applicants');
    }

    public function followedFollowupList()
    {
        $team = auth()->user()->team;
        $followups = $team->assignedVendorForms;
        return view('teams.followup.followed.vendorforms',compact('followups'));
    }

    public function followedFollowupApplicantList($assignId)
    {
        $assign = TeamAssignVendorForm::find($assignId);
        if(!$assign)
        {
            abort(404);
        }

        if(!$assign->form)
        {
            abort(404);
        }

        $team = auth()->user()->team;
        $followups = $team->followupVendorForms()->where('form_id','=',$assign->form_id)->whereBetween('applicant_id',[$assign->start_id,$assign->end_id])->get();

        // dd($followups);
        return view('teams.followup.followed.vendorformapplicants',compact('followups','assign'));
    }

    public function updateFollowedApplicant($assignId, Request $request)
    {
        $assign = TeamAssignVendorForm::find($assignId);
        if(!$assign)
        {
            abort(404);
        }

        if(!$assign->form)
        {
            abort(404);
        }
        $team = auth()->user()->team;

        $request->validate([
            "follow_id" => "numeric|required",
            "user_id" => "numeric|required",
            "user_name" => "string|required",
            "user_contact" => "numeric|required",
            "status" => "string|required|min:1",
            "remarks" => "string|required|min:2",
        ]);

        $followup = TeamFollowupVendorForm::find($request->follow_id);
        $oldrem = json_decode($followup->remarks);
        $remarks = '{"date":"'.date('Y-m-d G:i:s').'", "rem":"'.$request->remarks.'", "status":"'.$request->status.'"}';

        array_push($oldrem,$remarks);
        $newrem = json_encode($oldrem);

        $followup->update([
            'status' => $request->status,
            'remarks' => $newrem,
        ]);

        VendorFormApplicant::where('id','=',$request->user_id)->update([
            'name' => $request->user_name,
            'contact' => $request->user_contact,
            'remarks' => ucwords($request->remarks),
            'uploaded_by' => ucwords(auth()->user()->name),
        ]);

        // dd($request->all(), $assign,$followup);
        return redirect('/team/followup/followed/vendor-forms/'.$assign->id.'/applicants');
    }

    public function showFollowedApplicant($assignId, TeamFollowupVendorForm $followup)
    {
        $assign = TeamAssignVendorForm::find($assignId);
        if(!$assign)
        {
            abort(404);
        }

        if(!$assign->form)
        {
            abort(404);
        }
        // dd($followup,$assign);
        return view('teams.followup.followed.showvendorformapplicant',compact('followup','assign'));
    }

}
