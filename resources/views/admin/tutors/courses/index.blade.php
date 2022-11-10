@extends('admin.layouts.app')
@section('admin-title')
    Tutors Courses
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">{{$tutor->name}} : Special Courses</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="/admin/home">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="/admin/tutors">Tutors</a></li>
              <li class="breadcrumb-item active" aria-current="page">Courses</li>
              </ol>
          </nav>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="custon-table-header">
                            <h4 class="card-title">{{$tutor->name}} : Special Courses</h4>
                            <div class="text-right">
                                @if(auth()->user()->permission>=20)
                                <!-- <a href="{{ ('/admin/tutors/create') }}"><button type="button" class="btn btn-sm ml-3 btn-success">Add Tutor</button></a> -->
                                @endif
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="tutor-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Course</th>
                                        <th>Fee</th>
                                        <th>Discount</th>
                                        <th>Start Date</th>
                                        <th>Duration</th>
                                        <th>Status</th>
                                        <th>Payments</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($courses as $course)
                                    <tr>
                                        <td>{{$course->id}}</td>
                                        <td>{{$course->course}}</td>
                                        <td>Rs {{$course->fee}}</td>
                                        <td>Rs {{$course->discount}}</td>
                                        <td>{{date('Y-m-d',strtotime($course->startDate))}}</td>
                                        <td>{{$course->duration}}</td>
                                        <td>{{$course->status}}</td>
                                        <td>
                                            <a href="/admin/tutors/{{$tutor->id}}/courses/{{$course->id}}/payments">View Paid {{$course->payments()->where('status','=','Paid')->count()}} out of {{$course->payments->count()}} requests </a>
                                        </td>
                                        <td class="classroom-btn" width="160">
                                            <a href="/special-course/classroom/chat/{{$course->id}}" class="btn btn-success">Classroom</a>
                                            <a href="/admin/tutors/{{$tutor->id}}/courses/{{$course->id}}/bookings" class="btn btn-info">Bookings</a>
                                            <a href="/admin/tutors/{{$tutor->id}}/courses/{{$course->id}}" class="btn btn-primary">Show</a>
                                            @if(auth()->user()->permission>=20)
                                            <a href="/admin/tutors/{{$tutor->id}}/courses/{{$course->id}}/edit" class="btn btn-danger">Edit</a>
                                            <form id="delete-form-{{$course->id}}" action="/admin/tutors/{{$tutor->id}}/courses/{{$course->id}}" method="POST" style="display: inline">
                                                @csrf
                                                @method('DELETE')
                                                <a href="javascript:{}" onclick="javascript:deleteData({{$course->id}});" class="btn btn-warning">Delete</a>
                                            </form>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <script type="text/javascript">
                                function deleteData(id)
                                {
                                    if(confirm('Are You Sure? ')){
                                        document.getElementById('delete-form-'+id).submit();
                                    }
                                }
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
