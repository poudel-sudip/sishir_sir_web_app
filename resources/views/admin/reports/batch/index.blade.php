@extends('admin.layouts.app')
@section('admin-title')
   Batch Reports
@endsection

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">Batch Reports</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/admin/reports') }}">Reports</a></li>
            <li class="breadcrumb-item active" aria-current="page">Batch Reports</li>
            </ol>
        </nav>
    </div> 
    <div class="row reports">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Batch Report</h4>
                    <p class="card-description">Generate Booking Report of the Batch:</p>
                    <ul class="list-ticked">
                        @foreach($batches as $batch)
                        <li>{{$batch->name}} 
                            <a href="/admin/reports/batch/{{$batch->id}}/all" class="btn btn-primary">All</a>
                            <a href="/admin/reports/batch/{{$batch->id}}/pending" class="btn btn-info">Pending</a>
                            <a href="/admin/reports/batch/{{$batch->id}}/verified" class="btn btn-success">Verified</a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
