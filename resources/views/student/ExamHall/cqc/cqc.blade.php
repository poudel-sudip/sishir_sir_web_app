@extends('student.layouts.app')
@section('student-title')
    Common Question Collections or Queries of {{$category->title}}
@endsection
@section('student-title-icon')
    <i class="fas fa-comment"></i>
@endsection

@section('content')

<div class="student-content-wrapper">
    <div class="card p-3">
        <div class="card-title">
            <div class="h4 text-center">{{$category->title}} </div>
        </div>
        <div class="enrolled-table table-responsive">
            <table class="table" style="width:100%">
                <thead class="table-light">
                    <tr>
                        <th>SN</th>
                        <th>Date</th>
                        <th>Posted By</th>
                        <th>Question</th>
                    </tr>
                </thead>

                <tbody>
                    @php($i=1)
                    @foreach($category->cqcs as $cqc)
                    <tr>
                        <td> {{$i}} </td>
                        <td> {{date('Y-m-d (D)',strtotime($cqc->created_at))}} </td>
                        <td> {{$cqc->name}} </td>
                        <td class="text-wrap"> {!! $cqc->question !!} </td>
                    </tr>
                    @php($i++)
                    @endforeach
                   
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <hr>
            <form method="POST" action="/student/exam-hall/{{$category->id}}/cqc" enctype="multipart/form-data">
                @csrf

                <div class="form-group row">
                    <label for="question" class="col-md-4 col-form-label text-md-right">{{ __(' Question') }}</label>

                    <div class="col-md-6">
                        <input id="question" type="text" class="form-control @error('question') is-invalid @enderror" name="question" value="{{ old('question') }}" required autofocus>

                        @error('question')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row mb-0 mt-2">
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

@endsection
