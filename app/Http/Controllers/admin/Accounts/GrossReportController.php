<?php

namespace App\Http\Controllers\admin\Accounts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Batch;
use App\Models\Accounts\AccountIncome;
use App\Models\Accounts\AccountExpense;

class GrossReportController extends Controller
{
    public function index()
    {
        $batches=Batch::all()->sortByDesc('id');
        return view('admin.accounts.reports.gross.index',compact('batches'));
    }

    public function courseReport(Request $request)
    {
        $request->validate(['course'=>'string']);
        $course=$request->course;
        $incomes=AccountIncome::where('type','=','Course')->where('category','=',$course)->where('deleted','=',false)->get();
        $expenses=AccountExpense::where('category','=',$course)->where('deleted','=',false)->get();

        return view('admin.accounts.reports.gross.courseReport',compact('course','incomes','expenses'));
    }

    public function dailyReport(Request $request)
    {
        $request->validate(['dailydate'=>'date']);
        $start=date('Y-m-d',strtotime($request->dailydate));
        $end=date('Y-m-d',strtotime($request->dailydate .'+ 1 day'));
        $incomes=AccountIncome::where('date','>=',$start)->where('date','<',$end)->where('deleted','=',false)->get();
        $expenses=AccountExpense::where('date','>=',$start)->where('date','<',$end)->where('deleted','=',false)->get();

        return view('admin.accounts.reports.gross.dailyReport',compact('start','incomes','expenses'));
    }

    public function monthlyReport(Request $request)
    {
        $request->validate(['monthlydate'=>'string|required']);
        $date=$request->monthlydate.'-01';
        $start=date('Y-m-d',strtotime($date));
        $end=date('Y-m-d',strtotime($date .'+ 1 month'));
        $expenses=AccountExpense::where('date','>=',$start)->where('date','<',$end)->where('deleted','=',false)->get();
        $incomes=AccountIncome::where('date','>=',$start)->where('date','<',$end)->where('deleted','=',false)->get();

        return view('admin.accounts.reports.gross.monthlyReport',compact('start','incomes','expenses'));
    }

    public function yearlyReport(Request $request)
    {
        $request->validate(['yearlydate'=>'string|required']);
        $date=$request->yearlydate.'-01-01';
        $start=date('Y-m-d',strtotime($date));
        $end=date('Y-m-d',strtotime($date .'+ 1 year'));
        $incomes=AccountIncome::where('date','>=',$start)->where('date','<',$end)->where('deleted','=',false)->get()->groupBy('category');
        $expenses=AccountExpense::where('date','>=',$start)->where('date','<',$end)->where('deleted','=',false)->get()->groupBy('category');
        $incomedata=[];
        $expensedata=[];
        foreach($incomes as $i=>$val)
        {
            $incomedata[] =(object)[
                'category'=>$i,
                'amount'=>$val->sum('amount')
            ];
        }

        foreach($expenses as $i=>$val)
        {
            $expensedata[] =(object)[
                'category'=>$i,
                'amount'=>$val->sum('amount')
            ];
        }
        
        return view('admin.accounts.reports.gross.yearlyReport',compact('start','incomedata','expensedata'));
    }

}
