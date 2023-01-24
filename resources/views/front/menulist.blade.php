@extends('front.layouts.app')
@section('page_title', ucwords($menuCategory->name))
@section('content')
    <div class="container">
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
    <div class="container mb-5">
        
        @if($menuCategory->type != 'heading')
            <div class="blog-container mt-5">
                <h5>{{$menuCategory->name}}</h5>
                <div>
                    {!! $menuCategory->description !!}
                </div>
                <div class="post-share-option" >
                    @php($shareLink = url($mainMenu->slug.'/'.$subMenu->slug.'/'.$menuCategory->slug))
                    <h6 class="text-primary my-2 d-inline-block">Share On: </h6>
                    <a target="_blank" href='//facebook.com/sharer/sharer.php?u={{$shareLink}}'><i class="fab fa-facebook-f"></i></a>
                    <a target="_blank" href='//twitter.com/intent/tweet?text="{{$menuCategory->name}}"&url="{{$shareLink}}"'><i class="fab fa-twitter"></i></a>
                    <a target="_blank" href='//reddit.com/submit?title="{{$menuCategory->name}}"&url="{{$shareLink}}"'><i class="fab fa-reddit-alien"></i></a>
                    <a target="_blank" href='//telegram.me/share/url?url="{{$shareLink}}"&text="{{$menuCategory->name}}"'><i class="fab fa-telegram-plane"></i></a>
                    <a target="_blank" href='//wa.me/?text="{{$shareLink}}"'><i class="fab fa-whatsapp"></i></a>
                    <a target="_blank" href='//linkedin.com/sharing/share-offsite?mini="true"&url="{{$shareLink}}"&title="{{$menuCategory->name}}"'><i class="fab fa-linkedin-in"></i></a>
                    <a target="_blank" href='//pinterest.com/pin/create/button/?url="{{$shareLink}}"'><i class="fab fa-pinterest-p"></i></a>
                </div>
                @if($menuCategory->type == 'file')
                    <div><a href="/storage/{{$menuCategory->fileurl}}" target="_blank" download class="text-primary"> <i class="fa fa-download"></i>  Download</a></div>
                    <div class="mt-4">
                        <iframe src="/storage/{{$menuCategory->fileurl}}" 
                            frameborder="0" 
                            style="width: 100%; min-height:500px" 
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
                        $menuItems = $menuCategory->items()->where('status','=','Active')->orderByDesc('id')->get(['id','name','slug']); 
                        $i = 1;
                    ?>

                    @forelse($menuItems as $item)
                        <tbody>
                            <tr>
                                <td>{{$i}}</td>
                                <td>{{$item->name}}</td>
                                <td width="50"><a href="/{{$mainMenu->slug}}/{{$subMenu->slug}}/{{$menuCategory->slug}}/{{$item->slug}}"><i class="fas fa-eye text-success"></i></a></td>
                                <td style="max-width: 50px">
                                    <div class="d-inline post-share-option">
                                        @php($shareLink = url($mainMenu->slug.'/'.$subMenu->slug.'/'.$menuCategory->slug.'/'.$item->slug))
                                        <a target="_blank" href='//facebook.com/sharer/sharer.php?u={{$shareLink}}'><i class="fab fa-facebook-f"></i></a>
                                        <a target="_blank" href='//twitter.com/intent/tweet?text="{{$item->name}}"&url="{{$shareLink}}"'><i class="fab fa-twitter"></i></a>
                                        {{-- <a target="_blank" href='//reddit.com/submit?title="{{$item->name}}"&url="{{$shareLink}}"'><i class="fab fa-reddit-alien"></i></a> --}}
                                        {{-- <a target="_blank" href='//telegram.me/share/url?url="{{$shareLink}}"&text="{{$item->name}}"'><i class="fab fa-telegram-plane"></i></a> --}}
                                        <a target="_blank" href='//wa.me/?text="{{$shareLink}}"'><i class="fab fa-whatsapp"></i></a>
                                        {{-- <a target="_blank" href='//linkedin.com/sharing/share-offsite?mini="true"&url="{{$shareLink}}"&title="{{$item->name}}"'><i class="fab fa-linkedin-in"></i></a> --}}
                                        <a target="_blank" href='//pinterest.com/pin/create/button/?url="{{$shareLink}}"'><i class="fab fa-pinterest-p"></i></a>
                                    </div>
                                </td>
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

@endsection
