@extends('front.layouts.app')
@section('page_title', 'Library')
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
                <h2>Digital Library</h2>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                      <li class="breadcrumb-item"><a href="{{ ('/') }}">Home</a></li>
                      <li class="breadcrumb-item active" aria-current="page">Library</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid px-md-5">
        <div class="lib-filter-alphabets">
            <span class="lib-filter-character  {{$filterchar=='all'?'active':''}} " charfil="all"> All </span>
            @for($i='A';$i<'Z';$i++)
                <span class="lib-filter-character {{strtoupper($filterchar) == $i ? 'active':''}} " charfil='{{$i}}'> {{$i}} </span>
            @endfor
            <span class="lib-filter-character {{strtoupper($filterchar) == 'Z' ? 'active':''}} " charfil='Z'> Z </span>
        </div>        
    </div>

    <div class="container-fluid px-md-5">
        <div class="blog-container mt-5">
            <div class="row" id="library_categories_list">
                
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

    @if($filterchar == 'all')
        <script> displayCategories(libraryCategories); </script>
    @else
        <script> 
            var filchar = '{{$filterchar}}';
            filterCategories(filchar); 
        </script>
    @endif
    
@endsection
