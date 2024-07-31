@extends('admin.layouts.app')
@section('admin-title')
  Used Booking Coupons
@endsection

@section('content')
  <div class="content-wrapper">
    <div class="page-header">
      <h3 class="page-title">Used Booking Coupons</h3>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
          <li class="breadcrumb-item active" aria-current="page">Used Coupons </li>
        </ol>
      </nav>
    </div>

    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div class="custon-table-header">
              <h4 class="card-title">Used Booking Coupons</h4>

            </div>
            <div class="table-responsive table-responsive-md">
              <table class="table table-bordered all-entries-asc-table">
                <thead>
                  <tr>
                    <th>SN</th>
                    <th>Coupon For </th>
                    <th>Coupon Code</th>
                    <th>Used Date</th>
                    <th>Booking ID</th>
                    <th>User</th>
                    <th>Remarks</th>                                                        
                  </tr>
                </thead>
                <tbody>
                  @php($i=1)
                  @foreach($coupons as $row)
                    <tr>
                      <td width="50">{{$i}}</td>
                      <td class="text-wrap" width="150">{{$row->source}}</td>
                      <td class="text-wrap">{{$row->coupon}}</td>
                      <td class="text-wrap">{{$row->use_date}}</td>
                      <td class="text-wrap">{{$row->booking_id}}</td>
                      <td class="text-wrap">
                        <div>ID: {{$row->user_id}}</div>
                        <div>Name: {{$row->user->name ?? ''}}</div>
                      </td>
                      <td class="text-wrap">{{$row->remarks}}</td>
                    </tr>
                    @php($i++)
                  @endforeach
                </tbody>
              </table>
              
            </div>
            <div class="mt-2">
              {{$coupons->onEachSide(1)->links('paginator.bootstrap')}}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  {{-- popup model for coupon add start --}}
  <div id="add_coupon" class="modal fade">
    <div class="modal-dialog ">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"> Add New Booking Coupon </h5>
          <button type="button" class="close" data-bs-dismiss="modal" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <form method="POST" action="/admin/booking-coupons" enctype="multipart/form-data">
            @csrf
                        
            <div class="form-group row">
              <label for="coupon_for" class="col-md-3 col-form-label">{{ __('Coupon For') }}</label>

              <div class="col-md-9">
                <select name="coupon_for" id="coupon_for" class="form-control @error('coupon_for') is-invalid @enderror" value="{{ old('coupon_for') }}" required>
                  <option value="exam">Exam</option>
                  <option value="pdfbank">PdfBank</option>
                </select>

                @error('coupon_for')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>

            <div class="form-group row">
              <label for="coupon_count" class="col-md-3 col-form-label">{{ __('Coupon Count') }}</label>

              <div class="col-md-9">
                <input id="coupon_count" type="number" class="form-control @error('coupon_count') is-invalid @enderror" name="coupon_count" value="{{ old('coupon_count') ?? 1 }}" required >

                @error('coupon_count')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>

            <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Generate Coupons') }}
                    </button>
                </div>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
  {{-- Popup Model For coupon Add End --}}

  
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

