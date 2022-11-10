@extends('vendors.layouts.app')
@section('admin-title')
    Covered Area Users
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Covered Area Users</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/vendor/home') }}">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Covered Area Users</li>
              </ol>
          </nav>
        </div>  
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="">
                            <h4 class="h4 text-center">Covered Area Users </h4>
                            <div class="h6">Covered Area : {{$coverageArea}}</div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="user-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Full Name</th>
                                        <th>Email</th>
                                        <th>Contact</th>
                                        <th>Provience</th>
                                        <th>District/City</th>
                                        <th class="text-wrap">Interested Courses</th>
                                        <th class="text-wrap">Register Date</th>
                                        <th class="text-wrap">Last Login</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>       
                                <tbody>
                                    @foreach($users as $user)
                                    <tr>
                                        <td>{{$user->id ?? ''}}</td>
                                        <td class="text-wrap">{{$user->name ?? ''}}</td>
                                        <td class="text-wrap">{{$user->email ?? ''}}</td>
                                        <td class="text-wrap">{{$user->contact ?? ''}}</td>
                                        <td class="text-wrap">{{$user->provience ?? ''}}</td>
                                        <td class="text-wrap">{{$user->district_city ?? ''}}</td>
                                        <td class="text-wrap">{{$user->interests ?? '-'}}</td>
                                        <td class="text-wrap">{{date("Y-m-d",strtotime($user->created_at))}}</td>
                                        <td class="text-wrap">{{ $user->last_login ?? '----' }}</td>
                                        
                                        <td class="classroom-btn">
                                            <a href="/vendor/provience-users/{{$user->id}}" class="btn btn-primary">Show</a>
                                            <a href="/vendor/provience-users/{{$user->id}}/edit" class="btn btn-warning">Edit</a>
                                        </td>
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
