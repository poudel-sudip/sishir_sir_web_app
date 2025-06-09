@extends('front.layouts.app')

@section('page_title', 'Health Days')
@section('og-title', 'Health Days')
@section('og-url', url('/health-days'))

@section('content')

    <style>
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
        
    </style>

    <div class="container-fluid px-md-5">
        <div class="row">
            <div class="col-md-12 etutor-breadcrumb text-center">
                <h2>Health Days of {{ $year }}</h2>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="{{ ('/') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="/health-days/year/{{$year}}">{{$year}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Health Days</li>
                    </ol>
                </div>
            </div>
        </div>        
        
        <div class="d-flex justify-content-between">
            <div class="py-1 px-1 rounded" style="background: #1374ba;">
                @foreach($healthYears as $y)                    
                    <div class="health-year">
                        <a href="/health-days/year/{{$y}}" class="{{ $year == $y ? 'active' : '' }} " style="">{{ $y }}</a>
                    </div>
                @endforeach
            </div>
            <div class="border border-primary rounded" style="width: 100%;">

                <div class="lib-filter-alphabets ">
                    <span class="lib-filter-character active" charfil="0"> All </span>
                    @for($i=1;$i<=12;++$i)
                        <span class="lib-filter-character" charfil='{{$i}}'> {{date('M', mktime(0, 0, 0, $i, 1))}} </span>
                    @endfor
                </div>  
                
                <div class="mt-2 p-2 px-md-5" id="data-content">                   

                </div>
            </div>
        </div>
        
    </div>

    <script>
        const healthDays = {!! $healthDays !!};
        displayContent(healthDays);

        $('.lib-filter-character').on('click',function(e){
            filchar = $(this).attr('charfil');
            $('.lib-filter-character').removeClass('active');
            $(this).addClass('active');
            
            if(filchar == '0')
            {
                displayContent(healthDays); 
            }
            else
            {
                filterContent(filchar);
            }
        });
        
        function filterContent(month) {
            const fmonth = month.padStart(2, '0'); 
            const filtered = healthDays.filter(day => {
                const dateMonth = day.date.slice(5, 7);
                return dateMonth == fmonth;
            });
            displayContent(filtered);
        }

        function displayContent(dataDays) {
            const contentDiv = document.getElementById('data-content');
            contentDiv.innerHTML = '';

            dataDays.forEach(cat => {

                const dateObj = new Date(cat.date);
                const dateOptions = { month: 'short', day: '2-digit' };
                const formattedDate = dateObj.toLocaleDateString('en-US', dateOptions);
                const dataElement = document.createElement('div');
                dataElement.classList.add('my-2','d-flex','justify-content-between','align-items-center');
                const innerHTML = `
                    <div class="p-1 rounded bg-info  text-center text-nowrap">
                        ${formattedDate}
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
