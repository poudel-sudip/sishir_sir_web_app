@extends('admin.layouts.app')
@section('admin-title')
    Show Branch
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Show Branch</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="/admin/home">Dashboard</a></li>
                  <li class="breadcrumb-item"><a href="/admin/branches">Branches</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Show</li>
              </ol>
          </nav>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">View {{$branch->name}} details</div>
                    <div class="card-body">
                        <div class="course-row">
                            <div>User ID:</div>
                            <div>{{$branch->user->id ?? ''}}</div>
                        </div>
                        <div class="course-row">
                            <div>Branch ID:</div>
                            <div>{{$branch->id}}</div>
                        </div>
                        <div class="course-row">
                            <div>Full Name:</div>
                            <div>{{$branch->name}}</div>
                        </div>
                        <div class="course-row">
                            <div>Email:</div>
                            <div>{{$branch->user->email ?? ''}}</div>
                        </div>
                        <div class="course-row">
                            <div>Contact:</div>
                            <div>{{$branch->user->contact ?? ''}}</div>
                        </div>
                        <div class="course-row">
                            <div>Description:</div>
                            <div>{!! $branch->description !!}</div>
                        </div>
                        <div class="course-row">
                            <div>Image:</div>
                            <div><img src="/storage/{{$branch->user->photo ?? ''}}" height="50" alt=""></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
