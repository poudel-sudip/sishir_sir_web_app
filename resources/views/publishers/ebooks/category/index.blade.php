@extends('publishers.layouts.app')
@section('admin-title')
    E-Book Categories
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
        <h3 class="page-title">All E-Book Categories</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/publisher/home') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">E-Book Categories </li>
            </ol>
        </nav>
        </div>

        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="custon-table-header">
                        <h4 class="card-title">E-Book Categories Lists</h4>
                        <div class="text-right">
                            <a href="{{ ('/publisher/ebooks/categories/create') }}"><button type="button" class="btn btn-sm ml-3 btn-success"> Add Category </button></a>
                        </div>
                    </div>
                    <div class="table-responsive">
                      <table class="table table-bordered" id="category-table">
                        <thead>
                          <tr>
                            <th>SN</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Order</th>
                            <th>Status</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          @php($i=1)
                          @foreach($categories as $cat)
                          <tr>
                            <td>{{$i}}</td>
                            <td>{{$cat->name}}</td>
                            <td>{{$cat->slug}}</td>
                            <td>{{$cat->order}}</td>
                            <td><span class='text-{{$cat->status == "Active" ? "success" : "danger"}}'>{{$cat->status}}</span></td>
                            <td class="classroom-btn" width="150">
                              <a href="/publisher/ebooks/categories/{{$cat->id}}/edit" class="btn btn-warning">Edit</a>
                              <a href="/publisher/ebooks/categories/{{$cat->id}}/books" class="btn btn-primary">E-Books</a>
                            </td>
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

