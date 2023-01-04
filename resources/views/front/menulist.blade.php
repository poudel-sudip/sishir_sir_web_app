@extends('front.layouts.app')

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
    <div class="container">
        <div class="blog-container mt-5">
            <ul>
                @forelse($menuItems as $item)
                    <li>
                        <h6>{{$item->name}}</h6> 
                        <div>
                            @if($item->type == 'text')  
                                <a href="/{{$mainMenu->slug}}/{{$subMenu->slug}}/{{$item->slug}}">View Details</a>
                            @else()
                                <a href="/storage/{{$item->fileurl}}" target="_blank">Download</a>
                            @endif
                        </div>
                    </li>
                @empty              
                    <div>No Menu Items Published</div>
                @endforelse
            </ul>
        </div>
    </div>

@endsection
