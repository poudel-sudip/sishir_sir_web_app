@extends('admin.layouts.app')
@section('admin-title')
    Batch Assignment Answer View
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">{{$batch->name}} :- Assignment Answer </h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/admin/batches') }}">Batches</a></li>
              <li class="breadcrumb-item"><a href="/admin/batches/{{$batch->id}}/assignments">Assignments</a></li>
              <li class="breadcrumb-item"><a href="/admin/batches/{{$batch->id}}/assignments/{{$assignment->id}}/answers">Answers</a></li>
              <li class="breadcrumb-item active" aria-current="page">View</li>
              </ol>
          </nav>
        </div>  
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="">{{$assignment->question}}</h4>
                    <div class="h5">By: {{$answer->user->name}}</div>
                    <div class="h6">Remarks: {{$answer->remarks}}</div>
                    <b>Answer:</b><br>
                    <div class="">
                      {!! $answer->answer !!}
                    </div>

                    <form action="/admin/batches/{{$batch->id}}/assignments/{{$assignment->id}}/answers/{{$answer->id}}" method="POST">
                        @csrf
                        <div class="form-group row">
                            <label for="remarks" class="col-md-4 col-form-label">{{ __('Add Remarks') }}</label>

                            <div class="col-md-8">
                                <input type="remarks" class="form-control @error('remarks') is-invalid @enderror" name="remarks" required>
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
    </div>
    
@endsection
