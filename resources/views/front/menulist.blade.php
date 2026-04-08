@extends('front.layouts.app')

@section('page_title', ($menuCategory->name))
@section('og-title', ($menuCategory->name))
@section('og-url', url('/'.$mainMenu->id.'/'.$subMenu->id.'/'.$menuCategory->id))
@section('og-description', strip_tags($menuCategory->description) ? strip_tags(str_replace('<', '  <', $menuCategory->description)) : $menuCategory->name )
@if($menuCategory->thumbnail)
@section('og-image', asset('/storage/'.$menuCategory->thumbnail))
@endif

@section('content')
    <div class="container-fluid px-md-5">
        <div class="row">
            <div class="col-md-12 etutor-breadcrumb text-center">
                @if($menuCategory->type == 'heading')
                    <div class="text-center">
                        <h3 class="dchl-title fs-3">{{($menuCategory->name)}}</h3>
                    </div>
                @endif
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item">{{($mainMenu->name)}}</li>
                        <li class="breadcrumb-item"><a href="/{{$mainMenu->id}}/{{$subMenu->id}}">{{($subMenu->name)}}</a></li>
                        {{-- <li class="breadcrumb-item active" aria-current="page">{{($menuCategory->name)}}</li> --}}
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid px-md-5 ">
        
        @if($menuCategory->type != 'heading')
        
            <div class="blog-container ">
                <div class="text-center">
                    <h3 class="dchl-title fs-3">{{($menuCategory->name)}}</h3>
                </div>

                <div class="mt-3">
                    <span class="mx-2 text-primary"><i class="fa fa-calendar-alt"></i> {{$menuCategory->created_at->format('d M, Y, h:i A')}}</span>
                    <span class="mx-2 text-danger"><i class="fa fa-share"></i> {{$counterData->page_share_count ?? '0'}}</span>
                    <span class="mx-2 text-info"><i class="fa fa-eye"></i> {{$counterData->page_view_count ?? '1'}}</span>
                    <span class="mx-2 text-primary">
                        <span class="text-danger"> {{$counterData->page_download_count ?? '0'}} <i class="fa fa-download"></i>  </span>
                        @if($menuCategory->type == 'file' && $menuCategory->download)
                            <a href="/storage/{{$menuCategory->fileurl}}" filename="{{($menuCategory->name)}}" onclick="handleDownload(event)" target="_blank" class="text-primary">  Download <i class="fa fa-file-pdf text-danger"></i> ({{ $menuCategory->size ?? 'undefined' }}) </a>
                        @endif
                    </span>
                </div>

                <div class="mb-4 row align-items-center justify-content-end">
                    <div class="col-md-6"><div class="sharethis-inline-share-buttons" onclick="handleShare(event)"></div></div>
                </div>  

                @if($menuCategory->type == 'file')
                    <div class="mt-4">
                        
                        <div class="_df_book" id="pdf_book_df" source="/storage/{{$menuCategory->fileurl}}" ></div>

                        {{-- <div class="pdf-container" id="pdf-container" style="max-height:800px;overflow-y: scroll;"></div> --}}
                        {{-- <iframe src="/storage/{{$menuCategory->fileurl}}" 
                            frameborder="0" 
                            style="width: 100%; min-height:700px" 
                            target="_parent">
                        </iframe> --}}
                    </div>
                @endif

                <div class="my-4">
                    {!! $menuCategory->description !!}
                </div>

                <div class="mt-3">
                    <div><strong>Author(s)/Publisher(s): </strong>  {{$menuCategory->author ? (html_entity_decode('&copy;')."  ".$menuCategory->author) : ""}} </div>    
                </div>

            </div>
        @else
            <div class="table-responsive table-responsive-md ">
                <table class="table table-bordered asc-data-table table-hover table-striped border-primary">
                    <thead>
                        <tr class="" style="background:#0C2B64;color:#ffffff;">
                            <th>SN</th>
                            <th>Title</th>
                            <th>View</th>
                            {{-- <th>Share</th> --}}
                        </tr>
                    </thead>
                    <?php 
                        $menuItems = $menuCategory->items()->where('status','=','Active')->orderBy('order')->orderByDesc('id')->get(['id','name','slug']); 
                        $i = 1;
                    ?>

                    <tbody>
                        @forelse($menuItems as $item)
                            
                            <tr>
                                <td>{{$i}}</td>
                                <td> <a href="/{{$mainMenu->id}}/{{$subMenu->id}}/{{$menuCategory->id}}/{{$item->id}}">{{$item->name}}</a></td>
                                <td width="50"><a href="/{{$mainMenu->id}}/{{$subMenu->id}}/{{$menuCategory->id}}/{{$item->id}}"><i class="fas fa-eye text-success"></i></a></td>
                                {{-- <td style="max-width: 50px">
                                    <div class="d-inline post-share-option">
                                        @php($shareLink = url($mainMenu->id.'/'.$subMenu->id.'/'.$menuCategory->id.'/'.$item->id))
                                        <a href="javascript:void();" onclick="createPopupWin('//facebook.com/sharer/sharer.php?u={{$shareLink}}&t={{$item[`name`]}}')"><i class="fab fa-facebook-f"></i></a>
                                        <a href="javascript:void();" onclick="createPopupWin('//twitter.com/intent/tweet?text={{$item[`name`]}}&url={{$shareLink}}')"><i class="fab fa-twitter"></i></a>
                                        <a href="javascript:void();" onclick="createPopupWin('//wa.me/?text={{$shareLink}}')"><i class="fab fa-whatsapp"></i></a>
                                        <a href="javascript:void();" onclick="createPopupWin('//pinterest.com/pin/create/button/?url={{$shareLink}}')"><i class="fab fa-pinterest-p"></i></a>
                                    </div>
                                </td> --}}
                            </tr>
                            
                            @php($i++)
                        @empty              
                            <tr><td colspan="3">No Menu Items Published</td></tr>
                        @endforelse
                    </tbody>
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
            backgroundColor: "#0C2B64",
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
        load_pdf_reader("/storage/{{$menuCategory->fileurl}}");
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
            const postData = { type: 'download', page: 'Menu Category',pageurl: pageURL };
            postDataWithFetch('/page-counter-increment', postData);
        }

        function handleShare(event){
            let pageURL = getPageURLWithoutProtocol();
            const postData = { type: 'share', page: 'Menu Category',pageurl: pageURL };
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

    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.7/css/dataTables.bootstrap5.min.css">
    <script defer src="https://cdn.datatables.net/2.3.7/js/dataTables.min.js"></script>

    <script>
        let dataTableInstance = null;

        function initDataTable() {

            if (typeof $.fn.DataTable === 'undefined') {
                console.warn('DataTables not loaded yet');
                return;
            }

            if (!$.fn.DataTable.isDataTable('.asc-data-table')) {
                $('.asc-data-table').DataTable({
                    paging: false,
                    info: false,
                    searching: false,
                    order: [[0, 'asc']]
                });
            }
        }

        function destroyDataTable() {
            if ($.fn.DataTable.isDataTable('.asc-data-table')) {
                $('.asc-data-table').DataTable().destroy();
            }
        }

        $('.asc-data-table').on('click', function() {
            initDataTable();
        });
        
    </script>

@endsection
