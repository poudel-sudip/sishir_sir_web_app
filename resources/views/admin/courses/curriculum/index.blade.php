@extends('admin.layouts.app')
@section('admin-title')
    Batch Curriculum
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Batch Curriculum</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/admin/courses') }}">Courses</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/admin/courses/'.$course->id.'/batches') }}">Batches</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Curriculum</li>
                </ol>
            </nav>
        </div> 
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                      <div class="custon-table-header">
                          <h4 class="card-title">Curriculum || {{$batch->name}}</h4>
                          <div class="text-right">
                              <a  href="/admin/courses/{{$course->id}}/batches/{{$batch->id}}/curriculum/create" class="btn btn-success" > Create Curriculum </a>
                          </div>
                      </div>
                      <div class="table-responsive table-responsive-md">
                        <table class="table table-bordered advanced-asc-table">
                          <thead>
                            <tr>
                                <th>SN</th>
                                {{-- <th>Batch</th> --}}
                                <th>Title</th>
                                <th>Is Main</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($curriculums as $key=>$row)
                            <tr>
                                <td class="text-wrap" width="50">{{$key+1}}</td>
                                {{-- <td class="text-wrap">{{optional($row->batch)->name}}</td> --}}
                                <td class="text-wrap">{{$row->title}}</td>
                                <td class="text-wrap">{{$row->is_heading == 1 ? 'Yes' : 'No'}}</td>
                                <td class="text-wrap {{$row->status == 1 ? 'text-success' : 'text-danger'}}">{{$row->status == 1 ? 'Active' : 'Inactive'}}</td>
                                
                                <td class="classroom-btn" width="100">
                                    <a class="btn btn-primary" href="/admin/courses/{{$course->id}}/batches/{{$batch->id}}/curriculum/{{$row->id}}">Show</a>
                                    <a class="btn btn-warning " href="/admin/courses/{{$course->id}}/batches/{{$batch->id}}/curriculum/{{$row->id}}/edit" >Edit</a>
                                    <form id="delete-form-{{$row->id}}" action="/admin/courses/{{$course->id}}/batches/{{$batch->id}}/curriculum/{{$row->id}}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <a href="javascript:{}" onclick="javascript:deleteData({{$row->id}});" class="btn btn-danger">Delete</a>
                                    </form>                                    
                                </td>
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
                'Your file has been deleted.',
                'success'
            )
            }
        })
        }
    </script>
@endsection
