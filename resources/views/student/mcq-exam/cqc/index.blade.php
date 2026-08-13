@extends('student.layouts.app')
@section('student-title')
    MCQ Exam CQCs
@endsection

@section('student-title-icon')
    <i class="fas fa-stopwatch "></i>
@endsection

@section('content')

    <section class="about-page">
        <div class="container-fluid pt-3">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="card mb-5 shadow border border-primary border-2" style="border-radius: 8px;">
                        <div class="card-body">
                            <div class="text-center mb-2 h3">{{$exam->name}}</div>
                            <div class="text-end">
                                <a href="/student/mcq-exams/{{$exam->id}}/cqcs/create" class="btn btn-sm btn-primary">Add CQC</a>
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
                                                @if($cqc->user_id == auth()->user()->id)
                                                    <div class="text-end classroom-btn mt-1">
                                                        <a href="/student/mcq-exams/{{$exam->id}}/cqcs/{{$cqc->id}}/edit" class="btn btn-sm btn-warning">Edit</a>

                                                        <form id="delete-form-{{$cqc->id}}" action="/student/mcq-exams/{{$exam->id}}/cqcs/{{$cqc->id}}" method="POST" class="d-inline-block">
                                                            @csrf
                                                            @method('DELETE')
                                                            <a href="javascript:{}" onclick="javascript:deleteData({{$cqc->id}});" class="btn btn-sm btn-danger">Delete</a>
                                                        </form>
                                                    </div>
                                                @endif
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
    </section>

    <script type="text/javascript">
        function deleteData(id)
        {
            if(confirm('Are You Sure You want to Delete this data ? You will not be able to revert it ? ')){
                document.getElementById('delete-form-'+id).submit();
            }
        }
    </script>

@endsection

