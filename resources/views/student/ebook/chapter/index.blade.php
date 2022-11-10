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
                    <a href="/student/ebook/{{$booking->id}}/chapters/{{$chapter->id}}" style="text-decoration: none">
                        <div class="student-vid-chapter">
                            <span class="text-primary">{{($chapter->name ?? '')}}</span>
                            <h6 class="text-black">{{($chapter->title ?? '')}}</h6>
                            <div class="student-vid-cpt-action">
                                <div class="col-6 text-black">
                                    <i class="fas fa-file-alt text-success"></i>
                                    {{$chapter->chapterfiles->count()}}
                                    @if ($chapter->chapterfiles->count() >= 2)
                                        Pages
                                    @else
                                    Page
                                    @endif
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
            {{-- <div class="col-md-12">
                <div class="enrolled-table table-responsive">
                    <table class="table" style="width:100%">
                        <thead class="table-light">
                            <tr>
                                <th>SN</th>
                                <th>Chapter Name</th>
                                <th>Chapter Title</th>
                                <th>Show</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php($i=1)
                            @foreach($chapters as $chapter)
                            <tr>
                                <td>{{$i}}</td>
                                <td class="text-wrap">{{($chapter->name ?? '')}}</td>
                                <td class="text-wrap">{{($chapter->title ?? '')}}</td>
                                <td><a href="/student/ebook/{{$booking->id}}/chapters/{{$chapter->id}}" class="btn btn-sm btn-success">Show</a></td>
                            </tr>
                            @php($i++)
                            @endforeach
                        </tbody>
                        
                    </table>
                </div>
            </div> --}}
        </div>
    </div>

@endsection
