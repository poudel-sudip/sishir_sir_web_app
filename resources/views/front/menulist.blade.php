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
    <div class="container mb-5">
        <div class="row">
            <div class="col-md-8">
                <div class="table-responsive table-responsive-md">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>SN</th>
                                <th>Title</th>
                                <th>File</th>
                            </tr>
                        </thead>
                        
                        @php($i=1)
                        @forelse($menuItems as $item)
                        <tbody>
                            <tr>
                                <td>{{$i}}</td>
                                <td>{{$item->name}}</td>
                                <td>
                                    @if($item->type == 'text')  
                                        <a href="/{{$mainMenu->slug}}/{{$subMenu->slug}}/{{$item->slug}}"><i class="fas fa-eye text-success"></i></a>
                                    @else()
                                        <a href="/storage/{{$item->fileurl}}" target="_blank"><i class="fas fa-file-pdf text-danger"></i></a>
                                    @endif
                            </td>
                            </tr>
                        </tbody>
                        @php($i++)
                    @empty              
                    <div>No Menu Items Published</div>
                @endforelse
                    </table>
                </div>
            </div>
        </div>
        {{-- <div class="blog-container mt-5">
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
        </div> --}}
    </div>

@endsection
