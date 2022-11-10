@extends('admin.layouts.app')
@section('admin-title')
    Orientation Participants
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Orientation Participants</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/admin/orientations') }}">Orientations</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Participants</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="custon-table-header">
                            <h4 class="card-title">Participants | {{ucwords($orientation->course)}} </h4>
                        </div>
                        <div class="table-responsive table-responsive-md">
                            <table class="table table-bordered" id="table-courses">
                                <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Date</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Contact</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php($i=1)
                                @foreach($participants as $part)
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td>{{date("Y-m-d g:i a",strtotime($part->created_at))}}</td>
                                        <td>{{$part->name}}</td>
                                        <td>{{$part->email ?? ''}}</td>
                                        <td>{{$part->contact}}</td>
                                        
                                        <td class="classroom-btn" width="100">
                                            {{-- <a href="/admin/orientations/{{$orientation->id}}/participants/{{$part->id}}" class="btn btn-warning">Edit</a> --}}
                                            <form id="delete-form-{{$part->id}}" action="/admin/orientations/{{$orientation->id}}/participants/{{$part->id}}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <a href="javascript:{}" onclick="javascript:deleteData({{$part->id}});" class="text-danger">Delete</a>
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
                                            'Your file has been deleted.',
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
