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

    <div class="container-fluid px-md-5">
        <div class="lib-filter-alphabets hidden">
            <span class="lib-filter-character active" charfil="all"> All </span>
            @for($i='A';$i<'Z';$i++)
                <span class="lib-filter-character" charfil='{{$i}}'> {{$i}} </span>
            @endfor
            <span class="lib-filter-character" charfil='Z'> Z </span>
        </div>        
    </div>

    <div class="container-fluid px-md-5">
        <div class="d-flex justify-content-start align-items-center mb-3" id="toggle_view_button">
            <span class="me-2">View Type:</span>
            <button id="gridViewBtn" class="btn btn-outline-primary btn-sm mx-1 active" title="Grid View">
                <i class="fa fa-th"></i>
            </button>
            <button id="listViewBtn" class="btn btn-outline-primary btn-sm mx-1" title="List View">
                <i class="fa fa-list"></i>
            </button>
        </div>
    </div>

    <div class="container-fluid px-md-5">
        <div class="blog-container mt-5">
            <div class="row" id="library_categories_list" showType="grid">                                           

            </div>
        </div>
    </div>

    <script>
        const libraryCategories = {!! $js_lib_categories !!};
        const libraryMaterials = {!! $js_lib_materials !!};

        if(!libraryCategories.length && !libraryMaterials.length)
        {
            document.getElementById('library_categories_list').innerHTML = '<div>No Materials Published</div>';
        }
        else if(libraryCategories.length){
            $('.lib-filter-alphabets').removeClass('hidden');
            displayCategories(libraryCategories);

        } else if(libraryMaterials.length) {
            displayMaterials(libraryMaterials);
        } else {}
        

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
            const showType = categoriesDiv.getAttribute('showType');
            categoriesDiv.innerHTML = '';

            if(showType=='grid') {
                categories.forEach(cat => {
                    const categoryElement = document.createElement('div');
                    categoryElement.classList.add('col-md-3','mb-3');
                    const innerHTML = `
                        <div class="single-blog text-center py-3 library-item border border-primary">
                            <div class="">
                                <a href="/library/${cat.id}"><i class="h1 fa fa-folder"></i></a>
                            </div>
                            <h5><a href="/library/${cat.id}">${cat.name} <small style="color:red;"> (${cat.active_materials} Files) </small> </a></h5>
                        </div>
                    `;
                    categoryElement.innerHTML = innerHTML;
                    categoriesDiv.appendChild(categoryElement);
                });
                
            } else if(showType == 'list'){
                const tableDiv = document.createElement('div');
                tableDiv.classList.add('table-responsive', 'table-responsive-md');
                const table = document.createElement('table');
                table.classList.add('table', 'table-bordered');

                const thead = document.createElement('thead');
                thead.innerHTML = `
                    <tr>
                        <th style="width:60px;">#</th>
                        <th>Category Name</th>
                        <th>Files</th>
                        <th>Action</th>
                    </tr>
                `;
                table.appendChild(thead);

                const tbody = document.createElement('tbody');
                categories.forEach((cat, idx) => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>${idx + 1}</td>
                        <td><a href="/library/${cat.id}">${cat.name}</a></td>
                        <td>${cat.active_materials}</td>
                        <td><a href="/library/${cat.id}" class="btn btn-primary btn-sm">View</a></td>
                    `;
                    tbody.appendChild(tr);
                });
                
                table.appendChild(tbody);
            
                tableDiv.appendChild(table);
                categoriesDiv.appendChild(tableDiv);
            } else { }
            

        }
        
        function displayMaterials(materials) {
            const materialsDiv = document.getElementById('library_categories_list');
            const showType = materialsDiv.getAttribute('showType');
            materialsDiv.innerHTML = '';

            if(showType=='grid') {
                materials.forEach(mat => {
                    const materialElement = document.createElement('div');
                    materialElement.classList.add('col-md-4','mb-2');
                    const innerHTML = `
                       <div class="py-3 px-2 border border-primary border-2">
                            <div class="text-center">
                                <h1><a href="/library/{{$library_category->id}}/${mat.id}"><i class="fa fa-file-pdf text-danger"></i></a></h1>
                                <h5><strong><a href="/library/{{$library_category->id}}/${mat.id}">${mat.name}</a> </strong></h5>
                            </div>
                            <div class="text-justify">
                                <div><strong>Author(s):</strong> ${mat.author}</div>
                                <div><strong>Published On:</strong> ${mat.published_year}</div>
                                <div><strong>Pages:</strong> ${mat.pages}</div>
                                <div>${mat.description}</div>
                            </div>
                        </div>
                    `;
                    materialElement.innerHTML = innerHTML;
                    materialsDiv.appendChild(materialElement);
                });
                
            } else if(showType == 'list'){
                const tableDiv = document.createElement('div');
                tableDiv.classList.add('table-responsive', 'table-responsive-md');
                const table = document.createElement('table');
                table.classList.add('table', 'table-bordered');

                const thead = document.createElement('thead');
                thead.innerHTML = `
                    <tr>
                        <th style="width:60px;">#</th>
                        <th>Material Name</th>
                        <th>Author(s)</th>
                        <th>Published On</th>
                        <th>Pages</th>
                        <th style="width:75px;">Action</th>
                    </tr>
                `;
                table.appendChild(thead);

                const tbody = document.createElement('tbody');
                materials.forEach((mat, idx) => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>${idx + 1}</td>
                        <td class="text-wrap"><a href="/library/{{$library_category->id}}/${mat.id}">${mat.name}</a></td>
                        <td>${mat.author}</td>
                        <td>${mat.published_year}</td>
                        <td>${mat.pages}</td>
                        <td><a href="/library/{{$library_category->id}}/${mat.id}" class="btn btn-primary btn-sm">View</a></td>
                    `;
                    tbody.appendChild(tr);
                });
                
                table.appendChild(tbody);
            
                tableDiv.appendChild(table);
                materialsDiv.appendChild(tableDiv);
            } else { }
            

        }
    </script>

    <script>
        $('#gridViewBtn').on('click', function() {
            $(this).addClass('active');
            $('#listViewBtn').removeClass('active');
            $('#library_categories_list').attr('showType','grid');

            if(libraryCategories.length){
                const filterChar = $('.lib-filter-character.active').attr('charfil');
                if(filterChar == 'all')
                {
                    displayCategories(libraryCategories); 
                }
                else
                {
                    filterCategories(filterChar);
                }
            } else if(libraryMaterials.length) {
                displayMaterials(libraryMaterials);
            } else {}
            
        });

        $('#listViewBtn').on('click', function() {
            $(this).addClass('active');
            $('#gridViewBtn').removeClass('active');
            $('#library_categories_list').attr('showType','list');

            if(libraryCategories.length){
                const filterChar = $('.lib-filter-character.active').attr('charfil');
                if(filterChar == 'all')
                {
                    displayCategories(libraryCategories); 
                }
                else
                {
                    filterCategories(filterChar);
                }
            } else if(libraryMaterials.length) {
                displayMaterials(libraryMaterials);
            } else {}
        });

        
    </script>

@endsection
