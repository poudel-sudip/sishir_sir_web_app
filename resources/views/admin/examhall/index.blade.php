@extends('admin.layouts.app')
@section('admin-title')
    Exam Sets
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">All Exam Sets</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Exam Sets</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="custon-table-header">
                            <h4 class="card-title">Exam Sets</h4>
                            <div class="text-right">
                                <a href="{{ ('/admin/exam-hall/create') }}"><button type="button" class="btn btn-sm ml-3 btn-success"> Add Exam Set </button></a>
                            </div>
                        </div>
                        <div class="table-responsive table-responsive-md">
                            <table class="table table-bordered" id="advanced-desc-table">
                                <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Action</th>
                                    <th class="text-wrap">Group</th>
                                    <th class="text-wrap">Exam Set Title</th>
                                    <th>Exams Count</th>
                                    <th>Price (Rs)</th>
                                    <th>Discount (Rs)</th>
                                    <th>Creator</th>
                                    <th>CQC</th>
                                    <th class="text-wrap">Bookings (Unverified/Total)</th>
                                    <th>Pinned</th>
                                    <th>Status</th>

                                </tr>
                                </thead>
                                <tbody>
                                @php($i=1)
                                @foreach($categories as $cat)
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuOutlineButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Actions </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuOutlineButton1">
                                                    <a href="/admin/exam-hall/{{$cat->id}}/edit" class="text-danger dropdown-item">Edit</a>
                                                    <form id="delete-form-{{$cat->id}}" action="/admin/exam-hall/{{$cat->id}}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <a href="javascript:{}" onclick="javascript:deleteData({{$cat->id}});" class="text-warning dropdown-item">Delete</a>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-wrap">{{$cat->examGroup->name ?? '-'}}</td>
                                        <td class="text-wrap">{{$cat->title}}</td>
                                        <td> <a href="/admin/exam-hall/{{$cat->id}}/exams">Count({{$cat->category_exams->count()}})</a> </td>
                                        <td>{{$cat->price}}</td>
                                        <td>{{$cat->discount}}</td>
                                        <td>{{$cat->creator->name ?? '-'}}</td>
                                        <td> <a href="/admin/exam-hall/{{$cat->id}}/cqc">CQCs({{$cat->cqcs->count()}})</a> </td>
                                        <td> <a href="/admin/exam-hall/{{$cat->id}}/bookings">Bookings( {{$cat->bookings()->where('status','!=','Verified')->count()}}/{{$cat->bookings->count()}} )</a> </td>
                                        <td>{{$cat->isPinned}}</td>
                                        <td>
                                            @if($cat->status == 'Active')
                                                <span class="text-success">{{$cat->status}}</span>
                                            @else
                                                <span class="text-warning">{{$cat->status}}</span>
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
                                            'Your file record has been deleted.',
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
