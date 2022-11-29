@extends('admin.layouts.app')
@section('admin-title')
    Blog Comments
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">All Comments</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/admin/blogs') }}">Blogs</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Comments</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="custon-table-header">
                            <h4 class="card-title">Comments | {{$blog->title}}</h4>
                        </div>
                        <div class="table-responsive table-responsive-md">
                            <table class="table table-bordered" id="advanced-desc-table">
                                <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Date</th>
                                    <th>Blog Title</th>
                                    <th>Commented By</th>
                                    <th>Email</th>
                                    <th>Comments</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php($i=1)
                                @foreach($blog->comments as $comment)
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td>{{date('Y-m-d',strtotime($comment->created_at))}}</td>
                                        <td>{{$blog->title}}</td>
                                        <td>{{$comment->name}}</td>
                                        <td>{{$comment->email}}</td>
                                        <td class="text-wrap">{!! $comment->message !!}</td>
                                        <td>
                                            @if($comment->status == 'Unpublished')
                                                <span class="text-danger">{{$comment->status}}</span>
                                            @else
                                                <span class="text-success">{{$comment->status}}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuOutlineButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Actions </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuOutlineButton1">
                                                    <form id="publish-form-{{$comment->id}}" action="/admin/blogs/{{$blog->id}}/comment/{{$comment->id}}/Published" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <a href="javascript:{}" onclick="javascript:publishData({{$comment->id}});" class="text-primary dropdown-item">Publish</a>
                                                    </form>
                                                    <form id="unpublish-form-{{$comment->id}}" action="/admin/blogs/{{$blog->id}}/comment/{{$comment->id}}/Unpublished" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <a href="javascript:{}" onclick="javascript:unPublish({{$comment->id}});" class="text-warning dropdown-item">UnPublish</a>
                                                    </form>
                                                    <form id="delete-form-{{$comment->id}}" action="/admin/blogs/{{$blog->id}}/comment/{{$comment->id}}/delete" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <a href="javascript:{}" onclick="javascript:deleteData({{$comment->id}});" class="text-danger dropdown-item">Delete</a>
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

                                function publishData(id)
                                {
                                    Swal.fire({
                                    title: 'Are you sure?',
                                    text: "You want to Publish this!",
                                    icon: 'question',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Yes, publish it!'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            document.getElementById('publish-form-'+id).submit();
                                        Swal.fire(
                                            'Published!',
                                            'Your file has been Published.',
                                            'success'
                                        )
                                        }
                                    })
                                }

                                function unPublish(id)
                                {
                                    Swal.fire({
                                    title: 'Are you sure?',
                                    text: "You want to UnPublish it!",
                                    icon: 'question',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Yes, Unpublish it!'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            document.getElementById('unpublish-form-'+id).submit();
                                        Swal.fire(
                                            'Unpublished!',
                                            'Your file has been Unpublished.',
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
