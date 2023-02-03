@extends('front.layouts.app')

@section('page_title', ucwords($subMenu->name))
@section('og-title', ucwords($subMenu->name))
@section('og-url', url('/'.$mainMenu->slug.'/'.$subMenu->slug))
@section('og-description', strip_tags($subMenu->description) ? strip_tags(str_replace('<', '  <', $subMenu->description)) : $subMenu->name )
@if($subMenu->thumbnail)
@section('og-image', asset('/storage/'.$subMenu->thumbnail))
@endif

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 etutor-breadcrumb text-center">
                <h2>{{ucwords($subMenu->name)}}</h2>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="{{ ('/') }}">Home</a></li>
                        <li class="breadcrumb-item">{{ucwords($mainMenu->name)}}</li>
                        <li class="breadcrumb-item active" aria-current="page">{{ucwords($subMenu->name)}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="container mb-5">
        
        @if($subMenu->type != 'heading')
            <div class="blog-container mt-5">
                <h4 class="mb-2">{{$subMenu->name}}</h4>
                <div>
                    {!! $subMenu->description !!}
                </div>

                <div class="my-4 row align-items-center">
                    @if($subMenu->type == 'file')
                    <div class="col-md-4">
                        <a href="/storage/{{$subMenu->fileurl}}" target="_blank" download class="text-primary"> <i class="fa fa-download"></i>  Download</a>
                    </div>
                    @endif
                    <div class="col-md-8">
                        <div class="sharethis-inline-share-buttons"></div>
                    </div>
                </div>

                @if($subMenu->type == 'file')
                    <div class="mt-4">
                        <iframe src="/storage/{{$subMenu->fileurl}}" 
                            frameborder="0" 
                            style="width: 100%; min-height:700px" 
                            target="_parent">
                        </iframe>
                    </div>
                @endif
            </div>
        @else
            <div class="table-responsive table-responsive-md ">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>SN</th>
                            <th>Title</th>
                            <th>View</th>
                            <th>Share</th>
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
                                <td style="max-width: 50px">
                                    <div class="d-inline post-share-option">
                                        @php($shareLink = url($mainMenu->slug.'/'.$subMenu->slug.'/'.$cat->slug))
                                        <a href="javascript:void();" onclick="createPopupWin('//facebook.com/sharer/sharer.php?u={{$shareLink}}&t={{$cat[`name`]}}')"><i class="fab fa-facebook-f"></i></a>
                                        <a href="javascript:void();" onclick="createPopupWin('//twitter.com/intent/tweet?text={{$cat[`name`]}}&url={{$shareLink}}')"><i class="fab fa-twitter"></i></a>
                                        <a href="javascript:void();" onclick="createPopupWin('//wa.me/?text={{$shareLink}}')"><i class="fab fa-whatsapp"></i></a>
                                        <a href="javascript:void();" onclick="createPopupWin('//pinterest.com/pin/create/button/?url={{$shareLink}}')"><i class="fab fa-pinterest-p"></i></a>
                                    </div>
                                </td>
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
