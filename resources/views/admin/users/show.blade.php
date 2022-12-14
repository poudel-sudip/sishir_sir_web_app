@extends('admin.layouts.app')
@section('admin-title')
    Show User
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Show User</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/admin/users') }}">Users</a></li>
              <li class="breadcrumb-item active" aria-current="page">Show</li>
              </ol>
          </nav>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">View {{$user->name}} details</div>
                    <div class="card-body">
                        <div class="course-row">
                            <div>User ID:</div>
                            <div>{{$user->id}}</div>
                        </div>
                        <div class="course-row">
                            <div>User Full Name:</div>
                            <div>{{$user->name}}</div>
                        </div>
                        <div class="course-row">
                            <div>User Email:</div>
                            <div>{{$user->email}}</div>
                        </div>
                        <div class="course-row">
                            <div>User Contact:</div>
                            <div>{{$user->contact}}</div>
                        </div>
                        <div class="course-row">
                            <div>Role:</div>
                            <div>{{$user->role}}</div>
                        </div>
                        <div class="course-row">
                            <div>User Status:</div>
                            <div>{{$user->status}}</div>
                        </div>
                        <div class="course-row">
                            <div>Last Login:</div>
                            <div>{{$user->last_login}}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-5 row">
            <div class="col-12">
               <div class="card">
                   <div class="card-header">Booked Courses</div>
                   <div class="card-body">
                       @forelse($user->bookings as $res)
                        <div>
                            {{$res->course->name.'  -   '.$res->batch->name.' - '.$res->status}}
                        </div>
                       @empty
                           <div class="course-row">
                               <div>No Courses Booked</div>
                           </div>
                       @endforelse
                   </div>
               </div>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-header">Booked Exams</div>
                    <div class="card-body">
                        @forelse($user->exam_bookings as $res)
                            <div>{{$res->category->title.' - '.$res->status}}</div>
                        @empty
                            <div class="course-row">
                                <div>No Exams Booked</div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
