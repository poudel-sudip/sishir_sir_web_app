@extends('front.layouts.app')
@section('page_title', 'eLibrary')
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
                <h2>eLibrary</h2>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                      <li class="breadcrumb-item"><a href="{{ ('/') }}">Home</a></li>
                      <li class="breadcrumb-item active" aria-current="page">eLibrary</li>
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

            initDataTable();
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
                table.classList.add('table', 'table-bordered','asc-data-table','table-hover','table-striped','border-primary');

                const thead = document.createElement('thead');
                thead.innerHTML = `
                    <tr class="" style="background:#1375b9;color:#ffffff;">
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

    </script>

    @if($filterchar == 'all')
        <script> displayCategories(libraryCategories); </script>
    @else
        <script> 
            var filchar = '{{$filterchar}}';
            filterCategories(filchar); 
        </script>
    @endif

    <script>
        $('#gridViewBtn').on('click', function() {
            $(this).addClass('active');
            $('#listViewBtn').removeClass('active');
            $('#library_categories_list').attr('showType','grid');

            const filterChar = $('.lib-filter-character.active').attr('charfil');
            if(filterChar == 'all')
            {
                displayCategories(libraryCategories); 
            }
            else
            {
                filterCategories(filterChar);
            }

            destroyDataTable();
        });

        $('#listViewBtn').on('click', function() {
            $(this).addClass('active');
            $('#gridViewBtn').removeClass('active');
            $('#library_categories_list').attr('showType','list');

            const filterChar = $('.lib-filter-character.active').attr('charfil');
            if(filterChar == 'all')
            {
                displayCategories(libraryCategories); 
            }
            else
            {
                filterCategories(filterChar);
            }

            initDataTable();
        });

        
    </script>
    
    <script defer src="{{ asset('admin/js/jquery.dataTables.min.js') }}"></script>

    <script>
        let dataTableInstance = null;

        function initDataTable() {
            if (typeof $.fn.DataTable === 'undefined') {
                console.warn('DataTables not loaded yet');
                return;
            }

            if (!$.fn.DataTable.isDataTable('.asc-data-table')) {
                $('.asc-data-table').DataTable({
                    paging: false,
                    info: false,
                    searching: false,
                    order: [[0, 'asc']]
                });
            }
        }

        function destroyDataTable() {
            if ($.fn.DataTable.isDataTable('.asc-data-table')) {
                $('.asc-data-table').DataTable().destroy();
            }
        }

    </script>

@endsection
