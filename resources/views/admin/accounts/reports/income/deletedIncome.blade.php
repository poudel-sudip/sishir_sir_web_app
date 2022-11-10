@extends('admin.layouts.app')
@section('admin-title')
    Deleted Income Lists
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Deleted Incomes</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item" aria-current="page">Accounts</li>
                    <li class="breadcrumb-item"><a href="{{ url('/admin/accounts/reports') }}">Reports</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/admin/accounts/reports/incomes') }}">Incomes</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Deleted</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="custon-table-header">
                            <h4 class="card-title">Deleted Income Lists</h4>
                        </div>
                        <div class="table-responsive table-responsive-md">
                            <table class="table table-bordered" id="table-courses">
                                <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Date</th>
                                    <th>Type</th>
                                    <th>Category</th>
                                    <th>Ledger</th>
                                    <th>Amount</th>
                                    <th>From Account</th>
                                    <th>To Account</th>
                                    <th>Processed By</th>
                                    <th>Remarks</th>
                                    <th>Updated At</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php($i=1)
                                @foreach($data as $row)
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td>{{date('Y-m-d h:i A',strtotime($row->date))}}</td>
                                        <td>{{$row->type}}</td>
                                        <td>{{$row->category}}</td>
                                        <td>{{$row->ledger}}</td>
                                        <td>Rs {{$row->amount}}</td>
                                        <td>{{$row->fromAccount}}</td>
                                        <td>{{$row->toAccount}}</td>
                                        <td>{{$row->processedBy}}</td>
                                        <td class="text-wrap">{{$row->remarks}}</td>
                                        <td>{{date('Y-m-d h:i A',strtotime($row->updated_at))}}</td>
                                        <td class="classroom-btn" width="150">
                                            <form id="restore-form-{{$row->id}}" action="/admin/accounts/reports/incomes/deleted/{{$row->id}}" method="POST" style="display: inline">
                                                @csrf
                                                @method('PATCH')
                                                <a href="javascript:{}" onclick="javascript:restoreData({{$row->id}});" class="btn btn-success" title="Restore" ><i class="mdi mdi-restore menu-icon"></i></a>
                                            </form>
                                        </td>
                                    </tr>
                                    @php($i++)
                                @endforeach
                                </tbody>
                            </table>
                            <script type="text/javascript">
                                function restoreData(id)
                                {
                                    Swal.fire({
                                    title: 'Are you sure?',
                                    text: "",
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Yes, restore it!'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                        document.getElementById('restore-form-'+id).submit();
                                        Swal.fire(
                                            'Restored!',
                                            'Your Record has been Restored.',
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
