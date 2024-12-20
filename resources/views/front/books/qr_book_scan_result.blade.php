@extends('front.layouts.app')

@section('page_title', ($book->title))
@section('og-title', ($book->title))
@section('og-url', url('/qr-book-scans/'.$book->id))
@section('og-description', strip_tags($book->description) ? strip_tags(str_replace('<', '  <', $book->description)) : $book->title )
@if($book->thumbnail)
@section('og-image', asset('/storage/'.$book->thumbnail))
@endif

@section('content')
    <div class="container-fluid px-md-5">
        <div class="row">
            <div class="col-md-12 etutor-breadcrumb text-center">
                <h2>{{($book->title)}}</h2>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="{{ ('/') }}">Home</a></li>
                        <li class="breadcrumb-item">QR Book Scan Result</li>
                        <li class="breadcrumb-item active" aria-current="page">{{($book->title)}}</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="blogs-details-container ebook-section" style="background:transparent">            
            <div class="ebook-page-details">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6 book-details">
                                <h2 class="text-center">{{($book->title)}}</h2>
                                <div class="text-center">
                                    <img src="/storage/{{$book->thumbnail}}" onerror="this.src='{{asset('images/default-post.png')}}'" class="img img-fluid">                                
                                </div>     
                                <hr>
                                <h6>
                                    Publisher: <strong class="text-primary"> {{($book->category->publisher->name ?? ' ')}} </strong>
                                </h6>
                                <h6>
                                    Category: <strong class="text-primary"> {{($book->category->name ?? ' ')}} </strong>
                                </h6>
                                <h6>
                                    Author(s): <strong class="text-primary"> {{($book->author ?? ' ')}} </strong>
                                </h6>
                                <h6>
                                    Edition: <strong class="text-primary"> {{($book->edition ?? ' ')}} </strong>
                                </h6>                               
                                <h6>
                                    Published On: <strong class="text-primary"> {{($book->published_year ?? ' ')}} </strong>
                                </h6>                               
                                                        
                            </div>

                            <div class="col-md-6 border border-2 rounded p-3">
                                
                                <div class="alert alert-{{$status == 'won' ? 'success' : 'danger' }}">
                                    {!! $message !!}    
                                </div>                          
                                
                            </div>
                        </div>
                    </div>                    
                </div>      
            </div>     
            

        </div>
    </div>    


@endsection 
