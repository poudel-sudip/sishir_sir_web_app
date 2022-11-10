<?php

namespace App\Http\Controllers\Teams;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Forms\FormApplicant;
use App\Models\Teams\TeamAssignAdminForm;
use App\Models\Teams\TeamFollowupAdminForm;

class FollowupAdminFormController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function pendingFollowupList()
    {
        $team = auth()->user()->team;
        $followups = $team->assignedAdminForms;
        // dd('Followup Admin Form pendings',$followups);
        return view('teams.followup.pending.adminforms',compact('followups'));
    }

    public function pendingFollowupApplicantList($assignId)
    {
        $assign = TeamAssignAdminForm::find($assignId);
        if(!$assign)
        {
            abort(404);
        }

        if(!$assign->category)
        {
            abort(404);
        }

        $team = auth()->user()->team;
        $fusers = $team->followupAdminForms->where('category_id','=',$assign->category_id)->map(function($user){return $user->applicant_id;})->toArray();
        if(trim($assign->sub_category) !='')
        {
            $followups = $assign->category->applicants()->whereBetween('id',[$assign->start_id,$assign->end_id])->where('sub_category','=',trim($assign->sub_category))->whereNotIn('id',$fusers)->get();
        }
        else
        {
            $followups = $assign->category->applicants()->whereBetween('id',[$assign->start_id,$assign->end_id])->whereNotIn('id',$fusers)->get();
        }

        // dd($fusers,$followups);
        return view('teams.followup.pending.adminformapplicants',compact('followups','assign'));
    }

    public function addPendingFollowupApplicant($assignId, Request $request)
    {
        $assign = TeamAssignAdminForm::find($assignId);
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
        $team->followupAdminForms()->create([
            'applicant_id' => $request->user_id,
            'category_id' => $assign->category_id,
            'status' => $request->status,
            'remarks' => $remarks,
        ]);

        FormApplicant::where('id','=',$request->user_id)->update([
            'remarks' => ucwords($request->remarks),
            'uploaded_by' => ucwords(auth()->user()->name),
        ]);

        return redirect('/team/followup/pending/admin-forms/'.$assign->id.'/applicants');
    }

    public function followedFollowupList()
    {
        $team = auth()->user()->team;
        $followups = $team->assignedAdminForms;
        return view('teams.followup.followed.adminforms',compact('followups'));
    }

    public function followedFollowupApplicantList($assignId)
    {
        $assign = TeamAssignAdminForm::find($assignId);
        if(!$assign)
        {
            abort(404);
        }

        if(!$assign->category)
        {
            abort(404);
        }

        $team = auth()->user()->team;
        $followups = $team->followupAdminForms()->where('category_id','=',$assign->category_id)->whereBetween('applicant_id',[$assign->start_id,$assign->end_id])->get();

        // dd($followups);
        return view('teams.followup.followed.adminformapplicants',compact('followups','assign'));
    }

    public function updateFollowedApplicant($assignId, Request $request)
    {
        $assign = TeamAssignAdminForm::find($assignId);
        if(!$assign)
        {
            abort(404);
        }

        if(!$assign->category)
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

        $followup = TeamFollowupAdminForm::find($request->follow_id);
        $oldrem = json_decode($followup->remarks);
        $remarks = '{"date":"'.date('Y-m-d G:i:s').'", "rem":"'.$request->remarks.'", "status":"'.$request->status.'"}';

        array_push($oldrem,$remarks);
        $newrem = json_encode($oldrem);

        $followup->update([
            'status' => $request->status,
            'remarks' => $newrem,
        ]);

        FormApplicant::where('id','=',$request->user_id)->update([
            'name' => $request->user_name,
            'contact' => $request->user_contact,
            'remarks' => ucwords($request->remarks),
            'uploaded_by' => ucwords(auth()->user()->name),
        ]);

        // dd($request->all(), $assign,$followup);
        return redirect('/team/followup/followed/admin-forms/'.$assign->id.'/applicants');
    }

    public function showFollowedApplicant($assignId, TeamFollowupAdminForm $followup)
    {
        $assign = TeamAssignAdminForm::find($assignId);
        if(!$assign)
        {
            abort(404);
        }

        if(!$assign->category)
        {
            abort(404);
        }
        // dd($followup,$assign);
        return view('teams.followup.followed.showadminformapplicant',compact('followup','assign'));
    }

}
