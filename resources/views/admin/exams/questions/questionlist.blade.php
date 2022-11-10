@extends('admin.layouts.app')
@section('admin-title')
    Exam Question Lists
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Exam: {{$exam->name}}  : Questions</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/admin/exams') }}">Exams</a></li>
              <li class="breadcrumb-item active" aria-current="page">Questions</li>
              </ol>
          </nav>
        </div>  
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="custon-table-header">
                        <h4 class="card-title">Questions Table</h4>
                        <div class="text-right">
                            @if(auth()->user()->permission>=20)
                            <a href="/admin/exams/{{$exam->id}}/questions/create"><button type="button" class="btn btn-sm ml-3 btn-success"> Add Question </button></a>
                            <a href="/admin/exams/{{$exam->id}}/questions/upload"><button type="button" class="btn btn-sm ml-3 btn-primary"> Upload Questions </button></a>
                            @endif
                        </div>
                    </div>
                    <div class="table-responsive table-responsive-md">
                      <table class="table table-bordered" id="table-courses">
                        <thead>
                          <tr>
                            <th>SN</th>
                            <th>Question</th>
                            <th>Option A</th>
                            <th>Option B</th>
                            <th>Option C</th>
                            <th>Option D</th>
                            <th>Correct Answer</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          @php($i=1)
                          @foreach ($exam->questions as $question)
                          <tr>
                            <td>{{ $i }}</td>
                            <td class="text-wrap">{!! $question->name !!}</td>
                            <td class="text-wrap">{!! $question->opt_a !!}</td>
                            <td class="text-wrap">{!! $question->opt_b !!}</td>
                            <td class="text-wrap">{!! $question->opt_c !!}</td>
                            <td class="text-wrap">{!! $question->opt_d !!}</td>
                            <td>{{ $question->opt_correct }}</td>
                            <td class="classroom-btn" width="160">
                                <a href="/admin/exams/{{$exam->id}}/questions/{{$question->id}}/edit" class="btn btn-danger">Edit</a>
                                <form id="delete-form-{{$question->id}}" action="/admin/exams/{{$exam->id}}/questions/{{$question->id}}" method="POST" style="display: inline">
                                    @csrf
                                    @method('DELETE')
                                    <a href="javascript:{}" onclick="javascript:deleteData({{$question->id}});" class="btn btn-warning">Delete</a>
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
                    <div class="description small">
                      <a href="{{ asset('admin/files/questionupload.xlsx') }}" target="_blank">Download Bulk Question Upload Sample</a>
                    </div>
                  </div>
                </div>
              </div>
        </div>
    </div>
    
@endsection
