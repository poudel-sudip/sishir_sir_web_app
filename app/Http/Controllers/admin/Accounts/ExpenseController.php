<?php

namespace App\Http\Controllers\admin\Accounts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Accounts\AccountExpense;
use App\Models\Course;
use App\Models\Batch;
use App\Models\Tutor;
use App\Models\User;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses=AccountExpense::where('deleted','=',false)->get()->sortByDesc('id')->take(100);
        return view('admin.accounts.expenses.expenselist',compact('expenses'));
    }

    public function addTutorSalary()
    {
        $courses=Course::whereIn('status',['Active','Running'])->get(['id','name','slug']);
        return view('admin.accounts.expenses.addTutorSalary',compact('courses'));
    }

    public function addStaffSalary()
    {
        return view('admin.accounts.expenses.addStaffSalary');
    }

    public function addRefund()
    {
        $courses=Course::whereIn('status',['Active','Running'])->get(['id','name','slug']);
        return view('admin.accounts.expenses.addRefund',compact('courses'));
    }


    public function addOtherExpenses()
    {
        $batches=Batch::whereIn('status',['Active','Running'])->get();
        return view('admin.accounts.expenses.addOtherExpenses',compact('batches'));
    }

    public function storeTutorSalary(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'date'=>'date',
            'course_name'=>'required|string',
            'batch_name'=>'numeric|nullable',
            'userid'=>'numeric|nullable',
            'workingTime'=>'string|nullable',
            'amount'=>'numeric',
            'discount'=>'numeric|nullable',
            'fromacc'=>'string',
            'toacc'=>'string',
            'verifiedby'=>'string',
            'remarks'=>'string|nullable',
        ]);

        $batch=Batch::find($request->batch_name);
        $tutor=Tutor::findOrFail($request->userid);

        AccountExpense::create([
            'date'=>$request->date,
            'type'=>'Tutors',
            'category'=>$request->course_name.' '.$batch->name,
            'ledger'=>$tutor->name,
            'associatedID'=>$tutor->user_id,
            'amount'=>$request->amount,
            'discount'=>$request->discount ?? 0,
            'workedTime'=>$request->workingTime,
            'fromAccount'=>$request->fromacc,
            'toAccount'=>$request->toacc,
            'processedBy'=>auth()->user()->name,
            'verifiedBy'=>$request->verifiedby,
            'remarks'=>$request->remarks,
        ]);
        return redirect('/admin/accounts/expenses');
    }


    public function storeStaffSalary(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'date'=>'date',
            'name'=>'required|string',
            'workingTime'=>'string|nullable',
            'amount'=>'numeric',
            'fromacc'=>'string',
            'toacc'=>'string',
            'verifiedby'=>'string',
            'remarks'=>'string|nullable',
        ]);

        AccountExpense::create([
            'date'=>$request->date,
            'type'=>'Staff',
            'category'=>'Salary',
            'ledger'=>$request->name,
            'amount'=>$request->amount,
            'workedTime'=>$request->workingTime,
            'fromAccount'=>$request->fromacc,
            'toAccount'=>$request->toacc,
            'processedBy'=>auth()->user()->name,
            'verifiedBy'=>$request->verifiedby,
            'remarks'=>$request->remarks,
        ]);
        return redirect('/admin/accounts/expenses');
    }


    public function storeRefund(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'date'=>'date',
            'course_name'=>'required|string',
            'batch_name'=>'numeric|nullable',
            'userid'=>'numeric|nullable',
            'amount'=>'numeric',
            'fromacc'=>'string',
            'toacc'=>'string',
            'verifiedby'=>'string',
            'remarks'=>'string|nullable',
        ]);

        $batch=Batch::find($request->batch_name);
        $user=User::findOrFail($request->userid);

        AccountExpense::create([
            'date'=>$request->date,
            'type'=>'Refund',
            'category'=>$request->course_name.' '.$batch->name,
            'ledger'=>$user->name,
            'associatedID'=>$user->id,
            'amount'=>$request->amount,
            'fromAccount'=>$request->fromacc,
            'toAccount'=>$request->toacc,
            'processedBy'=>auth()->user()->name,
            'verifiedBy'=>$request->verifiedby,
            'remarks'=>$request->remarks,
        ]);
        return redirect('/admin/accounts/expenses');
    }

    public function storeOtherExpenses(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'date'=>'date',
            'category'=>'required|string',
            'ledger'=>'required|string',
            'amount'=>'numeric',
            'fromacc'=>'string',
            'toacc'=>'string',
            'verifiedby'=>'string',
            'remarks'=>'string|nullable',
        ]);

        AccountExpense::create([
            'date'=>$request->date,
            'type'=>'Office',
            'category'=>$request->category,
            'ledger'=>$request->ledger,
            'amount'=>$request->amount,
            'fromAccount'=>$request->fromacc,
            'toAccount'=>$request->toacc,
            'processedBy'=>auth()->user()->name,
            'verifiedBy'=>$request->verifiedby,
            'remarks'=>$request->remarks,
        ]);

        return redirect('/admin/accounts/expenses');

    }

    public function destroy(AccountExpense $expense)
    {
        $expense->update(['deleted'=>true]);
        return redirect('/admin/accounts/expenses');
    }

}
