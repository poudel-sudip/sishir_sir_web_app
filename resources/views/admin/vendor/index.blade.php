@extends('admin.layouts.app')
@section('admin-title')
    Vendors
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">All Vendors</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="/admin/home">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Vendors</li>
              </ol>
          </nav>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="custon-table-header">
                            <h4 class="card-title">All Vendors</h4>
                            <div class="text-right">
                                @if(auth()->user()->permission>=20)
                                <a href="{{ ('/admin/vendor/create') }}"><button type="button" class="btn btn-sm ml-3 btn-success">Add Vendor</button></a>
                                @endif
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="tutor-table">
                                <thead>
                                    <tr class="text-center">
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Coverage Area</th>
                                        <th>Discount(%)</th>
                                        <th>Status</th>
                                        <th>Options</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($vendors as $vendor)
                                <tr>
                                    <td class="text-wrap">{{$vendor->id}}</td>
                                    <td class="text-wrap">{{$vendor->name}}</td>
                                    <td class="text-wrap">{{$vendor->user->email ?? ''}}</td>
                                    <td class="text-wrap">
                                        <strong>[ {{ucwords($vendor->coverage_type)}} ]</strong>
                                        <br>
                                        @if(ucwords($vendor->coverage_type)=="Provience")
                                            {{$vendor->provience}}
                                        @elseif(ucwords($vendor->coverage_type)=="District")
                                            {{$vendor->district_city}}
                                        @endif
                                    </td>
                                    <td class="text-wrap text-center">{{$vendor->vendor_discount ?? '0'}}%</td>
                                    <td class="text-wrap text-center">{{$vendor->user->status ?? ''}}</td>
                                    <td class="classroom-btn" width="150">
                                        <a href="/admin/vendor/{{$vendor->id}}/bookings/course" class="m-1 btn btn-sm btn-info">Course Bookings</a> <br/>
                                        <a href="/admin/vendor/{{$vendor->id}}/bookings/exam" class="m-1 btn btn-sm btn-success">Exam Bookings</a> <br/>
                                        <a href="/admin/vendor/{{$vendor->id}}/bookings/video" class="m-1 btn btn-sm btn-primary">Video Bookings</a> <br/>
                                        <a href="/admin/vendor/{{$vendor->id}}/bookings/ebook" class="m-1 btn btn-sm btn-danger">E-Book Bookings</a> <br/>
                                        <a href="/admin/vendor/{{$vendor->id}}/students" class="m-1 btn btn-sm btn-warning">Students</a> <br/>
                                    </td>
                                                                     
                                    <td class="classroom-btn text-center">
                                        <a href="/admin/vendor/{{$vendor->id}}" class="m-1 btn btn-info">Show</a> <br>
                                        @if(auth()->user()->permission>=20)
                                        <a href="/admin/vendor/{{$vendor->id}}/edit" class="m-1 btn btn-warning">Edit</a> <br>
                                        <form id="delete-form-{{$vendor->id}}" action="/admin/vendor/{{$vendor->id}}" method="POST" style="display: inline">
                                            @csrf
                                            @method('DELETE')
                                            <a href="javascript:{}" onclick="javascript:deleteData({{$vendor->id}});" class="m-1 btn btn-danger">Delete</a>
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
