<?php

namespace App\Http\Controllers\Branches;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BranchHomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function home()
    {
        $branch = auth()->user()->branchProfile;
        if(!$branch)
        {
            $member = auth()->user()->branchMemberProfile;
            if($member)
            {
                $branch = $member->branch;
            }
        }

        if(!$branch)
        {
            abort(403,'Branch and Member Association Error. Please Contact Branch Admin.');
        }
        
        return view('branches.home',compact('branch'));
    }
}
