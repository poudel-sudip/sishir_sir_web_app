@extends('admin.layouts.app')
@section('admin-title')
    Closed Tickets
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Closed Tickets</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Closed Tickets</li>
              </ol>
          </nav>
        </div> 
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="custon-table-header">
                            <h4 class="card-title">Closed Tickets</h4>                            
                        </div>
                        <div class="table-responsive table-responsive-md">
                            <table class="table table-bordered all-entries-table" >
                                <thead>
                                    <tr>
                                        <th>Updated At</th>
                                        <th>Ticket Title</th>
                                        <th>Status</th>
                                        <th>Ticket ID</th>
                                        <th>Ticket By</th>
                                        <th>Actions</th>                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tickets as $row)
                                    <tr>
                                        <td>{{$row->sort_date }}</td>
                                        <td class="text-wrap">{{$row->title}}</td>
                                        <td class="text-{{$row->status ? 'success':'danger'}}">{{$row->status ? 'Open':'Closed'}}</td>
                                        <td>{{$row->id}}</td>
                                        <td class="test-wrap">{{$row->user->name ?? 'Unknown' }}</td>
                                        <td class="classroom-btn" width="50">
                                            <a href="/admin/user-tickets/{{$row->id}}/contents" class="btn btn-primary ">View Messages</a> 
                                            <form id="delete-form-{{$row->id}}" action="/admin/user-tickets/{{$row->id}}" method="POST" style="display: inline">
                                                @csrf
                                                @method('DELETE')
                                                <a href="javascript:{}" onclick="javascript:deleteData({{$row->id}});" class="btn btn-danger">Delete</a>
                                            </form>                                    
                                        </td>
                                    </tr>
                                    @endforeach                                 
                                    
                                </tbody>                                
                            </table>                            
                        </div>
                        <div class="mt-2">
                            {{$tickets->onEachSide(1)->links('paginator.bootstrap')}}
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
                'Your file has been deleted.',
                'success'
            )
            }
        })
        }
    </script>
@endsection
