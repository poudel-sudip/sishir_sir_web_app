@extends($header)
@section('student-title')
    Classroom  Chat
@endsection

@section('content')
<div class=" chatroom-section content-wrapper" oncontextmenu="return false" onselectstart="return false" ondragstart="return false">
    @if (session('status'))
    <span class="alert alert-success" role="alert">
        {{ session('status') }}
    </span>
    @endif
    <div class="row">
        <div class="col-md-12 text-center">
            <h5>{{$course->course}} <span>(Time: {{$course->timeSlot}})</span> </h5>
        </div>
        <div class="col-md-12 text-center" oncontextmenu="return false" onselectstart="return false" ondragstart="return false">
            <div class="chatroom-header">
                <a href="/special-course/classroom/chat/{{$course->id}}" class="nav-link active">Chat</a>
                <a href="/special-course/classroom/files/{{$course->id}}" class="nav-link">Files</a>
                <a href="/special-course/classroom/videos/{{$course->id}}" class="nav-link">Videos</a>
                <!-- <a href="/special-course/classroom/assignments/{{$course->id}}" class="nav-link">Assignments</a> -->
                @if($course->status=='Active' && $course->classroomLink!='')
                    <a href="{{$course->classroomLink}}" target="_blank" class="nav-link" title="Zoin Class" oncontextmenu="return false"><i class="fa fa-video-camera" aria-hidden="true"></i> Join</a>
                @endif

                

            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="chatroom-title">
                <h6>Chat</h6>
            </div>
            <div class="chatroom-main-content only-chatroom">
                <div class="chat-box pb-1">
                    <div class="posted-chat" id="posted-chat">
                        @forelse ($course->chats as $discussion)
                            @if(auth()->user()->role=='Admin'  || auth()->user()->role=='Tutor' || $discussion->to=='Everyone' || auth()->user()->name== $discussion->to || auth()->user()->name== $discussion->from )
                               @if(($discussion->from==auth()->user()->name) || (auth()->user()->role=='Admin' && $discussion->from=='Admin') || (auth()->user()->role=='Tutor'  && $discussion->from==auth()->user()->name.'(Tutor)') )
                                    <div class="chat chat-from-self chat-from-admin">
                                        <div class="user-name-time">
                                            <span> From: {{$discussion->from}}  To: {{$discussion->to}}  on {{$discussion->created_at}}</span>
                                        </div>
                                        <div class="user-message text-primary "> {{$discussion->message}} </div>
                                    </div>
                                @else
                                    <div class="chat chat-from-other">
                                        <div class="user-name-time">
                                            <span> From: {{$discussion->from}}  To: {{$discussion->to}}  on {{$discussion->created_at}}</span>
                                        </div>
                                        <div class="user-message"> {{$discussion->message}} </div>
                                    </div>
                                @endif 
                            @endif
                        @empty
                            <p>You can start the discussion here!</p>
                        @endforelse

                    </div>
                </div>

                <div class="your-message">
                    <form method="POST" class="mb-n2" action="/special-course/classroom/chat/{{$course->id}}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-3 col-3">
                                <select id="to" name="to" class="@error('message') is-invalid @enderror">
                                    <option value="Everyone">Everyone</option>
                                    @if(auth()->user()->role!='Admin')
                                        <option value="Admin">Admin</option>
                                    @endif
                                    @if(auth()->user()->role!='Tutor')
                                        <option value="Tutor">Tutor</option>
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
                            <div class="col-md-8 col-8">
                                <input id="message" type="text" class="form-control @error('message') is-invalid @enderror" name="message" value="{{ old('message') }}" placeholder="type your message" required  autofocus>

                                @error('message')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-1 col-1" style="padding-left: 0">
                                <button type="submit" class="message-send" title="Chat with Everyone">
                                    <i class="fa fa-paper-plane" aria-hidden="true"></i>
                                </button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script>
            function updateScroll(){
                var element = document.getElementById("posted-chat");
                element.scrollTop = element.scrollHeight;
            }
        </script>

    </div>
</div>
@endsection
<script>
    import App from "../../../public/js/app";
    export default {
        components: {App}
    }
</script>
