@extends('front.layouts.app')

@section('page_title', 'Library: '.($library_category->name))
@section('og-title', ($library_category->name))
@section('og-url', url('/library/'.$library_category->id))
@section('og-description', strip_tags($library_category->name) ? strip_tags(str_replace('<', '  <', $library_category->name)) : $library_category->name )

@section('content')
<style>
    .single-blog p, .single-blog .blog-description span {
    overflow: visible !important;
    text-overflow: unset !important;
    -webkit-line-clamp: unset !important;
}
</style>
    <div class="container-fluid px-md-5">
        <div class="row">
            <div class="col-md-12 etutor-breadcrumb text-center">
                <h2>{{($library_category->name)}}</h2>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="{{ ('/') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ ('/library') }}">Library</a></li>
                        {{-- <li class="breadcrumb-item active" aria-current="page">{{($library_category->name)}}</li> --}}

                        @if($library_category)
                            @php 
                            $cur = $library_category;
                            $bcm = [];
                            while($cur)
                            {
                            $c = (object)[
                                'name' => $cur->name,
                                'link' => '/library/'.$cur->id,
                            ];
                            array_push($bcm,$c);
                            $cur = $cur->parent;
                            } 
                            $bcm = array_reverse($bcm);
                            @endphp

                            @foreach($bcm as $b)
                            <li class="breadcrumb-item"><a href="{{$b->link}}">{{($b->name)}}</a></li>
                            @endforeach

                        @endif
                    </ol>
                </div>
            </div>
        </div>
    </div>

    @if($directories->count())
    <div class="container-fluid px-md-5">
        <div class="lib-filter-alphabets">
            <span class="lib-filter-character active" charfil="all"> All </span>
            @for($i='A';$i<'Z';$i++)
                <span class="lib-filter-character" charfil='{{$i}}'> {{$i}} </span>
            @endfor
            <span class="lib-filter-character" charfil='Z'> Z </span>
        </div>        
    </div>
    @endif

    <div class="container-fluid px-md-5">
        <div class="blog-container mt-5">
            <div class="row" id="library_categories_list">
                @foreach($directories as $dir)
                <div class="col-md-3 mb-3">
                    <div class="single-blog text-center py-3 library-item border border-primary">
                        <div class="">
                            <a href="/library/{{$dir->id}}"><i class="h1 fa fa-folder"></i></a>
                        </div>
                        <h5><a href="/library/{{$dir->id}}">{{($dir->name)}}</a></h5>
                    </div>
                </div>
                @endforeach

                @foreach($library_materials as $material)
                <div class="col-md-4 mb-2">
                    <div class="py-3 px-2 border border-primary border-2">
                        <div class="text-center">
                            {{-- <img src="/storage/{{$material->thumbnail}}" onerror="this.src='{{asset('images/default-post.png')}}'" class="img img-fluid" style="max-height:150px"> --}}
                            <h1><a href="/library/{{$library_category->id}}/{{$material->id}}"><i class="fa fa-file-pdf text-danger"></i></a></h1>
                            <h5><strong><a href="/library/{{$library_category->id}}/{{$material->id}}">{{($material->name)}}</a> </strong></h5>
                        </div>
                        <div class="text-justify">
                            <div><strong>Author(s):</strong> {{$material->author}}</div>
                            <div><strong>Published On:</strong> {{$material->published_year}}</div>
                            <div><strong>Pages:</strong> {{$material->pages}}</div>
                            <div>{{$material->description}}</div>
                        </div>
                    </div>
                </div>
                @endforeach

                @if(!$directories->count() && !$library_materials->count())
                    <div>No Materials Published</div>
                @endif

            </div>
        </div>
    </div>

    <script>
        const libraryCategories = {!! $js_lib_categories !!};

        $('.lib-filter-character').on('click',function(e){
            filchar = $(this).attr('charfil');
            $('.lib-filter-character').removeClass('active');
            $(this).addClass('active');
            
            if(filchar == 'all')
            {
                displayCategories(libraryCategories); 
            }
            else
            {
                filterCategories(filchar);
            }
        });
        
        function filterCategories(letter) {
            const lowerCaseLetter = letter.toLowerCase();
            const filtered = libraryCategories.filter(category => category.name.toLowerCase().startsWith(lowerCaseLetter));
            displayCategories(filtered);
        }

        function displayCategories(categories) {
            const categoriesDiv = document.getElementById('library_categories_list');
            categoriesDiv.innerHTML = '';
            categories.forEach(cat => {
                const categoryElement = document.createElement('div');
                categoryElement.classList.add('col-md-3','mb-3');
                const innerHTML = `
                    <div class="single-blog text-center py-3 library-item border border-primary">
                        <div class="">
                            <a href="/library/${cat.id}"><i class="h1 fa fa-folder"></i></a>
                        </div>
                        <h5><a href="/library/${cat.id}">${cat.name}</a></h5>
                    </div>
                `;
                categoryElement.innerHTML = innerHTML;
                categoriesDiv.appendChild(categoryElement);
            });

        }
    </script>
@endsection
