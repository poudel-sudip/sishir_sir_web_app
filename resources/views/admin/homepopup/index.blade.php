@extends('admin.layouts.app')
@section('admin-title')
    Home Pop Up
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Home Pop Up</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Home Pop Up</li>
              </ol>
          </nav>
        </div>  
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="custon-table-header">
                            <h4 class="card-title">Home Pop Up</h4>
                            <div class="text-right">
                                <a href="{{ ('/admin/home-popup/create') }}"><button type="button" class="btn btn-sm ml-3 btn-success"> Add Pop Up </button></a>
                            </div>
                        </div>
                        <div class="table-responsive table-responsive-md">
                            <table class="table table-bordered" id="advanced-desc-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Popup Title</th>
                                        <th>Popup Image</th>
                                        <th>Popup Link</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($popup as $popup)
                                        <tr>
                                            <td>{{$popup->id}}</td>
                                            <td>{{$popup->title}}</td>
                                            <td> <img src="/storage/{{$popup->image}}"> </td>
                                            <td>{{$popup->link}}</td>
                                            <td>
                                                @if($popup->status == 'Inactive')
                                                <span class="text-danger">{{$popup->status}}</span>
                                                @else
                                                <span class="text-info">{{$popup->status}}</span>
                                                @endif
                                            </td>
                                            <td width="100" class="classroom-btn">
                                                <a href="/admin/home-popup/{{$popup->id}}/edit" class="btn btn-danger btn-sm">Edit</a>
                                                <form id="delete-form-{{$popup->id}}" action="/admin/home-popup/{{$popup->id}}" method="POST" style="display: inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a href="javascript:{}" onclick="javascript:deleteData({{$popup->id}});" class="btn btn-warning btn-sm">Delete</a>
                                                </form>
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
