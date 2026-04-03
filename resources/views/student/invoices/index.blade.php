@extends('student.layouts.app')
@section('student-title')
    Payment Invoices
@endsection

@section('student-title-icon')
    <i class="fas fa-file-pdf"></i>
@endsection


@section('content')
    <div class="student-content-wrapper student-enroll-section">
        <div class="row">
            <div class="col-12 my-2">
                <h5>Online Payment Invoices</h5>  
             </div>
            <div class="col-md-12 student_exam_card">
                <div class="enrolled-table table-responsive">
                    <table class="table" style="width:100%">
                        <thead class="table-light">
                            <tr>
                                <th>SN</th>
                                <th>Invoice For</th>
                                <th>Invoice No</th>
                                <th>Invoice Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php($i=1)
                            @foreach($invoices as $row)
                                <tr>
                                    <td>{{$i}}</td>
                                    <td class="text-wrap">{{ucwords($row->type)}}</td>
                                    <td class="text-wrap">Invoice #{{$row->id}}</td>
                                    <td class="text-wrap">{{$row->created_at}}</td>
                                    <td>
                                        <a href="/student/invoices/{{ $row->id }}" class="btn btn-primary btn-sm">View Invoice</a>
                                    </td>
                                </tr>
                                @php($i++)
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
