@extends('front.layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 etutor-breadcrumb text-center">
                <h2>Public Exams</h2>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="/public-exams">Public Exams</a></li>
                      <li class="breadcrumb-item active" aria-current="page">Success</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="about-page">
        <div class="container">
            <div class="public-exam-section">
                <div class="row">
                    <div class="col-md-12">
                        @if('status')
                        <div class="alert alert-success" role="alert">
                            Hey <strong>{{$result->name}}</strong>, Your exam has been successfully submitted. You can view your result once it is published.
                            <br>
                            Your ID is <strong>{{$result->id}} </strong>. Keep your ID safe to view your result once published.
                        </div>
                        @endif
                        <div class="row">
                            <div class="col-md-6">
                                Name: {{$result->name}} <br>
                                Email: {{$result->email}} <br>
                                ID: {{$result->id}} <br>
                            </div>
                            <div class="col-md-6 text-end"><a href="/public-exams" class="btn btn-primary btn-sm">View Other Exams</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection