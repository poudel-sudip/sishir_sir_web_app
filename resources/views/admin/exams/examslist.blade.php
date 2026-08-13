@extends('admin.layouts.app')
@section('admin-title')
    Exam Lists
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">All MCQ Exams</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Exams</li>
              </ol>
          </nav>
        </div>  
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="custon-table-header">
                        <h4 class="card-title">Exams Table</h4>
                        <div class="text-right">
                            <a href="{{ ('/admin/exams/create') }}"><button type="button" class="btn btn-sm ml-3 btn-success"> Add MCQ Exam </button></a>
                        </div>
                    </div>
                    <div class="table-responsive table-responsive-md">
                      <table class="table table-bordered" id="advanced-desc-table">
                        <thead>
                          <tr>
                            <th>SN</th>
                            <th>Action</th>
                            <th>Category</th>
                            <th>Exam Name</th>
                            {{-- <th>Date</th> --}}
                            <th>Time(HH:MM:SS)</th>
                            <th>Questions</th>
                            <th>CQCs</th>
                            <th>Creator</th>
                            <th>Status</th>
                          </tr>
                        </thead>
                        <tbody>
                            @php($i=1)
                            @foreach ($exams as $exam)
                          <tr>
                            <td>{{ $i }}</td>
                            <td class="text-wrap">
                                <div class="dropdown">
                                    <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuOutlineButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Actions </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuOutlineButton1">
                                        <a href="/admin/exams/{{$exam->id}}" class="text-primary dropdown-item">Show</a>
                                        <a href="/admin/exams/{{$exam->id}}/edit" class="text-danger dropdown-item">Edit</a>
                                        <form id="delete-form-{{$exam->id}}" action="/admin/exams/{{$exam->id}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <a href="javascript:{}" onclick="javascript:deleteData({{$exam->id}});" class="text-warning dropdown-item">Delete</a>
                                        </form>
                                    </div>
                                </div>
                            </td>
                            <td class="text-wrap">{{ ucwords($exam->category->title ?? '-') }}</td>
                            <td class="text-wrap">{{ $exam->name }}</td>
                            {{-- <td>{{ $exam->exam_date }}</td> --}}
                            <td class="text-wrap"> {{ $exam->exam_time.':00' }} </td>
                            <td> <a href="/admin/exams/{{$exam->id}}/questions"> Count({{ $exam->questions()->count() }}) </a></td>
                            <td> <a href="/admin/exams/{{$exam->id}}/cqcs" class="@if($exam->cqc_unread()->exists()) text-danger @endif"> CQCs({{ $exam->cqcs()->count() }}) </a></td>
                            <td class="text-wrap"> {{$exam->creator->name ?? '-'}} </td>
                            <td>
                              @if($exam->status == 'Inactive')
                              <span class="text-danger">{{$exam->status}}</span>
                              @else
                              <span class="text-success">{{$exam->status}}</span>
                              @endif
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
                    </div>
                  </div>
                </div>
              </div>
        </div>
    </div>
    
@endsection
