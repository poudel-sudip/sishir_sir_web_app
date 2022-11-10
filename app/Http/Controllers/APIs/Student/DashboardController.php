<?php

namespace App\Http\Controllers\APIs\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
use App\Models\TutorPost;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    protected $user; 

    public function __construct()
    {
        $this->middleware('auth:api');
        $this->user=$this->guard()->user();
    }

    protected function guard()
    {
        return Auth::guard('api');
    }

    public function dashboard()
    {
        $user=$this->user;

        $totalBookings=$this->user->bookings()->count();
        $approvedBookings=$this->user->bookings()->where('status','=','Verified')->count();

        $data=[
            'course'=>[
                'total'=>$totalBookings,
                'approved'=>$approvedBookings,
                'pending'=>$totalBookings-$approvedBookings,
                'classroom'=>$approvedBookings,
            ],
        ];

        return response()->json([
            'user'=>$user,
            'dashboard'=>$data,
        ], 200);
    }

    public function notifications()
    {
        $notifications=$this->user->userNotifications()->withPivot('read')->get()->map(function($notification){
            return [
                'notification_id' => $notification->id,
                'title' => $notification->title,
                'body' => $notification->message,
                'image' => $notification->image,
                'author' => $notification->author,
                'created_at' => $notification->created_at,
                'updated_at' => $notification->updated_at,
                'group' => $notification-> groups,
                'is_read' => $notification->pivot->read,
            ];
        });
        return response()->json($notifications, 200);
    }

    public function getNotification($id)
    {
        $notification = Notification::find($id);
        if(!$notification)
        {
            return response()->json(['error'=>'Notification Not Found'], 404);
        }

        $this->user->userNotifications()->where('notification_id','=',$notification->id)->update(['read'=>'Yes']);

        return response()->json([
            'notification_id' => $notification->id,
            'title' => $notification->title,
            'body' => $notification->message,
            'image' => $notification->image,
            'author' => $notification->author,
            'created_at' => $notification->created_at,
            'updated_at' => $notification->updated_at,
            'group' => $notification-> groups,
        ], 200);
    }

    public function getNewsFeeds()
    {
        $newsfeeds=TutorPost::all()->where('status','=','Published')->sortByDesc('id')->take(30)->map(function($post){
            return [
                "post_id" => $post->id,
                "title" => $post->title,
                "slug" => $post->slug,
                "author" => $post->tutor->name ?? '',
                "thumbnail" => $post->thumbnail,
                "description" => $post->description,
                "status" => $post->status,
                "created_at" => $post->created_at,
                "updated_at" => $post->updated_at,
                "comments_count" => $post->comments->where('status','=','Published')->count(),
                // "comments" => $post->comments()->where('status','=','Published')->get(['id','post_id','name','email','message','status','created_at']),
            ];
        })->toArray();
        $newsfeeds = array_values($newsfeeds);
        return response()->json($newsfeeds, 200);
    }

    public function getNewsComments($slug)
    {
        $post = TutorPost::where('slug','=',$slug)->first();
        if(!$post)
        {
            return response()->json(["error"=>"Post Not Found"], 404);
        }
        $comments = $post->comments()->where('status','=','Published')->get(['id','post_id','name','email','message','status','created_at']);
        return response()->json([
            "post_id" => $post->id,
            "title" => $post->title,
            "slug" => $post->slug,
            "author" => $post->tutor->name ?? '',
            "thumbnail" => $post->thumbnail,
            "description" => $post->description,
            "status" => $post->status,
            "created_at" => $post->created_at,
            "updated_at" => $post->updated_at,
            "comments_count" => $post->comments->where('status','=','Published')->count(),
            "comments" => $comments,
        ], 200);

    }

    public function postNewsComment($slug, Request $request)
    {
        $post = TutorPost::where('slug','=',$slug)->first();
        if(!$post)
        {
            return response()->json(["error"=>"Post Not Found"], 404);
        }

        $validator=Validator::make($request->all(),[
            'message'=>'string | required',
        ]);
 
        if($validator->fails()){
            return response()->json([$validator->errors()]);
        }

        $post->comments()->create([
            'post_id'=>$post->id,
            'name'=>$this->user->name,
            'email'=>$this->user->email,
            'contact'=>$this->user->contact ?? '',
            'message'=>$request->message,
            'status'=>'Published',
        ]);

        return response()->json(["success"=>true,"message"=>"Comment Added Successfully."], 200);
    }

    public function messengerGroups()
    {
        $groups = $this->user->bookings()->where('status','=','Verified')->where('suspended','=',false)->orderBy('id','DESC')->get()->map(function($booking){
            
            return (object)[
                'image' => $booking->course->image ?? '',
                'course' => $booking->course->name ?? '',
                'batch' => $booking->batch->name ?? '',
                'chat_url' => url('api/v1/my/course/classroom/'.($booking->batch->id ?? '').'/chat'),
            ];
        });

        return response()->json($groups, 200);
    }
}
