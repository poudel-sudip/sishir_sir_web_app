@extends('front.layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 etutor-breadcrumb text-center">
                <h2>Forms</h2>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                      <li class="breadcrumb-item"><a href="/">Home</a></li>
                      <li class="breadcrumb-item active" aria-current="page">Forms</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="public-exam-section">
            <div class="row">
                @foreach($forms as $form)
                <div class="col-md-6"> 
                    <div class="public-result-list"><span class="icon-checkmark1 text-success"></span> <a href="/forms/{{$form->slug}}"> {{ucwords($form->name)}} </a></div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection