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
        </div>
        <div class="container" id="pdfcontainer">    

            <iframe id="pdfiframe" src="/storage/{{$content->pdf_file}}#toolbar=0&navpanes=0" frameBorder="0" scrolling="auto" height="600" width="100%"> </iframe>
        
        </div>
    </div>

    <script type="text/javascript">
        document.oncontextmenu = new Function("return false");

        $('#pdfiframe').on('load', function(){
            var title = this.contentDocument.title;
            if(title.includes("404"))
            {
                $('#pdfiframe').hide();
                $('#pdfcontainer').html('<h1 class="text-center mt-5 text-danger"> PDF File Not Found !! </h1>');
            }
        });

                
    </script>

@endsection
