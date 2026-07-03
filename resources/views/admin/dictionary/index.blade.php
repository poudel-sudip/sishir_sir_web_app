@extends('admin.layouts.app')
@section('admin-title')
    Health Dictionary
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Health Dictionary</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Health Dictionary</li>
              </ol>
          </nav>
        </div>  
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="custon-table-header">
                            <h4 class="card-title">Health Dictionary</h4>
                            <div class="text-right">
                                <a href="{{ ('/admin/health-dictionary/create') }}"><button type="button" class="btn btn-sm ml-3 btn-success"> Add Content </button></a>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered all-desc-table" id="search_data_table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Action</th>
                                        <th>Title</th>
                                        <th>Content</th>
                                    </tr>
                                </thead>       
                                <tbody>
                                    @foreach($dictionary as $row)
                                    <tr>
                                        <td>{{$row->id}}</td>
                                        <td width="50">
                                            <div class="dropdown">
                                                <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuOutlineButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Actions </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuOutlineButton1">
                                                    <a href="/admin/users/{{$row->id}}" class="text-primary dropdown-item">Show</a>
                                                    <a href="/admin/users/{{$row->id}}/edit" class="text-danger dropdown-item">Edit</a>
                                                    <form id="delete-form-{{$row->id}}" action="/admin/users/{{$row->id}}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <a href="javascript:{}" onclick="javascript:deleteData({{$row->id}});" class="text-warning dropdown-item">Delete</a>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-wrap">{{$row->title}}</td>
                                        <td class="text-wrap">{!!$row->content!!}</td>
                                                                                
                                    </tr>
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
                        </div>
                        
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            const table_source = "/admin/health-dictionary?json_type=1";
            $('#search_data_table').DataTable().destroy();
            $('#search_data_table').DataTable({
                searching: true,
                ordering: true,
                paging: true,
                info: true,
                lengthChange: true,
                processing: true,
                serverSide: true,
                ajax: table_source,
                columns: [
                    { data: 'id'},
                    { data: 'action', orderable: false, searchable: false },
                    { data: 'title', name:'name' },
                    { data: 'content', name:'description', orderable: false, searchable: false },
                ],
                columnDefs: [
                    {
                        targets: '_all',
                        className: 'text-start text-wrap'
                    },
                ],
                order: [[0, 'desc']], 
                lengthMenu: [[50, 100, 200, 500], [50, 100, 200, 500]],
                pageLength: 50, 

            });

        });
    </script>
@endsection
