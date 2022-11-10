@extends('teams.layouts.app')
@section('admin-title')
    My Registered Users Pending Followups
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Registered Users Pending Followups</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/team/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/team/followup/pending') }}">Pending Followups</a></li>
                <li class="breadcrumb-item active" aria-current="page">Users</li>
              </ol>
          </nav>
        </div>  
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        
                        <div class="table-responsive">
                            <table class="table table-bordered" id="advanced-desc-table">
                                <thead>
                                    <tr>
                                        <th>SN</th>
                                        <th>Full Name</th>
                                        <th>Email</th>
                                        <th>Contact</th>
                                        <th>Provience</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>       
                                <tbody>
                                    @php($i=1)
                                    @foreach($followups as $data)
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td>{{$data->user->name ?? ''}}</td>
                                        <td>{{$data->user->email ?? ''}}</td>
                                        <td>{{$data->user->contact ?? ''}}</td>
                                        <td>{{$data->user->provience ?? ''}}</td>                                        
                                        <td class="classroom-btn" width="75">
                                            <a class="edit-followup btn btn-warning" href="#edit_followup" user-id="{{$data->user->id ?? ''}}" user-name="{{$data->user->name ?? ''}}" user-contact="{{$data->user->contact ?? ''}}" data-bs-toggle="modal" data-bs-target="#edit_followup" data-toggle="modal" data-target="#edit_followup">Edit</a>
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

    {{-- Popup Model For Followup Start --}}
  <div id="edit_followup" class="modal fade">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> Add Status and Remarks </h5>
                <button type="button" class="close" data-bs-dismiss="modal" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form method="POST" action="/team/followup/pending/registered-users/add" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group row">
                      <label for="user_id" class="col-md-3 col-form-label">{{ __(' User ID') }}</label>

                      <div class="col-md-9">
                        <input id="user_id" type="text" class="form-control @error('user_id') is-invalid @enderror" name="user_id" value="{{ old('user_id') }}" required readonly>

                        @error('user_id')
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                          </span>
                        @enderror
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="user_name" class="col-md-3 col-form-label">{{ __(' User Name') }}</label>

                      <div class="col-md-9">
                        <input id="user_name" type="text" class="form-control @error('user_name') is-invalid @enderror" name="user_name" value="{{ old('user_name') }}" required readonly>

                        @error('user_name')
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                          </span>
                        @enderror
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="user_contact" class="col-md-3 col-form-label">{{ __(' User Contact') }}</label>

                      <div class="col-md-9">
                        <input id="user_contact" type="text" class="form-control @error('user_contact') is-invalid @enderror" name="user_contact" value="{{ old('user_contact') }}" readonly>

                        @error('user_contact')
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                          </span>
                        @enderror
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="status" class="col-md-3 col-form-label">{{ __(' Status') }}</label>

                      <div class="col-md-9">
                        <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                            <option value="Hot">Hot</option>
                            <option value="Warm">Warm</option>
                            <option value="Cold">Cold</option>
                            <option value="Drop">Drop</option>
                            <option value="Booked">Booked</option>
                        </select>
                        @error('status')
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                          </span>
                        @enderror
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="remarks" class="col-md-3 col-form-label">{{ __(' Remarks') }}</label>

                      <div class="col-md-9">
                        <input id="remarks" type="text" class="form-control @error('remarks') is-invalid @enderror" name="remarks" value="{{ old('remarks') }}" required autofocus>

                        @error('remarks')
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                          </span>
                        @enderror
                      </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Submit') }}
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
  </div>
  {{-- Popup Model For Followup End --}}

  <script>
    $(document).on('click', '.edit-followup', function(){
        const id=$(this).attr('user-id');
        const name=$(this).attr('user-name');
        const contact=$(this).attr('user-contact');
        $('#user_id').val("");
        $('#user_name').val("");
        $('#user_contact').val("");
        
        $('#user_id').val(id);
        $('#user_name').val(name);
        $('#user_contact').val(contact);
    })
  </script> 

@endsection