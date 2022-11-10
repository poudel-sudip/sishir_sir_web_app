<?php

namespace App\Http\Controllers\Teams;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Teams\TeamFollowupRegisteredUser;

class FollowupUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function pendingUserFollowup()
    {
        $team = auth()->user()->team;
        $vendor = $team->vendor;
        if(!$vendor)
        {
            dd('YOU ARE NOT ASSOCIATED WITH VENDOR OR BRANCH. PLEASE CONTACT ADMINISTRATOR.');
        }

        $fusers = $team->followupRegisteredUsers->map(function($user){return $user->user_id;})->toArray();
        $followups = $vendor->myusers()->whereNotIn('user_id',$fusers)->where('team_id','=',$team->id)->get();
        // dd('Followup User pendings',$fusers,$followups);
        return view('teams.followup.pending.registeredusers',compact('followups'));
    }

    public function addPendingUserFollowup(Request $request)
    {
        // dd($request->all());
        $request->validate([
            "user_id" => "numeric|required",
            "user_name" => "string|required",
            "user_contact" => "numeric|required",
            "status" => "string|required|min:1",
            "remarks" => "string|required|min:2",
        ]);
        // $remarks = json_encode(array([
        //     'date' => date('Y-m-d G:i:s'),
        //     'rem' => $request->remarks,
        // ]));
        $remarks = '{"date":"'.date('Y-m-d G:i:s').'", "rem":"'.$request->remarks.'", "status":"'.$request->status.'"}';
        // dd($remarks);
        $remarks = array($remarks);
        $remarks = json_encode($remarks);
        $team = auth()->user()->team;
        $team->followupRegisteredUsers()->create([
            'user_id' => $request->user_id,
            'status' => $request->status,
            'remarks' => $remarks,
        ]);

        return redirect('/team/followup/pending/registered-users');
    }

    public function followedUserFollowup()
    {
        $team = auth()->user()->team;
        $vendor = $team->vendor;
        if(!$vendor)
        {
            dd('YOU ARE NOT ASSOCIATED WITH VENDOR OR BRANCH. PLEASE CONTACT ADMINISTRATOR.');
        }

        $followups = $team->followupRegisteredUsers;
        return view('teams.followup.followed.registeredusers',compact('followups'));
    }

    public function updateFollowedUserFollowup(Request $request)
    {
        $request->validate([
            "follow_id" => "numeric|required",
            "user_id" => "numeric|required",
            "user_name" => "string|required",
            "user_contact" => "numeric|required",
            "status" => "string|required|min:1",
            "remarks" => "string|required|min:2",
        ]);
        $followup = TeamFollowupRegisteredUser::find($request->follow_id);
        $oldrem = json_decode($followup->remarks);
        $remarks = '{"date":"'.date('Y-m-d G:i:s').'", "rem":"'.$request->remarks.'", "status":"'.$request->status.'"}';
        array_push($oldrem,$remarks);
        $newrem = json_encode($oldrem);
        // dd($followup,$oldrem,$remarks,$newrem);
        $followup->update([
            'status' => $request->status,
            'remarks' => $newrem,
        ]);
        return redirect('/team/followup/followed/registered-users');
    }

    public function showFollowedUser(TeamFollowupRegisteredUser $followup)
    {
        // dd($followup);
        return view('teams.followup.followed.showregistereduser',compact('followup'));
    }

}
