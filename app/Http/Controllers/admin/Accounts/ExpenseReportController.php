<?php

namespace App\Http\Controllers\admin\Accounts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Batch;
use App\Models\Tutor;
use App\Models\Accounts\AccountExpense;

class ExpenseReportController extends Controller
{
    public function index()
    {
        $batches=Batch::all()->sortByDesc('id');
        $tutors=Tutor::all()->sortByDesc('rating');
        return view('admin.accounts.reports.expense.index',compact('batches','tutors'));
    }

    public function tutorExpenseReport(Request $request)
    {
        $request->validate(['tutor'=>'string|required']);
        $tutor=$request->tutor;
        $data=AccountExpense::where('type','=','Tutors')->where('ledger','=',$tutor)->where('deleted','=',false)->get();
        return view('admin.accounts.reports.expense.tutorExpense',compact('data','tutor'));
    }

    public function courseExpenseReport(Request $request)
    {
        $request->validate(['course'=>'string|required']);
        $course=$request->course;
        $data=AccountExpense::where('category','=',$course)->where('deleted','=',false)->get();
        return view('admin.accounts.reports.expense.courseExpense',compact('data','course'));
    }

    public function staffExpenseReport(Request $request)
    {
        $request->validate(['staff'=>'string|required']);
        $staff=$request->staff;
        $data=AccountExpense::where('type','=','Staff')->where('ledger','=',$staff)->where('deleted','=',false)->get();
        return view('admin.accounts.reports.expense.staffExpense',compact('data','staff'));
    }

    public function otherExpenseReport()
    {
        $data=AccountExpense::where('type','=','Office')->where('deleted','=',false)->get();
        return view('admin.accounts.reports.expense.otherExpense',compact('data'));
    }

    public function dailyExpenseReport(Request $request)
    {
        $request->validate(['dailydate'=>'string|required']);
        $date=$request->dailydate;
        $start=date('Y-m-d',strtotime($date));
        $end=date('Y-m-d',strtotime($date .'+ 1 day'));
        $filter=(object)[
            'type'=>'Day',
            'date'=>$start,
        ];
        $data=AccountExpense::where('date','>=',$start)->where('date','<',$end)->where('deleted','=',false)->get();
        return view('admin.accounts.reports.expense.datedExpense',compact('data','filter'));
    }

    public function monthlyExpenseReport(Request $request)
    {
        $request->validate(['monthlydate'=>'string|required']);
        $date=$request->monthlydate.'-01';
        $start=date('Y-m-d',strtotime($date));
        $end=date('Y-m-d',strtotime($date .'+ 1 month'));
        $filter=(object)[
            'type'=>'Month',
            'date'=>$start,
        ];
        $data=AccountExpense::where('date','>=',$start)->where('date','<',$end)->where('deleted','=',false)->get();
        return view('admin.accounts.reports.expense.datedExpense',compact('data','filter'));
    }

    public function deletedExpenseReport()
    {
        $data=AccountExpense::where('deleted','=',true)->get();
        return view('admin.accounts.reports.expense.deletedExpense',compact('data'));
    }

    public function restoreExpenseReport(AccountExpense $expense)
    {
        $expense->update(['deleted'=>false]);
        return redirect('/admin/accounts/reports/expenses/deleted');
    }

}
