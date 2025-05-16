@extends('student.layouts.app')
@section('student-title')
    PDF Bank Contents
@endsection

@section('student-title-icon')
    <i class="fas fa-file-pdf"></i>
@endsection


@section('content')
  
    <div class="student-content-wrapper student-enroll-section bg-white">
        <div class="row mb-2">
            <div class="col-md-12">
                <div class="h3 text-center">{{$pdfbank->title}}</div>
                <div class="h4 text-center text-success">{{$content->title}}</div>
            </div>
            <div class="col-12">
                <div class="text-end">
                    @if(trim($content->video_file))
                    <a class="view-video btn btn-primary" href="#videoModal" video-title="{{'Video Solution for '.$content->title}}" video-url="{{$content->video_file}}" data-bs-toggle="modal" data-bs-target="#videoModal" data-toggle="modal" data-target="#videoModal">Play Solution Video <span class="fas fa-video"></span></a>
                    @endif

                    @if($content->download)                        
                        <a href="/storage/{{$content->pdf_file}}" filename="{{ucwords($pdfbank->title.'__'.$content->title)}}" onclick="handleDownload(event)" target="_blank" class="text-primary"> <i class="fa fa-download"></i>  Download</a>
                    @endif
                </div>
            </div>
        </div>
        <div class="container">    
            <div class="">
                <div class="_df_book" id="pdf_book_df" source="/storage/{{$content->pdf_file}}" ></div>
            </div>
            {{-- <div class="pdf-container" id="pdf-container" style="max-height:800px;overflow-y: scroll;"></div> --}}
            {{-- <div class="pdf-container" id="pdf-container"></div> --}}
            {{-- <iframe id="pdfiframe" src="/storage/{{$content->pdf_file}}#toolbar=0&navpanes=0" frameBorder="0" scrolling="auto" height="600" width="100%"> </iframe> --}}
        
        </div>

        <div class="mt-3">
            <h4>Disclaimer:</h4>
            <p>
                If you print or copy any material placed here physically or with the help of electronic devices without permission, or if you use it or reproduce it unauthorized or share it on social media, action will be taken according to copyright Act.
            </p>
            <p>
                हजुरहरुले यहाँ राखिएको कुनैपनि सामग्री अनुमती नलिई अरु कसैलाई भौतिक रुपमा प्रिन्ट गरी वा इलेक्ट्रोनिक डिभाइसको मद्धतले कपि गरी अनाधिकृत रुपमा प्रयोग वा पुर्नउत्थान गरेमा वा सामाजिक सञ्जालमा शेयर गरेको पाइएमा प्रतिलिपि अधिकार ऐन अनुसार कारबाही गरिने  छ ।
            </p>
        </div>
        
    </div>
   
    <!-- Modal HTML -->
    <div id="videoModal" class="modal fade">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header text-white align-items-center">
                    <h5 class="modal-title" id="playingTitle"> </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div id="videoPlayer" class="embed-responsive embed-responsive-16by9"> </div>
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
            backgroundColor: "#1375b9",
            scrollWheel: false,
            pageMode: DFLIP.PAGE_MODE.SINGLE,
            singlePageMode: DFLIP.SINGLE_PAGE_MODE.BOOKLET,
            allControls: "startPage,altPrev,pageNumber,altNext,endPage,thumbnail,zoomIn,zoomOut,fullScreen,pageMode",
            moreControls: "",
            hideControls: "share,download",
        };
    </script>

    <script>
        function handleDownload(event) {
            event.preventDefault(); // Prevent the default behavior of the link

            var downloadUrl = event.target.getAttribute("href");
            var filename = event.target.getAttribute("filename");

            var link = document.createElement("a");
            link.href = downloadUrl;
            link.download = filename +" || shisiradhikari.com.pdf"; // Set an empty value for the download attribute to preserve the original filename

            document.body.appendChild(link);

            link.click(); // Simulate a click event to initiate the download

            document.body.removeChild(link); // Remove the dynamically created link element
        }
    </script>

    {{-- <script src="{{asset('/js/pdf.min.js') }}"></script>
    <script src="{{asset('/js/pdf.worker.min.js') }}"></script>
    <script src="{{asset('/js/pdf_reader.js') }}"></script>
    <script>
        load_pdf_reader("/storage/{{$content->pdf_file}}");      
    </script> --}}

    <script type="text/javascript" src="{{asset('js/noprint.js')}}"></script>

@endsection
