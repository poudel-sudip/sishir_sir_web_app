@extends('admin.layouts.app')
@section('admin-title')
    Show EPS Registration
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Show EPS Registration</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/eps-registration') }}">EPS Registration</a> </li>
                <li class="breadcrumb-item active" aria-current="page">Show</li>
                </ol>
            </nav>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Show EPS Registration Details</div>
                    <div class="card-body">
                        <div class="course-row">
                            <div>ID:</div>
                            <div>{{$korea->id}}</div>
                        </div>
                        <div class="course-row">
                            <div>Full Name:</div>
                            <div>{{$korea->fname}}</div>
                        </div>
                        <div class="course-row">
                            <div>Contact No:</div>
                            <div>{{$korea->mobile}}</div>
                        </div>
                        <div class="course-row">
                            <div>Email:</div>
                            <div>{{$korea->email}}</div>
                        </div>
                        <div class="course-row">
                            <div>Sector:</div>
                            <div>{{$korea->sector}}</div>
                        </div>
                        <div class="course-row">
                            <div>Sub Sector:</div>
                            <div>{{$korea->subsector}}</div>
                        </div>
                        <div class="course-row">
                            <div>korea Status:</div>
                            <div>{{$korea->status}}</div>
                        </div>
                        {{-- <div class="course-row">
                            <div>Remarks:</div>
                            <div>{{$korea->remarks}}</div>
                        </div> --}}
                        <div class="eps-images-show row">
                            <div class="col-md-4">
                                <h6>Photo:</h6>
                                <a href="/storage/{{$korea->photo}}" target="_blank">
                                    <img src="/storage/{{$korea->photo}}" class="w-100 img img-responsive">
                                </a>
                            </div>
                            <div class="col-md-8">
                                <h6>passport:</h6>
                                <a href="/storage/{{$korea->passport}}" target="_blank">
                                    <img src="/storage/{{$korea->passport}}" class="w-100 img img-responsive">
                                </a>
                            </div>
                            <div class="col-md-8">
                                <h6>Payment Slip:</h6>
                                <a href="/storage/{{$korea->payment_slip}}" target="_blank">
                                    <img src="/storage/{{$korea->payment_slip}}" class="w-100 img img-responsive">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
