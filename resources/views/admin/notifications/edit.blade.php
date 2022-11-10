@extends('admin.layouts.app')
@section('admin-title')
    Edit Notification
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Edit Notification</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/admin/notifications') }}">Notifications</a></li>
              <li class="breadcrumb-item active" aria-current="page">Edit</li>
              </ol>
          </nav>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">{{ __('Edit Notification: ').' '.$notification->title }}</div>

                    <div class="card-body">
                        <form method="POST" action="/admin/notifications/{{$notification->id}}" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')

                            <div class="form-group row">
                                <label for="allusers" class="col-md-4 col-form-label">{{ __('Notify To All Users') }}</label>

                                <div class="col-md-8">
                                    <input type="checkbox" name="allusers" id="allusers" value="true" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="group" class="col-md-4 col-form-label">{{ __('Notify to Group') }}</label>

                                <div class="col-md-8">
                                    <select id="group" class="form-control @error('group') is-invalid @enderror" name="group[]" multiple size="5" required>

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
                                <label for="title" class="col-md-4 col-form-label">{{ __('Title') }}</label>

                                <div class="col-md-8">
                                    <input id="title" type="text" class="form-control @error('title') is-invalid @enderror"  name="title" value="{{ old('title') ?? $notification->title }}" required>

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
                                    <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" autocomplete="description" required rows="5">{!! old('description') ?? $notification->message !!}</textarea>

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
                                    <input id="image" type="file" class="form-control @error('image') is-invalid @enderror" name="image" value="{{ old('image') }}" >
                                    <input type="hidden" name="old_image" value="{{$notification->image}}">
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
