@extends('admin.layouts.app')
@section('admin-title')
    Open Exam Results
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">{{$exam->name}} :- Results</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/admin/open-exams') }}">Open Exams</a></li>
              <li class="breadcrumb-item active" aria-current="page">Results</li>
              </ol>
          </nav>
        </div>  
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="custon-table-header">
                      <h4 class="card-title">{{$exam->name}} : Results</h4>
                      <div class="text-right">
                        <a href="/admin/open-exams/{{$exam->id}}/results/delete-dublicates"><button type="button" class="btn btn-sm ml-3 btn-danger"> Delete Dublicate </button></a>
                        <a href="/admin/open-exams/{{$exam->id}}/results/export"><button type="button" class="btn btn-sm ml-3 btn-info"> Excel Export </button></a>
                      </div>
                    </div>
                    <span style="font-size: 13px">TQ=Total Questions, LQ=Leaved Questions, CQ=Correct Questions, WQ=Wrong Questions, MO=Marks Obtained</span>
                    <div class="table-responsive table-responsive-md">
                      <table class="table table-bordered" id="advanced-desc-table">
                        <thead>
                          <tr>
                            <th>ID</th>
                            <th>Action</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Contact</th>
                            <th>Courses</th>
                            <th>TQ</th>
                            <th>LQ</th>
                            <th>CQ</th>
                            <th>WQ</th>
                            <th>MO</th>
                            <th>Date</th>
                          </tr>
                        </thead>
                        <tbody>
                          @php($i=1)
                          @foreach ($results as $result)
                          <tr>
                            <td>{{ $result->id }}</td>
                            <td>
                              <form id="delete-form-{{$result->id}}" action="/admin/open-exams/{{$exam->id}}/results/{{$result->id}}" method="POST" style="display: inline">
                                @csrf
                                @method('DELETE')
                                <a href="javascript:{}" onclick="javascript:deleteData({{$result->id}});" class="text-danger">Delete</a>
                              </form>
                            </td>  
                            <td>{{ $result->name }}</td>
                            <td>{{ $result->email }}</td>
                            <td>{{ $result->contact }}</td>
                            <td>{{ $result->courses }}</td>
                            <td>{{ $result->total_questions ?? '' }}</td>
                            <td>{{ $result->leaved_questions ?? '' }} </td>
                            <td>{{ $result->correct_questions ?? '' }} </td>
                            <td>{{ $result->wrong_questions ?? '' }} </td>
                            <td>{{ ($result->correct_questions * ($exam->exam->marks_per_question ?? 1))-($result->wrong_questions * ($exam->exam->negative_marks ?? 0))}} </td>
                            <td>{{ date('Y-m-d',strtotime($result->created_at))}} </td>   
                                                  
                          </tr>
                          @php($i++)
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
