@extends($header)
@section('student-title')
    Classroom  Chat
@endsection

@section('student-title-icon')
    <i class="fab fa-rocketchat"></i>
@endsection

@section('content')
<style>
    @import url("https://fonts.googleapis.com/css?family=Red+Hat+Display:400,500,900&display=swap");
        body,
        html {
            font-family: Red hat Display, sans-serif;
            font-weight: 400;
            line-height: 1.25em;
            letter-spacing: 0.025em;
            color: #333;
            background: #F7F7F7;
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
        }
        .chatroom-only{
            position: relative;
        }
        .center {
            position: absolute;
            top: 50%;
            left: calc(5% + 5rem);
            /* transform: translate(-50%, -50%); */
        }
        .chat {
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            width: 100%;
            height: 21rem;
            z-index: 2;
            box-sizing: border-box;
            border-radius: 1rem;
            background: white;
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
            display: flex;
            align-items: center;
            padding: 0 0.5rem 0 1.5rem;
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
    <div class="row">
        <div class="col-md-12 text-center">
            <h6>{{$batch->name}} @if($batch->timeSlot) <span>({{ $batch->timeSlot ?? ''}})</span> @endif </h6>
        </div>
        <div class="col-md-12 text-center" oncontextmenu="return false" onselectstart="return false" ondragstart="return false">
            <div class="chatroom-header">
                <a href="/classroom/chat/{{$batch->id}}" class="nav-link active">Chat</a>
                <a href="/classroom/files/{{$batch->id}}" class="nav-link">Files</a>
                <a href="/classroom/videos/{{$batch->id}}" class="nav-link">Videos</a>
                <a href="/classroom/cqcs/{{$batch->id}}" class="nav-link">CQC</a>
                @if(auth()->user()->role == 'Student')
                <a href="/student/classroom/exams/{{$batch->id}}" class="nav-link">Exams</a>
                @endif

                @if($batch->status=='Running' && $batch->classroomLink!='' )
                    <a href="{{$batch->classroomLink}}" target="_blank" class="nav-link" title="Zoin Class" oncontextmenu="return false"><i class="fa fa-video-camera" aria-hidden="true"></i> Join</a>
                @endif

            </div>
        </div>
    </div>
    <div class="row justify-content-center">
       
        <div class="col-md-12">
            <div  class="chatroom-only">
            <div class="center">
                <div class="chatroom-title">
                    <h6>Chat</h6>
                </div>
                <div class="chat">
                    <div class="messages" id="chat">
                        @forelse ($batch->classDiscussions as $discussion)
                            @if(auth()->user()->role=='Admin' || $discussion->to=='Everyone' || auth()->user()->name== $discussion->to || auth()->user()->name== $discussion->from )
                                @if(($discussion->from==auth()->user()->name) || (auth()->user()->role=='Admin' && $discussion->from=='Admin') )
                                <div class="user-name-time">
                                    <span> {{$discussion->from}} to {{$discussion->to}} on {!! date('d-M-y g:ia',strtotime($discussion->created_at)) !!}</span>
                                </div>
                                <div class="message parker">
                                    {{$discussion->message}}
                                </div>
                                @else
                                <div class="user-name-time">
                                    <span>{{$discussion->from}} to {{$discussion->to}} on {!! date('d-M-y g:ia',strtotime($discussion->created_at)) !!}</span>
                                </div>
                                <div class="message stark">
                                    {{$discussion->message}}
                                </div>
                                @endif
                            @endif
                        @empty
                            <p class="text-center">You can start the discussion here!</p> 
                        @endforelse
                        
                    </div>
                    <div class="your-message">
                        <form method="POST" class="mb-n2" action="/classroom/chat/{{$batch->id}}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-3 col-3" style="padding-left: 0;padding-right:0">
                                    <select id="to" name="to" class="@error('message') is-invalid @enderror">
                                        <option value="Everyone">Everyone</option>
                                        @if(auth()->user()->role!='Admin')
                                            <option value="Admin">Admin</option>
                                        @endif
                                        
                                        @foreach($students as $std)
                                            @if(auth()->user()->name!=$std->name)
                                                <option value="{{$std->name}}">{{$std->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @error('to')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-8 col-7" style="padding-right:0">
                                    <input id="message" type="text" class="form-control @error('message') is-invalid @enderror" name="message" value="{{ old('message') }}" placeholder="type your message" required  autofocus>
    
                                    @error('message')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-1 col-2" style="padding-left: 0">
                                    <button type="submit" class="message-send" title="Chat with Everyone">
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
           

    </div>
</div>
<script>
    var chat = document.getElementById("chat");
    chat.scrollTop = chat.scrollHeight - chat.clientHeight;
</script>
@endsection
