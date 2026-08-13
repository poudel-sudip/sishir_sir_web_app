@extends('admin.layouts.app')
@section('admin-title')
  Batch MCQ Exam Lists
@endsection

@section('content')
  <div class="content-wrapper">
    <div class="page-header">
      <h3 class="page-title">MCQ Exams | {{$batch->name}}</h3>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="{{ url('/admin/courses') }}">Courses</a></li>
          <li class="breadcrumb-item"><a href="{{ url('/admin/courses/'.$course->id.'/batches') }}">Batches</a></li>
          <li class="breadcrumb-item active" aria-current="page">MCQ Exams</li>
        </ol>
      </nav>
    </div>  
    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div class="custon-table-header">
              <h4 class="card-title">MCQ Exams | {{$batch->name}}</h4>
              <div class="text-right">
                <a href="/admin/courses/{{$course->id}}/batches/{{$batch->id}}/mcq-exams/create"><button type="button" class="btn btn-sm ml-3 btn-success"> Associate MCQ Exam to Batch </button></a>
              </div>
            </div>
            <div class="table-responsive table-responsive-md">
              <table class="table table-bordered" id="advanced-desc-table">
                <thead>
                  <tr>
                    <th>SN</th>
                    <th>Exam Name</th>
                    <th>Time(HH:MM:SS)</th>
                    <th>Questions</th>
                    <th>CQCs</th>
                    <th>Is Final Exam</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($mcq_exams as $key=>$exam)
                    <tr>
                      <td>{{ $key+1 }}</td>
                      <td>{{ $exam->exam->name ?? '' }}</td>
                      <td>{{ $exam->exam->exam_time.':00' ?? '' }} </td>
                      <td> <a href="/admin/exams/{{$exam->exam->id}}/questions"> Questions({{ $exam->exam->questions()->count() }}) </a></td>
                      <td> <a href="/admin/exams/{{$exam->exam->id}}/cqcs" class="@if($exam->exam->cqc_unread()->exists()) text-danger @endif"> CQCs({{ $exam->exam->cqcs()->count() }}) </a></td>
                      <td>{{ $exam->is_final_exam ? 'Yes' : 'No' }} </td>
                      
                      <td class="classroom-btn" width="100">
                        
                        <form id="delete-form-{{$exam->id}}" action="/admin/courses/{{$course->id}}/batches/{{$batch->id}}/mcq-exams/{{$exam->id}}" method="POST" style="display: inline">
                          @csrf
                          @method('DELETE')
                          <a href="javascript:{}" onclick="javascript:deleteData({{$exam->id}});" class="btn btn-warning">Delete</a>
                        </form>
                        <a href="/admin/courses/{{$course->id}}/batches/{{$batch->id}}/mcq-exams/{{$exam->exam->id}}/results" class="btn btn-primary">Results</a>
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
            'Your data has been deleted.',
            'success'
          )
        }
      })
    }
  </script>

@endsection
