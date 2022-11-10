<?php

namespace App\Http\Controllers\admin\Accounts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Accounts\AccountIncome;
use App\Models\Course;
use App\Models\Batch;
use App\Models\User;
class IncomeController extends Controller
{
    public function index()
    {
        $incomes=AccountIncome::where('deleted','=',false)->get()->sortByDesc('id')->take(100);
        return view('admin.accounts.incomes.incomelist',compact('incomes'));
    }

    public function addCourseIncome()
    {
        $courses=Course::whereIn('status',['Active','Running'])->get(['id','name','slug']);
        return view('admin.accounts.incomes.addCourseIncome',compact('courses'));
    }

    public function addOtherIncome()
    {
        $courses=Course::whereIn('status',['Active','Running'])->get(['id','name','slug']);
        return view('admin.accounts.incomes.addOtherIncome',compact('courses'));
    }

    public function storeCourseIncome(Request $request)
    {
        $request->validate([
            'date'=>'date',
            'course_name'=>'required|string',
            'batch_name'=>'numeric|nullable',
            'userid'=>'numeric|nullable',
            'amount'=>'numeric',
            'outof'=>'numeric|nullable',
            'discount'=>'numeric|nullable',
            'fromacc'=>'string',
            'toacc'=>'string',
            'remarks'=>'string|nullable',
        ]);
        $batch=Batch::find($request->batch_name);
        $user=User::findOrFail($request->userid);
        // dd($request->all(),$batch,$user);
        AccountIncome::create([
            'date'=>$request->date,
            'type'=>'Course',
            'category'=>$request->course_name.' '.$batch->name,
            'ledger'=>$user->name,
            'associatedID'=>$user->id,
            'amount'=>$request->amount,
            'outof'=>$request->outof ?? $request->amount ?? 0,
            'discount'=>$request->discount ?? 0,
            'fromAccount'=>$request->fromacc,
            'toAccount'=>$request->toacc,
            'processedBy'=>auth()->user()->name,
            'remarks'=>$request->remarks,
        ]);

        return redirect('/admin/accounts/incomes');
    }

    public function storeOtherIncome(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'date'=>'date',
            'category'=>'required|string',
            'ledger_name'=>'required|string',
            'amount'=>'numeric',
            'discount'=>'numeric|nullable',
            'fromacc'=>'string',
            'toacc'=>'string',
            'remarks'=>'string|nullable',
        ]);

        AccountIncome::create([
            'date'=>$request->date,
            'type'=>'Office',
            'category'=>$request->category,
            'ledger'=>$request->ledger_name,
            'amount'=>$request->amount,
            'outof'=>$request->amount,
            'discount'=>$request->discount,
            'fromAccount'=>$request->fromacc,
            'toAccount'=>$request->toacc,
            'processedBy'=>auth()->user()->name,
            'remarks'=>$request->remarks,
        ]);

        return redirect('/admin/accounts/incomes');
    }

    public function destroy(AccountIncome $income)
    {
        $income->update(['deleted'=>true]);
        return redirect('/admin/accounts/incomes');
    }
}
