<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Batch;
use App\Models\User;
use App\Models\Followup;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Followup\AllFollowupExport;
use App\Exports\Followup\BatchFollowupExport;
use App\Exports\Followup\FollowedFollowupExport;

class FollowupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $batches=Batch::all();
        return view('admin.followup.index',compact('batches'));
    }

    public function edit(Batch $batch,User $user)
    {
        $remarks=$batch->followup()->where('user_id','=',$user->id)->first();
        return view('admin.followup.edit',compact('batch','user','remarks'));
    }

    public function update(Batch $batch,User $user)
    {
        $data=request()->validate([
            'remarks-old'=>'string|nullable',
            'remarks-id'=>'numeric|nullable',
            'remarks'=>'string|required|min:3',
        ]);
        $rem='[ '.Carbon::now()->format('Y/m/d').' : '.$data['remarks'].' : '.auth()->user()->name.' ] <br>';
        $remarks=$data['remarks-old'].$rem;

        $batch->followup()->where('user_id','=',$user->id)->updateOrCreate([
            'id'=>$data['remarks-id'],
        ],[
            'user_id'=>$user->id,
            'remarks'=>$remarks,
        ]);

        return redirect('/admin/batch/'.$batch->id.'/followup/followed');
    }

    public function followupAll(Batch $batch)
    {
        $users=User::where('role','=','Student')->get()
            ->map(function ($user) use($batch) {
                $followup= $user->followup()
                    ->where('batch_id','=',$batch->id)
                    ->first()->remarks ?? '';
                $courses=$user->bookings->map(function ($book) {
                    return $book->batch->course->name ?? '';
                })->toArray();

                $courses=implode(", ",array_unique($courses));
                
                return (object)[
                    'user_id'=>$user->id,
                    'name'=>$user->name,
                    'email'=>$user->email,
                    'contact'=>$user->contact,
                    'interests'=>$user->interests,
                    'courses'=>$courses,
                    'remarks'=>$followup,
                ];
            });
            

        return view ('admin.followup.followupAll',compact('users','batch'));
    }

    public function followupBatch(Batch $batch)
    {
        $c=$batch->course->name;
        $users=User::where('interests','Like','%'.$c.'%')->where('role','=','Student')->get()
            ->map(function ($user) use($batch) {
            $followup= $user->followup()
                ->where('batch_id','=',$batch->id)
                ->first()->remarks ?? '';
            $courses=$user->bookings->map(function ($book) {
                return $book->batch->course->name ?? '';
            })->toArray();

            $courses=implode(", ",array_unique($courses));
            
            return (object)[
                'user_id'=>$user->id,
                'name'=>$user->name,
                'email'=>$user->email,
                'contact'=>$user->contact,
                'interests'=>$user->interests,
                'courses'=>$courses,
                'remarks'=>$followup,
            ];
        });
        
        return view ('admin.followup.followupBatch',compact('users','batch'));
    }

    public function followupFollowed(Batch $batch)
    {
        $users=$batch->followup->map(function ($followup){

            $courses=$followup->user->bookings->map(function ($book) {
                return $book->batch->course->name ?? '';
            })->toArray();

            $courses=implode(", ",array_unique($courses));

            return (object)[
                'user_id'=>$followup->user->id ?? '',
                'name'=>$followup->user->name ?? '',
                'email'=>$followup->user->email ?? '',
                'contact'=>$followup->user->contact ?? '',
                'interests'=>$followup->user->interests ?? '',
                'courses'=>$courses,
                'remarks'=>$followup->remarks,
            ];
        });
              
        return view ('admin.followup.followupFollowed',compact('users','batch'));
    }

    public function downloadFollowupAll(Batch $batch): BinaryFileResponse
    {
        $fileName = $batch->course->slug.'-'.$batch->slug.'-allusers.xlsx';
        return Excel::download(new AllFollowupExport($batch), $fileName);
    }

    public function downloadFollowupBatch(Batch $batch): BinaryFileResponse
    {
        $fileName = $batch->course->slug.'-'.$batch->slug.'-batchusers.xlsx';
        return Excel::download(new BatchFollowupExport($batch), $fileName);
    }

    public function downloadFollowupFollowed(Batch $batch): BinaryFileResponse
    {
        $fileName = $batch->course->slug.'-'.$batch->slug.'-followedusers.xlsx';
        return Excel::download(new FollowedFollowupExport($batch), $fileName);
    }

}
