@extends('admin.layouts.app')
@section('admin-title')
    Common Question Collections | {{$category->title}}
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Common Question Collections</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/admin/exam-hall') }}">Exam Sets</a></li>
                    <li class="breadcrumb-item active" aria-current="page">CQC</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="custon-table-header">
                            <h4 class="card-title">Common Question Collections | {{$category->title}}</h4>
                        </div>
                        <div class="table-responsive table-responsive-md">
                            <table class="table table-bordered" id="advanced-desc-table">
                                <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Date</th>
                                    <th>Posted By</th>
                                    <th>Question</th>
                                    <th>Action</th>
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
                                        <td class="classroom-btn" width="160">
                                            <form id="delete-form-{{$cqc->id}}" action="/admin/exam-hall/{{$category->id}}/cqc/{{$cqc->id}}" method="POST" style="display: inline">
                                                @csrf
                                                @method('DELETE')
                                                <a href="javascript:{}" onclick="javascript:deleteData({{$cqc->id}});" class="btn btn-danger">Delete</a>
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
                                            'Your file record has been deleted.',
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
        <div class="row">
            <div class="col-md-12">
                <hr>
                <form method="POST" action="/admin/exam-hall/{{$category->id}}/cqc" enctype="multipart/form-data">
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

@endsection
