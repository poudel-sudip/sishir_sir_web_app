@extends('admin.layouts.app')
@section('admin-title')
    Category Blogs
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Category Blogs</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/admin/blogs/categories') }}">Categories</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Blogs</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="custon-table-header">
                            <h4 class="card-title">{{ $category->name }}</h4>
                            <div class="text-right">
                                <a href="{{ ('/admin/blogs/create') }}"><button type="button" class="btn btn-sm ml-3 btn-success"> Add Blog </button></a>

                            </div>
                        </div>
                        <div class="table-responsive table-responsive-md">
                            <table class="table table-bordered" id="advanced-asc-table">
                                <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Action</th>
                                    <th>Blog Title</th>
                                    <th>Category</th>
                                    <th>Created Date</th>
                                    <th>Author</th>
                                    <th>Comments</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php($i=1)
                                @foreach($blogs as $blog)
                                    <tr>
                                        <td>{{$i}}</td>
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
                                        <td class="text-wrap">{{$blog->title}}</td>
                                        <td class="text-wrap">{{optional($blog->category)->name}}</td>
                                        <td class="text-wrap">{{date('Y-m-d',strtotime($blog->created_at))}}</td>
                                        <td class="text-wrap">{{$blog->author}}</td>
                                        <td class="text-wrap"> <a href="/admin/blogs/{{$blog->id}}/comments">Comments {!! $blog->comments()->where('status','=','Unpublished')->count() > 0 ? '<span style="background:#fc3200; color:#fff; border-radius:50%; height:15px; padding:2px; text-align:center; display:inline-block;">'.($blog->comments()->where('status','=','Unpublished')->count()).'</span>' : '' !!} </a></td>
                                        <td>
                                            @if($blog->status == 'Unpublished')
                                                <span class="text-danger">{{$blog->status}}</span>
                                            @else
                                                <span class="text-success">{{$blog->status}}</span>
                                            @endif
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
