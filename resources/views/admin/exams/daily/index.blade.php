@extends('admin.layouts.app')
@section('admin-title')
  Daily MCQ Question Lists
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title"> Daily MCQ Question Lists</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Daily MCQ Questions</li>
              </ol>
          </nav>
        </div>  
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="custon-table-header">
                      <h4 class="card-title"> Daily MCQ Question Lists </h4>
                      <div class="text-right">
                        <a href="/admin/daily-mcq-questions/create"><button type="button" class="btn btn-sm ml-3 btn-success"> Add Question </button></a>
                        <a href="/admin/daily-mcq-questions/upload"><button type="button" class="btn btn-sm ml-3 btn-primary"> Upload Questions </button></a>               
                      </div>
                    </div>
                    <div class="table-responsive table-responsive-md">
                      <table class="table table-bordered" id="advanced-asc-table">
                        <thead>
                          <tr>
                            <th>SN</th>
                            <th>Date</th>
                            <th>Question</th>
                            <th>Option A</th>
                            <th>Option B</th>
                            <th>Option C</th>
                            <th>Option D</th>
                            <th>Correct Option</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          @php($i=1)
                          @foreach ($questions as $question)
                          <tr>
                            <td>{{ $i }}</td>
                            <td>{{$question->show_date}}</td>
                            <td class="text-wrap">{!! $question->question !!}</td>
                            <td class="text-wrap">{!! $question->opt_a !!}</td>
                            <td class="text-wrap">{!! $question->opt_b !!}</td>
                            <td class="text-wrap">{!! $question->opt_c !!}</td>
                            <td class="text-wrap">{!! $question->opt_d !!}</td>
                            <td>{{ $question->opt_correct }}</td>
                            <td class="classroom-btn" width="100">
                              <a href="/admin/daily-mcq-questions/{{$question->id}}/comments" class="btn btn-primary">Comments</a>
                              <a href="/admin/daily-mcq-questions/{{$question->id}}" class="btn btn-info">Show</a>
                              <a href="/admin/daily-mcq-questions/{{$question->id}}/edit" class="btn btn-warning">Edit</a>
                                <form id="delete-form-{{$question->id}}" action="/admin/daily-mcq-questions/{{$question->id}}" method="POST" style="display: inline">
                                    @csrf
                                    @method('DELETE')
                                    <a href="javascript:{}" onclick="javascript:deleteData({{$question->id}});" class="btn btn-danger">Delete</a>
                                </form>
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
                    <div class="description small d-flex justify-content-between">
                      <a href="{{ asset('admin/files/questionupload.xlsx') }}" target="_blank">Download Bulk Question Upload Sample</a>
                      <a href="/admin/daily-mcq-questions/download" target="_blank">Download All Daily Questions</a>
                    </div>
                  </div>
                </div>
              </div>
        </div>
    </div>
    
@endsection
