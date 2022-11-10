@extends('front.layouts.app')
@section('title')
  Study Materials
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 etutor-breadcrumb text-center">
                <h2>Study Materials</h2>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                      <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                      <li class="breadcrumb-item active" aria-current="page">Study Materials</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="container syllabus-study-page">
        <div class="row">
            <div class="col-md-12">
                <div class="study-materials">
                    @foreach ($meterials as $data)
                        <div><a href="/storage/{{$data->filePath}}" target="_blank"><span class="icon-file-pdf"></span> {{ $data->title }}</a></div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection