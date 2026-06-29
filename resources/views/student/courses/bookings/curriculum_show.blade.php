@extends('student.layouts.app')
@section('student-title')
    Course Batch Curriculum Show
@endsection

@section('student-title-icon')
    <i class="far fa-file-pdf"></i>
@endsection


@section('content')
    <div class="student-content-wrapper student-enroll-section">        
        <div class="mt-2">
            <div class="text-center h5">{{optional($batch->course)->name}}</div>
            <div class="text-center h5">{{$batch->name}}</div>
        </div>

        <div class="row mt-3">
            <div class="col-md-3 border border-info py-2">
                <div class="h5">Curriculum</div>
                <div class="list">
                    @foreach ($curriculums as $row)
                        <div class="{{$row->is_heading == 0 ? 'ms-3': ''}}"><a href="/student/course-bookings/{{$booking->id}}/curriculum/{{$row->id}}" @if($row->id == $curriculum_single->id ) class="h6 text-success" @endif >{{$row->title}}</a></div>
                    @endforeach 
                </div>
            </div>
            <div class="col-md-9 p-2 border border-success rounded">
                <div class="text-center h5">{{$curriculum_single->title}}</div>
                <div class="text-justify">{!! $curriculum_single->description !!}</div>
                <div class="text-center">
                    @if($curriculum_single->pdf_file)
                        <div class="col-md-12 mt-3">
                            <div class="">
                                <div class="_df_book" id="pdf_book_df" source="{{$curriculum_single->pdf_file}}" ></div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
  
    <link href="{{asset('dflip/css/dflip.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('dflip/css/themify-icons.min.css')}}" rel="stylesheet" type="text/css">

    <script src="{{asset('dflip/js/dflip.min.js')}}" type="text/javascript"></script>

    <script>
        var option_pdf_book_df = {
            // height:'100%',
            webgl:true,
            soundEnable: true,
            enableDownload: false,
            backgroundColor: "#002742",
            scrollWheel: false,
            pageMode: DFLIP.PAGE_MODE.SINGLE,
            singlePageMode: DFLIP.SINGLE_PAGE_MODE.BOOKLET,
            allControls: "startPage,altPrev,pageNumber,altNext,endPage,thumbnail,zoomIn,zoomOut,fullScreen,pageMode",
            moreControls: "",
            hideControls: "share",
        };
    </script>

@endsection
