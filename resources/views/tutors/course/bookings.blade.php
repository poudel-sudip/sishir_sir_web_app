@extends('tutors.layouts.app')
@section('tutor-title')
    {{$course->course}} Bookings List
@endsection

@section('tutor-title-icon')
    <i class="far fa-calendar-check"></i>
@endsection

@section('content')
    <div class="tutor-content-wrapper student-enroll-section">
        
        <div class="row">
            <div class="col-md-12 mb-2 ">
                <h4>{{$course->course}} Bookings List</h4>
                <h5>Total Students: {{$bookings->count()}}</h5>
            </div>
            <hr>
            <div class="col-md-12 student_exam_card">
                <div class="enrolled-table table-responsive">
                    <table class="table" style="width:100%">
                        <thead class="table-light">
                            <tr>
                                <th>SN</th>
                                <th>Name</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php($i=1)
                            @foreach($bookings as $booking)
                            <tr>
                                <td>{{$i}}</td>
                                <td>{{$booking->user->name ?? ''}}</td>
                                <td>{{$booking->user->email ?? ''}}</td>                       
                            </tr>
                            @php($i++)
                            @endforeach
                        </tbody>
                        
                    </table>
                </div>
                

                </div>

            </div>
        </div>

    @endsection
