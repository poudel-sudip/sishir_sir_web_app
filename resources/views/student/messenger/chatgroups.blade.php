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
            <div class="col-md-6 border">
                
                @foreach($groups as $group)
                <div class="card my-2 p-1">
                    <a class="row justify-content-center align-items-center text-decoration-none fw-bold text-dark" href = "/student/messenger/{{$group->id}}/chat">
                        <div class="col-3"><img src="/storage/{{$group->image}}" alt="" class="img img-fluid" style="max-height:60px; max-width:60px; border-radius:50%"></div>
                        <div class="col-9">{{$group->batch}}</div>
                    </a>
                </div>
                @endforeach

            </div>
            <div class="col-md-6">
                <div class="messenger-start-message">
                    <p>Please, Click any group and start conversation. </p>
                </div>
                
            </div>
        </div>
    </div>
@endsection
