@extends('admin.layouts.app')
@section('admin-title')
    {{$chapter->name}} | {{$book->title}}
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Show {{$chapter->name}} | {{$book->title}}</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/ebook/books') }}">E-Books</a></li>
                <li class="breadcrumb-item"><a href="/admin/ebook/books/{{$book->id}}/chapters">Chapters</a></li>
                <li class="breadcrumb-item active" aria-current="page">Show</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{$chapter->name}} | {{$book->title}}</div>
                    <div class="card-body">
                        <div class="course-row">
                            <div>Chapter ID:</div>
                            <div>{{$chapter->id}}</div>
                        </div>
                        <div class="course-row">
                            <div>Chapter Name:</div>
                            <div>{{$chapter->name}} :- {{$chapter->title}}</div>
                        </div>
                        <div class="course-row">
                            <div>Chapter Slug: </div>
                            <div>{{$chapter->slug}}</div>
                        </div>
                        <div class="course-row">
                            <div>Book Name: </div>
                            <div>{{$book->title}}</div>
                        </div>
                        <div class="course-row">
                            <div>Chapter Status: </div>
                            <div>{{$chapter->status}}</div>
                        </div>
                        <div class="course-row">
                            <div>Chapter PDF: </div>
                            <div>
                                <iframe src="/storage/{{$chapter->pdf_file}}" frameBorder="0" scrolling="auto" height="600" width="100%"></iframe>
                                {{-- <object data="/storage/{{$chapter->pdf_file}}" type="application/pdf" width="100%" height="600">
                                    alt : <a href="/storage/{{$chapter->pdf_file}}">pdf</a>
                                </object> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
