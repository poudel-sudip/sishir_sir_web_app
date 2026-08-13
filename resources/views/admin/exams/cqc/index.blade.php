@extends('admin.layouts.app')
@section('admin-title')
    Exam CQCs
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Exam CQC</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/exam-category') }}">Exam Categories</a></li>
                <li class="breadcrumb-item"><a href="/admin/exam-category/{{$exam->category->id ?? ''}}/exams">Exams</a></li>
                <li class="breadcrumb-item active" aria-current="page">CQC</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="text-center mb-2 h3">{{$exam->name}}</div>
                        <div class="text-right">
                            <a href="/admin/exams/{{$exam->id}}/cqcs/create" class="btn btn-sm btn-primary">Add Content</a>
                        </div>
                        <div class="mt-2">
                            <div class="">
                                @forelse ($cqcs as $cqc)
                                    <div class="border-bottom border-primary mb-2 pb-1">
                                        <div class="h6 text-justify text-wrap">
                                            {{$cqc->title}}
                                        </div>
                                        <div class="text-justify text-wrap">{!!$cqc->description!!}</div>
                                        <div class="d-flex align-items-center justify-content-between gap-1">
                                            <div class="small text-muted">
                                                {{$cqc->created_at}}
                                            </div>
                                            <div class="text-right classroom-btn mt-1">
                                                <a href="/admin/exams/{{$exam->id}}/cqcs/{{$cqc->id}}/edit" class="btn btn-sm btn-warning">Edit</a>

                                                <form id="delete-form-{{$cqc->id}}" action="/admin/exams/{{$exam->id}}/cqcs/{{$cqc->id}}" method="POST" class="d-inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a href="javascript:{}" onclick="javascript:deleteData({{$cqc->id}});" class="btn btn-sm btn-danger">Delete</a>
                                                </form>
                                            </div>
                                        </div>
                                        
                                    </div>
                                @empty
                                    <div class="text-center">Exam CQC Content Not Available</div>
                                @endforelse
                            </div>
                            <div class="">
                                {{$cqcs->onEachSide(1)->links('paginator.bootstrap')}}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


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
                'Your data has been deleted.',
                'success'
                )
            }
            })
        }
    </script>
@endsection
