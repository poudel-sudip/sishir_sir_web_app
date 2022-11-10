@extends('admin.layouts.app')
@section('admin-title')
    Dynamic Form Sub Categories
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
        <h3 class="page-title">Form Sub Categories | {{$category->name}}</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/admin/dynamic-forms/categories') }}">Form Categories</a></li>
              <li class="breadcrumb-item active" aria-current="page"> Sub Categories </li>
            </ol>
        </nav>
        </div>

        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="custon-table-header">
                        <h4 class="card-title">Form Sub Categories | {{$category->name}} </h4>
                        <div class="text-right">
                            <a href="/admin/dynamic-forms/categories/{{$category->id}}/sub-categories/create"><button type="button" class="btn btn-sm ml-3 btn-success"> Add Sub Category </button></a>
                        </div>
                    </div>
                    <div class="table-responsive">
                      <table class="table table-bordered" id="category-table">
                        <thead>
                          <tr>
                            <th>SN</th>
                            <th>Category</th>
                            <th class="text-wrap">Sub Category Name</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          @php($i=1)
                          @foreach($subcategories as $cat)
                          <tr>
                            <td>{{$i}}</td>
                            <td class="text-wrap">{{$category->name}}</td>
                            <td class="text-wrap">{{$cat->name}}</td>
                           
                            <td class="classroom-btn" width="75">
                              <form id="delete-form-{{$cat->id}}" action="/admin/dynamic-forms/categories/{{$category->id}}/sub-categories/{{$cat->id}}" method="POST" style="display: inline">
                                    @csrf
                                    @method('DELETE')
                                    <a href="javascript:{}" onclick="javascript:deleteData({{$cat->id}});" class="btn btn-danger">Delete</a>
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
@endsection

