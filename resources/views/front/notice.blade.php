@extends('front.layouts.app')
@section('title')
  Notice
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 etutor-breadcrumb text-center">
            <h2>Notice</h2>
            <div aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center">
                  <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Notice</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="public-exam-section">
        <div class="row">
            <div class="col-md-3">
                <div class="notice-card"><a class="nav-link" href="/results">Exam Results</a></div>
            </div>
        </div>
    </div>
</div>
@endsection
