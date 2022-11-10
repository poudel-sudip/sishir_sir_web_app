@extends('admin.layouts.app')
@section('admin-title')
    Tutor Reports
@endsection

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">Tutor Reports</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/admin/reports') }}">Reports</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tutor Reports</li>
            </ol>
        </nav>
    </div> 
    <div class="row reports">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Tutor Reports</h4>
                <ul class="list-ticked">
                    <li>All Tutors Report <a href="/admin/reports/tutor/all" class="btn btn-warning">Generate</a></li>
                </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Tutor Batches Report</h4>
                    <ul class="list-arrow">
                    @foreach($tutors as $tutor)
                    <li>{{$tutor->name}}<a href="/admin/reports/tutor/{{$tutor->id}}/batches" class="btn btn-info">Generate</a></li>
                    @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
