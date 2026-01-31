@extends('admin.layouts.app')
@section('admin-title')
  Play Text Puzzle
@endsection

@section('content')
  <div class="content-wrapper">
    <div class="page-header">
      <h3 class="page-title"> Play Text Puzzle Lists</h3>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
          <li class="breadcrumb-item active" aria-current="page">Play Text Puzzles</li>
        </ol>
      </nav>
    </div>  
    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div class="custon-table-header">
              <h4 class="card-title"> Play Text Puzzle </h4>
              <div class="text-right">
                <a href="/admin/play-puzzle/text/create"><button type="button" class="btn btn-sm ml-3 btn-success"> Add Puzzle </button></a>
              </div>
            </div>
            <div class="table-responsive table-responsive-md">
              <table class="table table-bordered" id="advanced-asc-table">
                <thead>
                  <tr>
                    <th>SN</th>
                    <th>Question</th>
                    <th>Answer</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @php($i=1)
                  @foreach ($questions as $question)
                  <tr>
                    <td>{{ $i }}</td>
                    <td class="text-wrap">{!! $question->question !!}</td>
                    <td class="text-wrap">{!! $question->answer !!}</td>
                    <td class="classroom-btn" width="100">
                      <a href="/admin/play-puzzle/text/{{$question->id}}" class="btn btn-info">Show</a>
                      <a href="/admin/play-puzzle/text/{{$question->id}}/edit" class="btn btn-warning">Edit</a>
                        <form id="delete-form-{{$question->id}}" action="/admin/play-puzzle/text/{{$question->id}}" method="POST" style="display: inline">
                          @csrf
                          @method('DELETE')
                          <a href="javascript:{}" onclick="javascript:deleteData({{$question->id}});" class="btn btn-danger">Delete</a>
                        </form>
                    </td>
                  </tr>
                  @php($i++)
                  @endforeach
                </tbody>
              </table>    
            </div>
            <div class="mt-2">
              {{$questions->onEachSide(1)->links('paginator.bootstrap')}}
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
            'Your data has been deleted.',
            'success'
          )
        }
      })
    }
  </script>
@endsection
