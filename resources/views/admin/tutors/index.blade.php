@extends('admin.layouts.app')
@section('admin-title')
    Tutors
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">All Tutors</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="/admin/home">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Tutors</li>
              </ol>
          </nav>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="custon-table-header">
                            <h4 class="card-title">All Tutors</h4>
                            <div class="text-right">
                                @if(auth()->user()->permission>=20)
                                <a href="{{ ('/admin/tutors/create') }}"><button type="button" class="btn btn-sm ml-3 btn-success">Add Tutor</button></a>
                                @endif
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="tutor-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Courses</th>
                                        <th>Reviews</th>
                                        <th>Special Courses</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tutors as $tutor)
                                <tr>
                                    <td>{{$tutor->id}}</td>
                                    <td class="text-wrap">{{$tutor->name}}</td>
                                    <td class="text-wrap">{{$tutor->user->email ?? ''}}</td>
                                    <td class="text-wrap">
                                        @php($c=[])
                                        @foreach($tutor->batches as $batch)
                                            @if(in_array($batch->course->name,$c))
                                                @continue
                                            @endif
                                            {{$batch->course->name}},
                                            @php(array_push($c,$batch->course->name))
                                        @endforeach
                                    </td>
                                    <td>
                                        @if(auth()->user()->permission>=20)
                                        <a href="/admin/tutors/{{$tutor->id}}/reviews"> Reviews({{$tutor->reviews()->where('status','=','Unpublished')->count() .'/'.$tutor->reviews->count()}}) </a>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="/admin/tutors/{{$tutor->id}}/courses"> Courses({{$tutor->specialCourses()->where('status','=','Inactive')->count() .'/'.$tutor->specialCourses->count()}}) </a>
                                    </td>
                                    <td>{{$tutor->status ?? ''}}</td>
                                    <td class="classroom-btn" width="160">
                                        <a href="/admin/tutors/{{$tutor->id}}" class="btn btn-primary">Show</a>
                                        @if(auth()->user()->permission>=20)
                                        <a href="/admin/tutors/{{$tutor->id}}/edit" class="btn btn-danger">Edit</a>
                                        <form id="delete-form-{{$tutor->id}}" action="/admin/tutors/{{$tutor->id}}" method="POST" style="display: inline">
                                            @csrf
                                            @method('DELETE')
                                            <a href="javascript:{}" onclick="javascript:deleteData({{$tutor->id}});" class="btn btn-warning">Delete</a>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <script type="text/javascript">
                                function deleteData(id)
                                {
                                    if(confirm('Are You Sure? ')){
                                        document.getElementById('delete-form-'+id).submit();
                                    }
                                }
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
