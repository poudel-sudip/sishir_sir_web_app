@extends('student.layouts.app')
@section('student-title')
    Enrolled Course Bookings
@endsection

@section('student-title-icon')
    <i class="fas fa-calendar-check"></i>
@endsection

@section('content')
<div class="news-feeds student-content-wrapper">
    <div class="student-enroll-section">
        <div class="row">
            <div class="col-md-12 mb-2">
                <a class="student-enroll-btn" href="{{ url('/student/course-bookings/create') }}">Enroll New Course</a>
            </div>
            <div class="col-md-12">
                <div class="enrolled-table table-responsive">
                    <table class="table" style="width:100%">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Course Batch</th>
                                <th>Verification</th>
                                {{-- <th>Due Amt.</th> --}}
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bookings as $booking)
                            <tr style=" @if($booking->suspended) color:red !important @endif ">
                                <td>{{$booking->id}}</td>
                                <td>{{$booking->batch->name ?? ''}}</td>
                                <td>{{$booking->status}}</td>
                                {{-- <td>@if($booking->dueAmount>10) Rs. {{$booking->dueAmount}} @endif</td> --}}
                                <td width="200">
                                    <a href="/student/course-bookings/{{$booking->id}}" class="btn-primary btn btn-sm mb-1">Details</a>
                                    @if($booking->status=="Unverified" && $booking->batch->status!="Closed")
                                        <a href="/student/course-bookings/{{$booking->id}}/edit" class="btn btn-warning btn-sm mb-1 ">Verify</a>
                                        <form id="delete-form-{{$booking->id}}" action="/student/course-bookings/{{$booking->id}}" method="POST" style="display: inline">
                                            @csrf
                                            @method('DELETE')
                                            <a href="javascript:{}" onclick="javascript:deleteData({{$booking->id}});" class="btn btn-danger btn-sm mb-1">Delete</a>
                                        </form>
                                    @endif
                                    @if($booking->status=="Verified" && $booking->suspended==false)
                                        <a href="/classroom/chat/{{$booking->batch->id}}" class="btn btn-success btn-sm mb-1">Classroom</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="news-feeds-contact">
        @include('student.studentContact')
    </div>
</div>

<script type="text/javascript">
    function deleteData(id)
    {
        if(confirm('Are You Sure You want to Delete this Booking ? You will not be able to revert it ? ')){
            document.getElementById('delete-form-'+id).submit();
        }
    }
</script>

@endsection
