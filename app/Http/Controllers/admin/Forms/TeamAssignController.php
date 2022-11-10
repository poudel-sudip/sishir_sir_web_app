<?php

namespace App\Http\Controllers\admin\Forms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Forms\DynamicFormCategory;
use App\Models\Forms\FormApplicant;
use App\Models\Teams\TeamAssignAdminForm;
use App\Models\Teams\TeamFollowupAdminForm;
use App\Models\Teams\Team;

class TeamAssignController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(DynamicFormCategory $category)
    {
        $assigns = $category->assignedTeams;
        // dd($assigns);
        return view('admin.dynamicforms.teamassign.index',compact('category','assigns'));
    }

    public function create(DynamicFormCategory $category)
    {
        $teams = Team::all();
        return view('admin.dynamicforms.teamassign.create',compact('category','teams'));
    }

    public function store(DynamicFormCategory $category, Request $request)
    {
        // dd($request->all(),$category);
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
            $applicants = $category->applicants()->whereBetween('id',[$start_at,$end_at])->where('sub_category','=',$request->sub_category)->count();
        }
        else
        {
            $applicants = $category->applicants()->whereBetween('id',[$start_at,$end_at])->count();
        }

        if(!$applicants)
        {
            return back()->withInput()->withErrors(['sub_category'=>'There are no any Applicants to Assign.']);
        }
      
        // dd($end_at,$applicants,$category->form);
        TeamAssignAdminForm::create([
            'team_id' => $request->team,
            'category_id' => $category->id,
            'form_id' => $category->form->id ?? '',
            'sub_category' => $request->sub_category,
            'start_id' => $start_at,
            'end_id' => $end_at,
            'total' => $applicants,
        ]);

        return redirect('/admin/dynamic-forms/categories/'.$category->id.'/team-assign');
    }

    public function destroy(DynamicFormCategory $category, TeamAssignAdminForm $assign)
    {
        // dd($category,$assign);
        $followups = TeamFollowupAdminForm::where([
            ['category_id','=',$assign->category_id],
            ['team_id','=',$assign->team_id]
        ])->whereBetween('applicant_id',[$assign->start_id,$assign->end_id])->delete();

        $assign->delete();
        return redirect('/admin/dynamic-forms/categories/'.$category->id.'/team-assign');
    }
}
