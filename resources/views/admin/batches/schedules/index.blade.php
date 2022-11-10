@extends('admin.layouts.app')
@section('admin-title')
    {{$batch->name}} Schedules
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">{{$batch->name}} Schedules</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/batches') }}">Batches</a></li>
                <li class="breadcrumb-item active" aria-current="page">Schedules</li>
              </ol>
          </nav>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                      <div class="custon-table-header">
                          <h4 class="card-title">Schedules</h4>
                          <div class="text-right">
                              <a href="/admin/batches/{{$batch->id}}/schedules/create"><button type="button" class="btn btn-sm ml-3 btn-success"> Add Schedule </button></a>
                          </div>
                      </div>
                      <div class="table-responsive table-responsive-md">
                        <table class="table table-bordered" id="batches-table">
                          <thead>
                            <tr>
                              <th>SN</th>
                              <th>Date</th>
                              <th>Time </th>
                              <th>Tutor Name</th>
                              <th>Topic</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                              @php($i=1)
                              @foreach($schedules as $schedule)
                              <tr>
                                <td>{{$i}}</td>
                                <td> {{$schedule->date}} ({{ date('D',strtotime($schedule->date)) }})</td>
                                <td> {{$schedule->time}} </td>
                                <td> {{$schedule->tutor}} </td>
                                <td> {{$schedule->topic}} </td>
                                <td class="classroom-btn">
                                  <form id="delete-form-{{$schedule->id}}" action="/admin/batches/{{$batch->id}}/schedules/{{$schedule->id}}" method="POST" style="display: inline">
                                    @csrf
                                    @method('DELETE')
                                    <a href="javascript:{}" onclick="javascript:deleteData({{$schedule->id}});" class="btn btn-danger" title="Delete"><i class="fa fa-trash"></i></a>
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
                                    'Your Record has been deleted.',
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
<script>
    import App from "../../../../public/js/app";
    export default {
        components: {App}
    }
</script>
