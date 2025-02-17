<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $notifications=auth()->user()->userNotifications()->withPivot('read')->orderByDesc('created_at')->get();
        return view('student.notifications.index',compact('notifications'));
    }

    public function show(Notification $notification)
    {
        auth()->user()->userNotifications()->where('notification_id','=',$notification->id)->update(['read'=>'Yes']);
        return view('student.notifications.show',compact('notification'));
    }


}
