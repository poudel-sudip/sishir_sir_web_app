@extends('admin.layouts.app')
@section('admin-title')
    Batch Exam Lists
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Batch: {{$batch->name}} :- Exam Lists</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/admin/batches') }}">Batches</a></li>
              <li class="breadcrumb-item active" aria-current="page">Exams</li>
              </ol>
          </nav>
        </div>  
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="custon-table-header">
                        <h4 class="card-title">Batch: {{$batch->name}} :- Exam Lists</h4>
                        <div class="text-right">
                            @if(auth()->user()->permission>=20)
                            <a href="/admin/batches/{{$batch->id}}/exams/create"><button type="button" class="btn btn-sm ml-3 btn-success"> Associate MCQ Exam to Batch </button></a>
                            @endif
                        </div>
                    </div>
                    <div class="table-responsive table-responsive-md">
                      <table class="table table-bordered" id="table-courses">
                        <thead>
                          <tr>
                            <th>SN</th>
                            <th>Exam Name</th>
                            <th>Date</th>
                            <th>Time(HH:MM:SS)</th>
                            <th>Questions</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                            @php($i=1)
                            @foreach ($exams as $exam)
                          <tr>
                            <td>{{ $i }}</td>
                            <td>{{ $exam->exam->name ?? '' }}</td>
                            <td>{{ $exam->exam->exam_date ?? '' }}</td>
                            <td>{{ $exam->exam->exam_time.':00' ?? '' }} </td>
                            <td>{{ $exam->exam->questions->count() }} </td>
                           
                            <td class="classroom-btn" width="160">
                             
                                <form id="delete-form-{{$exam->id}}" action="/admin/batches/{{$batch->id}}/exams/{{$exam->id}}" method="POST" style="display: inline">
                                    @csrf
                                    @method('DELETE')
                                    <a href="javascript:{}" onclick="javascript:deleteData({{$exam->id}});" class="btn btn-warning">Delete</a>
                                </form>
                                <a href="/admin/batches/{{$batch->id}}/exams/{{$exam->exam->id}}/results" class="btn btn-primary">Results</a>

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
                                'Your data has been deleted.',
                                'success'
                              )
                            }
                          })
                        }
                    </script>
                    <hr>
                    </div>
                  </div>
                </div>
              </div>
        </div>
    </div>
    
@endsection
