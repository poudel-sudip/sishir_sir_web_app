@extends('front.layouts.app')

@section('page_title', 'Health Days')
@section('og-title', 'Health Days')
@section('og-url', url('/health-days'))

@section('content')

    {{-- <style>
        .health-year {
            margin: 8px 0;
            text-align: end;
            padding: 0 5px 0 25px;
        }
        .health-year a {
            background: #fff;
            padding: 2px 5px;
            border-radius: 5px;
            border-bottom: 3px solid #db3545;
            
        }
        .health-year a:hover, .health-year a.active {
            background: #c3e0f3;
        }
        
    </style> --}}

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
            
            <div class="lib-filter-alphabets ">
                <span class="category-filter lib-filter-character active" charfil="all"> All </span>
                @foreach($healthCategories as $cat)
                    <span class="category-filter lib-filter-character" charfil='{{$cat->id}}'> {{ $cat->name }} </span>
                @endforeach
            </div>  
            
            <div class="mt-2 " id="data-content">                   

            </div>
        </div>
        
    </div>

    <script>
        const healthDays = {!! $healthDays !!};
        displayContent(healthDays);

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
            contentDiv.innerHTML = '';

            dataDays.forEach(cat => {
                const dataElement = document.createElement('div');
                dataElement.classList.add('my-2','d-flex','justify-content-between','align-items-center');
                const innerHTML = `
                    <div class="p-1 rounded bg-info  text-center text-nowrap">
                        ${cat.date}
                    </div>
                    <div class="rounded border border-info p-1" style="width: 100%;">
                        <a href="/health-days/show/${cat.id}">${cat.title}</a>
                    </div>                    
                `;
                dataElement.innerHTML = innerHTML;
                contentDiv.appendChild(dataElement);
            });
                      
        }

    </script>


@endsection
