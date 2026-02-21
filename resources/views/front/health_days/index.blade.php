@extends('front.layouts.app')

@section('page_title', 'Health Days')
@section('og-title', 'Health Days')
@section('og-url', url('/health-days'))

@section('content')

    <div class="container-fluid px-md-5">
        <div class="row">
            <div class="col-md-12 etutor-breadcrumb text-center">
                <h2>Health Days</h2>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="{{ ('/') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Health Days</li>
                    </ol>
                </div>
            </div>
        </div>        
        
        <div class="mb-4 p-4 border border-primary rounded">
            
            {{-- <div class="lib-filter-alphabets ">
                <span class="category-filter lib-filter-character active" charfil="all"> All </span>
                @foreach($healthCategories as $cat)
                    <span class="category-filter lib-filter-character" charfil='{{$cat->id}}'> {{ $cat->name }} </span>
                @endforeach
            </div>   --}}
            
            <nav class="mb-2">
                <div class="d-flex align-items-center justify-content-center footer-imp-link">
                    <div class="swiper-button-prev"></div>
                    <div class="swiper category-swiper nav nav-tabs">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <button class="category-filter nav-link border {{ $selectedCategoryId ? '' : 'active' }} " charfil="all">All</button>
                            </div>
                            @foreach($healthCategories as $cat)
                                <div class="swiper-slide">
                                   <button class="category-filter nav-link border {{ $selectedCategoryId == $cat->id ? 'active' : '' }}" charfil='{{$cat->id}}'>{{$cat->name}}</button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="swiper-button-next"></div>
                </div>
            </nav>

            <div class="container-fluid px-md-5">
                <div class="d-flex justify-content-start align-items-center mb-3" id="toggle_view_button">
                    <span class="me-2">View Type:</span>                    
                    <button id="listViewBtn" class="btn btn-outline-primary btn-sm mx-1 active" title="List View">
                        <i class="fa fa-list"></i>
                    </button>
                    <button id="gridViewBtn" class="btn btn-outline-primary btn-sm mx-1 " title="Grid View">
                        <i class="fa fa-th"></i>
                    </button>
                </div>
            </div>

            <div class="mt-2 " id="data-content" showType="list">                   
                @php($healthDaysData = json_decode($healthDays))
                @foreach ($healthDaysData as $day)
                    <div class="my-2 d-flex justify-content-between align-items-center">
                        <div class="p-1 rounded bg-info  text-center text-nowrap">
                            {{$day->date}}
                        </div>
                        <div class="rounded border border-info p-1" style="width: 100%;">
                            <a class="h6" href="/health-days/show/{{$day->id}}">{{$day->title}}</a>
                        </div>  
                    </div>
                @endforeach

                <div class="row align-items-stretch">
                    {{-- @foreach ($healthDaysData as $day)
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                            <div class="my-2">
                                <div class="text-center bg-info rounded p-1" style="width: 100%;">
                                    <a class="h6" href="/health-days/show/{{$day->id}}">{{$day->title}}</a>
                                </div> 
                                <div class="p-1 rounded border border-info text-center text-nowrap text-danger" >
                                    {{$day->date}}
                                </div>                                 
                            </div>
                        </div>                        
                    @endforeach  --}}
                </div>

            </div>
        </div>
        
    </div>

    <script>
        const healthDays = {!! $healthDays !!};
        // displayContent(healthDays);

        $('.category-filter').on('click',function(e){
            filchar = $(this).attr('charfil');
            $('.category-filter').removeClass('active');
            $(this).addClass('active');
            
            if(filchar == 'all')
            {
                displayContent(healthDays); 
            }
            else
            {
                filterContentByCategory(filchar);
            }
        });

        function filterContentByCategory(cat) {
            const filtered = healthDays.filter(day => day.category_id == cat);
            displayContent(filtered);
        }

        function displayContent(dataDays) {

            const contentDiv = document.getElementById('data-content');
            const showType = contentDiv.getAttribute('showType');
            contentDiv.innerHTML = '';

            if(showType == 'list') {
                dataDays.forEach(cat => {
                    const dataElement = document.createElement('div');
                    dataElement.classList.add('my-2','d-flex','justify-content-between','align-items-center');
                    const innerHTML = `
                        <div class="p-1 rounded bg-info  text-center text-nowrap">
                            ${cat.date}
                        </div>
                        <div class="rounded border border-info p-1" style="width: 100%;">
                            <a class="h6" href="/health-days/show/${cat.id}">${cat.title}</a>
                        </div>                    
                    `;
                    dataElement.innerHTML = innerHTML;
                    contentDiv.appendChild(dataElement);
                });
            } else if(showType == 'grid') {
                const container = document.createElement('div');
                container.classList.add('row','align-items-stretch');
                dataDays.forEach(cat => {
                    const dataElement = document.createElement('div');
                    dataElement.classList.add('col-12','col-sm-6','col-md-4','col-lg-3');
                    const innerHTML = `
                        <div class="my-2">
                            <div class="text-center bg-info rounded p-1" style="width: 100%;">
                                <a class="h6" href="/health-days/show/${cat.id}">${cat.title}</a>
                            </div> 
                            <div class="p-1 rounded border border-info text-center text-nowrap text-danger" >
                                ${cat.date}
                            </div>                                 
                        </div>                                                               
                    `;
                    dataElement.innerHTML = innerHTML;
                    container.appendChild(dataElement);
                });
                contentDiv.appendChild(container);
            } else {}
            
                      
        }

    </script>

    <script>
        $('#gridViewBtn').on('click', function() {
            $(this).addClass('active');
            $('#listViewBtn').removeClass('active');
            $('#data-content').attr('showType','grid');

            if(healthDays.length){
                const filterChar = $('.category-filter.active').attr('charfil');
                if(filterChar == 'all')
                {
                    displayContent(healthDays); 
                }
                else
                {
                    filterContentByCategory(filterChar);
                }
            } else {}
            
        });

        $('#listViewBtn').on('click', function() {
            $(this).addClass('active');
            $('#gridViewBtn').removeClass('active');
            $('#data-content').attr('showType','list');

            if(healthDays.length){
                const filterChar = $('.category-filter.active').attr('charfil');
                if(filterChar == 'all')
                {
                    displayContent(healthDays); 
                }
                else
                {
                    filterContentByCategory(filterChar);
                }
            } else {}
        });

        const preSelectedCategoryId = @json($selectedCategoryId);
        if(preSelectedCategoryId) {
            filterContentByCategory(preSelectedCategoryId);
        }
        
    </script>

@endsection
