@extends('admin.layouts.app')
@section('admin-title')
  ExamHall Exam Groups
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
        <h3 class="page-title">ExamHall Exam Groups</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/admin/exam-hall') }}">ExamHall</a></li>
              <li class="breadcrumb-item active" aria-current="page"> ExamHall Exam Groups </li>
            </ol>
        </nav>
        </div>

        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="custon-table-header">
                        <h4 class="card-title">ExamHall Exam Groups</h4>
                        <div class="text-right">
                            <a href="{{ ('/admin/exam-hall/groups/create') }}"><button type="button" class="btn btn-sm ml-3 btn-success"> Add Exam Group </button></a>
                        </div>
                    </div>
                    <div class="table-responsive table-responsive-md">
                      <table class="table table-bordered" id="advanced-desc-table">
                        <thead>
                          <tr>
                            <th>SN</th>
                            <th>Action</th>
                            <th>Name</th>
                            {{-- <th>Slug</th> --}}
                            <th>Exam Sets</th>
                            <th>Order</th>
                            <th>Status</th>
                          </tr>
                        </thead>
                        <tbody>
                          @php($i=1)
                          @foreach($groups as $cat)
                          <tr>
                            <td>{{$i}}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuOutlineButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Actions </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuOutlineButton1">
                                        <a href="/admin/exam-hall/groups/{{$cat->id}}/edit" class="text-danger dropdown-item">Edit</a>
                                        <form id="delete-form-{{$cat->id}}" action="/admin/exam-hall/groups/{{$cat->id}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <a href="javascript:{}" onclick="javascript:deleteData({{$cat->id}});" class="text-warning dropdown-item">Delete</a>
                                        </form>
                                    </div>
                                </div>
                            </td>
                            <td>{{$cat->name}}</td>
                            {{-- <td>{{$cat->slug}}</td> --}}
                            <td><a href="/admin/exam-hall/groups/{{$cat->id}}/exam-sets">Exam Sets ({{$cat->premium_exams()->count()}}) </a></td>
                            <td>{{$cat->order}}</td>
                            <td class="text-wrap"><span class="text-{{$cat->status == 'Active' ? 'success' : 'danger'}}">{{$cat->status}}</span></td>
                            
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
                                'Your file has been deleted.',
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

