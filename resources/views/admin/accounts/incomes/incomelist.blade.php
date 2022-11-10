@extends('admin.layouts.app')
@section('admin-title')
    Last 100 Income Lists
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Incomes</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item" aria-current="page">Accounts</li>
                    <li class="breadcrumb-item active" aria-current="page">Incomes</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="custon-table-header">
                            <h4 class="card-title">Last 100 Income Lists</h4>
                            <div class="text-right">
                            <a href="{{ ('/admin/accounts/incomes/courses/add') }}"><button type="button" class="btn btn-sm ml-3 btn-danger"> Add Course Income  </button></a>
                            <a href="{{ ('/admin/accounts/incomes/others/add') }}"><button type="button" class="btn btn-sm ml-3 btn-primary"> Add Other Income  </button></a>

                            </div>
                        </div>
                        <div class="table-responsive table-responsive-md">
                            <table class="table table-bordered" id="table-courses">
                                <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Date</th>
                                    <th>Type</th>
                                    <th>Description</th>
                                    <th>Amount</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php($i=1)
                                @foreach($incomes as $income)
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td>{{date('Y-m-d h:i A',strtotime($income->date))}}</td>
                                        <td>{{$income->type}}</td>
                                        <td>
                                            @if(in_array($income->category,['Misc','Opening','Deposite']))
                                                <strong>{{$income->category}}</strong> income in <strong>{{$income->ledger}}</strong>  by <em> {{$income->fromAccount}} </em> 
                                            @else
                                                Paid by <strong>{{$income->ledger}}</strong> for <strong>{{$income->category}}</strong> by <em> {{$income->fromAccount}} </em> 
                                            @endif
                                        </td>
                                        <td>Rs {{$income->amount}}</td>
                                        <td class="classroom-btn" width="150">
                                            <form id="delete-form-{{$income->id}}" action="/admin/accounts/incomes/{{$income->id}}" method="POST" style="display: inline">
                                                @csrf
                                                @method('DELETE')
                                                <a href="javascript:{}" onclick="javascript:deleteData({{$income->id}});" class="btn btn-danger" title="Delete" ><i class="mdi mdi-delete menu-icon"></i></a>
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
                                            'Your Record has been Trashed.',
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
