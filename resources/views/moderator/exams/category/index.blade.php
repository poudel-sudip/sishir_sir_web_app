@extends('moderator.layouts.app')
@section('admin-title')
    Exam Categories
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
        <h3 class="page-title">All Exam Categories </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/moderator/home') }}">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page"> Exam Categories </li>
            </ol>
        </nav>
        </div>

        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="custon-table-header">
                        <h4 class="card-title">All Exam Categories</h4>
                        <div class="text-right">
                            <a href="/moderator/exam-category/create"><button type="button" class="btn btn-sm ml-3 btn-success"> Add Category </button></a>
                        </div>
                    </div>
                    <div class="table-responsive table-responsive-md">
                      <table class="table table-bordered" id="advanced-desc-table">
                        <thead>
                          <tr>
                            <th>SN</th>
                            <th>Category Title</th>
                            <th>MCQ Exams</th>
                            {{-- <th>Action</th> --}}
                          </tr>
                        </thead>
                        <tbody>
                          @php($i=1)
                          @foreach($categories as $cat)
                            <tr>
                              <td>{{$i}}</td>
                              <td>{{ucwords($cat->title)}}</td>
                              <td class="classroom-btn"> <a href="/moderator/exam-category/{{$cat->id}}/exams" class=" btn btn-info">Exams ( {{$cat->exams->count()}} ) </a> </td>
                              {{-- <td class="classroom-btn" width="50">
                                <form id="delete-form-{{$cat->id}}" action="/moderator/exam-category/{{$cat->id}}" method="POST" style="display: inline">
                                    @csrf
                                    @method('DELETE')
                                    <a href="javascript:{}" onclick="javascript:deleteData({{$cat->id}});" class="btn btn-danger">Delete</a>
                                </form>
                              </td> --}}
                            </tr>
                            @php($i++)
                          @endforeach
                        </tbody>
                      </table>
                      {{-- <script type="text/javascript">
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
                    </script> --}}
                    </div>
                  </div>
                </div>
              </div>
        </div>
    </div>
@endsection

