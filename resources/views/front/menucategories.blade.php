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
        
        @if($subMenu->type != 'heading')
            <div class="blog-container mt-5">
                <h5>{{$subMenu->name}}</h5>
                <div>
                    {!! $subMenu->description !!}
                </div>
                @if($subMenu->type == 'file')
                    <div><a href="/storage/{{$subMenu->fileurl}}" target="_blank" download class="text-primary"> <i class="fa fa-download"></i>  Download</a></div>
                    <div class="mt-4">
                        <iframe src="/storage/{{$subMenu->fileurl}}" 
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
                                <td><a href="/{{$mainMenu->slug}}/{{$subMenu->slug}}/{{$cat->slug}}"><i class="fas fa-eye text-success"></i></a> </td>
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

@endsection
