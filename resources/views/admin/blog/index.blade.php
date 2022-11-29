@extends('admin.layouts.app')
@section('admin-title')
    Blogs
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">All Blogs</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Blogs</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="custon-table-header">
                            <h4 class="card-title">Blogs table</h4>
                            <div class="text-right">
                                <a href="{{ ('/admin/blogs/create') }}"><button type="button" class="btn btn-sm ml-3 btn-success"> Add Blog </button></a>

                            </div>
                        </div>
                        <div class="table-responsive table-responsive-md">
                            <table class="table table-bordered" id="advanced-desc-table">
                                <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Blog Title</th>
                                    <th>Created Date</th>
                                    <th>Author</th>
                                    <th>Comments</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php($i=1)
                                @foreach($blogs as $blog)
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td>{{$blog->title}}</td>
                                        <td>{{date('Y-m-d',strtotime($blog->created_at))}}</td>
                                        <td>{{$blog->author}}</td>
                                        <td><a href="/admin/blogs/{{$blog->id}}/comments">Comments({{$blog->comments->count()}})</a></td>
                                        <td>
                                            @if($blog->status == 'Unpublished')
                                                <span class="text-danger">{{$blog->status}}</span>
                                            @else
                                                <span class="text-success">{{$blog->status}}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuOutlineButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Actions </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuOutlineButton1">
                                                    <a href="/admin/blogs/{{$blog->id}}" class="text-primary dropdown-item">Show</a>
                                                    <a href="/admin/blogs/{{$blog->id}}/edit" class="text-danger dropdown-item">Edit</a>
                                                    <form id="delete-form-{{$blog->id}}" action="/admin/blogs/{{$blog->id}}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <a href="javascript:{}" onclick="javascript:deleteData({{$blog->id}});" class="text-warning dropdown-item">Delete</a>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
