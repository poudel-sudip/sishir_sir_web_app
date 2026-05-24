@extends('admin.layouts.app')
@section('admin-title')
    Course Batches
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Course Batches</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/courses') }}">Courses</a></li>
                <li class="breadcrumb-item active" aria-current="page">Batches </li>
                </ol>
            </nav>
        </div> 
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                      <div class="custon-table-header">
                          <h4 class="card-title">Batches || {{$course->name}}</h4>
                          <div class="text-right">
                              <a href="/admin/courses/{{$course->id}}/batches/create"><button type="button" class="btn btn-sm ml-3 btn-success"> Create Batch </button></a>
                          </div>
                      </div>
                      <div class="table-responsive table-responsive-md">
                        <table class="table table-bordered" id="advanced-desc-table">
                          <thead>
                            <tr>
                                <th>ID</th>
                                <th>Batch Name</th>
                                <th>Duration </th>
                                {{-- <th>Time Slot</th> --}}
                                <th>Status</th>
                                <th>Classroom</th>
                                <th>Bookings</th>
                                <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($batches as $batch)
                            <tr>
                                <td class="text-wrap">{{$batch->id}}</td>
                                <td class="text-wrap">{{$batch->name}}</td>
                                <td class="text-wrap">{{$batch->duration}} {{$batch->durationType}}</td>
                                {{-- <td>{{$batch->timeSlot}}</td> --}}
                                <td class="text-wrap">
                                    @if($batch->status == 'Active')
                                    <span class="text-success">{{$batch->status}}</span>
                                    @elseif($batch->status == 'Inactive')
                                    <span class="text-danger">{{$batch->status}}</span>
                                    @elseif($batch->status == 'Closed')
                                    <span class="text-warning">{{$batch->status}}</span>
                                    @else
                                    <span class="text-info">{{$batch->status}}</span>
                                    @endif
                                </td>
                                <td class="text-wrap classroom-btn"> 
                                    <a href="/admin/courses/{{$course->id}}/batches/{{$batch->id}}/files" class="btn btn-primary">Files ({{$batch->class_files_count}})</a> 
                                    <a href="/admin/courses/{{$course->id}}/batches/{{$batch->id}}/videos" class="btn btn-danger">Videos ({{$batch->class_videos_count}})</a> 
                                    <a href="/admin/courses/{{$course->id}}/batches/{{$batch->id}}/curriculum" class="btn btn-info">Curriculum </a> 
                                    <a href="/admin/courses/{{$course->id}}/batches/{{$batch->id}}/mcq-exams" class="btn btn-success">MCQ Exams</a>
                                </td>

                                <td class="text-wrap classroom-btn"> 
                                    <a href="/admin/courses/{{$course->id}}/batches/{{$batch->id}}/bookings" class="btn btn-primary">Bookings ({{$batch->bookings_count}})</a> 
                                </td>

                                <td class="classroom-btn" width="100">
                                    <a href="/admin/courses/{{$course->id}}/batches/{{$batch->id}}" class="btn btn-primary">Show</a>
                                    <a href="/admin/courses/{{$course->id}}/batches/{{$batch->id}}/edit" class="btn btn-warning">Edit</a>
                                    <form id="delete-form-{{$batch->id}}" action="/admin/courses/{{$course->id}}/batches/{{$batch->id}}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <a href="javascript:{}" onclick="javascript:deleteData({{$batch->id}});" class="btn btn-danger">Delete</a>
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
