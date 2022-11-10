@extends('tutors.layouts.app')
@section('tutor-title')
    My Payment Requests
@endsection
@section('tutor-title-icon')
    <i class="fas fa-money-check-alt"></i>
@endsection

@section('content')
    <div class="tutor-content-wrapper student-enroll-section">
        
        <div class="row">
            <div class="col-md-12 mb-2 text-end">
                <a class="student-enroll-btn" href="{{ url('/tutor/payment-requests/request') }}">Add New Request</a>
            </div>
            <div class="col-md-12 student_exam_card">
                <div class="enrolled-table table-responsive">
                    <table class="table" style="width:100%">
                        <thead class="table-light">
                            <tr>
                                <th>SN</th>
                                <th>Date</th>
                                <th>Course</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php($i=1)
                            @foreach($payments as $payment)
                            <tr>
                                <td>{{$i}}</td>
                                <td>{{date('Y/m/d',strtotime($payment->updated_at))}}</td>                        
                                <td >
                                    @if($payment->courseType=='Normal')
                                        {{$payment->normalCourse->name}}
                                    @elseif($payment->courseType=='Special')
                                        {{$payment->specialCourse->course}}
                                    @endif
                                </td>
                                <td>Rs {{$payment->amount}}</td>
                                <td>{{$payment->status}}</td>
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
