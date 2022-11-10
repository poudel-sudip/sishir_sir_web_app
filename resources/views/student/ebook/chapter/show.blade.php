@extends('student.layouts.app')
@section('student-title')
    {{$book->title}} | {{$chapter->name}} :- {{$chapter->title}}
@endsection

@section('student-title-icon')
    <i class="fas fa-list-ol"></i>
@endsection


@section('content')
    <style>
        @media (max-width: 767px){
            .file-slide-item img{
            touch-action: pinch-zoom;
        }
        }
        
    </style>
    <div class="student-content-wrapper student-enroll-section bg-white">
        <div class="row">
            <div class="col-md-12">
                <div class="h3 text-center">{{$book->title}}</div>
                <div class="h5 text-center">{{$chapter->name}} :- {{$chapter->title}}</div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="owl-carousel chapter-file-carousel">
                    @foreach ($files as $files)
                    <div class="file-slide-item">
                        <img draggable="false" src="/storage/{{$files->image}}" alt="">
                    </div>
                    @endforeach
                </div>
                {{-- <iframe src="/storage/{{$chapter->pdf_file}}#toolbar=0&navpanes=0" frameBorder="0" scrolling="auto" height="600" width="100%"></iframe> --}}
            </div>
        </div>
    </div>
    <script type="text/javascript">
        document.oncontextmenu = new Function("return false");
    </script>

@endsection
