@extends('vendors.layouts.app')
@section('admin-title')
    Leads & Enquiries
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Leads/Enquiries</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/vendor/home') }}">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Enquiries</li>
              </ol>
          </nav>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Leads/Enquiries of : {{$coverageArea ?? ''}}</h4>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="user-table">
                                <thead>
                                    <tr>
                                        <th>SN</th>
                                        <th>Date</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Contact</th>
                                        <th>Provience</th>
                                        <th>District</th>
                                        <th>Course</th>
                                        <th>Message</th>
                                        <th>Remarks</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php($i=1)
                                    @foreach($enquiries as $enquiry)
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td class="text-wrap">{{date("Y-m-d",strtotime($enquiry->created_at))}}</td>
                                        <td class="text-wrap">{{$enquiry->name}}</td>
                                        <td class="text-wrap">{{$enquiry->email}}</td>
                                        <td class="text-wrap">{{$enquiry->contact}}</td>
                                        <td class="text-wrap">{{$enquiry->provience}}</td>
                                        <td class="text-wrap">{{$enquiry->district}}</td>
                                        <td class="text-wrap">{{$enquiry->course->name ?? ''}}</td>
                                        <td class="text-wrap">{!! $enquiry->message !!}</td>
                                        <td class="text-wrap">{!! $enquiry->remarks !!}</td>

                                        <td class="classroom-btn">
                                            <a href="/vendor/enquiries/{{$enquiry->id}}/edit" class="btn btn-danger">Edit</a>
                                            {{-- <form id="delete-form-{{$enquiry->id}}" action="/vendor/enquiries/{{$enquiry->id}}" method="POST" style="display: inline">
                                                @csrf
                                                @method('DELETE')
                                                <a href="javascript:{}" onclick="javascript:deleteData({{$enquiry->id}});" class="btn btn-warning">Delete</a>
                                            </form> --}}
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
