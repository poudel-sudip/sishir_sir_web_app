<?php

namespace App\Http\Controllers\Teams;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FollowupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function pending()
    {
        $team = auth()->user()->team;
        $vendor = $team->vendor;
        if(!$vendor)
        {
            dd('YOU ARE NOT ASSOCIATED WITH VENDOR OR BRANCH. PLEASE CONTACT ADMINISTRATOR.');
        }
        $fusers = $team->followupRegisteredUsers->map(function($user){return $user->user_id;})->toArray();
        $fuserremcount = $vendor->myusers()->whereNotIn('user_id',$fusers)->where('team_id','=',$team->id)->count();
        
        $adminforms = $team->assignedAdminForms->sum('total') - $team->followupAdminForms->count();
        $adminforms = ($adminforms > 0) ? $adminforms : 0;

        $vendorforms = $team->assignedVendorForms->sum('total') - $team->followupVendorForms->count();
        $vendorforms = ($vendorforms > 0) ? $vendorforms : 0;

        $data = (object)[
            'reguser'=>(object)[
                'count'=> $fuserremcount,
                'link' => '/team/followup/pending/registered-users',
            ],
            'adminforms'=>(object)[
                'count'=> $adminforms,
                'link' => '/team/followup/pending/admin-forms',
            ],
            'vendorforms'=>(object)[
                'count'=> $vendorforms,
                'link' => '/team/followup/pending/vendor-forms',
            ],
        ];
        // dd($data);
        return view('teams.followup.pending.index',compact('data'));
    }

    public function followed()
    {
        $team = auth()->user()->team;
        $vendor = $team->vendor;
        if(!$vendor)
        {
            dd('YOU ARE NOT ASSOCIATED WITH VENDOR OR BRANCH. PLEASE CONTACT ADMINISTRATOR.');
        }
        $fusers = $team->followupRegisteredUsers->count();
        $fadminform = $team->followupAdminForms->count();
        $fvendorform = $team->followupVendorForms->count();
        $data = (object)[
            'reguser'=>(object)[
                'count'=> $fusers,
                'link' => '/team/followup/followed/registered-users',
            ],
            'adminforms'=>(object)[
                'count'=> $fadminform,
                'link' => '/team/followup/followed/admin-forms',
            ],
            'vendorforms'=>(object)[
                'count'=> $fvendorform,
                'link' => '/team/followup/followed/vendor-forms',
            ],
        ];
        return view('teams.followup.followed.index',compact('data'));

    }
}
