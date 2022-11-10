@extends('admin.layouts.app')
@section('admin-title')
    Add Notification
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Create Notification</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/admin/notifications') }}">Notifications</a></li>
              <li class="breadcrumb-item active" aria-current="page">Add Notification</li>
              </ol>
          </nav>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">Add New Notification</div>
                    <div class="card-body">
                        <form method="POST" action="/admin/notifications" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group row">
                                <label for="allusers" class="col-md-4 col-form-label">{{ __('Notify To All Users') }}</label>

                                <div class="col-md-8">
                                    <input type="checkbox" name="allusers" id="allusers" value="true" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="group" class="col-md-4 col-form-label">{{ __('Notify to Group') }}</label>

                                <div class="col-md-8">
                                    <select id="group" class="form-control @error('group') is-invalid @enderror" name="group[]" multiple size="5">

                                        @foreach($batches as $batch)
                                            <option value='{"id":{{$batch->id}},"batch":"{{$batch->course->name.' - '.$batch->name}}" }'>{{$batch->course->name.' - '.$batch->name.' - '.$batch->status}}</option>
                                        @endforeach
                                    </select>
                                    @error('group')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="title" class="col-md-4 col-form-labe">{{ __('Title') }}</label>

                                <div class="col-md-8">
                                    <input id="title" type="text" class="form-control @error('title') is-invalid @enderror"  name="title" value="{{ old('title') }}" required>

                                    @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="description" class="col-md-4 col-form-label">{{ __('Message') }}</label>

                                <div class="col-md-8">
                                    <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description"  autocomplete="description" required rows="5"></textarea>

                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="image" class="col-md-4 col-form-label">{{ __('Image') }}</label>
                                <div class="col-md-8">
                                    <input id="image" type="file" class="form-control @error('image') is-invalid @enderror" name="image" value="{{ old('image') }}"  >

                                    @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mt-3">
                                <div class="col-md-6 offset-md-5">
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
