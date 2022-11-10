@extends('admin.layouts.app')
@section('admin-title')
    Add SMS
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Create SMS</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/admin/sms') }}">SMS</a></li>
              <li class="breadcrumb-item active" aria-current="page">Add SMS</li>
              </ol>
          </nav>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">Add New SMS</div>
                    <div class="card-body">
                        <form method="POST" action="/admin/sms" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="form-group row">
                                <label for="group" class="col-md-4 col-form-label">{{ __('Notify to Group') }}</label>

                                <div class="col-md-8">
                                    <select id="group" class="form-control @error('group') is-invalid @enderror" name="group[]" multiple size="6">

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
                                <label for="description" class="col-md-12 col-form-label">{{ __('Message') }}</label>

                                <div class="col-md-12">
                                    <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description"  autocomplete="description" required rows="10"> {{ old('description') }} </textarea>

                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mt-3 small">
                                <div class="col-12">Number of Characters: <span id="numberChar">0</span> </div>
                                <div class="col-12">Credits Used: <span id="creditsUsed">0</span> </div>
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

    <script>
    $('#description').on('keyup',function(){
       var count=($('#description').val()).length;
       var credit=parseInt(count/160)+1;
       $('#numberChar').html(count);
       $('#creditsUsed').html(credit);
    });
    </script>

@endsection
