@extends('admin.layouts.app')
@section('admin-title')
    Exam Lists | {{ucwords($category->title)}}
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">MCQ Exams | {{ucwords($category->title)}}</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="/admin/exam-category">Exam Categories</a></li>
                <li class="breadcrumb-item active" aria-current="page">Exams</li>
              </ol>
          </nav>
        </div>  
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="custon-table-header">
                        <h4 class="card-title">MCQ Exams | {{ucwords($category->title)}}</h4>
                        <div class="text-right">
                            @if(auth()->user()->permission>=20)
                            <a href="{{ ('/admin/exams/create') }}"><button type="button" class="btn btn-sm ml-3 btn-success"> Add MCQ Exam </button></a>
                            @endif
                        </div>
                    </div>
                    <div class="table-responsive table-responsive-md">
                      <table class="table table-bordered" id="table-courses">
                        <thead>
                          <tr>
                            <th>SN</th>
                            {{-- <th>Category</th> --}}
                            <th>Exam Name</th>
                            {{-- <th>Date</th> --}}
                            <th>Time(HH:MM:SS)</th>
                            <th>Questions</th>
                            <th>Status</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                            @php($i=1)
                            @foreach ($exams as $exam)
                          <tr>
                            <td>{{ $i }}</td>
                            {{-- <td>{{ ucwords($exam->category->title ?? '-') }}</td> --}}
                            <td>{{ $exam->name }}</td>
                            {{-- <td>{{ $exam->exam_date }}</td> --}}
                            <td>{{ $exam->exam_time.':00' }} </td>
                            <td> <a href="/admin/exams/{{$exam->id}}/questions"> Count({{ $exam->questions->count() }}) </a></td>
                            <td>
                              @if($exam->status == 'Inactive')
                              <span class="text-danger">{{$exam->status}}</span>
                              @else
                              <span class="text-success">{{$exam->status}}</span>
                              @endif
                            </td>
                            <td class="classroom-btn" width="160">
                                <a href="/admin/exams/{{$exam->id}}" class="btn btn-primary">Show</a>
                                <a href="/admin/exams/{{$exam->id}}/edit" class="btn btn-danger">Edit</a>
                                <form id="delete-form-{{$exam->id}}" action="/admin/exams/{{$exam->id}}" method="POST" style="display: inline">
                                    @csrf
                                    @method('DELETE')
                                    <a href="javascript:{}" onclick="javascript:deleteData({{$exam->id}});" class="btn btn-warning">Delete</a>
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
                  </div>
                </div>
              </div>
        </div>
    </div>
    
@endsection
