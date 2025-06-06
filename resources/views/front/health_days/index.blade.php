@extends('front.layouts.app')

@section('page_title', 'Health Days')
@section('og-title', 'Health Days')
@section('og-url', url('/health-days'))

@section('content')
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
        
        <div class="row">
            <div class="col-1">
                <div class="list-group">
                    @foreach($healthYears as $y)
                        <a href="/health-days/year/{{$y}}" class="list-group-item list-group-item-action {{ $year == $y ? 'active' : '' }}">
                            {{ $y }}
                        </a>
                    @endforeach
                </div>
            </div>
            <div class="col-11">
                @foreach ($healthDays as $row)
                    <a class="d-block" href="/health-days/show/{{$row->id}}" >
                        <div class="d-flex">
                            <div class="mx-1">{{ date('M d', strtotime($row->date)) }}</div>
                            <div class="mx-1">{{ $row->title }}</div>
                        </div>
                    </a>
                    
                @endforeach                
            </div>
        </div>
    </div>

    

@endsection
