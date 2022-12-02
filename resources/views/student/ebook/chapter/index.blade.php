@extends('student.layouts.app')
@section('student-title')
    Chapters | {{$book->title}}
@endsection

@section('student-title-icon')
    <i class="fas fa-list-ol"></i>
@endsection


@section('content')
    <div class="student-content-wrapper student-enroll-section">
        <div class="row">
            @foreach ($chapters as $chapter)
                <div class="col-md-4 mb-3">
                    <a href="/student/ebook-bookings/{{$booking->id}}/chapters/{{$chapter->id}}" style="text-decoration: none">
                        <div class="student-vid-chapter">
                            <span class="text-primary">{{($chapter->name ?? '')}}</span>
                            <h6 class="text-black">{{($chapter->title ?? '')}}</h6>
                            <div class="student-vid-cpt-action">
                                <div class="col-6 text-black">
                                    <i class="fas fa-file-alt text-success"></i>
                                    {{$chapter->chapterfiles->count()}}
                                    @if ($chapter->chapterfiles->count() >= 2)
                                        Page Images
                                    @else
                                    Page Image
                                    @endif
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
            
        </div>
    </div>

@endsection
