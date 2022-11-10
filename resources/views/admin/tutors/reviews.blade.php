@extends('admin.layouts.app')
@section('admin-title')
    Tutor Reviews
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">All Reviews of : {{$tutor->name}}</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/admin/tutors') }}">Tutors</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Reviews</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="custon-table-header">
                            <h4 class="card-title">Reviews Table : {{$tutor->name}}</h4>
                        </div>
                        <div class="table-responsive table-responsive-md">
                            <table class="table table-bordered" id="table-courses">
                                <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Date</th>
                                    <th>Reviewed By</th>
                                    <th>Email</th>
                                    <th>Rating</th>
                                    <th>Content</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php($i=1)
                                @foreach($tutor->reviews as $review)
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td>{{date('Y-m-d',strtotime($review->created_at))}}</td>
                                        <td>{{$review->name}}</td>
                                        <td>{{$review->email}}</td>
                                        <td>{{$review->rating}}</td>
                                        <td class="text-wrap">{!! $review->review !!}</td>
                                        <td>
                                            @if($review->status == 'Unpublished')
                                                <span class="text-danger">{{$review->status}}</span>
                                            @else
                                                <span class="text-success">{{$review->status}}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuOutlineButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Actions </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuOutlineButton1">
                                                    <form id="publish-form-{{$review->id}}" action="/admin/tutors/{{$tutor->id}}/review/{{$review->id}}/Published" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <a href="javascript:{}" onclick="javascript:publishData({{$review->id}});" class="text-primary dropdown-item">Publish</a>
                                                    </form>
                                                    <form id="unpublish-form-{{$review->id}}" action="/admin/tutors/{{$tutor->id}}/review/{{$review->id}}/Unpublished" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <a href="javascript:{}" onclick="javascript:unPublish({{$review->id}});" class="text-warning dropdown-item">UnPublish</a>
                                                    </form>
                                                    <form id="delete-form-{{$review->id}}" action="/admin/tutors/{{$tutor->id}}/review/{{$review->id}}/delete" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <a href="javascript:{}" onclick="javascript:deleteData({{$review->id}});" class="text-danger dropdown-item">Delete</a>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @php($i++)
                                @endforeach
                                </tbody>
                            </table>
                            <script type="text/javascript">
                                function deleteData(id)
                                {
                                    if(confirm('Are You Sure You want to Delete it? ')){
                                        document.getElementById('delete-form-'+id).submit();
                                    }
                                }

                                function publishData(id)
                                {
                                    if(confirm('Are You Sure You want to Publish it? ')){
                                        document.getElementById('publish-form-'+id).submit();
                                    }
                                }

                                function unPublish(id)
                                {
                                    if(confirm('Are You Sure You want to UnPublish it? ')){
                                        document.getElementById('unpublish-form-'+id).submit();
                                    }
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
