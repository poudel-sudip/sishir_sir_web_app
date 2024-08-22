@extends('student.layouts.app')
@section('student-title')
    User Tickets to Ask/Complain Admin
@endsection

@section('student-title-icon')
    <i class="fas fa-address-card"></i>
@endsection


@section('content')
    <div class="student-content-wrapper student-enroll-section">
        <div class="row mb-2">
            <div class="col-md-12 text-end">
                <a class="student-enroll-btn" href="/student/tickets/create">Ask/Complain Admin</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="enrolled-table table-responsive table-responsive-md">
                    <table class="table" style="width:100%">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Status</th>
                                <th>Updated At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tickets as $row)
                            <tr>
                                <td>{{$row->id}}</td>
                                <td class="text-wrap">{{$row->title}}</td>
                                <td class="text-{{$row->status ? 'success':'danger'}}">{{$row->status ? 'Open':'Closed'}}</td>
                                <td>{{$row->sort_date }}</td>
                                <td>

                                    <a href="/student/tickets/{{$row->id}}/contents" class="btn btn-primary btn-sm mb-1 ">View Messages</a> 
                                    @if($row->status)
                                    <a href="/student/tickets/{{$row->id}}/mark-closed" class="btn btn-warning btn-sm mb-1 ">Mark Closed</a> 
                                    @endif
                                    <form id="delete-form-{{$row->id}}" action="/student/tickets/{{$row->id}}" method="POST" style="display: inline">
                                        @csrf
                                        @method('DELETE')
                                        <a href="javascript:{}" onclick="javascript:deleteData({{$row->id}});" class="btn btn-danger btn-sm">Delete</a>
                                    </form>                                    
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        
                    </table>
                </div>
            </div>
            <div class="col-12">
                {{$tickets->onEachSide(1)->links('paginator.bootstrap')}}
            </div>
        </div>
    </div>

    <script type="text/javascript">
        function deleteData(id)
        {
            if(confirm('Are You Sure? ')){
                document.getElementById('delete-form-'+id).submit();
            }
        }
    </script>

@endsection
