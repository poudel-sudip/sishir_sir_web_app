@extends('front.layouts.app')

@section('page_title', ucwords($menuCategory->name))
@section('og-title', ucwords($menuCategory->name))
@section('og-url', url('/'.$mainMenu->slug.'/'.$subMenu->slug.'/'.$menuCategory->slug))
@section('og-description', strip_tags($menuCategory->description) ? strip_tags(str_replace('<', '  <', $menuCategory->description)) : $menuCategory->name )
@if($menuCategory->thumbnail)
@section('og-image', asset('/storage/'.$menuCategory->thumbnail))
@endif

@section('content')
    <div class="container-fluid px-md-5">
        <div class="row">
            <div class="col-md-12 etutor-breadcrumb text-center">
                <h2>{{ucwords($menuCategory->name)}}</h2>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item">{{ucwords($mainMenu->name)}}</li>
                        <li class="breadcrumb-item"><a href="/{{$mainMenu->slug}}/{{$subMenu->slug}}">{{ucwords($subMenu->name)}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ucwords($menuCategory->name)}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid px-md-5 ">
        
        @if($menuCategory->type != 'heading')
        
            <div class="blog-container ">
                <h3 class="text-primary">{{strtoupper($menuCategory->name)}}</h3>
                <div class="px-5">
                    <span class="mx-2 text-primary"><i class="fa fa-pen"></i> {{date('Y-m-d',strtotime($menuCategory->created_at))}}</span>
                    <span class="mx-2 text-info"><i class="fa fa-eye"></i> {{$counterData->page_view_count ?? '1'}}</span>
                    <span class="mx-2 text-primary"><i class="fa fa-download"></i> {{$counterData->page_download_count ?? '0'}}</span>
                    <span class="mx-2 text-danger"><i class="fa fa-share"></i> {{$counterData->page_share_count ?? '0'}}</span>
                </div>

                <div class="my-4 row align-items-center">
                    <div class="col-md-4">
                        @if($menuCategory->type == 'file' && $menuCategory->download)
                        <a href="/storage/{{$menuCategory->fileurl}}" filename="{{ucwords($menuCategory->name)}}" onclick="handleDownload(event)" target="_blank" class="text-primary"> <i class="fa fa-download"></i>  Download</a>
                        @endif
                    </div>
                    <div class="col-md-8"><div class="sharethis-inline-share-buttons" onclick="handleShare(event)"></div></div>
                </div>

                @if($menuCategory->type == 'file')
                    <div class="mt-4">
                        <div class="pdf-container" id="pdf-container" style="max-height:800px;overflow-y: scroll;"></div>
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
                        $menuItems = $menuCategory->items()->where('status','=','Active')->orderByDesc('id')->get(['id','name','slug']); 
                        $i = 1;
                    ?>

                    @forelse($menuItems as $item)
                        <tbody>
                            <tr>
                                <td>{{$i}}</td>
                                <td>{{$item->name}}</td>
                                <td width="50"><a href="/{{$mainMenu->slug}}/{{$subMenu->slug}}/{{$menuCategory->slug}}/{{$item->slug}}"><i class="fas fa-eye text-success"></i></a></td>
                                {{-- <td style="max-width: 50px">
                                    <div class="d-inline post-share-option">
                                        @php($shareLink = url($mainMenu->slug.'/'.$subMenu->slug.'/'.$menuCategory->slug.'/'.$item->slug))
                                        <a href="javascript:void();" onclick="createPopupWin('//facebook.com/sharer/sharer.php?u={{$shareLink}}&t={{$item[`name`]}}')"><i class="fab fa-facebook-f"></i></a>
                                        <a href="javascript:void();" onclick="createPopupWin('//twitter.com/intent/tweet?text={{$item[`name`]}}&url={{$shareLink}}')"><i class="fab fa-twitter"></i></a>
                                        <a href="javascript:void();" onclick="createPopupWin('//wa.me/?text={{$shareLink}}')"><i class="fab fa-whatsapp"></i></a>
                                        <a href="javascript:void();" onclick="createPopupWin('//pinterest.com/pin/create/button/?url={{$shareLink}}')"><i class="fab fa-pinterest-p"></i></a>
                                    </div>
                                </td> --}}
                            </tr>
                        </tbody>
                        @php($i++)
                    @empty              
                        <div>No Menu Items Published</div>
                    @endforelse
                </table>
            </div>
        @endif
        
    </div>

    <script src="{{asset('/js/pdf.min.js') }}"></script>
    <script src="{{asset('/js/pdf.worker.min.js') }}"></script>
    <script src="{{asset('/js/pdf_reader.js') }}"></script>
    <script>
        load_pdf_reader("/storage/{{$menuCategory->fileurl}}");

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
@endsection
