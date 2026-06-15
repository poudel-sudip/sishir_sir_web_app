@extends('admin.layouts.app')
@section('admin-title')
  Vision Page
@endsection

@section('content')
  <div class="content-wrapper">
    <div class="page-header">
      <h3 class="page-title">Vision Page</h3>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
          <li class="breadcrumb-item active" aria-current="page">Vision Page</li>
        </ol>
      </nav>
    </div> 
    <div class="text-center">
      <a href="{{ ('/admin/web-pages/about') }}"><button type="button" class="btn btn-sm ml-3 btn-outline-primary"> About Page </button></a>
      <a href="{{ ('/admin/web-pages/policy') }}"><button type="button" class="btn btn-sm ml-3 btn-outline-primary"> Policy Page </button></a>
      <a href="{{ ('/admin/web-pages/vision') }}"><button type="button" class="btn btn-sm ml-3 btn-outline-primary acticve"> Vision Page </button></a>
      <a href="{{ ('/admin/web-pages/contact') }}"><button type="button" class="btn btn-sm ml-3 btn-outline-primary"> Contact Page </button></a>
    </div>
    <div class="row">
      <div class="col-md-12 stretch-card grid-margin">
        <div class="card">
          <div class="card-body">
            <div class="custon-table-header">
              <h4 class="card-title">Vision Page</h4>
              <div class="text-right">
                <a href="/admin/web-pages/vision/edit"><button type="button" class="btn btn-sm ml-3 btn-warning"> Edit Page </button></a>
              </div>
            </div> 
            <hr>
            <div class="">
              {!! $page->description !!}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
