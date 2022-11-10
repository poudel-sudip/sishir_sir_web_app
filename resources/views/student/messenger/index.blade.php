@extends('student.layouts.app')
@section('student-title')
    My Messenger Groups
@endsection
@section('student-title-icon')
    <i class="fas fa-comment"></i>
@endsection

@section('content')
    <div class="student-content-wrapper">  
        <div class="row">
            <div class="col-md-6 messanger-section">
                @php($group=[])
                @php(array_push($group,auth()->user()->id))
                @foreach($chats as $key=>$value)
                    @if(!in_array($key,$group))
                        <div class="student-messenger-group">
                            <a href="/student/messenger/{{$key}}/chat" class="student-messenger-list">
                            {{$value->first()->from_user->name}} <!-- $value->first()->from_user returns user model data -->
                            </a>
                        </div>
                        @php(array_push($group,$key))
                    @endif
                @endforeach

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
            <div class="col-md-6">
                <div class="messenger-start-message">
                    <p>Please, click the any tutor and start conversation. </p>
                </div>
                
            </div>
        </div>
    </div>
@endsection
