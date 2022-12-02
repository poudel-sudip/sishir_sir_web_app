@extends('student.layouts.app')
@section('student-title')
    Enrolled E-Books
@endsection

@section('student-title-icon')
    <i class="fas fa-list-ol"></i>
@endsection


@section('content')
    <div class="student-content-wrapper student-enroll-section">
        <div class="row">
            <div class="col-md-12 mb-2 text-end">
                <a class="student-enroll-btn" href="{{ url('/student/ebook-bookings/create') }}">Book E-Book</a>
            </div>
        </div>
        <div class="row">
            @foreach ($bookings as $booking)
                <div class="col-md-4 student-video-card mb-3">
                    <div class="vid-card-img-container">
                        @if ($booking->status=="Verified")
                        <a href="/student/ebook-bookings/{{$booking->id}}/chapters">
                            <img src="/storage/{{$booking->book->thumbnail}}" alt="" class="w-100">
                        </a>
                        @else
                        <img src="/storage/{{$booking->book->thumbnail}}" alt="" class="w-100">
                        @endif
                    </div>
                    <div class="student-vid-dec">
                        <h6>{{($booking->book->title ?? '')}}</h6>
                        <div class="student-vid-status">
                            @if ($booking->status == "Verified")
                            <div class="text-success">{{$booking->status}}</div>
                            @else
                            <div class="text-primary">{{$booking->status}}</div>
                            @endif
                            <div class="text-end">
                                @if($booking->status!="Verified")
                                    <a href="/student/ebook-bookings/{{$booking->id}}/edit" class="btn btn-warning btn-sm">Verify</a> 
                                    <form id="delete-form-{{$booking->id}}" action="/student/ebook-bookings/{{$booking->id}}" method="POST" style="display: inline">
                                        @csrf
                                        @method('DELETE')
                                        <a href="javascript:{}" onclick="javascript:deleteData({{$booking->id}});" class="btn btn-danger btn-sm">Delete</a>
                                    </form>
                                {{-- @else
                                    <a href="/student/ebook-bookings/{{$booking->id}}/chapters" class="btn btn-primary btn-sm mb-1 ">Chapters</a>  --}}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script type="text/javascript">
        function deleteData(id)
        {
            if(confirm('Are You Sure? ')){
                document.getElementById('delete-form-'+id).submit();
            }
        }
    </script>

@endsection
