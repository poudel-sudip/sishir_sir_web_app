@extends('tutors.layouts.app')
@section('tutor-title')
    {{$post->title}} Comments
@endsection
@section('tutor-title-icon')
    <i class="far fa-comments"></i>
@endsection

@section('content')
    <div class="tutor-content-wrapper student-enroll-section">
        
        <div class="row">
            <div class="col-md-12 student_exam_card">
                <div class="enrolled-table table-responsive">
                    <table class="table" style="width:100%">
                        <thead class="table-light">
                            <tr>
                                <th>SN</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Comment</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php($i=1)
                            @foreach($post->comments as $comment)
                            <tr>
                                <td>{{$i}}</td>
                                <td class="text-wrap">{{$comment->name}}</td>
                                <td>{{$comment->email}}</td>
                                <td class="text-wrap">{{$comment->message}}</td>
                                <td>{{date('Y/m/d',strtotime($comment->created_at))}}</td>
                                <td class="text-wrap">{{$comment->status}}</td>
                                <td class="classroom-btn" >
                                    <form id="delete-form-{{$comment->id}}" action="/tutor/posts/{{$post->id}}/comments/{{$comment->id}}" method="POST" style="display: inline">
                                        @csrf
                                        @method('DELETE')
                                        <a href="javascript:{}" onclick="javascript:deleteData({{$comment->id}});" class="btn btn-danger btn-sm">Delete</a>
                                    </form>
                                </td>                       
                            </tr>
                            @php($i++)
                            @endforeach
                        </tbody>
                        
                    </table>
                </div>
                

                </div>

            </div>
        </div>

        <script type="text/javascript">
            function deleteData(id)
            {
                if(confirm('Are You Sure'))
                {
                    document.getElementById('delete-form-'+id).submit();
                }                  
            }
        </script>

    @endsection
