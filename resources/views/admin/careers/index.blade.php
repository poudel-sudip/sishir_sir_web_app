@extends('admin.layouts.app')
@section('admin-title')
    Career Vaccancies
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">All Career Vaccancies</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Vaccancies</li>
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
                            <table class="table table-bordered all-entries-table" >
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Action</th>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>Posted On</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                {{-- @php($i=1) --}}
                                @foreach($vaccancies as $vaccancy)
                                    <tr>
                                        <td>{{$vaccancy->id}}</td>
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
                                        <td class="text-wrap">{{$vaccancy->title}}</td>
                                        <td class="text-wrap">{{$vaccancy->author}}</td>
                                        <td class="text-wrap">{{$vaccancy->created_at}}</td>
                                        <td>
                                            @if($vaccancy->status == 'Active')
                                                <span class="text-success">{{$vaccancy->status}}</span>
                                            @else
                                                <span class="text-danger">{{$vaccancy->status}}</span>
                                            @endif
                                        </td>
                                        
                                    </tr>
                                    {{-- @php($i++) --}}
                                @endforeach
                                </tbody>
                            </table>
                                                        
                        </div>
                        <div class="mt-2">
                            {{$vaccancies->onEachSide(1)->links('paginator.bootstrap')}}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

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

@endsection
