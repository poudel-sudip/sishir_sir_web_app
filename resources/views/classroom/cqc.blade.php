@extends($header)
@section('student-title')
    Common Question Collections
@endsection
@section('student-title-icon')
    <i class="fas fa-question"></i>
@endsection

@section('content')
<div class="student-content-wrapper chatroom-section content-wrapper" oncontextmenu="return false" onselectstart="return false" ondragstart="return false">
    @if (session('status'))
    <span class="alert alert-success" role="alert">
        {{ session('status') }}
    </span>
    @endif
    <div class="row">
        <div class="col-md-12 text-center">
            <h6>{{$batch->name}} @if($batch->timeSlot) <span>({{ $batch->timeSlot ?? ''}})</span> @endif </h6>        
        </div>
        <div class="col-md-12 text-center" oncontextmenu="return false" onselectstart="return false" ondragstart="return false">
            <div class="chatroom-header">
                <a href="/classroom/chat/{{$batch->id}}" class="nav-link ">Chat</a>
                <a href="/classroom/files/{{$batch->id}}" class="nav-link">Files</a>
                <a href="/classroom/videos/{{$batch->id}}" class="nav-link">Videos</a>
                <a href="/classroom/cqcs/{{$batch->id}}" class="nav-link active">CQC</a>

                @if($batch->status=='Running' && $batch->classroomLink!='' )
                    <a href="{{$batch->classroomLink}}" target="_blank" class="nav-link" title="Zoin Class" oncontextmenu="return false"><i class="fa fa-video-camera" aria-hidden="true"></i> Join</a>
                @endif

            </div>
        </div>
    </div>
    <div class="container">
        <div class="col-md-12">
            <div class="enrolled-table table-responsive table-responsive-md">
                <table class="table" style="width:100%">
                    <thead class="table-light">
                        <tr>
                            <th>SN</th>
                            <th>Date</th>
                            <th>Posted By</th>
                            <th>Question</th>
                            @if(auth()->user()->role!='Student')
                                <th></th>
                            @endif
                        </tr>
                    </thead>

                    <tbody>
                        @php($i=1)
                        @foreach($cqcs as $cqc)
                        <tr>
                            <td> {{$i}} </td>
                            <td> {{date('Y-m-d (D)',strtotime($cqc->created_at))}} </td>
                            <td> {{$cqc->name}} </td>
                            <td class="text-wrap"> {!! $cqc->question !!} </td>
                            @if(auth()->user()->role!='Student')
                            <td class="classroom-btn">
                                <form class="d-inline" id="delete-form-{{$cqc->id}}" action="/classroom/cqcs/{{$batch->id}}/{{$cqc->id}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <a class="file-video-delete-btn" href="javascript:{}" title="Delete Data" onclick="javascript:deleteData({{$cqc->id}});"><span class="mdi mdi-delete"></span></a>
                                </form>
                            </td>
                            @endif
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
                                'Your file has been deleted.',
                                'success'
                                )
                            }
                            })
                    }
                </script>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <hr>
                <form method="POST" action="/classroom/cqcs/{{$batch->id}}" enctype="multipart/form-data">
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
</div>
@endsection
