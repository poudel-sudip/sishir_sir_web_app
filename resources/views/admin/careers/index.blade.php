@extends('admin.layouts.app')
@section('admin-title')
    Careers
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">All Career Vaccancies</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Careers</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="custon-table-header">
                            <h4 class="card-title">Careers / Vaccancies</h4>
                            <div class="text-right">
                                <a href="{{ ('/admin/careers/create') }}"><button type="button" class="btn btn-sm ml-3 btn-success"> Add Vaccancy </button></a>

                            </div>
                        </div>
                        <div class="table-responsive table-responsive-md">
                            <table class="table table-bordered" id="table-courses">
                                <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Title</th>
                                    <th>Applicants</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php($i=1)
                                @foreach($vaccancies as $vaccancy)
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td>{{$vaccancy->title}}</td>
                                        <td><a href="/admin/careers/{{$vaccancy->id}}/applicants">Applicants({{$vaccancy->applicants->count() }})</a></td>
                                        <td>
                                            @if($vaccancy->status == 'Closed')
                                                <span class="text-danger">{{$vaccancy->status}}</span>
                                            @else
                                                <span class="text-success">{{$vaccancy->status}}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuOutlineButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Actions </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuOutlineButton1">
                                                    <a href="/admin/careers/{{$vaccancy->id}}" class="text-primary dropdown-item">Show</a>
                                                    <a href="/admin/careers/{{$vaccancy->id}}/edit" class="text-danger dropdown-item">Edit</a>
                                                    <form id="delete-form-{{$vaccancy->id}}" action="/admin/careers/{{$vaccancy->id}}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <a href="javascript:{}" onclick="javascript:deleteData({{$vaccancy->id}});" class="text-warning dropdown-item">Delete</a>
                                                    </form>
                                                </div>
                                            </div>
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
