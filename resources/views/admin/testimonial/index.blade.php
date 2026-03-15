@extends('admin.layouts.app')
@section('admin-title')
    Testimonial
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Testimonial</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Testimonial</li>
              </ol>
          </nav>
        </div> 
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="custon-table-header">
                            <h4 class="card-title">All Testimonials</h4>
                            <div class="text-right">
                                <a href="{{ ('/admin/testimonials/create') }}"><button type="button" class="btn btn-sm ml-3 btn-success"> Add Testimonial </button></a>
                            </div>
                        </div>
                        <div class="table-responsive table-responsive-md">
                            <table class="table table-bordered" id="advanced-desc-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Action</th>
                                        <th>Testimonial By</th>
                                        <th>As</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($testimonials as $testimonial)
                                    <tr>
                                        <td>{{$testimonial->id}}</td>
                                        <td width="50">
                                            <div class="dropdown">
                                            <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuOutlineButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Actions </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuOutlineButton1">
                                                <a href="/admin/testimonials/{{$testimonial->id}}/edit" class="text-danger dropdown-item">Edit</a>
                                                <form id="delete-form-{{$testimonial->id}}" action="/admin/testimonials/{{$testimonial->id}}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a href="javascript:{}" onclick="javascript:deleteData({{$testimonial->id}});" class="text-warning dropdown-item">Delete</a>
                                                </form>
                                            </div>
                                            </div>
                                        </td>
                                        <td class="text-wrap">{{$testimonial->name}}</td>
                                        <td class="text-wrap"> {{$testimonial->role}} </td>
                                        <td>{{date('Y-m-d',strtotime($testimonial->created_at))}}</td>
                                        <td class="text-{{ucwords($testimonial->status) == 'Active' ? 'success' : 'danger'}}">{{ucwords($testimonial->status)}}</td>
                                        
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
