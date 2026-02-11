@extends('student.layouts.app')
@section('student-title')
    Latest Vacancies
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

            <h2 class="text-center mt-3 text-primary">Vacancies</h2>

            <div class="text-end mb-2">
                <a href="/student/vaccancies/create" class="btn btn-success">Submit Your New Vacancy <i class="fa fa-paint-brush"></i> </a>
            </div>

            {{-- <div class="my-2">
                <div class="lib-filter-alphabets justify-content-center">
                    <a href="/student/vaccancies" class="lib-filter-character active" > All </a>
                    @foreach ($tag_categories as $tag)
                        <a href="/student/vaccancies-tag/{{$tag->id}}" class="lib-filter-character" > {{$tag->name}} </a>
                    @endforeach                    
                </div>                  
            </div> --}}

            <nav class="my-2">
                <div class="d-flex align-items-center justify-content-center footer-imp-link">
                    <div class="swiper-button-prev"></div>
                    <div class="swiper category-swiper nav nav-tabs">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <a href="/student/vaccancies"> <button class="nav-link border active">All</button> </a>
                            </div>
                            @foreach($tag_categories as $tag)
                                <div class="swiper-slide">
                                    <a href="/student/vaccancies-tag/{{$tag->id}}"> <button class="nav-link border">{{$tag->name}}</button> </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="swiper-button-next"></div>
                </div>
            </nav>

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
                    <div class="text-center">No Vacancies Published......</div>
                @endforelse
            </div>
            <div class="mt-2">
                {{$vaccancies->onEachSide(1)->links('paginator.bootstrap')}}
            </div>
        </div>
    </div>

@endsection

@section('page-footer-content')
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {

            const categorySwipers  = document.querySelectorAll('.category-swiper');
            categorySwipers.forEach(el => {

                // const nextBtn = el.querySelector('.swiper-button-next');
                // const prevBtn = el.querySelector('.swipSer-button-prev');
                const prevBtn = el.previousElementSibling;
                const nextBtn = el.nextElementSibling;

                new Swiper(el, {
                slidesPerView: "auto",
                // spaceBetween: 8,
                freeMode: true,
                grabCursor: true,
                navigation: {
                    nextEl: nextBtn,
                    prevEl: prevBtn,
                }
                });

                const tabButtons = el.querySelectorAll('.nav-link');
                tabButtons.forEach(button => {
                button.addEventListener('click', function () {
                    tabButtons.forEach(btn => {
                    btn.classList.remove('active');
                    btn.setAttribute('aria-selected', 'false');
                    });

                    this.classList.add('active');
                    this.setAttribute('aria-selected', 'true');
                });
                });
            });

        });
    </script>
    
@endsection
