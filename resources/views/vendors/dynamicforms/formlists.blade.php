@extends('vendors.layouts.app')
@section('admin-title')
    Dynamic Forms
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
        <h3 class="page-title">All Dynamic Forms</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/vendor/home') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page"> Forms </li>
            </ol>
        </nav>
        </div>

        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="custon-table-header">
                        <h4 class="card-title">Dynamic Forms </h4>
                    </div>
                    <div class="table-responsive">
                      <table class="table table-bordered" id="category-table">
                        <thead>
                          <tr>
                            <th class="text-wrap">SN</th>
                            <th class="text-wrap">Name</th>
                            <th class="text-wrap">Form Applicants</th>
                          </tr>
                        </thead>
                        <tbody>
                          @php($i=1)
                            @foreach($categories as $cat)
                          <tr>
                            <td class="text-wrap" width="50">{{$i}}</td>
                            <td class="text-wrap">{{ucwords($cat->name)}}</td>
                            <td class="text-wrap classroom-btn" width="200"><a href="/vendor/dynamic-forms/{{$cat->id}}/applicants" class="btn btn-info">Applicants</a></td>
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

