@extends('admin.layouts.app')
@section('admin-title')
    Create Open MCQ Exam
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Create New Open MCQ Exam</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/open-exams') }}">Open Exams</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add Exam </li>
                </ol>
            </nav>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">Add Open Exam</div>
                    <div class="card-body">
                        <form method="POST" action="{{ ('/admin/open-exams') }}" enctype="multipart/form-data" class="forms-sample">
                            @csrf
                            
                            <div class="form-group row">
                                <label for="exam_category" class="col-md-5 col-form-label">{{ __('Exam Category') }}</label>

                                <div class="col-md-7">
                                    <select id="exam_category" class="form-control @error('exam_category') is-invalid @enderror" name="exam_category" value="{{ old('exam_category') }}" required>
                                        <option value="">Choose an Exam Category</option>
                                        @foreach($categories as $cat)
                                        <option value="{{$cat->id}}">{{ucwords($cat->title)}}</option>
                                        @endforeach
                                    </select>
                                    @error('exam_category')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="exam_name" class="col-md-5 col-form-label">{{ __('Exam Name') }}</label>

                                <div class="col-md-7">
                                    <select id="exam_name" class="form-control @error('exam_name') is-invalid @enderror" name="exam_name" value="{{ old('exam_name') }}" required>
                                    </select>
                                    @error('exam_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                           
                            <div class="form-group row">
                                <label for="status" class="col-md-5 col-form-label">{{ __('Result Status') }}</label>

                                <div class="col-md-7">
                                    <select id="status" class="form-control @error('status') is-invalid @enderror" name="status" value="{{ old('status') }}" required>
                                        <option value="Unpublished">Unpublished</option>
                                        <option value="Published">Published</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>
                                    @error('status')
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

    <script>
        $(document).ready(function () {
            $(document).on('change', '#exam_category', function() {
                var cat_id = $(this).find(":selected").attr('value');
                // console.log(cat_id);
                get_exams(cat_id);                
            });

            function get_exams(id)
            {
                $('#exam_name').html("");
                var op='';
                var request = new XMLHttpRequest()
                request.open('GET', '/admin/exam-category/'+id+'/getexams', true)
                request.onload = function () {
                    // Begin accessing JSON data here
                    var data = JSON.parse(this.response);
                    // console.log(data);
                    if (request.status >= 200 && request.status < 400) {
                        var exams=data;
                        exams.forEach((exam) => {
                            op += '<option value="' + exam.id + '">' + exam.name + '</option>';
                        });
                        // console.log(op);
                        $('#exam_name').append(op);
                    } else {
                        console.log('error');
                        $('#exam_name').html("");
                    }
                }
                request.send();
            }
        });
    </script>


@endsection
