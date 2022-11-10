@extends('admin.layouts.app')
@section('admin-title')
    Course Features
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Course Features</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/courses') }}">Courses</a></li>
                <li class="breadcrumb-item active" aria-current="page">Features</li>
                </ol>
            </nav>
        </div> 
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                      <div class="custon-table-header">
                          <h4 class="card-title">Course Features</h4>
                          <div class="text-right">
                                @if(auth()->user()->permission>=20)
                                <a href="/admin/courses/{{$course->id}}/features/create"><button type="button" class="btn btn-sm ml-3 btn-success"> Add Feature </button></a>
                                @endif
                          </div>
                      </div>
                      <div class="table-responsive">
                        <table class="table table-bordered">
                          <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Icon</th>
                                <th>Unique Feature</th>
                                <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                              @foreach($course->features as $feature)
                            <tr>
                                <td>{{$feature->id}}</td>
                                <td>{{$feature->title}}</td>
                                <td><img src="/storage/{{$feature->image}}" style="max-height: 40px;max-width:40px " ></td>
                                <td>{{$feature->isunique}}</td>
                                <td width="270">
                                    <a href="/admin/courses/{{$course->id}}/features/{{$feature->id}}" class="btn btn-primary btn-sm">Show</a>
                                    @if(auth()->user()->permission>=20)
                                    <a href="/admin/courses/{{$course->id}}/features/{{$feature->id}}/edit" class="btn btn-danger btn-sm">Edit</a>
                                    <form id="delete-form-{{$feature->id}}" action="/admin/courses/{{$course->id}}/features/{{$feature->id}}" method="POST" style="display: inline">
                                        @csrf
                                        @method('DELETE')
                                        <a href="javascript:{}" onclick="javascript:deleteData({{$feature->id}});" class="btn btn-warning btn-sm">Delete</a>
                                    </form>
                                    @endif
                                </td>
                            </tr>
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
