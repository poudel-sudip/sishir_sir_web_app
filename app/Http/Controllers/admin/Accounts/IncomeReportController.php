<?php

namespace App\Http\Controllers\admin\Accounts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Batch;
use App\Models\Accounts\AccountIncome;

class IncomeReportController extends Controller
{
    public function index()
    {
        $batches=Batch::all()->sortByDesc('id');
        return view('admin.accounts.reports.income.index',compact('batches'));
    }

    public function courseIncomeReport(Request $request)
    {
        $request->validate(['course'=>'string']);
        $course=$request->course;
        $data=AccountIncome::where('type','=','Course')->where('category','=',$course)->where('deleted','=',false)->get();
        return view('admin.accounts.reports.income.courseIncome',compact('data','course'));
    }

    public function otherIncomeReport()
    {
        $data=AccountIncome::where('type','!=','Course')->where('deleted','=',false)->get();
        return view('admin.accounts.reports.income.otherIncome',compact('data'));
    }

    public function dailyIncomeReport(Request $request)
    {
        $request->validate(['dailydate'=>'date']);
        $start=date('Y-m-d',strtotime($request->dailydate));
        $end=date('Y-m-d',strtotime($request->dailydate .'+ 1 day'));
        $filter=(object)[
            'type'=>'Day',
            'date'=>$start,
        ];
        $data=AccountIncome::where('date','>=',$start)->where('date','<',$end)->where('deleted','=',false)->get();
        return view('admin.accounts.reports.income.datedIncome',compact('data','filter'));
    }

    public function monthlyIncomeReport(Request $request)
    {
        $request->validate(['monthlydate'=>'string']);
        $date=$request->monthlydate.'-01';
        $start=date('Y-m-d',strtotime($date));
        $end=date('Y-m-d',strtotime($date .'+ 1 month'));
        $filter=(object)[
            'type'=>'Month',
            'date'=>$start,
        ];
        $data=AccountIncome::where('date','>=',$start)->where('date','<',$end)->where('deleted','=',false)->get();
        return view('admin.accounts.reports.income.datedIncome',compact('data','filter'));
    }

    public function deletedIncomeReport()
    {
        $data=AccountIncome::where('deleted','=',true)->get();
        return view('admin.accounts.reports.income.deletedIncome',compact('data'));
    }

    public function restoreIncomeReport(AccountIncome $income)
    {
        $income->update(['deleted'=>false]);
        return redirect('/admin/accounts/reports/incomes/deleted');
    }

}
