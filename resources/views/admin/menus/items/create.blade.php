@extends('admin.layouts.app')
@section('admin-title')
    Create Menu Item
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Create Menu Item</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/menus') }}">Menu Groups</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/menus/'.$group->id.'/sub-groups') }}">Sub Groups</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/menus/'.$group->id.'/sub-groups/'.$subgroup->id.'/items') }}">Items</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add </li>
                </ol>
            </nav>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">Add Menu Item | {{$subgroup->name}} | {{$group->name}}</div>
                  <div class="card-body">
                    <form class="forms-sample" method="POST" action="/admin/menus/{{$group->id}}/sub-groups/{{$subgroup->id}}/items" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label">{{ __('Item Name') }}</label>
                            <div class="col-md-9">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="order" class="col-sm-3 col-form-label">{{ __('Item Order') }}</label>
                            <div class="col-md-9">
                                <input id="order" type="number" class="form-control @error('order') is-invalid @enderror" name="order" value="{{ old('order') ?? 1  }}" required autocomplete="order" >
                                @error('order')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="file" class="col-sm-3 col-form-label">{{ __('Item File') }}</label>
                            <div class="col-md-9">
                                <input id="file" type="file" class="form-control @error('file') is-invalid @enderror" name="file" value="{{ old('file') ?? 1  }}" required autocomplete="file" >
                                @error('file')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="status" class="col-sm-3 col-form-label">{{ __('Item Status') }}</label>
                            <div class="col-md-9">
                                <select id="status" class="form-control @error('status') is-invalid @enderror" name="status" value="{{ old('status') }}" required>
                                    <option value="Inactive">Inactive</option>
                                    <option value="Active">Active</option>
                                </select>
                                @error('status')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-3">
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
    </div>
@endsection
