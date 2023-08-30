@extends('admin.layouts.app')
@section('admin-title')
  Book  Reviews
@endsection

@section('content')
  <div class="content-wrapper">
    <div class="page-header">
      <h3 class="page-title">Book Reviews </h3>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="{{ url('/admin/books') }}">Books</a></li>
          <li class="breadcrumb-item active" aria-current="page">Reviews</li>
        </ol>
      </nav>
    </div>  
    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div class="custom-table-header">
              <h4 class="card-title">Book Reviews || {{$book->title}}</h4>
            </div>
            <div class="table-responsive table-responsive-md">
              <table class="table table-bordered" id="advanced-asc-table">
                <thead>
                  <tr>
                    <th>SN</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Rating</th>
                    <th>Message</th>
                    <th>Date</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @php($i=1)
                  @foreach($reviews as $rev)
                    <tr>
                      <td width='75'>{{$i}}</td>
                      <td class="text-wrap">{{$rev->name}}</td>
                      <td class="text-wrap">{{$rev->email}}</td>
                      <td class="text-wrap">{{$rev->rating}}</td>
                      <td class="text-wrap"> {!! $rev->message !!} </td>
                      <td class="text-wrap">{{$rev->created_at}}</td>

                      <td width='75'>
                        <form id="delete-form-{{$rev->id}}" action="/admin/books/{{$book->id}}/reviews/{{$rev->id}}" method="POST" class="d-inline">
                          @csrf
                          @method('DELETE')
                          <a href="javascript:{}" onclick="javascript:deleteData({{$rev->id}});">Delete</a>
                        </form>
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
