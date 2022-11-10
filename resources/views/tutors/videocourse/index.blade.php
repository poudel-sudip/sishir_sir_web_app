@extends('tutors.layouts.app')
@section('tutor-title')
    Video Courses
@endsection
@section('tutor-title-icon')
    <i class="fas fa-money-check-alt"></i>
@endsection

@section('content')
    <div class="tutor-content-wrapper student-enroll-section">
        
        <div class="row">
            <div class="col-md-12 student_exam_card">
                <div class="enrolled-table table-responsive">
                    <table class="table" style="width:100%">
                        <thead class="table-light">
                            <tr>
                                <th>SN</th>
                                <th>Video Course</th>
                                <th>Total Bookings</th>
                                <th>Percentage</th>
                                <th>Payment Amount</th>
                                <th>Received Amount</th>
                                <th>Remaining Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php($i=1)
                            @foreach($courses as $course)
                            <tr>
                                <td>{{$i}}</td>
                                <td>{{$course->course->name ?? ''}}</td>
                                <td> {{$course->course->bookings()->where('status','=','Verified')->count() ?? 0 }} </td>
                                <td> {{$course->percent ?? 0}} %</td>
                                <td> Rs. {{ (integer) ( ($course->course->bookings()->where('status','=','Verified')->sum('paymentAmount') ?? 0) * ($course->percent / 100)) }} </td>
                                <td> Rs. {{$course->paidAmount ?? 0}} </td>
                                <td> Rs. 
                                    @php($amt = (($course->course->bookings()->where('status','=','Verified')->sum('paymentAmount') ?? 0) * ($course->percent / 100)) - ($course->paidAmount ?? 0) )
                                    {{ $amt > 0 ? (integer)$amt : '0' }}
                                </td>
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
