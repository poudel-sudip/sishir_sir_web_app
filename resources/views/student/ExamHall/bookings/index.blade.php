@extends('student.layouts.app')
@section('student-title')
    Enrolled Exam Sets
@endsection

@section('student-title-icon')
    <i class="fas fa-list-ol"></i>
@endsection


@section('content')
    <div class="student-content-wrapper student-enroll-section">
        <div class="row mb-2">
            <div class="col-md-12 text-end">
                <a class="student-enroll-btn" href="{{ url('/student/exam-bookings/create') }}">Book an Exam Set</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="enrolled-table table-responsive table-responsive-md">
                    <table class="table" style="width:100%">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                {{-- <th>Date</th> --}}
                                <th>Exam Set</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bookings as $booking)
                            <tr>
                                <td>{{$booking->id}}</td>
                                {{-- <td>{{date('Y/m/d',strtotime($booking->created_at))}}</td> --}}
                                <td>{{($booking->category->title ?? '').' ('.($booking->category->category_exams->count() ?? '0').' sets) '}}</td>
                                <td>{{$booking->status}}</td>
                                <td>
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
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        
                    </table>
                </div>
            </div>
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
