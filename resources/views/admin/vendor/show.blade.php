@extends('admin.layouts.app')
@section('admin-title')
    Show Vendor
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Show Vendor</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="/admin/home">Dashboard</a></li>
                  <li class="breadcrumb-item"><a href="/admin/vendor">Vendors</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Show</li>
              </ol>
          </nav>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">View {{$vendor->name}} details</div>
                    <div class="card-body">
                        <div class="course-row">
                            <div>User ID:</div>
                            <div>{{$vendor->user->id ?? ''}}</div>
                        </div>
                        <div class="course-row">
                            <div>Vendor ID:</div>
                            <div>{{$vendor->id}}</div>
                        </div>
                        <div class="course-row">
                            <div>Full Name:</div>
                            <div>{{$vendor->name}}</div>
                        </div>
                        <div class="course-row">
                            <div>Email:</div>
                            <div>{{$vendor->user->email ?? ''}}</div>
                        </div>
                        <div class="course-row">
                            <div>Contact:</div>
                            <div>{{$vendor->user->contact ?? ''}}</div>
                        </div>
                        <div class="course-row">
                            <div>Vendor Discount:</div>
                            <div>{{$vendor->vendor_discount ?? '0'}}%</div>
                        </div>
                        <div class="course-row">
                            <div>Description:</div>
                            <div>{!! $vendor->description !!}</div>
                        </div>
                        <div class="course-row">
                            <div>Image:</div>
                            <div><img src="/storage/{{$vendor->user->photo ?? ''}}" height="50" alt=""></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
