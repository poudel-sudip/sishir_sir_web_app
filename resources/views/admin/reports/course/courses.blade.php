@extends('admin.layouts.app')
@section('admin-title')
   Course Reports
@endsection

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">All Course Reports</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/admin/reports') }}">Reports</a></li>
            <li class="breadcrumb-item"><a href="/admin/reports/course">Course Reports</a></li>
            <li class="breadcrumb-item active" aria-current="page">Generate</li>
            </ol>
        </nav>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="custon-table-header">
{{--                        <h4 class="card-title">All Course Reports</h4>--}}
                        <a href="/admin/reports/course/all/export">Download</a>
                    </div>
                    <div class="report">
                        @foreach($categories as $category)
                            <div class="mb-5">
                                <h4 class="text-center">{{$category->name}}</h4>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>SN</th>
                                            <th>Course Name</th>
                                            <th>Course Slug</th>
                                            <th>Is Popular</th>
                                            <th>Status</th>
                                            <th>Created On</th>
                                            <th>Modified On</th>
                                        </tr>
                                        @php($i=1)
                                        @forelse($category->courseReport as $course)
                                            <tr>
                                                <td>{{$i}}</td>
                                                <td>{{$course->course}}</td>
                                                <td>{{$course->slug}}</td>
                                                <td>{{$course->isPopular}}</td>
                                                <td>{{$course->status}}</td>
                                                <td>{{$course->created_at}}</td>
                                                <td>{{$course->updated_at}}</td>
                                            </tr>
                                            @php($i++)
                                        @empty
                                            <tr><td colspan="7" class="text-center">No Courses Found</td></tr>
                                        @endforelse
                                    </table>
                                </div>

                            </div>
                            <hr class="border-warning">
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
