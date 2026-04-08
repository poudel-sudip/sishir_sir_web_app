@extends('student.layouts.app')
@section('student-title')
    Enrolled Exam Sets
@endsection

@section('student-title-icon')
    <i class="fas fa-list-ol"></i>
@endsection


@section('content')
    <div class="student-content-wrapper student-enroll-section">
        <div class="row">
            <div class="col-md-12 mb-2 text-end">
                {{-- <a class="student-enroll-btn" href="{{ url('/student/exam-bookings/create') }}">Book an Exam Set</a> --}}
                <a class="student-enroll-btn" href="/public-exams">Book an Exam Set</a>
            </div>
        </div>
        <div class="row">
            @foreach ($bookings as $booking)
                <div class="col-md-4 student-video-card mb-3">
                    
                    <div class="student-vid-dec">
                        <div class="text-center mb-1">
                            <img src="/storage/{{$booking->category->image ?? ''}}" alt="" onerror="this.src='/images/default-post.png'" style="max-height:200px; width:auto;" class="img img-fluid" draggable="false">
                        </div>

                        <h6>{{($booking->category->title ?? '')}}</h6>
                        <div class="">{{ ($booking->category->category_exams->count() ?? '0').' Sets MCQs'}}</div>
                        <div class="small">Expiry Date: {{$booking->expiry_date}}</div>
                        @if ($booking->status == "Verified")
                            <div class="text-success">{{$booking->status}}</div>
                        @elseif($booking->status == "Expired")
                        <div class="text-danger">{{$booking->status}} <span class="text-primary">(Renew with 50% discount)</span> </div>
                        @endif
                        <div class="student-vid-status">                            
                            <div class=""></div>
                            <div class="text-end text-nowrap">
                                @if($booking->status!="Verified")
                                    <a href="/student/exam-bookings/{{$booking->id}}/edit" class="btn btn-warning btn-sm mb-1 ">Verify</a> 
                                    <form id="delete-form-{{$booking->id}}" action="/student/exam-bookings/{{$booking->id}}" method="POST" style="display: inline">
                                        @csrf
                                        @method('DELETE')
                                        <a href="javascript:{}" onclick="javascript:deleteData({{$booking->id}});" class="btn btn-danger btn-sm">Delete</a>
                                    </form>
                                @else
                                    <a href="/student/exam-bookings/{{$booking->category_id}}/exams" class="btn btn-success btn-sm mb-1 ">Show Exams</a> 
                                    <a href="/student/exam-bookings/{{$booking->category_id}}/cqc" class="btn btn-info btn-sm mb-1 ">CQQ</a> 
                                @endif
                                
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="">
            {{$bookings->onEachSide(1)->links('paginator.bootstrap')}}
        </div>
        
    </div>

    <script type="text/javascript">
        function deleteData(id)
        {
            if(confirm('Are You Sure? ')){
                document.getElementById('delete-form-'+id).submit();
            }
        }
    </script>

@endsection
