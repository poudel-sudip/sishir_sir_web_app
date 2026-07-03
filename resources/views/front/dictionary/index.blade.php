@extends('front.layouts.app')

@section('page_title', 'Health Dictionary')
@section('og-title', 'Health Dictionary')
@section('og-url', url('/health-dictionary'))

@section('content')
    <div class="container-fluid px-md-5">
        <div class="row">
            <div class="col-md-12 etutor-breadcrumb text-center">
                <div class="text-center">
                    <h3 class="dchl-title fs-3"> Health Dictionary </h3>
                </div>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="{{ ('/') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Dictionary</li>
                    </ol>
                </div>
            </div>
        </div>
        
        <div class="mb-3">
            <div class="row align-items-center">
                <div class="col-md-6 align-self-center">
                    <div class="d-flex align-items-center flex-wrap">
                        <span class="mx-3 h6 text-info text-nowrap"><i class="fa fa-eye"></i> {{$counterData->page_view_count ?? '1'}}</span>
                        <span class="mx-3 h6 text-danger text-nowrap"><i class="fa fa-share"></i> {{$counterData->page_share_count ?? '0'}}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="sharethis-inline-share-buttons" onclick="handleShare(event)"></div>
                </div>
            </div>
        </div>

        <div class="my-2">
            <div class="row justify-content-end align-items-center">
                <div class="col-8 col-lg-4 col-xl-3">
                    <div class="d-flex align-items-center gap-1">
                        <label for="dictionary_search"><b>Search:</b></label>
                        <input type="text" class="form-control dictionary_search border-primary" id="dictionary_search">
                    </div>
                </div>
            </div>
            <div id="dictionary_loading" class="text-center my-3" style="font-weight:bold; display:none;">
                <i class="fa fa-spinner fa-spin"></i> Searching...
            </div>
            <div class="mt-2" id="dictionary_container">
                @foreach ($dictionary as $row)
                    <div class="mb-2">
                        <div class=""><strong>{{$row->name}}</strong></div>
                        <div class="">{!!$row->description!!}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <script>
        function handleShare(event)
        {
            let pageURL = getPageURLWithoutProtocol();
            const postData = { type: 'share', page: 'Health Dictionary',pageurl: pageURL };
            postDataWithFetch('/page-counter-increment', postData);
        }

        $().ready(function(){
            let container = $('#dictionary_container');
            let search = $('#dictionary_search');
            let loading = $('#dictionary_loading');
            let debounceTimer;

            search.on('input',function(){
                let query = $(this).val();
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(function () {
                    fetchData(query);
                }, 500); // 1-second delay
            });

            function fetchData(query)
            {
                loading.show();
                container.empty();
                fetch(`/health-dictionary/search?query=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(response => {
                    loading.hide();

                    if (response.success) {
                        container.html(`<div class="mb-2 text-primary"><strong class="text-center">${response.message}</strong></div>`);

                        response.data.forEach(item => {
                            container.append(`
                                <div class="mb-2">
                                    <div class=""><strong>${item.name}</strong></div>
                                    <div class="">${item.description}</div>
                                </div>
                            `);
                        });
                    } else {
                        container.html(`<p class="text-center">${response.message}</p>`);
                    }
                })
                .catch(error => {
                    loading.hide();
                    console.error(error);
                    container.html('<p class="text-danger text-center">Something went wrong.</p>');
                });
            }
        });
    </script>

@endsection
