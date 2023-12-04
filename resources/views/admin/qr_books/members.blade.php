@extends('admin.layouts.app')
@section('admin-title')
  QR Generated Book Scan Members
@endsection

@section('content')
  <div class="content-wrapper">
    <div class="page-header">
      <h3 class="page-title">QR Generated Book Scan Members </h3>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="{{ url('/admin/qr-books') }}">QR Books</a></li>
          <li class="breadcrumb-item active" aria-current="page">Scan Members</li>
        </ol>
      </nav>
    </div>  
    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div class="custon-table-header">
              <h4 class="card-title">QR Generated Book Scan Members || {{$book->title}}</h4>
              <div class="text-right">
                <a href="/admin/qr-books/{{$book->id}}/scans/export"><button type="button" class="btn btn-sm ml-3 btn-info"> Excel Export </button></a>
              </div>
            </div>
          
            <div class="table-responsive table-responsive-md">
              <table class="table table-bordered" id="advanced-asc-table">
                <thead>
                  <tr>
                    <th>SN</th>
                    <th>Book Link</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Contact</th>
                    <th>Provience</th>
                    <th>District</th>
                    <th>Date</th>
                    {{-- <th>Action</th> --}}
                  </tr>
                </thead>
                <tbody>
                  @php($i=1)
                  @foreach($members as $rev)
                    <tr>
                      <td width='75'>{{$i}}</td>
                      <td class="text-wrap">{{$rev->book_link ?? ''}}</td>
                      <td class="text-wrap">{{$rev->name}}</td>
                      <td class="text-wrap">{{$rev->email}}</td>
                      <td class="text-wrap">{{$rev->contact}}</td>
                      <td class="text-wrap">{{$rev->provience}}</td>
                      <td class="text-wrap">{{$rev->district}}</td>
                      <td class="text-wrap">{{$rev->scan_date}}</td>

                      {{-- <td width='75'>
                        <form id="delete-form-{{$rev->id}}" action="/admin/books/{{$book->id}}/reviews/{{$rev->id}}" method="POST" class="d-inline">
                          @csrf
                          @method('DELETE')
                          <a href="javascript:{}" onclick="javascript:deleteData({{$rev->id}});">Delete</a>
                        </form>
                      </td> --}}
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
