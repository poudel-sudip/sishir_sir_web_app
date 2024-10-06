@extends('front.layouts.app')

@section('page_title', ($subMenu->name))
@section('og-title', ($subMenu->name))
@section('og-url', url('/'.$mainMenu->slug.'/'.$subMenu->slug))
@section('og-description', strip_tags($subMenu->description) ? strip_tags(str_replace('<', '  <', $subMenu->description)) : $subMenu->name )
@if($subMenu->thumbnail)
@section('og-image', asset('/storage/'.$subMenu->thumbnail))
@endif

@section('content')
    <div class="container-fluid px-md-5">
        <div class="row">
            <div class="col-md-12 etutor-breadcrumb text-center">
                <h2>{{($subMenu->name)}}</h2>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="{{ ('/') }}">Home</a></li>
                        <li class="breadcrumb-item">{{($mainMenu->name)}}</li>
                        <li class="breadcrumb-item active" aria-current="page">{{($subMenu->name)}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid px-md-5">
        
        @if($subMenu->type != 'heading')
            <div class="blog-container">
                <h3 class="text-primary">{{($subMenu->name)}}</h3>
                <div class="px-5">
                    <span class="mx-2 text-primary"><i class="fa fa-pen"></i> {{date('Y-m-d',strtotime($subMenu->created_at))}}</span>
                    <span class="mx-2 text-info"><i class="fa fa-eye"></i> {{$counterData->page_view_count ?? '1'}}</span>
                    <span class="mx-2 text-primary"><i class="fa fa-download"></i> {{$counterData->page_download_count ?? '0'}}</span>
                    <span class="mx-2 text-danger"><i class="fa fa-share"></i> {{$counterData->page_share_count ?? '0'}}</span>
                </div>

                <div class="my-4 row align-items-center">
                    <div class="col-md-4">
                        @if($subMenu->type == 'file' && $subMenu->download)
                        <a href="/storage/{{$subMenu->fileurl}}" filename="{{($subMenu->name)}}" onclick="handleDownload(event)" target="_blank" class="text-primary"> <i class="fa fa-download"></i>  Download</a>
                        @endif
                    </div>
                    <div class="col-md-8"><div class="sharethis-inline-share-buttons" onclick="handleShare(event)"></div></div>
                </div>               
                             

                @if($subMenu->type == 'file')
                    <div class="mt-4">

                        <div class="_df_book" id="pdf_book_df" source="/storage/{{$subMenu->fileurl}}" ></div>

                        {{-- <div class="pdf-container" id="pdf-container" style="max-height:800px;overflow-y: scroll;"></div> --}}
                        {{-- <iframe src="/storage/{{$subMenu->fileurl}}" 
                            frameborder="0" 
                            style="width: 100%; min-height:700px" 
                            target="_parent">
                        </iframe> --}}
                    </div>
                @endif

                <div class="my-4">
                    {!! $subMenu->description !!}
                </div>

                <div class="mt-3">
                    <div><strong>Author(s)/Publisher(s): </strong>  {{$subMenu->author ? (html_entity_decode('&copy;')."  ".$subMenu->author) : ""}} </div>    
                </div>

            </div>
        @else
            <div class="table-responsive table-responsive-md ">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>SN</th>
                            <th>Title</th>
                            <th>View</th>
                            {{-- <th>Share</th> --}}
                        </tr>
                    </thead>
                    <?php 
                        $menuCategories = $subMenu->categories()->where('status','=','Active')->orderBy('order')->get(['id','name','slug']); 
                        $i = 1;
                    ?>

                    @forelse($menuCategories as $cat)
                        <tbody>
                            <tr>
                                <td>{{$i}}</td>
                                <td>{{$cat->name}}</td>
                                <td width="50"><a href="/{{$mainMenu->slug}}/{{$subMenu->slug}}/{{$cat->slug}}"><i class="fas fa-eye text-success"></i></a> </td>
                                {{-- <td style="max-width: 50px">
                                    <div class="d-inline post-share-option">
                                        @php($shareLink = url($mainMenu->slug.'/'.$subMenu->slug.'/'.$cat->slug))
                                        <a href="javascript:void();" onclick="createPopupWin('//facebook.com/sharer/sharer.php?u={{$shareLink}}&t={{$cat[`name`]}}')"><i class="fab fa-facebook-f"></i></a>
                                        <a href="javascript:void();" onclick="createPopupWin('//twitter.com/intent/tweet?text={{$cat[`name`]}}&url={{$shareLink}}')"><i class="fab fa-twitter"></i></a>
                                        <a href="javascript:void();" onclick="createPopupWin('//wa.me/?text={{$shareLink}}')"><i class="fab fa-whatsapp"></i></a>
                                        <a href="javascript:void();" onclick="createPopupWin('//pinterest.com/pin/create/button/?url={{$shareLink}}')"><i class="fab fa-pinterest-p"></i></a>
                                    </div>
                                </td> --}}
                            </tr>
                        </tbody>
                        @php($i++)
                    @empty              
                        <div>No Menu Categories Published</div>
                    @endforelse
                </table>
            </div>
        @endif

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


    {{-- <script src="{{asset('/js/pdf.min.js') }}"></script>
    <script src="{{asset('/js/pdf.worker.min.js') }}"></script>
    <script src="{{asset('/js/pdf_reader.js') }}"></script>
    <script>
        load_pdf_reader("/storage/{{$subMenu->fileurl}}");
    </script> --}}
    
    <script>
        function handleDownload(event) {
            event.preventDefault(); // Prevent the default behavior of the link

            var downloadUrl = event.target.getAttribute("href");
            var filename = event.target.getAttribute("filename");
            var fileExtension = downloadUrl.split('.').pop().toLowerCase();

            var link = document.createElement("a");
            link.href = downloadUrl;
            // link.download = filename +" || shisiradhikari.com.pdf"; // Set an empty value for the download attribute to preserve the original filename
            link.download = filename +" || shisiradhikari.com."+fileExtension;

            document.body.appendChild(link);

            link.click(); // Simulate a click event to initiate the download

            document.body.removeChild(link); // Remove the dynamically created link element

            let pageURL = getPageURLWithoutProtocol();
            const postData = { type: 'download', page: 'Menu Sub Group',pageurl: pageURL };
            postDataWithFetch('/page-counter-increment', postData);
        }

        function handleShare(event){
            let pageURL = getPageURLWithoutProtocol();
            const postData = { type: 'share', page: 'Menu Sub Group',pageurl: pageURL };
            postDataWithFetch('/page-counter-increment', postData);
        }
    </script>

    <script>
        function createPopupWin(url) {
            let height = 400;
            let width = 800;
            var left = ( screen.width - width ) / 2;
            var top = ( screen.height - height ) / 2;
            var newWindow = window.open( url, "Center Window", 'resizable = yes, width=' + width + ', height=' + height + ', top='+ top + ', left=' + left);
        }
    </script>

@endsection
