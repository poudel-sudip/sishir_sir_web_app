@extends('admin.layouts.app')
@section('admin-title')
    Health Days
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Health Days</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Health Days</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="text-right pt-3 px-4">
                        <label for="change_year">Selected Year:</label>
                        <select name="year" id="change_year">
                            <option value="">Select Year</option>
                            @foreach($healthYears as $yr)
                                <option value="{{ $yr }}" {{ $yr == $year ? 'selected' : '' }}>{{ $yr }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="card-body">
                        <div class="custon-table-header">
                            <h4 class="card-title">Health Days || {{$year}}</h4>
                            <div class="text-right">
                                <a href="{{ ('/admin/health-days/create?year='.$year) }}"><button type="button" class="btn btn-sm ml-3 btn-success"> Add Health Day </button></a>
                            </div>
                        </div>
                        <div class="table-responsive table-responsive-md">
                            <table class="table table-bordered" id="advanced-asc-table">
                                <thead>
                                <tr>
                                    <th>SN</th>
                                    {{-- <th>Category</th> --}}
                                    <th>Date</th>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($healthDays as $key=>$row)
                                        <tr>
                                            <td width="50">{{$key+1}}</td>
                                            {{-- <td>{{optional($row->category)->name}}</td> --}}
                                            <td width="100">{{date('Y-m-d',strtotime($row->date))}}</td>
                                            <td class="text-wrap">{{ $row->title }}</td>
                                            <td class="text-wrap">{{ $row->author }}</td>
                                            {{-- <td class="{{strtolower($row->status) == 'active' ? 'text-primary' : 'text-danger'}}"> {{ucwords($row->status)}} </td> --}}
                                            <td class="classroom-btn" width="100">
                                                <a href="/admin/health-days/{{$row->id}}" class="btn btn-primary">Show</a>
                                                <a href="/admin/health-days/{{$row->id}}/edit" class="btn btn-danger">Edit</a>
                                                <form id="delete-form-{{$row->id}}" action="/admin/health-days/{{$row->id}}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a href="javascript:{}" onclick="javascript:deleteData({{$row->id}});" class="btn btn-warning">Delete</a>
                                                </form>
                                            </td>
                                        </tr>
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
                    'Your Record has been deleted.',
                    'success'
                )
                }
            })
        }
    </script>
    
    <script>
        document.getElementById('change_year').addEventListener('change', function() {
            var selectedYear = this.value;
            if (selectedYear) {
                window.location.href = '/admin/health-days?year=' + selectedYear;
            }
        });
    </script>

@endsection
