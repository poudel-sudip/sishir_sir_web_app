@extends('admin.layouts.app')
@section('admin-title')
    Slider
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">All Slider</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Slider</li>
              </ol>
          </nav>
        </div>  
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="custon-table-header">
                            <h4 class="card-title">All Slider</h4>
                            <div class="text-right">
                                @if(auth()->user()->permission==50 || auth()->user()->permission==20 )
                                <a href="{{ ('/admin/sliders/create') }}"><button type="button" class="btn btn-sm ml-3 btn-success"> Add Slider </button></a>
                                @endif
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th>ID</th>
                                    <th>Slider Order</th>
                                    <th>Slider Image</th>
                                    <th>Slider Title</th>
                                    <th>Action</th>
                                </tr>
                                @foreach($sliders as $slider)
                                    <tr>
                                        <td>{{$slider->id}}</td>
                                        <td>{{$slider->order}}</td>
                                        <td> <img src="/storage/{{$slider->image}}"> </td>
                                        <td>{{$slider->title}}</td>
                                        <td width="165">
                                            @if(auth()->user()->permission==50 || auth()->user()->permission==20 )
                                            <a href="/admin/sliders/{{$slider->id}}/edit" class="btn btn-danger btn-sm">Edit</a>
                                            <form id="delete-form-{{$slider->id}}" action="/admin/sliders/{{$slider->id}}" method="POST" style="display: inline">
                                                @csrf
                                                @method('DELETE')
                                                <a href="javascript:{}" onclick="javascript:deleteData({{$slider->id}});" class="btn btn-warning btn-sm">Delete</a>
                                            </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
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
