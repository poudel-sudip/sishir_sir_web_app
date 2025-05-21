@extends('student.layouts.app')
@section('student-title')
    Latest Vaccancies
@endsection

@section('student-title-icon')
    <i class="fas fa-graduation-cap "></i>
@endsection

@section('content')

    <style>
        .hidden{
            display: none
        }
    </style>    

    <div class="container-fluid">
        <div class="blog-container mt-3">

            @if(session('alert_message'))
                <div class="alert alert-success" role="alert">
                    {{ session('alert_message') }}
                </div>
            @endif

            <h2 class="text-center mt-3 text-primary">Vaccancies</h2>

            <div class="text-end mb-2">
                <a href="/student/vaccancies/create" class="btn btn-success">Submit Your New Vacancy <i class="fa fa-paint-brush"></i> </a>
            </div>

            <div class="my-2 h6">
                <span><a href="/student/vaccancies" class="btn btn-sm btn-primary">All</a></span>
                @foreach ($tag_categories as $tag)
                    <span><a href="/student/vaccancies-tag/{{$tag->id}}" class="btn btn-sm btn-outline-primary">{{$tag->name}}</a></span>
                @endforeach
            </div>

            <div class="row">
                @forelse($vaccancies as $vaccancy)
                <div class="col-md-6 mb-2">
                    <div class="single-blog border border-primary rounded">
                        <div class="blog-image">
                            <a href="/student/vaccancies/{{$vaccancy->id}}"><img src="/storage/{{$vaccancy->thumbnail}}" class="img img-fluid"></a>
                        </div>
                        <div class="blog-details">
                            <h4 class="text-center"><a href="/student/vaccancies/{{$vaccancy->id}}">{{$vaccancy->title}}</a></h4>
                            <div class="blog-footer">
                                <div><i class="fa fa-user text-primary" aria-hidden="true"></i> <span class="text-success">{{$vaccancy->author}}</span></div>
                                <div class="text-end">Posted On: <span class="text-primary"> {{date('Y-m-d',strtotime($vaccancy->created_at))}}</span></div>
                            </div>
                        </div>
                    </div>
                </div>                
                @empty              
                    <div class="text-center">No Vaccancies Published......</div>
                @endforelse
            </div>
            <div class="mt-2">
                {{$vaccancies->onEachSide(1)->links('paginator.bootstrap')}}
            </div>
        </div>
    </div>

@endsection
