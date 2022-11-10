@extends('teams.layouts.app')
@section('admin-title')
    Admin Forms Followup Lists
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Followed Admin Forms Followup Lists</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/team/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/team/followup/followed') }}">Followed Followups</a></li>
                <li class="breadcrumb-item active" aria-current="page">Admin Forms</li>
              </ol>
          </nav>
        </div>  
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        
                        <div class="table-responsive">
                            <table class="table table-bordered" id="advanced-desc-table">
                                <thead>
                                    <tr>
                                        <th>SN</th>
                                        <th>Assigned Date</th>
                                        <th>Category</th>
                                        <th>Sub Category</th>
                                        <th>Total</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>       
                                <tbody>
                                    @php($i=1)
                                    @foreach($followups as $data)
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td class="text-wrap">{{$data->created_at ?? ''}}</td>
                                        <td class="text-wrap">{{$data->category->name ?? ''}}</td>
                                        <td class="text-wrap">{{$data->sub_category ?? ''}}</td>
                                        <td class="text-wrap">{{$data->total ?? ''}}</td>                                        
                                        <td class="classroom-btn" width="100"> <a href="/team/followup/followed/admin-forms/{{$data->id}}/applicants" class="btn btn-info"> View Followed</a> </td>
                                    </tr>
                                    @php($i++)
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
