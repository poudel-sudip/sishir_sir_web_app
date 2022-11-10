@extends('admin.layouts.app')
@section('admin-title')
    Last 100 Expense Lists
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Expenses</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item" aria-current="page">Accounts</li>
                    <li class="breadcrumb-item active" aria-current="page">Expenses</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <a href="{{ ('/admin/accounts/expenses/tutor') }}"><button type="button" class="btn btn-sm ml-3 btn-danger"> Add Tutor Salary  </button></a>
                            <a href="{{ ('/admin/accounts/expenses/staff') }}"><button type="button" class="btn btn-sm ml-3 btn-primary"> Add Staff Salary  </button></a>
                            <a href="{{ ('/admin/accounts/expenses/refund') }}"><button type="button" class="btn btn-sm ml-3 btn-success"> Add Course Refund  </button></a>
                            <a href="{{ ('/admin/accounts/expenses/others') }}"><button type="button" class="btn btn-sm ml-3 btn-warning"> Add Other Expenses  </button></a>
                        </div>
                        <div class="custon-table-header">
                            <h4 class="card-title">Last 100 Expense Lists</h4>
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
                                @foreach($expenses as $expense)
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td>{{date('Y-m-d h:i A',strtotime($expense->date))}}</td>
                                        <td>{{$expense->type}}</td>
                                        <td>
                                            @if($expense->category=='Withdraw')
                                            {{$expense->category}} from <strong>{{$expense->fromAccount}}</strong> to <strong>{{$expense->toAccount}}</strong>
                                            @else
                                            Paid to <strong>{{$expense->ledger}}</strong> for <strong>{{$expense->category}}</strong>  by <em> {{$expense->fromAccount}} </em> 
                                            @endif
                                        </td>
                                        <td>Rs {{$expense->amount}}</td>
                                        <td class="classroom-btn" width="150">
                                            <form id="delete-form-{{$expense->id}}" action="/admin/accounts/expenses/{{$expense->id}}" method="POST" style="display: inline">
                                                @csrf
                                                @method('DELETE')
                                                <a href="javascript:{}" onclick="javascript:deleteData({{$expense->id}});" class="btn btn-danger" title="Delete" ><i class="mdi mdi-delete menu-icon"></i></a>
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
