<?php

namespace App\Http\Controllers\messenger;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StudentTutorChat;
use App\Models\Tutor;
use App\Models\User;

class ChatMessengerController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function tutorindex()
    {
        $chats=StudentTutorChat::where('from','=',auth()->user()->id)->orWhere('to','=',auth()->user()->id)->get()->groupBy('from')->sortByDesc('id');
        // dd($chats);
        return view('tutors.messenger.index',compact('chats'));
    }

    public function studentindex()
    {
        $chats=StudentTutorChat::where('from','=',auth()->user()->id)->orWhere('to','=',auth()->user()->id)->get()->groupBy('from')->sortByDesc('id');
        $tutors=Tutor::all();
        // dd($chats);
        return view('student.messenger.index',compact('chats','tutors'));
    }


    public function tutorchat(User $user)
    {
        $me=auth()->user();
        $chats=StudentTutorChat::where([['from','=',$me->id],['to','=',$user->id]])
            ->orWhere([['from','=',$user->id],['to','=',$me->id]])->get();
        // dd($user,$me,$chats);
        return view('tutors.messenger.chat',compact('chats','me','user'));
    }

    public function studentchat(User $user)
    {
        $me=auth()->user();
        $chats=StudentTutorChat::where([['from','=',$me->id],['to','=',$user->id]])
            ->orWhere([['from','=',$user->id],['to','=',$me->id]])->get();
        $tutors=Tutor::all();
        // dd($user,$me,$chats);
        return view('student.messenger.chat',compact('chats','me','user','tutors'));
    }

    public function chatsave(Request $request, User $user)
    {
        // dd($request->all(), $user);
        $request->validate(['message'=>'string|required|min:1']);
        StudentTutorChat::create([
            'from'=>auth()->user()->id,
            'to'=>$user->id,
            'message'=>$request->message,
        ]);

        if(auth()->user()->role=="Tutor")
        {
            return redirect('/tutor/messenger/'.$user->id.'/chat');
        }
        else{
            return redirect('/student/messenger/'.$user->id.'/chat');
        }
    }
}
