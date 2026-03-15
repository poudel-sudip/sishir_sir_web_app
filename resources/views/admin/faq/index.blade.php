@extends('admin.layouts.app')
@section('admin-title')
    Faqs
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">All Faqs</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Faqs</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="custon-table-header">
                            <h4 class="card-title">Faqs table</h4>
                            <div class="text-right">
                                <a href="{{ ('/admin/faqs/create') }}"><button type="button" class="btn btn-sm ml-3 btn-success"> Add Faq </button></a>

                            </div>
                        </div>
                        <div class="table-responsive table-responsive-md">
                            <table class="table table-bordered" id="advanced-asc-table">
                                <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Action</th>
                                    <th>Faq Title</th>
                                    <th>Created Date</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($faqs as $key=>$faq)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td class="text-wrap">
                                                <div class="dropdown">
                                                    <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuOutlineButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Actions </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuOutlineButton1">
                                                        <a href="/admin/faqs/{{$faq->id}}" class="text-primary dropdown-item">Show</a>
                                                        <a href="/admin/faqs/{{$faq->id}}/edit" class="text-danger dropdown-item">Edit</a>
                                                        <form id="delete-form-{{$faq->id}}" action="/admin/faqs/{{$faq->id}}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <a href="javascript:{}" onclick="javascript:deleteData({{$faq->id}});" class="text-warning dropdown-item">Delete</a>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-wrap">{{$faq->name}}</td>
                                            <td>{{date('Y-m-d',strtotime($faq->created_at))}}</td>
                                            <td class="{{strtolower($faq->status) == 'active' ? 'text-primary' : 'text-danger'}}"> {{ucwords($faq->status)}} </td>
                                            
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
