@extends('tutors.layouts.app')
@section('tutor-title')
    Create New Payment Request
@endsection
@section('tutor-title-icon')
    <i class="fas fa-comment-dollar"></i>
@endsection
@section('content')
<div class="tutor-content-wrapper"> 
    <div class="row">
        <div class="col-12 my-3">
            <div class="card">
                <div class="card-body">
                <h5>Payment Requests for Self Created Courses</h5>
                <ol>
                    @foreach($courses as $course)
                    <li><a href="/tutor/payment-requests/request/{{$course->id}}">{{$course->course}} |  <span> Total Paid: Rs {{$course->payments()->where('status','=','Paid')->sum('amount')}} </span></a>  </li>
                    @endforeach
                </ol>
                   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
