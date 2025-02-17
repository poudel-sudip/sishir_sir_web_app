<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Booking;
use App\Models\Notification;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Mockery\Matcher\Not;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $notifications=Notification::orderBy('created_at','DESC')->get();
        return view('admin.notifications.index',compact('notifications'));
    }

    public function create()
    {
        $batches=Batch::all()->sortBy('created_at');
        return view('admin.notifications.create',compact('batches'));
    }

    public function store(Request $request)
    {
        $data=$request->validate([
            'group'=>'',
            'allusers'=>'',
            'title'=>'required | string',
            'description'=>'required | string',
            'image' => 'image | nullable',
        ]);

        $batchids=[];
        $batchgroups=[];
        $userids=[];
        $batchesIdString='';
        $batchesGroupString='';
        if(isset($data['allusers']) || isset($data['group']))
        {
            if(isset($data['allusers']))
            {
                $batchesIdString="All Users";
                $batchesGroupString="All Users";
                $users=User::all();
                foreach ($users as $user)
                {
                    $userids[] = $user->id;
                }
            }
            else
            {
                $groups=$data['group'];
                foreach ($groups as $group)
                {
                    $result = json_decode($group);
                    $batchids[] = $result->id;
                    $batchgroups[] = $result->batch;
                }
                // $bookings=Booking::whereIn('batch_id',$batchids)->where('status','Verified')->get();  // get only booking verified users of given batch
                $bookings=Booking::whereIn('batch_id',$batchids)->get();  //get all booking users of given batch

                foreach ($bookings as $book)
                {
                    if(in_array($book->user_id,$userids))
                    {
                        continue;
                    }
                    $userids[] = $book->user_id;
                }
                $batchesIdString=implode(',',$batchids);
                $batchesGroupString=implode(' , ',$batchgroups);

            }
        }
        else{
            $request->validate(['group'=>'required | min:1']);
        }

        $image = null;
        if(isset($data['image']))
        {
            $image = $data['image']->store('uploads','public');
        }

        $notification=Notification::create([
            'groups'=>$batchesGroupString,
            'groups_id'=>$batchesIdString,
            'title'=>$data['title'],
            'message'=>$data['description'],
            'image' => $image,
            'author'=>auth()->user()->name,
        ]);

        $notification->users()->attach($userids,['read'=>'No']);
        return redirect('/admin/notifications');

    }

    public function show(Notification $notification)
    {
        return view('admin.notifications.show',compact('notification'));
    }

    public function edit(Notification $notification)
    {
        $batches=Batch::all()->sortBy('created_at');
        return view('admin.notifications.edit',compact('notification','batches'));
    }

    public function update(Notification $notification)
    {
        $data=request()->validate([
            'group'=>'',
            'allusers'=>'',
            'title'=>'required | string',
            'description'=>'required | string',
            'old_image' => 'string | nullable',
            'image' => 'image | nullable',
        ]);

        $batchids=[];
        $batchgroups=[];
        $userids=[];
        $batchesIdString='';
        $batchesGroupString='';

        if(isset($data['allusers']) || isset($data['group']))
        {
            if(isset($data['allusers']))
            {
                $batchesIdString="All Users";
                $batchesGroupString="All Users";
                $users=User::all();
                foreach ($users as $user)
                {
                    $userids[] = $user->id;
                }
            }
            else
            {
                $groups=$data['group'];
                foreach ($groups as $group)
                {
                    $result = json_decode($group);
                    $batchids[] = $result->id;
                    $batchgroups[] = $result->batch;
                }
                // $bookings=Booking::whereIn('batch_id',$batchids)->where('status','Verified')->get();  // get only booking verified users of given batch
                $bookings=Booking::whereIn('batch_id',$batchids)->get();  //get all booking users of given batch

                foreach ($bookings as $book)
                {
                    if(in_array($book->user_id,$userids))
                    {
                        continue;
                    }
                    $userids[] = $book->user_id;
                }
                $batchesIdString=implode(',',$batchids);
                $batchesGroupString=implode(' , ',$batchgroups);

            }
        }
        else{
            request()->validate(['group'=>'required | min:1']);
        }

        $image = $data['old_image'];
        if(isset($data['image']))
        {
            $image = $data['image']->store('uploads','public');
        }

        $notification->update([
            'groups'=>$batchesGroupString,
            'groups_id'=>$batchesIdString,
            'title'=>$data['title'],
            'message'=>$data['description'],
            'image' => $image,
        ]);

        $notification->users()->sync($userids,['read'=>'No']);
        return redirect('/admin/notifications');
    }

    public function destroy(Notification $notification)
    {
        $notification->users()->detach();
        $notification->delete();
        return redirect('/admin/notifications');
    }
}
