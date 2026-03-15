@extends('admin.layouts.app')
@section('admin-title')
    Health Days
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Health Days</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Health Days</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">                    
                    <div class="card-body">
                        <div class="custon-table-header">
                            <h4 class="card-title">Health Days</h4>
                            <div class="text-right">
                                <a href="{{ ('/admin/health-days/create') }}"><button type="button" class="btn btn-sm ml-3 btn-success"> Add Health Day </button></a>
                            </div>
                        </div>
                        <div class="table-responsive table-responsive-md">
                            <table class="table table-bordered" id="advanced-asc-table">
                                <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Action</th>
                                    <th>Category</th>
                                    <th>Date</th>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>Slogans</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($healthDays as $key=>$row)
                                        <tr>
                                            <td width="50">{{$key+1}}</td>
                                            <td class="text-wrap">
                                                <div class="dropdown">
                                                    <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuOutlineButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Actions </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuOutlineButton1">
                                                        <a href="/admin/health-days/{{$row->id}}" class="text-primary dropdown-item">Show</a>
                                                        <a href="/admin/health-days/{{$row->id}}/edit" class="text-danger dropdown-item">Edit</a>
                                                        <form id="delete-form-{{$row->id}}" action="/admin/health-days/{{$row->id}}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <a href="javascript:{}" onclick="javascript:deleteData({{$row->id}});" class="text-warning dropdown-item">Delete</a>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="text-wrap">{{optional($row->category)->name}}</td>
                                            <td class="text-wrap">{{ $row->date }}</td>
                                            <td class="text-wrap">{{ $row->title }}</td>
                                            <td class="text-wrap">{{ $row->author_name }}</td>
                                            {{-- <td class="{{strtolower($row->status) == 'active' ? 'text-primary' : 'text-danger'}}"> {{ucwords($row->status)}} </td> --}}
                                            <td class="classroom-btn" width="100"> <a href="/admin/health-days/{{$row->id}}/slogans" class="">Slogans ({{$row->slogans()->count()}}) </a> </td>
                                           
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            
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
                    'Your Record has been deleted.',
                    'success'
                )
                }
            })
        }
    </script>
    

@endsection
