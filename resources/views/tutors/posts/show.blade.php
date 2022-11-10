@extends('tutors.layouts.app')
@section('tutor-title')
    {{$post->title}} | Tutor Post
@endsection
@section('tutor-title-icon')
    <i class="fas fa-eye"></i>
@endsection

@section('content')
    <div class="content-wrapper tutor-content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="card student_exam_card">
                    <div class="card-header">{{$post->title}} </div>
                    <div class="card-body">
                        <div class="course-row row">
                            <div class="col-md-2">Image: </div>
                            <div class="col-md-6"><img src="/storage/{{$post->thumbnail}}" class="w-100" alt=""></div>
                        </div>

                        <div class="course-row row">
                            <div class="col-md-2">Created Date : </div>
                            <div class="col-md-10">{{$post->created_at}}</div>
                        </div>
                        <div class="course-row row">
                            <div class="col-md-2">Status: </div>
                            <div class="col-md-10">{{$post->status}}</div>
                        </div>
                        <div class="course-row row">
                            <div class="col-md-2">Description: </div>
                            <div class="col-md-10">{!! $post->description !!}</div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
