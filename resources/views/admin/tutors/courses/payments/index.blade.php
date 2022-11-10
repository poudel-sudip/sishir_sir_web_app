@extends('admin.layouts.app')
@section('admin-title')
{{$tutor->name}} : {{$course->course}} Payments
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">{{$tutor->name}} : {{$course->course}} Payments</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="/admin/home">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="/admin/tutors">Tutors</a></li>
              <li class="breadcrumb-item"><a href="/admin/tutors/{{$tutor->id}}/courses">Courses</a></li>
              <li class="breadcrumb-item active" aria-current="page">Payments</li>
              </ol>
          </nav>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div>
                            <h5>Tutor:- {{$tutor->name}} </h5>
                            <h5>Course:- {{$course->course}} </h5>
                            <h5>Tutor Fee Type:- {{$course->payMode}} </h5>
                            <h5>Tutor Fee:- {{$course->payAmount}} </h5>
                            @if($course->payMode=='Daywise')
                            <h5>Worked Days:- {{$course->worked_days}} </h5>
                            @endif
                            <br>
                            <h5>Total Tutor Payable Amount: {{$totalPayAmount}} </h5>
                            <h5>Total Paid Amount: {{$paidAmount}} </h5>
                            <h5>Remaining Amount: {{$totalPayAmount-$paidAmount}} </h5>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="tutor-table">
                                <thead>
                                    <tr>
                                        <th>SN</th>
                                        <th>Requested Date</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Updated Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php($i=1)
                                    @foreach($payments as $pay)
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td>{{date('Y-m-d',strtotime($pay->created_at))}}</td>
                                        <td>{{$pay->amount}}</td>
                                        <td>{{$pay->status}}</td>
                                        <td>{{date('Y-m-d',strtotime($pay->updated_at))}}</td>
                                        <td class="classroom-btn" width="160">
                                            @if($pay->status=='Unpaid')
                                            <form id="update-form-{{$pay->id}}" action="/admin/tutors/{{$tutor->id}}/courses/{{$course->id}}/payments/{{$pay->id}}" method="POST" style="display: inline">
                                                @csrf
                                                @method('PATCH')
                                                <a href="javascript:{}" onclick="javascript:updateData({{$pay->id}});" class="btn btn-info">Pay Now</a>
                                            </form>
                                            @endif
                                        </td>
                                    </tr>
                                    @php($i++)
                                    @endforeach
                                </tbody>
                            </table>
                            <script type="text/javascript">
                                function updateData(id)
                                {
                                    Swal.fire({
                                    title: 'Are you sure?',
                                    text: "You won't be able to revert this!",
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Yes, Update it!'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                    document.getElementById('update-form-'+id).submit();
                                    Swal.fire(
                                        'Updated!',
                                        'Your record has been updated.',
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
