@extends('admin.layouts.app')
@section('admin-title')
    Vendor Students | {{ucwords($vendor->name)}}
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Students | {{ucwords($vendor->name)}} </h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin/home">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="/admin/vendor">Vendor</a></li>
                <li class="breadcrumb-item active" aria-current="page">Students</li>
              </ol>
          </nav>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="custon-table-header">
                            <h4 class="card-title">Students | {{ucwords($vendor->name)}}</h4>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="tutor-table">
                                <thead>
                                    <tr>
                                        <th>ID | User ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Contact</th>
                                        <th>Provience</th>
                                        <th>District/City</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                        <tr>
                                            <td class="text-wrap">{{$user->id}} | {{$user->user->id ?? ''}}</td>
                                            <td class="text-wrap">{{$user->user->name ?? ''}}</td>
                                            <td class="text-wrap">{{$user->user->email ?? ''}}</td>
                                            <td class="text-wrap">{{$user->user->contact ?? ''}}</td>
                                            <td class="text-wrap">{{$user->user->provience ?? ''}}</td>
                                            <td class="text-wrap">{{$vendor->user->district_city ?? ''}}</td>
                                            <td class="text-wrap">{{$vendor->user->status ?? ''}}</td>
                                            
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
