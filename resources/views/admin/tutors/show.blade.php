@extends('admin.layouts.app')
@section('admin-title')
    Show Tutor
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Show Tutor</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="/admin/home">Dashboard</a></li>
                  <li class="breadcrumb-item"><a href="/admin/tutors">Tutors</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Show</li>
              </ol>
          </nav>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">View {{$tutor->name}} details</div>
                    <div class="card-body">
                        <div class="course-row">
                            <div>User ID:</div>
                            <div>{{$tutor->user->id}}</div>
                        </div>
                        <div class="course-row">
                            <div>Tutor ID:</div>
                            <div>{{$tutor->id}}</div>
                        </div>
                        <div class="course-row">
                            <div>Full Name:</div>
                            <div>{{$tutor->name}}</div>
                        </div>
                        <div class="course-row">
                            <div>Email:</div>
                            <div>{{$tutor->user->email}}</div>
                        </div>
                        <div class="course-row">
                            <div>Contact:</div>
                            <div>{{$tutor->user->contact}}</div>
                        </div>
                        <div class="course-row">
                            <div>Status:</div>
                            <div>{{$tutor->status}}</div>
                        </div>
                        <div class="course-row">
                            <div>Qualification:</div>
                            <div>{{$tutor->qualification}}</div>
                        </div>
                        <div class="course-row">
                            <div>Experience:</div>
                            <div>{{$tutor->experience}}</div>
                        </div>
                        <div class="course-row">
                            <div>Courses:</div>
                            <div>@php($c=[])
                                @foreach($tutor->batches as $batch)
                                    @if(in_array($batch->course->name,$c))
                                        @continue
                                    @endif
                                    {{$batch->course->name}},
                                    @php(array_push($c,$batch->course->name))
                                @endforeach
                            </div>
                        </div>
                        <div class="course-row">
                            <div>Video Courses:</div>
                            <div>
                                @foreach($tutor->videoCourses as $course)
                                    {{$course->course->name ?? ''}},
                                @endforeach
                            </div>
                        </div>
                        <div class="course-row">
                            <div>Description:</div>
                            <div>{{$tutor->description}}</div>
                        </div>
                        <div class="course-row">
                            <div>Image:</div>
                            <div><img src="/storage/{{$tutor->user->photo}}" height="50" alt=""></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
