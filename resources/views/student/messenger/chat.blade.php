@extends('student.layouts.app')
@section('student-title')
Chat With {{ $user->name }}
@endsection
@section('student-title-icon')
    <i class="fas fa-comment"></i>
@endsection

@section('content')
<style>
    @import url("https://fonts.googleapis.com/css?family=Red+Hat+Display:400,500,900&display=swap");
        body,
        html {
            line-height: 1.25em;
            letter-spacing: 0.025em;
        }
        @media (max-width: 767px){
            .student-main-container .student-side-navbar, .student-main-content {
                height: calc( 100vh - 50px) !important;
            }
            .center {
                left: 0 !important;
            }
            .chat{
                width: 100% !important;
                height: 29rem !important;
            }
        *, ::after, ::before {
            box-sizing: border-box;
        }
        .chatroom-section{
            grid-template-columns: 1fr !important;
        }
        .tutor-list{
            display: none !important;
        }
        }
        .chatroom-section{
            display: grid;
            grid-template-columns: 1fr 1fr;
        }
        .tutor-list{
            width: 100%;
            display: block;
        }
        .chatroom-only{
            position: relative;
        }
        .center {
            position: absolute;
            top: 0%;
            left: 0;
            width: 100%;
            /* transform: translate(-50%, -50%); */
        }
        .chat {
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            width: 100%;
            height: 25rem;
            z-index: 2;
            box-sizing: border-box;
            border-radius: 1rem;
            background: #f4f4f4;
            box-shadow: 0 0 8rem 0 rgba(0, 0, 0, 0.1), 0rem 2rem 4rem -3rem rgba(0, 0, 0, 0.5);
        }
        
        .chat .contact.bar {
            flex-basis: 3.5rem;
            flex-shrink: 0;
            margin: 1rem;
            box-sizing: border-box;
        }
        
        .chat .messages {
            /* padding: 1rem; */
            background: #F7F7F7;
            flex-shrink: 2;
            overflow-y: auto;
            box-shadow: inset 0 2rem 2rem -2rem rgba(0, 0, 0, 0.05), inset 0 -2rem 2rem -2rem rgba(0, 0, 0, 0.05);
        }
        .chat .messages::-webkit-scrollbar {
            width: 1px;
        }

        .chat .messages::-webkit-scrollbar-track {
            background: #ffffff;
        }

        .chat .messages::-webkit-scrollbar-thumb {
            background-color: #3490dc;
            border-radius: 20px;
        }
        
        .chat .messages .time {
            font-size: 0.8rem;
            background: #EEE;
            padding: 0.25rem 1rem;
            border-radius: 2rem;
            color: #999;
            width: -webkit-fit-content;
            width: -moz-fit-content;
            width: fit-content;
            margin: 0 auto;
        }
        
        .chat .messages .message {
            box-sizing: border-box;
            padding: 0.5rem 1rem;
            margin: 0 1rem 1rem;
            background: #FFF;
            border-radius: 1.125rem 1.125rem 1.125rem 0;
            min-height: 2.25rem;
            width: -webkit-fit-content;
            width: -moz-fit-content;
            width: fit-content;
            max-width: 66%;
            box-shadow: 0 0 2rem rgba(0, 0, 0, 0.075), 0rem 1rem 1rem -1rem rgba(0, 0, 0, 0.1);
        }
        
        .chat .messages .message.parker {
            margin: 0 1rem 1rem auto;
            border-radius: 1.125rem 1.125rem 0 1.125rem;
            background: #333;
            color: white;
        }
        .chat .user-name-time {
            font-weight: 600;
            color: #3490dc;
            text-align: center;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .chat .user-name-time span {
            font-size: 12px;
            font-weight: 400;
            color: #686c6f;
        }
        .chat .your-message {
            box-sizing: border-box;
            flex-basis: 4rem;
            flex-shrink: 0;
            /* display: flex; */
            align-items: center;
            padding: 0.8rem 0.5rem 0 1.5rem;
            background: #ffffff;
        }
        
        .chat .your-message i {
            font-size: 1.5rem;
            margin-right: 1rem;
            color: #666;
            cursor: pointer;
            transition: color 200ms;
        }
        
        .chat .your-message i:hover {
            color: #333;
        }
        
        .chat .your-message input {
            border: none;
            background-image: none;
            background-color: white;
            padding: 0.5rem;
            /* margin-right: 1rem; */
            border-radius: 1.125rem;
            flex-grow: 2;
            box-shadow: 0 0 1rem rgba(0, 0, 0, 0.1), 0rem 1rem 1rem -1rem rgba(0, 0, 0, 0.2);
            font-family: Red hat Display, sans-serif;
            font-weight: 400;
            letter-spacing: 0.025em;
        }
        
        .chat .your-message input:placeholder {
            color: #999;
        }      
</style>
<div class="student-content-wrapper chatroom-section content-wrapper" oncontextmenu="return false" onselectstart="return false" ondragstart="return false">
    @if (session('status'))
    <span class="alert alert-success" role="alert">
        {{ session('status') }}
    </span>
    @endif
    <div class="tutor-list messanger-section">
        @php($group=[])
        @php(array_push($group,auth()->user()->id))
        {{-- @foreach($chats as $key=>$value)
            @if(!in_array($key,$group))
                <div class="student-messenger-group">
                    <a href="/student/messenger/{{$key}}/chat" class="student-messenger-list">
                    {{$value->first()->from_user->name}}
                    </a>
                </div>
                @php(array_push($group,$key))
            @endif
        @endforeach --}}

        @foreach($tutors as $tutor)
            @if(!in_array($tutor->user_id,$group))
                <div class="student-messenger-section">
                    <img src="/storage/{{$tutor->user->photo ?? ''}}" alt="" width="60">
                    <a href="/student/messenger/{{$tutor->user_id}}/chat" class="student-messenger-list">
                    {{$tutor->user->name ?? ''}} <!-- returns user model data -->
                    </a>
                </div>
                @php(array_push($group,$tutor->user_id))
            @endif
        @endforeach
    </div>
     <div class="chatroom-only">
     <div class="center">
        <div class="chatroom-title">
            <h6>Chat With {{ $user->name }}</h6>
        </div>
        <div class="chat">
            <div class="messages" id="chat">
                @forelse ($chats as $chat)
                    @if($chat->from==$me->id)
                    <div class="user-name-time">
                        <span> {!! date('d-M-y g:ia',strtotime($chat->created_at)) !!}</span>
                    </div>
                    <div class="message parker">
                        {{$chat->message}}
                    </div>
                    @else
                    <div class="user-name-time">
                        <span> {!! date('d-M-y g:ia',strtotime($chat->created_at)) !!}</span>
                    </div>
                    <div class="message stark">
                        {{$chat->message}}
                    </div>
                    @endif
                @empty
                    <p class="text-center">You can start the Chat here!</p> 
                @endforelse
                
            </div>
            <div class="your-message">
                <form method="POST" class="mb-n2" action="/student/messenger/{{$user->id}}/chat" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-10 col-9" style="padding-right:0">
                            <input id="message" type="text" class="form-control @error('message') is-invalid @enderror" name="message" value="{{ old('message') }}" placeholder="type your message" required  autofocus>

                            @error('message')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-1 col-2" style="padding-left: 0">
                            <button type="submit" class="message-send" title="Chat">
                                <i class="fa fa-paper-plane" aria-hidden="true"></i>
                            </button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>

<script>
    var chat = document.getElementById("chat");
    chat.scrollTop = chat.scrollHeight - chat.clientHeight;
</script>

@endsection
