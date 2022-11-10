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
                        @if($user->role=="Admin")
                        <div class="course-row">
                            <div>Admin Level:</div>
                            <div>
                                @if($user->permission==10)
                                    {{ 'Sales' }}
                                @elseif($user->permission==20)
                                    {{ 'Technical' }}
                                @elseif($user->permission==30)
                                    {{ 'Communication' }}
                                @elseif($user->permission==40)
                                    {{ 'Account' }}
                                @elseif($user->permission==50)
                                    {{ 'Admin' }}
                                @endif
                            </div>
                        </div>
                        @endif
                        <div class="course-row">
                            <div>Interested Courses:</div>
                            <div>{{$user->interests}}</div>
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

            <div class="col-12">
                <div class="card">
                    <div class="card-header">Booked Videos</div>
                    <div class="card-body">
                        @forelse($user->video_bookings as $res)
                            <div>{{$res->course->name.' - '.$res->status}}</div>
                        @empty
                            <div class="course-row">
                                <div>No Videos Booked</div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-header">Booked E-Books</div>
                    <div class="card-body">
                        @forelse($user->ebook_bookings as $res)
                            <div>{{$res->book->title.' - '.$res->status}}</div>
                        @empty
                            <div class="course-row">
                                <div>No E-Books Booked</div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
