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
                                    <th class="text-wrap">Exam Set Title</th>
                                    <th>Exams Count</th>
                                    <th>Price (Rs)</th>
                                    <th>Discount (Rs)</th>
                                    <th>CQC</th>
                                    <th class="text-wrap">Bookings (Unverified/Total)</th>
                                    <th>Status</th>

                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php($i=1)
                                @foreach($categories as $cat)
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td class="text-wrap">{{$cat->title}}</td>
                                        <td> <a href="/admin/exam-hall/{{$cat->id}}/exams">Count({{$cat->category_exams->count()}})</a> </td>
                                        <td>{{$cat->price}}</td>
                                        <td>{{$cat->discount}}</td>
                                        
                                        <td> <a href="/admin/exam-hall/{{$cat->id}}/cqc">CQCs({{$cat->cqcs->count()}})</a> </td>
                                        <td> <a href="/admin/exam-hall/{{$cat->id}}/bookings">Bookings( {{$cat->bookings()->where('status','!=','Verified')->count()}}/{{$cat->bookings->count()}} )</a> </td>
                                        <td>
                                            @if($cat->status == 'Active')
                                                <span class="text-success">{{$cat->status}}</span>
                                            @else
                                                <span class="text-warning">{{$cat->status}}</span>
                                            @endif
                                        </td>
                                        <td class="classroom-btn" width="100">
                                            <a href="/admin/exam-hall/{{$cat->id}}/edit" class="btn btn-success">Edit</a>
                                            <form id="delete-form-{{$cat->id}}" action="/admin/exam-hall/{{$cat->id}}" method="POST" style="display: inline">
                                                @csrf
                                                @method('DELETE')
                                                <a href="javascript:{}" onclick="javascript:deleteData({{$cat->id}});" class="btn btn-danger">Delete</a>
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
