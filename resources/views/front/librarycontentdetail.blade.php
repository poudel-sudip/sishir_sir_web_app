@extends('front.layouts.app')

@section('page_title', ucwords($material->name))
@section('og-title', ucwords($material->name))
@section('og-url', url('/library/'.$library_category->slug.'/'.$material->slug))
@section('og-description', strip_tags($material->description) ? strip_tags(str_replace('<', '  <', $material->description)) : $material->name )
@if($material->thumbnail)
@section('og-image', asset('/storage/'.$material->thumbnail))
@endif

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 etutor-breadcrumb text-center">
                <h2>{{ucwords($material->name)}}</h2>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="{{ ('/') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ ('/library') }}">Library</a></li>
                        <li class="breadcrumb-item"><a href="/library/{{$library_category->slug}}">{{ucwords($library_category->name)}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ucwords($material->name)}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="container">

        <div class="blog-container mt-5">
            <h4 class="mb-2">{{$material->name}}</h4>
            <div>
                {!! $material->description !!}
            </div>
            
            <div class="my-4 row">
                <div class="col-md-4"></div>
                <div class="col-md-8"><div class="sharethis-inline-share-buttons" ></div></div>
            </div>
            
            @if($material->type == 'file')
                <div class="mt-4">
                    <!-- <div id="my_pdf_viewer" class="text-center" oncontextmenu="return false"> </div> -->
                    
                    <iframe src="/storage/{{$material->fileurl}}#toolbar=0" 
                        oncontextmenu="return false" 
                        onselectstart="return false" 
                        ondragstart="return false"
                        frameborder="0" 
                        style="width: 100%; min-height:700px" 
                        target="_parent"
                        nodownload>
                    </iframe> 
                </div>
            @endif
        </div>

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/1.10.100/pdf.min.js"  crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        //pdf js script  
        var filePath = "/storage/{{$material->fileurl}}";

        function Num(num) {
            var num = num;

            return function () {
                return num;
            }
        };

        function renderPDF(url, canvasContainer, options) {
            var options = options || {
                    scale: 1.7
                },          
                func,
                pdfDoc,
                def = $.Deferred(),
                promise = $.Deferred().resolve().promise(),         
                width, 
                height,
                makeRunner = function(func, args) {
                    return function() {
                        return func.call(null, args);
                    };
                };

            function renderPage(num) {          
                var def = $.Deferred(),
                currPageNum = new Num(num);
                pdfDoc.getPage(currPageNum()).then(function(page) {
                    var viewport = page.getViewport(options.scale);
                    var canvas = document.createElement("canvas");
                    canvas.setAttribute("class","img img-fluid");
                    canvas.setAttribute("id","pdfCanvas"+num);
                    // canvas.setAttribute("onclick","popCanvas('{{url('/dashboard/showcanvas')}}','"+document.getElementById('pdfPath').innerHTML+"','"+num+"');");
                    var ctx = canvas.getContext('2d');
                    var renderContext = {
                        canvasContext: ctx,
                        viewport: viewport
                    };

                    if(currPageNum() === 1) {                   
                        height = viewport.height;
                        width = viewport.width;
                    }

                    canvas.height = height;
                    canvas.width = width;

                    canvasContainer.appendChild(canvas);

                    page.render(renderContext).then(function() {                                        
                        def.resolve();
                    });
                })

                return def.promise();
            }

            function renderPages(data) {
                pdfDoc = data;

                var pagesCount = pdfDoc.numPages;
                for (var i = 1; i <= pagesCount; i++) { 
                    func = renderPage;
                    promise = promise.then(makeRunner(func, i));
                }
            }

            PDFJS.disableWorker = true;
            PDFJS.getDocument(url).then(renderPages);       
        };

        var body = document.getElementById("my_pdf_viewer");
        renderPDF(filePath, body);
    </script>

    <script>
        // document.addEventListener('contextmenu', e => e.preventDefault());
        function createPopupWin(url) {
            let height = 400;
            let width = 800;
            var left = ( screen.width - width ) / 2;
            var top = ( screen.height - height ) / 2;
            var newWindow = window.open( url, "Center Window", 'resizable = yes, width=' + width + ', height=' + height + ', top='+ top + ', left=' + left);
        }
    </script>

@endsection
