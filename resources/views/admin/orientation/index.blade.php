@extends('admin.layouts.app')
@section('admin-title')
    Orientations
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">All Orientation Classes</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Orientations</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="custon-table-header">
                            <h4 class="card-title">Free Orientation Classes</h4>
                            <div class="text-right">
                                <a href="{{ ('/admin/orientations/create') }}"><button type="button" class="btn btn-sm ml-3 btn-success"> Add Orientation </button></a>

                            </div>
                        </div>
                        <div class="table-responsive table-responsive-md">
                            <table class="table table-bordered" id="table-courses">
                                <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Course</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Participants</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php($i=1)
                                @foreach($orientations as $ori)
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td>{{ucwords($ori->course)}}</td>
                                        <td>{{$ori->date}}</td>
                                        <td>{{date("g:i a",strtotime($ori->time))}}</td>
                                        <td> <a href="/admin/orientations/{{$ori->id}}/participants">Show ( {{$ori->participants->count()}} ) </a> </td>
                                        <td>
                                            <span class="text-{{ $ori->status == "Active" ? 'success' : 'danger' }}">{{$ori->status}}</span>
                                        </td>
                                        <td class="classroom-btn" width="100">
                                            <a href="/admin/orientations/{{$ori->id}}" class="btn btn-info">Show</a>
                                            <a href="/admin/orientations/{{$ori->id}}/edit" class="btn btn-warning">Edit</a>
                                            <form id="delete-form-{{$ori->id}}" action="/admin/orientations/{{$ori->id}}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <a href="javascript:{}" onclick="javascript:deleteData({{$ori->id}});" class="btn btn-danger">Delete</a>
                                            </form>
                                            
                                        </td>
                                    </tr>
                                    @php($i++)
                                @endforeach
                                </tbody>
                            </table>
                            <script type="text/javascript">
                                function deleteData(id)
                                {
                                    Swal.fire({
                                    title: 'Are you sure?',
                                    text: "You won't be able to revert this!",
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Yes, delete it!'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                        document.getElementById('delete-form-'+id).submit();
                                        Swal.fire(
                                            'Deleted!',
                                            'Your file has been deleted.',
                                            'success'
                                        )
                                        }
                                    })
                                }
                            </script>
                            <hr>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
