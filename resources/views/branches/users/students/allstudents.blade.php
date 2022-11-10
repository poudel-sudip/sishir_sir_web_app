@extends('branches.layouts.app')
@section('admin-title')
    All Students
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">All Users</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/branch/home') }}">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">All Students</li>
              </ol>
          </nav>
        </div>  
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="custon-table-header">
                            <h4 class="card-title">All Students</h4>
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
                                        <th>Action</th>
                                    </tr>
                                </thead>       
                                <tbody>
                                    @foreach($students as $user)
                                    <tr>
                                        <td>{{$user->id ?? ''}}</td>
                                        <td>{{$user->name ?? ''}}</td>
                                        <td>{{$user->email ?? ''}}</td>
                                        <td>{{$user->contact ?? ''}}</td>
                                        <td>{{$user->provience ?? ''}}</td>
                                        <td>{{$user->district_city ?? ''}}</td>
                                        <td class="classroom-btn" width="160">
                                            <a href="/branch/all-students/{{$user->id}}/edit" class="btn btn-info">Edit</a>
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
