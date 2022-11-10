@extends('tutors.layouts.app')
@section('tutor-title')
    My Messenger Groups
@endsection
@section('tutor-title-icon')
    <i class="fab fa-facebook-messenger"></i>
@endsection

@section('content')
    <div class="student-enroll-section">  
        <div class="row">
            <div class="col-md-6 messanger-section">
                @php($group=[])
                @php(array_push($group,auth()->user()->id))
                @foreach($chats as $key=>$value)
                    @if(!in_array($key,$group))
                        <div class="student-messenger-group">
                            <a href="/tutor/messenger/{{$key}}/chat" class="student-messenger-list">
                            {{$value->first()->from_user->name}} <!-- $value->first()->from_user returns user model data -->
                            </a>
                        </div>
                        @php(array_push($group,$key))
                    @endif
                @endforeach

            </div>
            <div class="col-md-6">
                <div class="messenger-start-message">
                    <p>Chat With Student</p>
                </div>
                
            </div>
        </div>
    </div>
@endsection
