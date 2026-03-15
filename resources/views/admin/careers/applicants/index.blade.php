@extends('admin.layouts.app')
@section('admin-title')
    Vaccancy Applicants
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Vaccancy Applications</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/admin/careers') }}">Carrers</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Applicants</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <h4 class="card-title">Applications | {{$vaccancy->title}}</h4>
                        </div>
                        <div class="table-responsive table-responsive-md">
                            <table class="table table-bordered" id="advanced-desc-table">
                                <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Action</th>
                                    <th>Date</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Contact</th>
                                    <th>Qualification</th>
                                    <th>Post</th>
                                    <th>Remarks</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php($i=1)
                                @foreach($applicants as $data)
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuOutlineButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Actions </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuOutlineButton1">
                                                    <a href="/admin/careers/{{$vaccancy->id}}/applicants/{{$data->id}}" class="text-primary dropdown-item">Show</a>
                                                    <a href="/admin/careers/{{$vaccancy->id}}/applicants/{{$data->id}}/edit" class="text-warning dropdown-item">Edit</a>
                                                    <form id="delete-form-{{$data->id}}" action="/admin/careers/{{$vaccancy->id}}/applicants/{{$data->id}}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <a href="javascript:{}" onclick="javascript:deleteData({{$data->id}});" class="text-danger dropdown-item">Delete</a>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{date('Y-m-d',strtotime($data->created_at))}}</td>
                                        <td>{{$data->name}}</td>
                                        <td>{{$data->email}}</td>
                                        <td>{{$data->contact}}</td>
                                        <td>{{$data->qualification}}</td>
                                        <td>{{$data->post_name}}</td>
                                        <td class="text-wrap">{!! $data->remarks !!}</td>
                                        
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
